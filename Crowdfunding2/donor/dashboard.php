<?php
require_once('../view/header.php');
require_once('../model/db.php');

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Donor') {
    header("Location: ../view/login.php");
    exit();
}

$con = getConnection();
$user_id = $_SESSION['id'];

// Fetch donor's points from the database (using points_balance column from users table)
$sql = "SELECT points_balance FROM users WHERE id = '$user_id'";
$result = mysqli_query($con, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $points_balance = $user['points_balance'];
} else {
    $points_balance = 0; // Default value if no points are found
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Dashboard</title>
    <style>
        /* General Styles */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 1.5em;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .card {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f1f1f1;
        }

        .card h2 {
            margin-top: 0;
            color: #007bff;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            color: white;
            background-color: #007bff;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1em;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>Donor Dashboard</header>
    <div class="container">
        <h1>Welcome, Donor</h1>
        <div class="card">
            <h2>Your Points Balance</h2>
            <p><?php echo $points_balance; ?> points</p>
        </div>
        <div class="card">
            <h2>Actions</h2>
            <a href="running_campaigns.php" class="button">View Running Campaigns</a><br><br>
            <a href="donor.php" class="button">Make a Donation</a>
        </div>
    </div>

    <?php require_once('../view/footer.php'); // Include the footer ?>
</body>
</html>
