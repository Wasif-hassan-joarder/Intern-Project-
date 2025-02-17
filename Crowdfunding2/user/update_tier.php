<?php
session_start();
require_once('../model/db.php');

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'User') {
    header("Location: ../view/login.php");
    exit();
}

if (isset($_POST['update_tier'])) {
    $new_role = $_POST['role'];
    $user_id = $_SESSION['id'];

    $con = getConnection();

    // Update the user's role (tier)
    $sql = "UPDATE users SET role = '$new_role' WHERE id = '$user_id'";

    if (mysqli_query($con, $sql)) {
        echo "Your tier has been updated to: $new_role!";
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Tier</title>
</head>
<body>
    <h1>Update Your Tier</h1>

    <form method="POST">
        <label for="role">Choose your tier:</label>
        <select name="role" id="role">
            <option value="Admin" <?php if ($_SESSION['role'] == 'Admin') echo 'selected'; ?>>Admin</option>
            <option value="User" <?php if ($_SESSION['role'] == 'User') echo 'selected'; ?>>User</option>
            <option value="Donor" <?php if ($_SESSION['role'] == 'Donor') echo 'selected'; ?>>Donor</option>
        </select><br><br>

        <input type="submit" name="update_tier" value="Update Tier">
    </form>
</body>
</html>
