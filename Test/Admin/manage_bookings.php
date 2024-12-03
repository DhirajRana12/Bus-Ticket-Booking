<?php
include '../Database/database.php'; // Include your database connection

// Handle booking deletion
if (isset($_GET['delete_id'])) {
    $booking_id = $_GET['delete_id'];

    $delete_query = "DELETE FROM bookings WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param('i', $booking_id);

    if ($stmt->execute()) {
        header("Location: manage_bookings.php?success=Booking deleted successfully.");
        exit();
    } else {
        header("Location: manage_bookings.php?error=Error deleting booking.");
        exit();
    }
}

// Handle booking update (if the form is submitted)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_booking'])) {
    $booking_id = $_POST['booking_id'];
    $seat_number = $_POST['seat_number'];
    $booking_date = $_POST['booking_date'];

    $update_query = "UPDATE bookings SET seat_number = ?, booking_date = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('ssi', $seat_number, $booking_date, $booking_id);

    if ($stmt->execute()) {
        header("Location: manage_bookings.php?success=Booking updated successfully.");
        exit();
    } else {
        header("Location: manage_bookings.php?error=Error updating booking.");
        exit();
    }
}

// Fetch bookings to display
$query = "SELECT bookings.id, users.name AS user_name, users.email, buses.name AS bus_name, routes.departure_city, 
          routes.destination_city, bookings.seat_number, bookings.booking_date 
          FROM bookings 
          JOIN users ON bookings.user_id = users.id 
          JOIN buses ON bookings.bus_id = buses.id 
          JOIN routes ON bookings.route_id = routes.id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <style>
        /* General Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #2980b9;
            color: white;
            text-align: left;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        .action-btn {
            padding: 5px 10px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .delete-btn {
            background-color: #e74c3c;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            width: 400px;
            max-width: 90%;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            animation: fadeIn 0.4s ease-in-out;
        }
        @keyframes fadeIn {
            from {opacity: 0; transform: scale(0.9);}
            to {opacity: 1; transform: scale(1);}
        }
        .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            transition: color 0.3s ease;
        }
        .close-btn:hover,
        .close-btn:focus {
            color: #e74c3c;
            cursor: pointer;
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .modal-header h3 {
            font-size: 24px;
            color: #333;
        }
        .modal-body {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .modal-body label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .modal-body input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
        }
        .modal-body input[type="submit"] {
            background-color: #3498db;
            color: white;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
        }
        .modal-body input[type="submit"]:hover {
            background-color: #2980b9;
        }

        /* Back button styles */
        .back-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .back-btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <!-- Back button -->
    <a href="dashboard.php" class="back-btn">Back</a>

    <h2>Manage Bookings</h2>

    <!-- Display success/error messages -->
    <?php if (isset($_GET['success'])): ?>
        <div style="color: green;"><?php echo $_GET['success']; ?></div>
    <?php elseif (isset($_GET['error'])): ?>
        <div style="color: red;"><?php echo $_GET['error']; ?></div>
    <?php endif; ?>

    <!-- Booking Table -->
    <table>
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>User</th>
                <th>Email</th>
                <th>Bus</th>
                <th>Route</th>
                <th>Seat Number</th>
                <th>Booking Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['user_name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['bus_name']; ?></td>
                <td><?php echo $row['departure_city'] . " - " . $row['destination_city']; ?></td>
                <td><?php echo $row['seat_number']; ?></td>
                <td><?php echo $row['booking_date']; ?></td>
                <td>
                    <a class="action-btn" href="javascript:void(0);" onclick="openModal(<?php echo $row['id']; ?>, '<?php echo $row['user_name']; ?>', '<?php echo $row['email']; ?>', '<?php echo $row['seat_number']; ?>', '<?php echo $row['booking_date']; ?>')">Edit</a>
                    <a class="action-btn delete-btn" href="manage_bookings.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit Booking</h3>
                <span class="close-btn" onclick="closeModal()">&times;</span>
            </div>
            <div class="modal-body">
                <form method="POST" action="manage_bookings.php">
                    <input type="hidden" name="booking_id" id="booking_id">
                    
                    <label for="user_name">User:</label>
                    <input type="text" id="user_name" name="user_name" readonly>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" readonly>

                    <label for="seat_number">Seat Number:</label>
                    <input type="text" id="seat_number" name="seat_number" required pattern="[A-B][0-9]" title="Seat number must be in the format 'A1', 'B2', etc."><br>

                    <label for="booking_date">Booking Date:</label>
                    <input type="date" id="booking_date" name="booking_date" required>

                    <input type="submit" name="update_booking" value="Update Booking">
                </form>
            </div>
        </div>
    </div>

    <script>
        // Function to open the modal and populate it with booking data
        function openModal(id, userName, email, seatNumber, bookingDate) {
            document.getElementById('booking_id').value = id;
            document.getElementById('user_name').value = userName;
            document.getElementById('email').value = email;
            document.getElementById('seat_number').value = seatNumber;
            document.getElementById('booking_date').value = bookingDate;
            
            document.getElementById('editModal').style.display = "flex";
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById('editModal').style.display = "none";
        }
    </script>
</body>
</html>
