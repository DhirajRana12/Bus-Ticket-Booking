<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "bus_ticketing_system";

$conn = new mysqli($servername, $db_username, $db_password, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from POST
$user_id = $_SESSION['user_id'] ?? null;
$bus_id = $_POST['bus_id'] ?? null;
$selected_seats = json_decode($_POST['seats'] ?? '[]', true);
$total_cost = $_POST['total_cost'] ?? 0;

if (!$user_id || !$bus_id || empty($selected_seats)) {
    die("Invalid request. Please try again.");
}

if (!is_numeric($total_cost) || $total_cost <= 0) {
    die("Invalid total cost.");
}

// Begin transaction to handle seat booking
$conn->begin_transaction();

try {
    // Booking logic for each seat
    foreach ($selected_seats as $seat_number) {
        // Check if the seat is already booked
        $check_stmt = $conn->prepare("SELECT status FROM bus_seats WHERE bus_id = ? AND seat_number = ?");
        $check_stmt->bind_param("is", $bus_id, $seat_number);
        $check_stmt->execute();
        $check_stmt->bind_result($seat_status);
        $check_stmt->fetch();
        $check_stmt->close();

        if ($seat_status === 'booked') {
            throw new Exception("Seat $seat_number is already booked. Please choose another seat.");
        }

        // Insert booking record into the bookings table
        $stmt = $conn->prepare("INSERT INTO bookings (user_id, bus_id, seat_number, booking_date, created_at) VALUES (?, ?, ?, NOW(), NOW())");
        $stmt->bind_param("iis", $user_id, $bus_id, $seat_number);
        if (!$stmt->execute()) {
            throw new Exception("Error while booking seat $seat_number.");
        }

        // Update seat status in the bus_seats table
        $update_stmt = $conn->prepare("UPDATE bus_seats SET status = 'booked' WHERE bus_id = ? AND seat_number = ?");
        $update_stmt->bind_param("is", $bus_id, $seat_number);
        if (!$update_stmt->execute()) {
            throw new Exception("Error updating seat status for seat $seat_number.");
        }
    }

    // Simulate successful payment (since we're skipping the actual gateway)
    $payment_status = 'completed';  // Assuming payment is always successful
    $stmt = $conn->prepare("INSERT INTO payments (user_id, bus_id, amount, payment_status, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("iiis", $user_id, $bus_id, $total_cost, $payment_status);
    if (!$stmt->execute()) {
        throw new Exception("Error processing payment.");
    }

    // Commit the transaction after successful booking and payment insertion
    $conn->commit();
    echo "<script>alert('Payment successful! Your seats have been booked.'); window.location.href = 'ticket.php';</script>";

} catch (Exception $e) {
    // Rollback the transaction if any query fails
    $conn->rollback();
    echo "<script>alert('Payment failed: " . $e->getMessage() . ". Please try again.'); window.history.back();</script>";
} finally {
    // Close connection
    $conn->close();
}
?>
