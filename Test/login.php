<?php
include 'Database/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            font-family: 'Arial', sans-serif;
        }

        .login-container {
            width: 400px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            text-align: center;
            animation: fadeIn 1.5s ease;
        }

        .login-container h2 {
            color: #fff;
            font-size: 2rem;
            margin-bottom: 20px;
            animation: slideIn 1.5s ease;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group label {
            color: #fff;
            position: absolute;
            top: -20px;
            left: 0;
            font-size: 1rem;
            transition: 0.3s ease;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            background: transparent;
            border: none;
            border-bottom: 2px solid #fff;
            color: #fff;
            font-size: 1rem;
            transition: 0.3s ease;
        }

        .input-group input:focus,
        .input-group input:valid {
            border-color: #6a11cb;
            outline: none;
        }

        .input-group input:focus + label,
        .input-group input:valid + label {
            color: #6a11cb;
        }

        .login-btn {
            padding: 10px 20px;
            background-color: #6a11cb;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1rem;
            color: #fff;
            margin-top: 20px;
            transition: 0.3s ease;
        }

        .login-btn:hover {
            background-color: #2575fc;
            transform: translateY(-3px);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .login-container {
            animation: zoomIn 0.8s ease forwards;
        }

        @keyframes zoomIn {
            from {
                transform: scale(0.8);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="login_check.php" method="post">
            <div class="input-group">
                <input type="email" id="email" name="email" required>
                <label for="email">Email</label>
            </div>

            <div class="input-group">
                <input type="password" id="password" name="password" required>
                <label for="password">Password</label>
            </div>
            
            <button type="submit" class="login-btn" name="login">Login</button>
        </form>
        <div class="register-link">
            <p>Don't have an account? <a href="register.php">Register here</a>.</p>
        </div>
    </div>
</body>
</html>
