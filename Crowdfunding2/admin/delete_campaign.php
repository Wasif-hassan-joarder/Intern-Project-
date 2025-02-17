<?php
session_start();
require_once('../model/db.php');

// Check if the user is logged in as Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../view/login.php");
    exit();
}

$con = getConnection();

// Process campaign deletion
if (isset($_GET['id'])) {
    $campaign_id = $_GET['id'];

    $delete_sql = "DELETE FROM campaigns WHERE id = '$campaign_id'";
    if (mysqli_query($con, $delete_sql)) {
        header("Location: view_campaigns.php");
        exit();
    } else {
        echo "Error deleting campaign!";
    }
}
?>
