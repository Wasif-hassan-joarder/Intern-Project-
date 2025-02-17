<?php
session_start();
require_once('../model/db.php'); // Adjusted path to db.php

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        echo "<p class='error'>Username or password cannot be empty!</p>";
    } else {
        // Connect to database
        $con = getConnection();

        // Query to check if username and password are correct
        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);

            // Storing user session data
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['id'] = $user['id'];

            // Redirecting based on the user role
            if ($user['role'] === 'Admin') {
                header('Location: ../admin/dashboard.php');
                exit();
            } elseif ($user['role'] === 'Donor') {
                header('Location: ../donor/dashboard.php');
                exit();
            } else {
                header('Location: ../user/dashboard.php');
                exit();
            }
        } else {
            echo "<p class='error'>Invalid username or password!</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: #fff;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: bold;
            text-align: left;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        p {
            font-size: 14px;
        }

        .error {
            color: red;
            font-size: 14px;
            margin: 10px 0;
        }

        .error-msg {
            color: red;
            font-size: 14px;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        function validateLoginForm() {
            let username = document.getElementById('username').value.trim();
            let password = document.getElementById('password').value.trim();
            let valid = true;

            if (username === "") {
                document.getElementById('username_error').innerHTML = "Username is required.";
                valid = false;
            } else {
                document.getElementById('username_error').innerHTML = "";
            }

            if (password === "") {
                document.getElementById('password_error').innerHTML = "Password is required.";
                valid = false;
            } else {
                document.getElementById('password_error').innerHTML = "";
            }

            return valid;
        }
    </script>
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>

        <form method="POST" onsubmit="return validateLoginForm()">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username">
            <span class="error-msg" id="username_error"></span>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            <span class="error-msg" id="password_error"></span>

            <button type="submit" name="submit">Login</button>
        </form>

        <p>Don't have an account? <a href="signup.php">Sign Up here</a></p>
    </div>
</body>
</html>
