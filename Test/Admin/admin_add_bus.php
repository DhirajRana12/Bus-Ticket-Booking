<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bus_name = $_POST['bus_name'];
    $bus_number = $_POST['bus_number'];
    $total_seats = $_POST['total_seats'];

    $sql = "INSERT INTO buses (bus_name, bus_number, total_seats, available_seats) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $bus_name, $bus_number, $total_seats, $total_seats);
    
    if ($stmt->execute()) {
        echo "Bus added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
