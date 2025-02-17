<?php
require_once('../view/header.php');
require_once('../model/db.php');

// Check if the user is logged in as Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../view/login.php");
    exit();
}

$con = getConnection();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* General Styles */
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            transition: background-color 0.3s ease;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 1.5em;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        nav {
            background-color: #333;
            color: white;
            padding: 15px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        nav a:hover {
            background-color: #575757;
            transform: scale(1.1);
        }

        main {
            padding: 20px;
            max-width: 1100px;
            margin: 20px auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            color: #007bff;
            font-size: 2em;
            margin-bottom: 15px;
        }

        p {
            font-size: 1.2em;
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .card {
            background-color: #f2f2f2;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            color: #333;
            margin-bottom: 15px;
        }

        .card p {
            font-size: 1.1em;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 1.1em;
            color: white;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        /* Add some responsive design for smaller screens */
        @media (max-width: 768px) {
            body {
                font-size: 16px;
            }

            header {
                font-size: 1.2em;
            }

            nav a {
                padding: 8px 16px;
                margin: 0 10px;
            }

            main {
                padding: 10px;
            }

            .card {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <header>Admin Dashboard</header>
    <nav>
        <a href="view_campaigns.php">View All Campaigns</a>
        <a href="view_donors.php">View Donors</a>
        <a href="admin_campaigns.php">Bookmark to Run Campaign</a>
    </nav>
    <main>
        <h1>Welcome, Admin!</h1>
        <h2>Overview</h2>
        <?php
        // Example queries for total campaigns and donors
        $campaign_query = "SELECT COUNT(*) AS total_campaigns FROM campaigns";
        $donor_query = "SELECT COUNT(*) AS total_donors FROM users WHERE role = 'Donor'";

        $campaign_result = mysqli_query($con, $campaign_query);
        $donor_result = mysqli_query($con, $donor_query);

        $campaigns = mysqli_fetch_assoc($campaign_result);
        $donors = mysqli_fetch_assoc($donor_result);

        echo "<div class='card'>
                <h3>Total Campaigns</h3>
                <p>" . $campaigns['total_campaigns'] . "</p>
              </div>";
        echo "<div class='card'>
                <h3>Total Donors</h3>
                <p>" . $donors['total_donors'] . "</p>
              </div>";
        ?>
        <a href="view_campaigns.php" class="btn">View All Campaigns</a>
    </main>
    <?php
    require_once('../view/footer.php'); // Include the footer
    ?>
</body>
</html>
