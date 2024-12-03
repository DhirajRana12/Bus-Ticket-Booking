<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Bus Ticket Booking</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <header class="bg-green-600 text-white shadow-lg">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <div class="logo">
                <img src="Buslogo.jpg" alt="Bus Ticket System" class="h-12">
            </div>
            <nav class="flex gap-6">
                <a href="../Index.php" class="hover:bg-green-700 py-2 px-4 rounded">Home</a>
                <a href="User/ticket.php" class="hover:bg-green-700 py-2 px-4 rounded">Bus Tickets</a>
                <a href="#" class="hover:bg-green-700 py-2 px-4 rounded">Help</a>
                <div class="relative">
                    <button id="accountBtn" class="hover:bg-green-700 py-2 px-4 rounded focus:outline-none">Account</button>
                    <div class="dropdown-content absolute hidden bg-white text-black shadow-lg rounded mt-2 w-48">
                        <a href="login.php" id="loginBtn" class="block px-4 py-2 hover:bg-gray-200">Login</a>
                        <a href="register.php" id="registerBtn" class="block px-4 py-2 hover:bg-gray-200">Register</a>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <?php
    session_start();
    include('../Database/database.php'); // Ensure you have a database connection file

    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Query to fetch booking details for the logged-in user
        $sql = "SELECT 
                    bookings.id AS booking_id, 
                    users.name AS user_name, 
                    buses.name AS bus_name, 
                    buses.bus_number, 
                    routes.departure_city, 
                    routes.destination_city, 
                    routes.travel_time, 
                    bookings.seat_number, 
                    routes.priceperseat, 
                    bookings.booking_date, 
                    bookings.created_at 
                FROM bookings 
                INNER JOIN users ON bookings.user_id = users.id 
                INNER JOIN buses ON bookings.bus_id = buses.id 
                INNER JOIN routes ON bookings.route_id = routes.id 
                WHERE bookings.user_id = ? 
                ORDER BY bookings.created_at DESC"; // Order by created_at to get the latest booking first

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<div class="ticket-container">';

            while ($row = $result->fetch_assoc()) {
                // Determine travel time (day/night) based on travel_time column
                $travel_time = (intval(substr($row['travel_time'], 0, 2)) < 18) ? "Day" : "Night";

                echo '<div class="ticket">';
                echo '<div class="ticket-header">';
                echo '<h2>BUS TICKET</h2>';
                echo '<p>Booking ID: ' . htmlspecialchars($row['booking_id']) . '</p>';
                echo '</div>';
                echo '<div class="ticket-body">';
                echo '<div class="ticket-column">';
                echo '<p><strong>User Name:</strong> ' . htmlspecialchars($row['user_name']) . '</p>';
                echo '<p><strong>Bus Name:</strong> ' . htmlspecialchars($row['bus_name']) . '</p>';
                echo '<p><strong>Bus Number:</strong> ' . htmlspecialchars($row['bus_number']) . '</p>';
                echo '<p><strong>Seat Number:</strong> ' . htmlspecialchars($row['seat_number']) . '</p>';
                echo '</div>';
                echo '<div class="ticket-column">';
                echo '<p><strong>Travel Time:</strong> ' . $travel_time . '</p>';
                echo '<p><strong>From:</strong> ' . htmlspecialchars($row['departure_city']) . '</p>';
                echo '<p><strong>To:</strong> ' . htmlspecialchars($row['destination_city']) . '</p>';
                echo '<p><strong>Price:</strong> Rs.' . htmlspecialchars($row['priceperseat']) . '</p>';
                echo '<p><strong>Booking Date:</strong> ' . htmlspecialchars($row['booking_date']) . '</p>';
                echo '</div>';
                echo '</div>';
                echo '<div class="ticket-footer">';
                echo '<p>Thank you for choosing our service!</p>';
                echo '</div>';
                echo '</div>';
            }

            echo '</div>';
        } else {
            echo "<p>No bookings found.</p>";
        }

        $stmt->close();
    } else {
        echo "<p>Please log in and booked ticket to view your tickets.</p>";
    }

    $conn->close();
    ?>

    <!-- Include the CSS within the same file for convenience -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }

        .ticket-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .ticket {
            width: 900px; /* Increased width */
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #ffffff;
            margin: 20px 0;
            overflow: hidden;
            position: relative;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: #333;
        }

        .ticket-header {
            background-color: #4CAF50;
            color: white;
            padding: 20px; /* Increased padding */
            text-align: center;
            font-size: 24px; /* Increased font size */
        }

        .ticket-body {
            padding: 25px; /* Increased padding */
            font-size: 16px; /* Increased font size */
            display: flex;
            justify-content: space-between;
        }

        .ticket-column {
            width: 48%; /* Adjusted column width for a better layout */
        }

        .ticket-column p {
            margin: 12px 0; /* Increased spacing */
        }

        .ticket-footer {
            background-color: #4CAF50;
            color: white;
            padding: 15px; /* Increased padding */
            text-align: center;
            font-size: 16px; /* Increased font size */
        }

        /* Additional styles for the bar code and other elements */
        .ticket::before {
            content: "";
            position: absolute;
            left: 0;
            top: 40px;
            width: 10px;
            height: 100px;
            background-color: #333;
        }

        .ticket::after {
            content: "";
            position: absolute;
            right: 0;
            top: 40px;
            width: 10px;
            height: 100px;
            background-color: #333;
        }
    </style>
</body>
</html>
