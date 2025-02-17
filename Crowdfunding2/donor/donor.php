<?php
require_once('../view/header.php'); 
require_once('../model/db.php');

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Donor') {
    header("Location: ../view/login.php");
    exit();
}

if (isset($_POST['donate'])) {
    $donation_amount = $_POST['donation_amount']; // Donation amount
    $campaign_id = $_POST['campaign_id']; // Selected campaign ID
    $user_id = $_SESSION['id'];

    // php validation
    if ($donation_amount < 1) {
        echo "Donation amount must be at least $1.";
        exit();
    }

    if (empty($campaign_id)) {
        echo "Please select a campaign to donate to.";
        exit();
    }

    // Calculate points (1 point per $100)
    $points_earned = $donation_amount / 100;

    // Connect to the database
    $con = getConnection();

    // Insert the donation into the database
    $sql = "INSERT INTO donations (user_id, campaign_id, amount) VALUES ('$user_id', '$campaign_id', '$donation_amount')";
    if (mysqli_query($con, $sql)) {
        // Update points_balance in users table
        $update_points_sql = "UPDATE users SET points_balance = points_balance + $points_earned WHERE id = '$user_id'";
        if (mysqli_query($con, $update_points_sql)) {
            echo "Donation successful! You earned $points_earned points.";
        } else {
            echo "Error updating points balance: " . mysqli_error($con);
        }
    } else {
        echo "Error processing donation: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make a Donation</title>
    <script>
        function validateDonationForm() {
            let campaign = document.getElementById('campaign_id').value;
            let donationAmount = document.getElementById('donation_amount').value.trim();
            let valid = true;

            if (campaign === "") {
                document.getElementById('campaign_error').innerHTML = "Please select a campaign.";
                valid = false;
            } else {
                document.getElementById('campaign_error').innerHTML = "";
            }

            if (donationAmount === "" || parseFloat(donationAmount) < 1) {
                document.getElementById('donation_error').innerHTML = "Enter a valid donation amount (minimum $1).";
                valid = false;
            } else {
                document.getElementById('donation_error').innerHTML = "";
            }

            return valid;
        }
    </script>
</head>
<body>
    <h1>Donate to a Campaign</h1>

    <form method="POST" onsubmit="return validateDonationForm()">
        <label for="campaign_id">Select Campaign:</label>
        <select name="campaign_id" id="campaign_id">
            <option value="">-- Select a Campaign --</option>
            <?php
            // Fetch running campaigns from the database
            $con = getConnection();
            $sql = "SELECT id, title FROM campaigns WHERE status = 'Running'";
            $result = mysqli_query($con, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($campaign = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $campaign['id'] . "'>" . $campaign['title'] . "</option>";
                }
            } else {
                echo "<option value=''>No running campaigns</option>";
            }
            ?>
        </select>
        <span class="error-msg" id="campaign_error"></span>

        <label for="donation_amount">Donation Amount ($):</label>
        <input type="number" name="donation_amount" id="donation_amount" min="1">
        <span class="error-msg" id="donation_error"></span>

        <input type="submit" name="donate" value="Donate">
    </form>

    <a href="dashboard.php">Back to Dashboard</a>

    <?php
    require_once('../view/footer.php'); // Include the footer
    ?>
</body>
</html>
