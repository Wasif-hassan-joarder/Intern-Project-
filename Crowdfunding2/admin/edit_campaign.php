<?php
session_start();
require_once('../model/db.php');

// Check if the user is logged in as Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../view/login.php");
    exit();
}

$con = getConnection();

// Check if a campaign ID is passed
if (isset($_GET['id'])) {
    $campaign_id = $_GET['id'];
    $sql = "SELECT * FROM campaigns WHERE id = '$campaign_id'";
    $result = mysqli_query($con, $sql);
    $campaign = mysqli_fetch_assoc($result);
}

// Process form submission
if (isset($_POST['update'])) {
    $campaign_title = $_POST['title'];
    $campaign_description = $_POST['description'];

    $update_sql = "UPDATE campaigns SET title = '$campaign_title', description = '$campaign_description' WHERE id = '$campaign_id'";
    if (mysqli_query($con, $update_sql)) {
        header("Location: view_campaigns.php");
        exit();
    } else {
        echo "Error updating campaign!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Campaign</title>
</head>
<body>
    <h1>Edit Campaign</h1>
    <form method="POST">
        <label for="title">Campaign Title:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($campaign['title']); ?>" /><br><br>

        <label for="description">Campaign Description:</label>
        <textarea id="description" name="description"><?php echo htmlspecialchars($campaign['description']); ?></textarea><br><br>

        <input type="submit" name="update" value="Update Campaign" />
    </form>
    <a href="view_campaigns.php">Cancel</a>
</body>
</html>
