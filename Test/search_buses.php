<?php
include 'connection.php';

$from = $_POST['from'];
$to = $_POST['to'];
$date = $_POST['date'];

// Fetch buses that match the criteria
$query = "SELECT * FROM Buses WHERE departure_location='$from' AND arrival_location='$to'";
$result = mysqli_query($conn, $query);

while($bus = mysqli_fetch_assoc($result)){
    echo "Bus Name: " . $bus['bus_name'] . "<br>";
    // Add more details and a booking button
}
?>
