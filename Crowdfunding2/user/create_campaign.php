<?php
require_once('../view/header.php');
require_once('../model/db.php');

// Check if the user is logged in and has the correct role
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'User') {
    header("Location: ../view/login.php");
    exit();
}

$errors = [];

if (isset($_POST['create_campaign'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $goal_amount = trim($_POST['goal_amount']);

    // Validation checks
    if (empty($title)) {
        $errors[] = "Campaign title is required.";
    }

    if (empty($description)) {
        $errors[] = "Description is required.";
    }

    if (empty($goal_amount) || !is_numeric($goal_amount) || $goal_amount <= 0) {
        $errors[] = "Goal amount should be a positive number.";
    }

    // If no errors, proceed with inserting the campaign
    if (empty($errors)) {
        $con = getConnection();
        $user_id = $_SESSION['id'];

        // Insert the new campaign
        $sql = "INSERT INTO campaigns (title, description, goal_amount, created_by, status) 
                VALUES ('$title', '$description', '$goal_amount', '$user_id', 'Not Running')";

        if (mysqli_query($con, $sql)) {
            header("Location: dashboard.php");
            exit();
        } else {
            $errors[] = "Error: " . mysqli_error($con);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Campaign</title>
</head>
<body>
    <h1>Create a New Campaign</h1>

    <!-- Display errors if any -->
    <?php if (!empty($errors)): ?>
        <ul style="color: red;">
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <!-- Create campaign form -->
    <form method="POST">
        <label for="title">Campaign Title:</label>
        <input type="text" name="title" id="title" value="<?php echo isset($title) ? htmlspecialchars($title) : ''; ?>"><br><br>
        
        <label for="description">Description:</label>
        <textarea name="description" id="description"><?php echo isset($description) ? htmlspecialchars($description) : ''; ?></textarea><br><br>
        
        <label for="goal_amount">Goal Amount ($):</label>
        <input type="number" name="goal_amount" id="goal_amount" value="<?php echo isset($goal_amount) ? htmlspecialchars($goal_amount) : ''; ?>"><br><br>
        
        <input type="submit" name="create_campaign" value="Create Campaign">
    </form>

    <?php
    require_once('../view/footer.php'); // Include the footer
    ?>
</body>
</html>
