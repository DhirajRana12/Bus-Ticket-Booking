<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "bus_ticketing_system";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start(); // Start the session

// Fetch distinct cities from the routes table
$cities = [];
$sql = "SELECT DISTINCT departure_city AS city FROM routes
        UNION
        SELECT DISTINCT destination_city AS city FROM routes
        ORDER BY city ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cities[] = $row['city'];
    }
}

$conn->close();
?>

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
                <a href="User/ticket.php" class="hover:bg-green-700 py-2 px-4 rounded">Bus Tickets</a>
                <a href="#" class="hover:bg-green-700 py-2 px-4 rounded">Help</a>
                <div class="relative">
                    <button id="accountBtn" class="hover:bg-green-700 py-2 px-4 rounded focus:outline-none">Account</button>
                    <div class="dropdown-content absolute hidden bg-white text-black shadow-lg rounded mt-2 w-48">
                        <!-- Check if the user is logged in or not -->
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="profile.php" id="profileBtn" class="block px-4 py-2 hover:bg-gray-200">Profile</a>
                            <a href="logout.php" id="logoutBtn" class="block px-4 py-2 hover:bg-gray-200">Logout</a>
                        <?php else: ?>
                            <a href="login.php" id="loginBtn" class="block px-4 py-2 hover:bg-gray-200">Login</a>
                            <a href="register.php" id="registerBtn" class="block px-4 py-2 hover:bg-gray-200">Register</a>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <section class="hero bg-cover bg-center text-white" style="background-image: url('bus.jpg');">
        <div class="container mx-auto text-center py-32">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold">Find Your Bus, Book Your Seat<br>Travel Your Destination</h1>
        </div>
    </section>

    <!-- Search Section with Dynamic Dropdowns -->
    <section class="search-container py-12">
        <form action="user/busroute.php" method="get">
            <div class="container mx-auto">
                <div class="search-box bg-white p-8 rounded-lg shadow-lg flex flex-col md:flex-row justify-center gap-6">
                    <div class="search-item flex flex-col">
                        <label for="from" class="font-semibold mb-2">From</label>
                        <select id="from" name="from" class="p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600" required>
                            <option value="" disabled selected>Select departure location</option>
                            <?php foreach ($cities as $city): ?>
                                <option value="<?php echo htmlspecialchars($city); ?>"><?php echo htmlspecialchars($city); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="search-item flex flex-col">
                        <label for="to" class="font-semibold mb-2">To</label>
                        <select id="to" name="to" class="p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600" required>
                            <option value="" disabled selected>Select destination</option>
                            <?php foreach ($cities as $city): ?>
                                <option value="<?php echo htmlspecialchars($city); ?>"><?php echo htmlspecialchars($city); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="search-item flex flex-col">
                    <label for="date" class="font-semibold mb-2">Date</label>
                    <input type="date" id="date" name="date" class="p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600" required>
                    </div>

                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                     // Get today's date in the format YYYY-MM-DD
                    const today = new Date().toISOString().split('T')[0];
        
                    // Set the min attribute to today's date for the date input
                    document.getElementById('date').setAttribute('min', today);
                     });
                    </script>
                    <div class="search-button flex items-end">
                        <button class="bg-green-600 text-white py-3 px-6 rounded-lg hover:bg-green-700 transition duration-300">Search Buses</button>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <footer class="bg-gray-800 text-white py-4 mt-8 shadow-lg">
        <div class="container mx-auto text-center">
            <p>Contact Us | Privacy Policy</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>
