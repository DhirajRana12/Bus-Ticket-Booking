<?php
include '../Database/database.php'; // Include your database connection file

// Check if bus ID is passed through the GET request
if (isset($_GET['id'])) {
    $bus_id = $_GET['id'];

    // Fetch bus seat details for the selected bus ID
    $sql = "SELECT * FROM bus_seats WHERE bus_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bus_id); // 'i' denotes integer
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch bus details
    if ($result->num_rows > 0) {
        $seats = $result->fetch_all(MYSQLI_ASSOC); // Fetch all seats for the bus
    } else {
        echo "No seats found for this bus.";
        exit;
    }
} else {
    echo "No bus ID provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Seat Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .back-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Bus Seat Details</h2>
        <table>
            <thead>
                <tr>
                    <th>Seat ID</th>
                    <th>Bus ID</th>
                    <th>Route ID</th>
                    <th>Seat Number</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($seats as $seat): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($seat['id']); ?></td>
                        <td><?php echo htmlspecialchars($seat['bus_id']); ?></td>
                        <td><?php echo htmlspecialchars($seat['route_id']); ?></td>
                        <td><?php echo htmlspecialchars($seat['seat_number']); ?></td>
                        <td><?php echo htmlspecialchars($seat['status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a class="back-btn" href="your_previous_page.php">Go Back</a>
    </div>
</body>
</html>
