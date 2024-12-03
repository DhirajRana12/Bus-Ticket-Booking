<?php
include '../Database/database.php';

// Handle Add Schedule
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_schedule'])) {
    $bus_id = $_POST['bus_id'];
    $from_location = $_POST['from_location'];
    $to_location = $_POST['to_location'];
    $departure_time = $_POST['departure_time'];
    $eta = $_POST['eta'];
    $price = $_POST['price'];

    $sql = "INSERT INTO schedule_list (bus_id, from_location, to_location, departure_time, eta, price) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssi", $bus_id, $from_location, $to_location, $departure_time, $eta, $price);
    
    if ($stmt->execute()) {
        echo "<p>Schedule added successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }
}

// Handle Update Schedule
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_schedule'])) {
    $schedule_id = $_POST['schedule_id'];
    $bus_id = $_POST['bus_id'];
    $from_location = $_POST['from_location'];
    $to_location = $_POST['to_location'];
    $departure_time = $_POST['departure_time'];
    $eta = $_POST['eta'];
    $price = $_POST['price'];

    $sql = "UPDATE schedule_list SET bus_id = ?, from_location = ?, to_location = ?, departure_time = ?, eta = ?, price = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssii", $bus_id, $from_location, $to_location, $departure_time, $eta, $price, $schedule_id);
    
    if ($stmt->execute()) {
        echo "<p>Schedule updated successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }
}

// Handle Delete Schedule
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $schedule_id = $_GET['id'];

    $sql = "DELETE FROM schedule_list WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $schedule_id);

    if ($stmt->execute()) {
        echo "<p>Schedule deleted successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }
}

// Fetch All Schedules
$sql = "SELECT * FROM schedule_list";
$result = $conn->query($sql);

// Fetch All Buses for Dropdown
$buses_sql = "SELECT * FROM buses";
$buses_result = $conn->query($buses_sql);

// Fetch All Routes for Dropdown
$routes_sql = "SELECT * FROM routes";
$routes_result = $conn->query($routes_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Schedules</title>
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
        <h2>Manage Schedules</h2>

        <!-- Add Schedule Form -->
        <h3>Add New Schedule</h3>
        <form action="manage_schedules.php" method="post">
            <input type="hidden" name="add_schedule">
            <div class="form-group">
                <label for="bus_id">Bus:</label>
                <select id="bus_id" name="bus_id" required>
                    <option value="">Select Bus</option>
                    <?php while ($bus = $buses_result->fetch_assoc()): ?>
                        <option value="<?php echo $bus['id']; ?>"><?php echo htmlspecialchars($bus['name']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="from_location">From Location:</label>
                <select id="from_location" name="from_location" required>
                    <option value="">Select Route</option>
                    <?php while ($route = $routes_result->fetch_assoc()): ?>
                        <option value="<?php echo $route['id']; ?>"><?php echo htmlspecialchars($route['departure_city']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="to_location">To Location:</label>
                <select id="to_location" name="to_location" required>
                    <option value="">Select Route</option>
                    <?php $routes_result->data_seek(0); // Reset pointer for to_location dropdown ?>
                    <?php while ($route = $routes_result->fetch_assoc()): ?>
                        <option value="<?php echo $route['id']; ?>"><?php echo htmlspecialchars($route['destination_city']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="departure_time">Departure Time:</label>
                <input type="time" id="departure_time" name="departure_time" required>
            </div>
            <div class="form-group">
                <label for="eta">Estimated Arrival Time:</label>
                <input type="time" id="eta" name="eta" required>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" required>
            </div>
            <div class="form-group">
                <button type="submit">Add Schedule</button>
                <a href="dashboard.php" style="text-decoration: none; margin-left: 10px;">
                <button type="button">Back</button>
                </a>
            </div>
        </form>

        <!-- Update Schedule Form (Populated When Edit Button is Clicked) -->
        <?php if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])):
            $schedule_id = $_GET['id'];
            $sql = "SELECT * FROM schedule_list WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $schedule_id);
            $stmt->execute();
            $schedule = $stmt->get_result()->fetch_assoc();
        ?>
        <h3>Edit Schedule</h3>
        <form action="manage_schedules.php" method="post">
            <input type="hidden" name="update_schedule">
            <input type="hidden" name="schedule_id" value="<?php echo $schedule['id']; ?>">
            <div class="form-group">
                <label for="bus_id">Bus:</label>
                <select id="bus_id" name="bus_id" required>
                    <?php
                    $buses_result->data_seek(0); // Reset the buses result pointer
                    while ($bus = $buses_result->fetch_assoc()): ?>
                        <option value="<?php echo $bus['id']; ?>" <?php echo $schedule['bus_id'] == $bus['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($bus['name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="from_location">From Location:</label>
                <select id="from_location" name="from_location" required>
                    <?php
                    $routes_result->data_seek(0); // Reset pointer for from_location dropdown
                    while ($route = $routes_result->fetch_assoc()): ?>
                        <option value="<?php echo $route['id']; ?>" <?php echo $schedule['from_location'] == $route['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($route['departure_city']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="to_location">To Location:</label>
                <select id="to_location" name="to_location" required>
                    <?php
                    $routes_result->data_seek(0); // Reset pointer for to_location dropdown
                    while ($route = $routes_result->fetch_assoc()): ?>
                        <option value="<?php echo $route['id']; ?>" <?php echo $schedule['to_location'] == $route['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($route['destination_city']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="departure_time">Departure Time:</label>
                <input type="time" id="departure_time" name="departure_time" value="<?php echo $schedule['departure_time']; ?>" required>
            </div>
            <div class="form-group">
                <label for="eta">Estimated Arrival Time:</label>
                <input type="time" id="eta" name="eta" value="<?php echo $schedule['eta']; ?>" required>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" value="<?php echo $schedule['price']; ?>" required>
            </div>
            <div class="form-group">
                <button type="submit">Update Schedule</button>
            </div>
        </form>
        <?php endif; ?>

        <!-- Display Schedules -->
        <h3>Current Schedules</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Bus</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Departure Time</th>
                    <th>ETA</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($schedule = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $schedule['id']; ?></td>
                    <td><?php echo $schedule['bus_id']; ?></td>
                    <td><?php echo $schedule['from_location']; ?></td>
                    <td><?php echo $schedule['to_location']; ?></td>
                    <td><?php echo $schedule['departure_time']; ?></td>
                    <td><?php echo $schedule['eta']; ?></td>
                    <td><?php echo $schedule['price']; ?></td>
                    <td class="actions">
                        <a href="manage_schedules.php?action=edit&id=<?php echo $schedule['id']; ?>">Edit</a>
                        <a href="manage_schedules.php?action=delete&id=<?php echo $schedule['id']; ?>" onclick="return confirm('Are you sure you want to delete this schedule?');">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html> 