<?php
// Include the database connection
include '../Database/database.php'; // Adjust the path as necessary

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_bus'])) {
        // Capture form data for adding a new bus
        $bus_number = $_POST['bussno'];
        $name = $_POST['name'];
        $status = isset($_POST['status']) ? (int)$_POST['status'] : 1; // Default to 1 (active)

        // Prepare and execute the bus insertion query
        $stmt = $conn->prepare("INSERT INTO buses (name, bus_number, status) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $name, $bus_number, $status);

        if ($stmt->execute()) {
            // Get the ID of the newly inserted bus
            $bus_id = $conn->insert_id;

            // Generate and insert 37 seats for this bus
            $seat_labels = [];
            $columns = ['A', 'B'];

            foreach ($columns as $column) {
                for ($i = 1; $i <= 16; $i++) { // 9 rows for each column (A1 to A16, B1 to B16, etc.)
                    $seat_labels[] = $column . $i;
                }
            }

            // Adding the last row with 5 seats
            $seat_labels = array_merge($seat_labels, ['C1', 'C2', 'C3', 'C4', 'C5']);

            // Insert seats into bus_seats table
            foreach ($seat_labels as $seat_label) {
                $seat_stmt = $conn->prepare("INSERT INTO bus_seats (bus_id, seat_number) VALUES (?, ?)");
                $seat_stmt->bind_param("is", $bus_id, $seat_label);
                $seat_stmt->execute();
            }

            echo "<p style='color: green;'>Bus and its 37 seats added successfully.</p>";
        } else {
            echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } elseif (isset($_POST['update_status'])) {
        // Update bus status
        $bus_id = $_POST['bus_id'];
        $status = $_POST['status'];

        // Prepare and execute the status update query
        $stmt = $conn->prepare("UPDATE buses SET status = ? WHERE id = ?");
        $stmt->bind_param("ii", $status, $bus_id);

        if ($stmt->execute()) {
            echo "<p style='color: green;'>Bus status updated successfully.</p>";
        } else {
            echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }
}

// Fetch all buses from the database
$buses_result = $conn->query("SELECT id, name, bus_number, status FROM buses ORDER BY id DESC");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Bus</title>
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
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group select {
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
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        form {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add New Bus</h2>
        <form action="" method="post">
            <input type="hidden" name="add_bus" value="1">
            <div class="form-group">
                <label for="busno">Bus Number:</label>
                <input type="text" id="busno" name="bussno" required>
            </div>
            <div class="form-group">
                <label for="name">Bus Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit">Add Bus</button>
                <a href="dashboard.php" style="text-decoration: none; margin-left: 10px;">
                <button type="button">Back</button>
                </a>
            </div>
        </form>

        <!-- Display existing buses -->
        <h3>Existing Buses</h3>
        <table>
            <thead>
                <tr>
                    <th>Bus ID</th>
                    <th>Bus Number</th>
                    <th>Bus Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($buses_result->num_rows > 0): ?>
                    <?php while ($bus = $buses_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $bus['id']; ?></td>
                            <td><?php echo $bus['bus_number']; ?></td>
                            <td><?php echo $bus['name']; ?></td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="bus_id" value="<?php echo $bus['id']; ?>">
                                    <select name="status" onchange="this.form.submit()">
                                        <option value="1" <?php echo $bus['status'] == 1 ? 'selected' : ''; ?>>Active</option>
                                        <option value="0" <?php echo $bus['status'] == 0 ? 'selected' : ''; ?>>Inactive</option>
                                    </select>
                                    <input type="hidden" name="update_status" value="1">
                                </form>
                            </td>
                            <td>
                                <button onclick="this.parentNode.parentNode.querySelector('form').submit();">Update Status</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No buses found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
