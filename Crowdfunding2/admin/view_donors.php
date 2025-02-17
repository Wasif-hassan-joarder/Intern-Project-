<?php
require_once('../view/header.php');
require_once('../model/db.php');

// Check if the user is logged in as Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../view/login.php");
    exit();
}

$con = getConnection();

// Fetch all donors
$sql = "SELECT u.id, u.username, u.points_balance FROM users u WHERE u.role = 'Donor'";
$result = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Donors</title>
</head>
<body>
    <h1>Donors</h1>
    <a href="dashboard.php">Back to Dashboard</a><br><br>
    <table border="1">
        <tr>
            <th>Username</th>
            <th>Points</th>
        </tr>
        <?php while ($donor = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo htmlspecialchars($donor['username']); ?></td>
            <td><?php echo htmlspecialchars($donor['points_balance']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
