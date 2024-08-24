<?php
// Include your database connection code here
include("./includes/session.php");
include("../database/dbconnection.php");

// Check if the user is logged in
if (isset($_SESSION['admin_id'])) {
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page after logout
     echo "<script>alert('Logout successful!'); window.location = '../admin/admin-login.php';</script>";
    exit();
} else {
    // If the user is not logged in, redirect to the login page
    echo "<script>alert window.location = '../admin/admin-login.php';</script>";
    exit();
}
?>
