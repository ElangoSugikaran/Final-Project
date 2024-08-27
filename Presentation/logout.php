<?php
// Include your database connection code here
include("../includes/session.php");
include("../database/dbconnection.php");

// Check if the user is logged in
if (isset($_SESSION['customer_id'])) {
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page after logout
    echo "<script>alert('Logout successful!'); window.location = '../Presentation/login.php';</script>";
    exit();
} else {
    // If the user is not logged in, redirect to the login page
    echo "<script>window.location = '../Presentation/login.php';</script>";
    exit();
}
?>
