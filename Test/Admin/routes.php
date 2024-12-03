<?php
// session_start();
// if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 2) {
//     header("Location: Index.php"); // Ensure to use 'Location:' in the header
//     exit;
// }

// Include the database connection
include '../Database/database.php'; // Adjust the path based on your folder structure

// Example: Fetch routes from the database
$sql = "SELECT * FROM routes ORDER BY id DESC";
$result = $conn->query($sql);

// Handle route deletion
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $routeId = intval($_GET['id']);
    $deleteSql = "DELETE FROM routes WHERE id = ?";
    
    if ($stmt = $conn->prepare($deleteSql)) {
        $stmt->bind_param("i", $routeId);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: routes.php"); // Redirect back to the routes page
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Routes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<!-- Your Admin Dashboard Layout Here -->

<section class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Manage Routes</h2>
    <a href="add_rout.php" class="bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700">Add Route</a>
    <!-- Back Button -->
    <a href="dashboard.php" class="bg-gray-600 text-white py-2 px-4 rounded-lg hover:bg-gray-700 ml-2">Back</a>
    <div class="mt-6">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead>
                <tr>
                    <th class="py-3 px-6 bg-gray-200 font-bold uppercase text-sm text-left">ID</th>
                    <th class="py-3 px-6 bg-gray-200 font-bold uppercase text-sm text-left">Departure City</th>
                    <th class="py-3 px-6 bg-gray-200 font-bold uppercase text-sm text-left">Destination City</th>
                    <th class="py-3 px-6 bg-gray-200 font-bold uppercase text-sm text-left">Travel Time</th>
                    <th class="py-3 px-6 bg-gray-200 font-bold uppercase text-sm text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td class="py-4 px-6 border-b"><?php echo $row['id']; ?></td>
                        <td class="py-4 px-6 border-b"><?php echo htmlspecialchars($row['departure_city']); ?></td>
                        <td class="py-4 px-6 border-b"><?php echo htmlspecialchars($row['destination_city']); ?></td>
                        <td class="py-4 px-6 border-b"><?php echo $row['travel_time']; ?></td>
                        <td class="py-4 px-6 border-b">
                            <a href="edit_route.php?id=<?php echo $row['id']; ?>" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Edit</a>
                            <a href="routes.php?action=delete&id=<?php echo $row['id']; ?>" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600" onclick="return confirm('Are you sure you want to delete this route?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</section>

</body>
</html>

<?php
$conn->close();
?>
