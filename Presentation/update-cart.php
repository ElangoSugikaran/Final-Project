<?php
// update-cart.php
include("../includes/session.php");
include("../database/dbconnection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['total-price'])) {
    // Assuming you want to update a session variable
    session_start();
    $_SESSION['cart_total_price'] = $_POST['total-price'];

    // You can also update a database here if needed

    // Send a response back to the client
    echo 'Cart updated successfully';
} else {
    // Handle invalid requests
    http_response_code(400);
    echo 'Invalid request';
}
?>
