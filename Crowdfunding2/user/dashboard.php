<?php
require_once('../view/header.php');
require_once('../model/db.php');

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'User') {
    header("Location: ../view/login.php");
    exit();
}

$con = getConnection();
$user_id = $_SESSION['id'];

// Fetch the user's campaigns based on created_by column
$sql = "SELECT * FROM campaigns WHERE created_by = '$user_id'";
$result = mysqli_query($con, $sql);

// Fetch user tier
$sqlTier = "SELECT role FROM users WHERE id = '$user_id'";
$resultTier = mysqli_query($con, $sqlTier);

if (!$result || !$resultTier) {
    die("Error: " . mysqli_error($con));
}

$user = mysqli_fetch_assoc($resultTier); // Assuming 'role' field corresponds to the tier
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <header>User Dashboard</header>
    <div class="container">
        <h1>Welcome to your dashboard, <?php echo $_SESSION['username']; ?>!</h1>

        <!-- Navigation to other user pages -->
        <div class="card">
            <h2>Manage Campaigns</h2>
            <a href="create_campaign.php" class="button">Create New Campaign</a><br><br>
            <a href="view_campaigns.php" class="button">View All Campaigns</a><br><br>
            <a href="update_tier.php" class="button">Update Your Tier</a>
        </div>

        <div class="card">
            <h2>Your Campaigns</h2>
            <table>
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
        </div>
    </div>

    <?php require_once('../view/footer.php'); // Include the footer ?>
</body>
</html>
