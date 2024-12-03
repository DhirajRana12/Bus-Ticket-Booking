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

$busno = $_GET['busno'] ?? '';
$user_id = $_SESSION['user_id'] ?? null;

if ($busno) {
    // Get bus ID
    $stmt = $conn->prepare("SELECT id FROM buses WHERE bus_number = ?");
    $stmt->bind_param("s", $busno);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $bus_id = $row['id'];

        // Get seat information
        $stmt = $conn->prepare("SELECT seat_number, status FROM bus_seats WHERE bus_id = ?");
        $stmt->bind_param("i", $bus_id);
        $stmt->execute();
        $seats_result = $stmt->get_result();

        $seats = [];
        while ($seat_row = $seats_result->fetch_assoc()) {
            $seats[$seat_row['seat_number']] = $seat_row['status'];
        }
    } else {
        $error_message = "Bus not found.";
    }
} else {
    $error_message = "No bus number provided.";
}

// Handle booking submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_seats = json_decode($_POST['seats'] ?? '[]', true);
    $route_bussno = $_POST['busno'] ?? '';

    if (empty($selected_seats)) {
        echo "<script>alert('No seats selected.');</script>";
    } else {
        if (!$user_id) {
            echo "<script>alert('User not logged in.');</script>";
        } else {
            // ** Start of FCFS logic with transaction handling **
            $conn->begin_transaction();

            try {
                // Check if route exists
                $stmt = $conn->prepare("SELECT id FROM routes WHERE bussno = ?");
                $stmt->bind_param("s", $route_bussno);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $route_id = $row['id'];

                    $stmt = $conn->prepare("INSERT INTO bookings (user_id, bus_id, route_id, seat_number, booking_date, created_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
                    $updateSeatStmt = $conn->prepare("UPDATE bus_seats SET status = 'booked', route_id = ? WHERE bus_id = ? AND seat_number = ? AND status = 'available'");

                    foreach ($selected_seats as $seat_number) {
                        // Lock seat for the current transaction
                        $updateSeatStmt->bind_param("iis", $route_id, $bus_id, $seat_number);
                        $updateSeatStmt->execute();

                        if ($updateSeatStmt->affected_rows > 0) {
                            // Seat was successfully booked, now insert into bookings
                            $stmt->bind_param("iiis", $user_id, $bus_id, $route_id, $seat_number);
                            $stmt->execute();
                        } else {
                            // Seat is already booked by another user
                            throw new Exception("Seat $seat_number is already booked by another user.");
                        }
                    }

                    // Commit transaction
                    $conn->commit();
                    echo "<script>alert('Booking successful!'); window.location.href = 'ticket.php?booking_id=" . $conn->insert_id . "';</script>";
                    exit;
                } else {
                    throw new Exception("Route not found.");
                }
            } catch (Exception $e) {
                // Rollback transaction in case of error
                $conn->rollback();
                echo "<script>alert('" . $e->getMessage() . "');</script>";
            }

            $stmt->close();
            $updateSeatStmt->close();
            // ** End of FCFS logic **
        }
    }
}

// Get user's booked seats
$booked_seats = [];
if ($user_id) {
    $stmt = $conn->prepare("SELECT seat_number FROM bookings WHERE user_id = ? AND bus_id = ?");
    $stmt->bind_param("ii", $user_id, $bus_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $booked_seats[] = $row['seat_number'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Seat Layout for Bus <?php echo htmlspecialchars($busno); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        .container {
            display: flex;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .seat-map-container {
            width: 320px;
        }

        .user-bookings {
            margin-left: 20px;
        }

        .seat-map {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            margin-bottom: 20px;
        }

        .seat {
            width: 40px;
            height: 40px;
            background-color: #007bff;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .seat.selected {
            background-color: #ff9800;
        }

        .seat.booked {
            background-color: #9e9e9e;
            cursor: not-allowed;
        }

        .seat.non-selectable {
            background-color: #333;
            cursor: default;
        }

        .seat:hover:not(.booked):not(.non-selectable) {
            background-color: #0056b3;
        }

        .last-row {
            grid-column: span 4;
            display: flex;
            justify-content: space-between;
            padding-top: 10px;
        }

        .last-row .seat {
            flex: 1;
            margin: 0 5px;
        }

        .driver-seat {
            grid-column: span 4;
            margin-bottom: 10px;
        }

        .seat-info {
            margin-top: 20px;
            font-size: 16px;
        }

        .seat-info span {
            display: inline-block;
            margin: 10px;
            font-size: 14px;
        }

        .legend-seat {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 4px;
            vertical-align: middle;
        }

        .legend-seat.available {
            background-color: #007bff;
        }

        .legend-seat.selected {
            background-color: #ff9800;
        }

        .legend-seat.booked {
            background-color: #9e9e9e;
        }

        .book-btn {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #28a745;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .book-btn:hover {
            background-color: #218838;
        }

        .back-btn {
            margin-top: 20px;
            padding: 10px 90px;
            background-color: #6c757d;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .back-btn:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="seat-map-container">
            <h2>Bus Number: <?php echo htmlspecialchars($busno); ?></h2>
            <?php if (isset($error_message)): ?>
                <p><?php echo htmlspecialchars($error_message); ?></p>
            <?php else: ?>
                <div class="seat-map">
                    <!-- Driver Seat (non-selectable) -->
                    <div class="seat driver-seat non-selectable" data-seat="Driver">Driver</div>

                    <?php
                    $seat_numbers = [
                        'A2', 'A1', 'B1', 'B2', 
                        'A4', 'A3', 'B3', 'B4',  
                        'A6', 'A5', 'B5', 'B6',  
                        'A8', 'A7', 'B7', 'B8', 
                        'A10', 'A9', 'B9', 'B10', 
                        'A12', 'A11', 'B11', 'B12',  
                        'A14', 'A13', 'B13', 'B14',  
                        'A16', 'A15', 'B15', 'B16', 
                    ];

                    foreach ($seat_numbers as $seat_number) {
                        $status = isset($seats[$seat_number]) ? $seats[$seat_number] : 'available';
                        echo "<div class='seat $status' data-seat-number='$seat_number'>$seat_number</div>";
                    }

                    echo "<div class='last-row'>";
                    for ($i = 17; $i <= 21; $i++) {
                        $status = isset($seats[$i]) ? $seats[$i] : 'available';
                        echo "<div class='seat $status' data-seat-number='$i'>$i</div>";
                    }
                    echo "</div>";
                    ?>
                </div>

                <form id="bookingForm" method="POST" action="payment.php">
                    <input type="hidden" name="seats" id="selectedSeats">
                    <input type="hidden" name="busno" value="<?php echo htmlspecialchars($busno); ?>">
                    <button type="submit" class="book-btn">Book You Seat</button>
                </form>

                <form action="../index.php" method="GET">
                    <button type="submit" class="back-btn">Back</button>
                </form>

                <div class="seat-info">
                    <span><div class="legend-seat available"></div> Available</span>
                    <span><div class="legend-seat selected"></div> Selected</span>
                    <span><div class="legend-seat booked"></div> Booked</span>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($booked_seats)): ?>
            <div class="user-bookings">
                <h3>Your Booked Seats:</h3>
                <ul>
                    <?php foreach ($booked_seats as $seat): ?>
                        <li><?php echo htmlspecialchars($seat); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>

    <script>
        const seats = document.querySelectorAll('.seat');
        const selectedSeatsInput = document.getElementById('selectedSeats');

        let selectedSeats = [];

        seats.forEach(seat => {
            if (!seat.classList.contains('booked') && !seat.classList.contains('non-selectable')) {
                seat.addEventListener('click', () => {
                    const seatNumber = seat.getAttribute('data-seat-number');
                    seat.classList.toggle('selected');

                    if (selectedSeats.includes(seatNumber)) {
                        selectedSeats = selectedSeats.filter(s => s !== seatNumber);
                    } else {
                        selectedSeats.push(seatNumber);
                    }

                    selectedSeatsInput.value = JSON.stringify(selectedSeats);
                });
            }
        });
    </script>
</body>
</html>