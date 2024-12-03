<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database_name"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO routes (departure_city, destination_city, travel_time, date, bussno, seat, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("ssssss", $departure_city, $destination_city, $travel_time, $date, $bussno, $seat);

// Set parameters and execute
$departure_city = $_POST['departure_city'];
$destination_city = $_POST['destination_city'];
$travel_time = $_POST['travel_time'];
$date = $_POST['date'];
$bussno = $_POST['bussno'];
$seat = $_POST['seat'];

if ($stmt->execute()) {
    echo "New route added successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
