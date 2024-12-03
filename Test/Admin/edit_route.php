<?php
// Include the database connection
include '../Database/database.php'; // Adjust the path based on your folder structure

// Handle Update Route
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_route'])) {
    $route_id = $_POST['route_id'];
    $departure_city = $_POST['departure_city'];
    $destination_city = $_POST['destination_city'];
    $travel_time = $_POST['travel_time']; // This will now be 'day' or 'night' as per ENUM
    $date = $_POST['date']; // Update to use 'date' column

     // Check if the selected date is today or in the future
     $today = date('Y-m-d');
     if ($date < $today) {
         echo "<p>Error: The selected date cannot be in the past.</p>";
         exit;
     }

    $sql = "UPDATE routes SET departure_city = ?, destination_city = ?, travel_time = ?, `date` = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $departure_city, $destination_city, $travel_time, $date, $route_id);

    if ($stmt->execute()) {
        header("Location: routes.php"); // Redirect back to routes management page
        exit;
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }
}

// Fetch the route to be edited
if (isset($_GET['id'])) {
    $route_id = intval($_GET['id']);
    $sql = "SELECT * FROM routes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $route_id);
    $stmt->execute();
    $route = $stmt->get_result()->fetch_assoc();
} else {
    header("Location: routes.php"); // Redirect if no ID is provided
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Route</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<section class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Edit Route</h2>
    
    <form action="edit_route.php" method="post">
        <input type="hidden" name="update_route">
        <input type="hidden" name="route_id" value="<?php echo $route['id']; ?>">
        
        <div class="mb-4">
            <label for="departure_city" class="block text-sm font-medium text-gray-700">Departure City</label>
            <input type="text" id="departure_city" name="departure_city" value="<?php echo htmlspecialchars($route['departure_city']); ?>" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md" />
        </div>
        
        <div class="mb-4">
            <label for="destination_city" class="block text-sm font-medium text-gray-700">Destination City</label>
            <input type="text" id="destination_city" name="destination_city" value="<?php echo htmlspecialchars($route['destination_city']); ?>" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md" />
        </div>

        <div class="mb-4">
            <label for="travel_time" class="block text-sm font-medium text-gray-700">Travel Time</label>
            <select id="travel_time" name="travel_time" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                <option value="" disabled <?php echo ($route['travel_time'] == '') ? 'selected' : ''; ?>>Select Travel Time</option>
                <option value="day" <?php echo ($route['travel_time'] == 'day') ? 'selected' : ''; ?>>Day</option>
                <option value="night" <?php echo ($route['travel_time'] == 'night') ? 'selected' : ''; ?>>Night</option>
            </select>
        </div>

         <!-- Updated Date field with restriction to allow only today and future dates -->
        <div class="mb-4">
            <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
            <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($route['date']); ?>" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
            min="<?php echo date('Y-m-d'); ?>" /> <!-- Set minimum to today -->
        </div>

        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Update Route</button>
        <a href="routes.php" class="bg-gray-300 text-gray-800 py-2 px-4 rounded-lg hover:bg-gray-400 ml-4">Back</a>
    </form>
</section>

</body>
</html>

<?php
$conn->close();
?>
