<?php

session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You are not logged in. Please log in first.";
    exit;
}
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

// Fetch data from the form using the GET method
$from = $_GET['from'] ?? '';  // Default to empty string if not set
$to = $_GET['to'] ?? '';      // Default to empty string if not set
$date = $_GET['date'] ?? '';  // Default to empty string if not set

// Prepare the SQL statement to prevent SQL injection
// Prepare the SQL statement to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM routes WHERE `departure_city` = ? AND `destination_city` = ? AND `date` = ?");
$stmt->bind_param("sss", $from, $to, $date);

// Execute the query
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Routes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
            position: relative;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .view-seat-btn {
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .view-seat-btn:hover {
            background-color: #0056b3;
        }
        .no-results {
            text-align: center;
            padding: 20px;
            font-size: 18px;
            color: #888;
        }
        .back-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .back-btn:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <a href="../index.php" class="back-btn">Back</a>
    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            // Output data for each row in an HTML table
            echo "<table>
            <tr>
                <th>From</th>
                <th>To</th>
                <th>Date</th>
                <th>Bus Number</th>
                <th>Travel Time</th> <!-- New column for Travel Time -->
                <th>Action</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        // Check and sanitize variables before outputting
        $departure_city = htmlspecialchars($row['departure_city'] ?? '');
        $destination_city = htmlspecialchars($row['destination_city'] ?? '');
        $date = htmlspecialchars($row['date'] ?? '');
        $bussno = htmlspecialchars($row['bussno'] ?? '');  // Ensure this matches your column name
        $travel_time = htmlspecialchars($row['travel_time'] ?? ''); // Fetching travel_time
    
        echo "<tr>
                <td>" . $departure_city . "</td>
                <td>" . $destination_city . "</td>
                <td>" . $date . "</td>
                <td>" . $bussno . "</td>
                <td>" . ucfirst($travel_time) . "</td> <!-- Displaying travel_time with the first letter capitalized -->
                <td><a href='seats.php?busno=" . urlencode($bussno) . "' class='view-seat-btn'>View Seats</a></td>
              </tr>";
    }
    
            echo "</table>";
        } else {
            echo "<div class='no-results'>No routes found for the selected criteria.</div>";
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
        ?>
    </div>
</body>
</html>
