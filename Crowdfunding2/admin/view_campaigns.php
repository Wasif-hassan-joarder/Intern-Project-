<?php
require_once('../view/header.php');
require_once('../model/db.php');

// Check if the user is logged in as Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../view/login.php");
    exit();
}

$con = getConnection();

// Fetch all campaigns
$sql = "SELECT * FROM campaigns";
$result = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Campaigns</title>
</head>
<body>
    <h1>All Campaigns</h1>
    <a href="dashboard.php">Back to Dashboard</a><br><br>
    <table border="1">
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        <?php while ($campaign = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo htmlspecialchars($campaign['title']); ?></td>
            <td><?php echo htmlspecialchars($campaign['description']); ?></td>
            <td>
                <a href="edit_campaign.php?id=<?php echo $campaign['id']; ?>">Edit</a> |
                <a href="delete_campaign.php?id=<?php echo $campaign['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
