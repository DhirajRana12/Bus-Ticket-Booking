<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "bus_ticketing_system";

// Connect to the database
$conn = new mysqli($servername, $db_username, $db_password, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve user ID and post data
$user_id = $_SESSION['user_id'] ?? null;
$selected_seats = json_decode($_POST['seats'] ?? '[]', true);
$busno = $_POST['busno'] ?? '';

if (!$user_id || empty($selected_seats) || empty($busno)) {
    die("Invalid request. Please try again.");
}

// Fetch bus ID based on bus number
$stmt = $conn->prepare("SELECT id FROM buses WHERE bus_number = ?");
$stmt->bind_param("s", $busno);
$stmt->execute();
$bus_result = $stmt->get_result();
$bus_data = $bus_result->fetch_assoc();

if (!$bus_data) {
    die("Bus not found.");
}

$bus_id = $bus_data['id'];
$stmt->close();

// Fetch seat price from the routes table or any other relevant table
$stmt = $conn->prepare("SELECT priceperseat FROM routes WHERE bussno = ?");
$stmt->bind_param("s", $busno);
$stmt->execute();
$stmt->bind_result($seat_price);
$stmt->fetch();
$stmt->close();

if (!$seat_price) {
    $seat_price = 100; // Default fallback price if none is found in the database
}

// Calculate total cost based on selected seats
$total_cost = count($selected_seats) * $seat_price;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .pay-btn {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .pay-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Payment for Bus <?php echo htmlspecialchars($busno); ?></h2>
        <p>Selected Seats: <?php echo htmlspecialchars(implode(', ', $selected_seats)); ?></p>
        <p>Total Cost: Rs. <?php echo htmlspecialchars($total_cost); ?></p>

        <!-- Payment Form -->
        <form action="process_payment.php" method="POST">
            <input type="hidden" name="bus_id" value="<?php echo htmlspecialchars($bus_id); ?>">
            <input type="hidden" name="seats" value="<?php echo htmlspecialchars(json_encode($selected_seats)); ?>">
            <input type="hidden" name="total_cost" value="<?php echo htmlspecialchars($total_cost); ?>">
            <button type="submit" class="pay-btn">Pay to Book</button>
        </form>
    </div>
</body>
</html>
