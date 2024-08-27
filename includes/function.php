<!-- shopping cart code start -->

<?php
// functions.php

// Function to get products from the cart (using session in this example)
function getCartProducts() {
    // Start the session (if not started already)
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Check if the 'cart' session variable is set
    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        return $_SESSION['cart'];
    } else {
        return array(); // Return an empty array if the cart is not set
    }
}
?>

<!-- shopping cart code end -->

<!-- wishlist function code start-->

<?php
// In your functions.php or wherever you store your functions

// Function to get wishlist products (using session in this example)
function getWishlistProducts() {
    // Start the session (if not started already)
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Check if the 'wishlist' session variable is set
    if (isset($_SESSION['wishlist']) && is_array($_SESSION['wishlist'])) {
        return $_SESSION['wishlist'];
    } else {
        return array(); // Return an empty array if the wishlist is not set
    }
}
?>

<!-- wishlist function code end-->

<!-- display product summary start-->
<?php
// Example definition of the calculateTotalPrice function
function calculateTotalPrice($cartProducts) {
    $totalPrice = 0;

    foreach ($cartProducts as $product) {
        $totalPrice += $product['quantity'] * $product['price'];
    }

    return $totalPrice;
}

?>

<!-- display product summary end-->