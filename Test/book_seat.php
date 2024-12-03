<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "bus_ticketing_system";

$conn = new mysqli($servername, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You need to log in to book seats.";
    exit;
}

// Get the bus number and seats from the POST request
$busno = $_POST['busno'] ?? '';
$seats = json_decode($_POST['seats'] ?? '[]', true);

if (empty($busno) || empty($seats) || !is_array($seats)) {
    echo "Invalid input.";
    exit;
}

// Debugging: Print the bus number
echo "Bus Number: " . htmlspecialchars($busno) . "<br>";

// Begin a transaction
$conn->begin_transaction();

try {
    // Get the bus ID from the bus number
    $stmt = $conn->prepare("SELECT id FROM buses WHERE TRIM(bus_number) = ?");
    $stmt->bind_param("s", $busno);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("Bus not found.");
    }

    $busRow = $result->fetch_assoc();
    $busId = $busRow['id'];

    // Debugging: Print the bus ID
    echo "Bus ID: " . htmlspecialchars($busId) . "<br>";

    // Check if seats are available
    foreach ($seats as $seat) {
        $seatStmt = $conn->prepare("SELECT status FROM seats WHERE bus_id = ? AND seat_number = ?");
        $seatStmt->bind_param("is", $busId, $seat);
        $seatStmt->execute();
        $seatResult = $seatStmt->get_result();

        if ($seatResult->num_rows === 0) {
            throw new Exception("Seat $seat not found.");
        }

        $seatRow = $seatResult->fetch_assoc();
        if ($seatRow['status'] !== 'available') {
            throw new Exception("Seat $seat is not available.");
        }
    }

    // Book the seats
    foreach ($seats as $seat) {
        // Update seat status to booked
        $updateStmt = $conn->prepare("UPDATE seats SET status = 'booked' WHERE bus_id = ? AND seat_number = ?");
        $updateStmt->bind_param("is", $busId, $seat);
        $updateStmt->execute();

        // Insert into bookings table
        $bookingStmt = $conn->prepare("INSERT INTO bookings (user_id, bus_id, seat_number, booking_date) VALUES (?, ?, ?, NOW())");
        $bookingStmt->bind_param("iis", $_SESSION['user_id'], $busId, $seat);
        $bookingStmt->execute();
    }

    // Commit the transaction
    $conn->commit();
    echo "Seats booked successfully!";
} catch (Exception $e) {
    // Rollback the transaction if something goes wrong
    $conn->rollback();
    echo "Failed to book seats: " . $e->getMessage();
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
