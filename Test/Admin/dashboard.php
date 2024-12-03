<?php
include '../Database/database.php'; // Corrected the path
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Adding Bootstrap for improved styles and responsiveness -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 20px;
            height: 100vh;
            position: fixed;
            transition: all 0.3s ease;
        }

        .sidebar-header h3 {
            text-align: center;
            margin: 0;
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: #ecf0f1;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 10px;
            margin: 10px 0;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #ecf0f1;
            font-size: 1.1rem;
            display: block;
            transition: 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #34495e;
            padding-left: 10px;
            color: #ecf0f1;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 40px;
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        .main-content header {
            padding: 20px;
            background-color: #2980b9;
            color: #fff;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 40px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Cards */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .card {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
            transition: transform 0.3s ease-in-out;
            text-align: center;
            border-left: 5px solid #2980b9;
        }

        .card h3 {
            margin: 15px 0;
            color: #34495e;
        }

        .card p {
            color: #7f8c8d;
            margin-bottom: 20px;
        }

        .card a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #2980b9;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease-in-out;
        }

        .card a:hover {
            background-color: #3498db;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .sidebar {
                width: 200px;
            }
            .main-content {
                margin-left: 200px;
            }
        }

        @media screen and (max-width: 576px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: static;
            }
            .main-content {
                margin: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h3>Bus Ticketing Admin</h3>
        </div>
    </div>
    <div class="main-content">
        <header>
            <h2>Welcome to the Admin Dashboard</h2>
        </header>
        <div class="dashboard-cards">
            <div class="card">
                <h3>Buses</h3>
                <p>Manage buses.</p>
                <a href="add_bus.php">Manage Buses</a>
            </div>
            <div class="card">
                <h3>Routes</h3>
                <p>Set and update routes.</p>
                <a href="routes.php">Manage Routes</a>
            </div>
            <div class="card">
                <h3>Schedules</h3>
                <p>Manage bus schedules.</p>
                <a href="manage_schedules.php">Manage Schedules</a>
            </div>
            <div class="card">
                <h3>Seats</h3>
                <p>Update seat availability.</p>
                <a href="manage_seats.php">Manage Seats</a>
            </div>
            <div class="card">
                <h3>Users</h3>
                <p>View and manage users.</p>
                <a href="manage_users.php">Manage Users</a>
            </div>
            <div class="card">
                <h3>Bookings</h3>
                <p>View and manage booking.</p>
                <a href="manage_bookings.php">Manage Booking</a>
            </div>
            <div class="card">
                <h3>Payments</h3>
                <p>Monitor payment statuses.</p>
                <a href="#">Manage Payments</a>
            </div>
        </div>
    </div>

    <!-- Optional Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
