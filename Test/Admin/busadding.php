<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "bus_ticketing_system";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the form
$bus_number = isset($_POST['bussno']) ? $_POST['bussno'] : '';
$seats = isset($_POST['seat']) ? $_POST['seat'] : 0;
$travel_date = isset($_POST['date']) ? $_POST['date'] : '';
$destination_city = isset($_POST['destination']) ? $_POST['destination'] : '';
$departure_city = isset($_POST['departure_city']) ? $_POST['departure_city'] : '';

// Ensure all fields are filled
if (!empty($bus_number) && !empty($seats) && !empty($travel_date) && !empty($destination_city) && !empty($departure_city)) {
    // Prepare the SQL statement to insert into the buses table
    $stmt = $conn->prepare("INSERT INTO buses (name, bus_number, status, date_updated) VALUES (?, ?, ?, ?)");
    $name = 'Bus'; // Example name, adjust as needed
    $status = 'Available'; // Example status, adjust as needed
    $date_updated = date('Y-m-d'); // Current date

    $stmt->bind_param("ssss", $name, $bus_number, $status, $date_updated);

    if ($stmt->execute()) {
        echo "Bus added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Please fill in all required fields.";
}

// Close the connection
$conn->close();
?>
