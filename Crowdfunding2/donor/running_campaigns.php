<?php
require_once('../view/header.php');
require_once('../model/db.php');

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Donor') {
    header("Location: ../view/login.php");
    exit();
}

$con = getConnection();

// Fetch running campaigns
$sql = "SELECT id, title, goal_amount, description FROM campaigns WHERE status = 'Running'";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Running Campaigns</title>
</head>
<body>
    <h1>Running Campaigns</h1>

    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($campaign = mysqli_fetch_assoc($result)) {
            echo "<div>
                    <h3>" . $campaign['title'] . "</h3>
                    <p>" . $campaign['description'] . "</p>
                    <p>Goal: $" . $campaign['goal_amount'] . "</p>
                    <a href='donor.php?campaign_id=" . $campaign['id'] . "'>Donate to this campaign</a>
                  </div><br>";
        }
    } else {
        echo "<p>No running campaigns at the moment.</p>";
    }
    ?>

<?php
    require_once('../view/footer.php'); // Include the footer
    ?>
</body>
</html>
