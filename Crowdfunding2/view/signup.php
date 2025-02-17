<?php
session_start();
require_once('../model/db.php'); // Adjusted path to db.php

if (isset($_POST['signup'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    if (empty($username) || empty($password) || empty($role)) {
        $error = "Username, password, and role are required!";
    } else {
        // Connect to database
        $con = getConnection();

        // Check if username already exists
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            $error = "Username already taken.";
        } else {
            // Insert new user into database
            $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
            if (mysqli_query($con, $sql)) {
                header("Location: login.php");
                exit();
            } else {
                $error = "Error signing up. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
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

        .signup-container {
            background: #fff;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
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

        input, select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        p {
            font-size: 14px;
        }

        .error {
            color: red;
            font-size: 14px;
        }

        .error-msg {
            color: red;
            font-size: 14px;
        }
    </style>
    <script>
        function validateSignupForm() {
            let username = document.getElementById('username').value.trim();
            let password = document.getElementById('password').value.trim();
            let role = document.getElementById('role').value;
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

            if (role === "") {
                document.getElementById('role_error').innerHTML = "Role is required.";
                valid = false;
            } else {
                document.getElementById('role_error').innerHTML = "";
            }

            return valid;
        }
    </script>
</head>
<body>
    <div class="signup-container">
        <h1>User Signup</h1>

        <form method="POST" onsubmit="return validateSignupForm()">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo isset($username) ? $username : ''; ?>">
            <span class="error-msg" id="username_error"></span>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            <span class="error-msg" id="password_error"></span>

            <label for="role">Role:</label>
            <select name="role" id="role">
                <option value="" <?php echo isset($role) && $role == '' ? 'selected' : ''; ?>>Select Role</option>
                <option value="User" <?php echo isset($role) && $role == 'User' ? 'selected' : ''; ?>>User</option>
                <option value="Donor" <?php echo isset($role) && $role == 'Donor' ? 'selected' : ''; ?>>Donor</option>
                <option value="Admin" <?php echo isset($role) && $role == 'Admin' ? 'selected' : ''; ?>>Admin</option>
            </select>
            <span class="error-msg" id="role_error"></span>

            <input type="submit" name="signup" value="Sign Up">
        </form>

        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
    </div>
</body>
</html>
