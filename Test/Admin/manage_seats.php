<?php
include '../Database/database.php';

// Fetch All Buses
$buses_sql = "SELECT * FROM buses";
$buses_result = $conn->query($buses_sql);

// Fetch All Seats if a bus is selected
$selected_bus_id = isset($_GET['bus_id']) ? (int)$_GET['bus_id'] : null;
$seats_result = null;
if ($selected_bus_id) {
    $seats_sql = "SELECT * FROM bus_seats WHERE bus_id = ?";
    $stmt = $conn->prepare($seats_sql);
    $stmt->bind_param("i", $selected_bus_id);
    $stmt->execute();
    $seats_result = $stmt->get_result();
}

// Handle Add, Update, Delete Seat Logic
function handleSeatActions($conn) {
    // Same as before...
}

$message = handleSeatActions($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Seats</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #eef2f3;
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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #007bff;
        }
        .bus-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }
        .bus-card {
            flex: 1 1 calc(33% - 10px);
            background: #f4f4f4;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: background 0.3s;
        }
        .bus-card:hover {
            background: #e0e0e0;
        }
        .seat-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }
        .seat {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }
        .seat.available {
            background-color: #28a745;
            color: white;
        }
        .seat.booked {
            background-color: #dc3545;
            color: white;
        }
        .actions {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Buses and Seats</h2>
        
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Display Buses -->
        <h3>Available Buses</h3>
        <div class="bus-grid">
            <?php while ($bus = $buses_result->fetch_assoc()): ?>
                <div class="bus-card" onclick="window.location.href='?bus_id=<?php echo $bus['id']; ?>'">
                    <h4><?php echo htmlspecialchars($bus['name']); ?></h4>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Display Seats if a bus is selected -->
        <?php if ($seats_result): ?>
            <h3>Seats for Bus ID: <?php echo $selected_bus_id; ?></h3>
            <div class="seat-grid">
                <?php while ($seat = $seats_result->fetch_assoc()): ?>
                    <div class="seat <?php echo htmlspecialchars($seat['status']); ?>">
                        <?php echo htmlspecialchars($seat['seat_number']); ?>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
        
        <!-- Add Seat Form -->
        <h3>Add New Seat</h3>
        <form action="manage_seats.php" method="post">
            <input type="hidden" name="add_seat">
            <input type="hidden" name="bus_id" value="<?php echo $selected_bus_id; ?>">
            <div class="form-group">
                <label for="seat_number">Seat Number:</label>
                <input type="text" id="seat_number" name="seat_number" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="available">Available</option>
                    <option value="booked">Booked</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit">Add Seat</button>
            </div>
        </form>
    </div>
</body>
</html>
