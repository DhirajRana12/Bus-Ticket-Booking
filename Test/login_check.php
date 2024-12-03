<?php
session_start();
include 'Database/database.php'; // Include your database connection file

if (isset($_POST['login'])) {
    $email = trim($_POST['email']); // Use email instead of username
    $password = trim($_POST['password']); 

    // Check if the email exists in the database and if the account is active (status = 1)
    $query = "SELECT * FROM users WHERE email = ? AND status = 1";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $email); // Bind email for query
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify the password (assuming the passwords are hashed)
            if (password_verify($password, $user['password'])) {
                // Regenerate session ID to prevent session fixation attacks
                session_regenerate_id(true);
                
                // Set session variables based on user type
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_type'] = $user['user_type']; // 1 for admin, 0 for regular users

                // Redirect based on user type
                if ($user['user_type'] == 1) {
                    // Redirect to admin dashboard
                    header("Location: Admin/dashboard.php");
                    exit();
                } elseif ($user['user_type'] == 0) {
                    // Redirect to user dashboard
                    header("Location: Index.php");
                    exit();
                }
            } else {
                // Password does not match
                echo "<script>alert('Incorrect password. Please try again.'); window.location.href = 'login.php';</script>";
            }
        } else {
            // Email doesn't exist or account is inactive
            echo "<script>alert('Email does not exist or is inactive.'); window.location.href = 'login.php';</script>";
        }
        $stmt->close();
    } else {
        // Log SQL error instead of displaying it to the user
        error_log("SQL error: " . $conn->error);
        echo "<script>alert('An error occurred. Please try again later.'); window.location.href = 'login.php';</script>";
    }
}
?>
