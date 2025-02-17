<?php
require_once('../view/header.php');
require_once('../model/db.php');

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ensure the user is logged in and has the Admin role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../view/login.php");
    exit();
}

$con = getConnection();
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch all campaigns
$sql_campaigns = "
    SELECT c.*, u.username AS created_by 
    FROM campaigns c
    JOIN users u ON c.created_by = u.id";
$result_campaigns = mysqli_query($con, $sql_campaigns);

if (!$result_campaigns) {
    die("Error fetching campaigns: " . mysqli_error($con));
}

// Update campaign status
if (isset($_POST['update_status'])) {
    $campaign_id = (int) $_POST['campaign_id'];
    $new_status = mysqli_real_escape_string($con, $_POST['status']);

    $sql_update = "UPDATE campaigns SET status = '$new_status' WHERE id = $campaign_id";
    if (mysqli_query($con, $sql_update)) {
        header("Location: admin_campaigns.php");
        exit();
    } else {
        echo "Error updating campaign: " . mysqli_error($con);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Campaigns</title>
</head>
<body>
    <h1>Manage Campaigns</h1>
    <a href="dashboard.php">Back to Dashboard</a><br><br>

    <h2>All Campaigns</h2>
    <table border="1">
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Goal Amount</th>
            <th>Status</th>
            <th>Created By</th>
            <th>Actions</th>
        </tr>
        <?php if (mysqli_num_rows($result_campaigns) > 0): ?>
            <?php while ($campaign = mysqli_fetch_assoc($result_campaigns)): ?>
            <tr>
                <td><?php echo htmlspecialchars($campaign['title']); ?></td>
                <td><?php echo htmlspecialchars($campaign['description']); ?></td>
                <td><?php echo htmlspecialchars($campaign['goal_amount']); ?></td>
                <td><?php echo htmlspecialchars($campaign['status']); ?></td>
                <td><?php echo htmlspecialchars($campaign['created_by']); ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="campaign_id" value="<?php echo $campaign['id']; ?>">
                        <select name="status">
                            <option value="Running" <?php if ($campaign['status'] === 'Running') echo 'selected'; ?>>Running</option>
                            <option value="Not Running" <?php if ($campaign['status'] === 'Not Running') echo 'selected'; ?>>Not Running</option>
                        </select>
                        <button type="submit" name="update_status">Update</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6">No campaigns found.</td></tr>
        <?php endif; ?>
    </table>
   
</body>
</html>
<?php
    require_once('../view/footer.php'); // Include the footer
    ?>
