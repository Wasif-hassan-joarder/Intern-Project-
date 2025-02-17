<?php

function getConnection() {
    $con = mysqli_connect('127.0.0.1', 'root', '', 'crowdfunding2'); 
    if (mysqli_connect_errno()) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $con;
}

?>
