<?php
require_once('../view/header.php');
require_once('../model/db.php');

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'User') {
    header("Location: ../view/login.php");
    exit();
}

$con = getConnection();

// Fetch all campaigns
$sql = "SELECT * FROM campaigns";
$result = mysqli_query($con, $sql);

// Check if the query was successful
if (!$result) {
    die("Error fetching campaigns: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Campaigns</title>
</head>
<body>
    <h1>All Campaigns</h1>
    <table border="1">
        <tr>
            <th>Campaign Title</th>
            <th>Description</th>
            <th>Status</th>
        </tr>
        <?php while ($campaign = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($campaign['title']); ?></td>
                <td><?php echo htmlspecialchars($campaign['description']); ?></td>
                <td><?php echo htmlspecialchars($campaign['status']); ?></td>
            </tr>
        <?php } ?>
    </table>
    <?php
    require_once('../view/footer.php'); // Include the footer
    ?>
</body>
</html>
