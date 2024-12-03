<?php
include '../Database/database.php';

// Handle Add Bus
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_bus'])) {
    $bus_name = $_POST['bus_name'];
    $bus_number = $_POST['bus_number'];
    $total_seats = $_POST['total_seats'];

    $sql = "INSERT INTO buses (bus_name, bus_number, total_seats, available_seats) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $bus_name, $bus_number, $total_seats, $total_seats);
    
    if ($stmt->execute()) {
        echo "<p>Bus added successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }
}

// Handle Update Bus
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_bus'])) {
    $bus_id = $_POST['bus_id'];
    $bus_name = $_POST['bus_name'];
    $bus_number = $_POST['bus_number'];
    $total_seats = $_POST['total_seats'];

    $sql = "UPDATE buses SET bus_name = ?, bus_number = ?, total_seats = ?, available_seats = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiii", $bus_name, $bus_number, $total_seats, $total_seats, $bus_id);
    
    if ($stmt->execute()) {
        echo "<p>Bus updated successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }
}

// Handle Delete Bus
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $bus_id = $_GET['id'];

    $sql = "DELETE FROM buses WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bus_id);

    if ($stmt->execute()) {
        echo "<p>Bus deleted successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }
}

// Fetch All Buses
$sql = "SELECT * FROM buses";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Buses</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .back-button, .add-button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            margin-bottom: 20px;
            display: inline-block;
        }
        .back-button:hover, .add-button:hover {
            background-color: #0056b3;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-group button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .form-group button:hover {
            background-color: #0056b3;
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
        .actions a {
            margin-right: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .actions a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Buses</h2>
        
        <!-- Back Button -->
        <a href="dashboard.php" class="back-button">Back</a>
        <a href="manage_bus.php?action=add" class="add-button">Add Bus</a>

        <!-- Add Bus Form -->
        <h3>Add New Bus</h3>
        <form action="busmanagement.php" method="post">
            <input type="hidden" name="add_bus">
            <div class="form-group">
                <label for="bus_name">Bus Name:</label>
                <input type="text" id="bus_name" name="bus_name" required>
            </div>
            <div class="form-group">
                <label for="bus_number">Bus Number:</label>
                <input type="text" id="bus_number" name="bus_number" required>
            </div>
            <div class="form-group">
                <label for="total_seats">Total Seats:</label>
                <input type="number" id="total_seats" name="total_seats" required>
            </div>
            <div class="form-group">
                <button type="submit">Add Bus</button>
            </div>
        </form>

        <!-- Update Bus Form (Populated When Edit Button is Clicked) -->
        <?php if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])):
            $bus_id = $_GET['id'];
            $sql = "SELECT * FROM buses WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $bus_id);
            $stmt->execute();
            $bus = $stmt->get_result()->fetch_assoc();
        ?>
        <h3>Edit Bus</h3>
        <form action="busmanagement.php" method="post">
            <input type="hidden" name="update_bus">
            <input type="hidden" name="bus_id" value="<?php echo $bus['id']; ?>">
            <div class="form-group">
                <label for="bus_name">Bus Name:</label>
                <input type="text" id="bus_name" name="bus_name" value="<?php echo htmlspecialchars($bus['bus_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="bus_number">Bus Number:</label>
                <input type="text" id="bus_number" name="bus_number" value="<?php echo htmlspecialchars($bus['bus_number']); ?>" required>
            </div>
            <div class="form-group">
                <label for="total_seats">Total Seats:</label>
                <input type="number" id="total_seats" name="total_seats" value="<?php echo htmlspecialchars($bus['total_seats']); ?>" required>
            </div>
            <div class="form-group">
                <button type="submit">Update Bus</button>
            </div>
        </form>
        <?php endif; ?>

        <!-- Display Buses -->
        <h3>Existing Buses</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Bus Name</th>
                    <th>Bus Number</th>
                    <th>Total Seats</th>
                    <th>Available Seats</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['bus_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['bus_number']); ?></td>
                    <td><?php echo htmlspecialchars($row['total_seats']); ?></td>
                    <td><?php echo htmlspecialchars($row['available_seats']); ?></td>
                    <td class="actions">
                        <a href="busmanagement.php?action=edit&id=<?php echo $row['id']; ?>">Edit</a>
                        <a href="busmanagement.php?action=delete&id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this bus?');">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
