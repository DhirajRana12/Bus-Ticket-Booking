<?php
// session_start();
// if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 2) {
//     header("Location: Index.php");
//     exit;
// }

// Include the database connection
include '../Database/database.php'; // Adjust the path based on your folder structure

// Fetch bus numbers for dropdown
$bus_numbers = [];
$bus_query = "SELECT bus_number FROM buses";
$bus_result = $conn->query($bus_query);

if ($bus_result->num_rows > 0) {
    while ($row = $bus_result->fetch_assoc()) {
        $bus_numbers[] = $row['bus_number'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the price per seat from the form
    $priceperseat = $_POST['priceperseat'];

    // Validate price per seat
    if ($priceperseat < 0) {
        echo "<p class='text-red-500'>Error: Price per seat cannot be less than Rs. 0.</p>";
    } else {
        // Prepare and bind (adjusting for schema with `priceperseat` column)
        $stmt = $conn->prepare("INSERT INTO routes (departure_city, destination_city, travel_time, date, bussno, priceperseat, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssssss", $departure_city, $destination_city, $travel_time, $date, $bussno, $priceperseat);

        // Set parameters and execute
        $departure_city = $_POST['departure_city'];
        $destination_city = $_POST['destination_city'];
        $travel_time = $_POST['travel_time'];
        $date = $_POST['date'];
        $bussno = $_POST['bussno'];

        if ($stmt->execute()) {
            echo "<p class='text-green-500'>New route added successfully. Price per seat: Rs. " . number_format($priceperseat, 2) . "</p>";
        } else {
            echo "<p class='text-red-500'>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Route</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<section class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Add Route</h2>
    <a href="routes.php" class="bg-gray-600 text-white py-2 px-4 rounded-lg hover:bg-gray-700">Back</a>

    <div class="mt-6">
        <form action="#" method="POST" class="bg-white p-6 shadow-md rounded-lg">
            <label for="departure_city" class="block text-sm font-medium text-gray-700">Departure City:</label>
            <input type="text" id="departure_city" name="departure_city" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">

            <label for="destination_city" class="block text-sm font-medium text-gray-700 mt-4">Destination City:</label>
            <input type="text" id="destination_city" name="destination_city" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">

            <label for="travel_time" class="block text-sm font-medium text-gray-700 mt-4">Travel Time:</label>
            <select id="travel_time" name="travel_time" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="" disabled selected>Select Time of Day</option>
                <option value="Day">Day</option>
                <option value="Night">Night</option>
            </select>

            <label for="date" class="block text-sm font-medium text-gray-700 mt-4">Date:</label>
            <input type="date" id="date" name="date" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">

            <label for="bussno" class="block text-sm font-medium text-gray-700 mt-4">Bus Number:</label>
            <select id="bussno" name="bussno" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="" disabled selected>Select Bus Number</option>
                <?php foreach ($bus_numbers as $bus_number): ?>
                    <option value="<?php echo htmlspecialchars($bus_number); ?>"><?php echo htmlspecialchars($bus_number); ?></option>
                <?php endforeach; ?>
            </select>

            <label for="priceperseat" class="block text-sm font-medium text-gray-700 mt-4">Price Per Seat (Rs.):</label>
            <input type="number" id="priceperseat" name="priceperseat" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" step="0.01" min="0" oninput="this.setCustomValidity(this.validity.rangeUnderflow ? 'Price per seat cannot be less than Rs. 0.' : '');">

            <button type="submit" class="mt-6 bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700">Add Route</button>
        </form>
    </div>
</section>

</body>
</html>
