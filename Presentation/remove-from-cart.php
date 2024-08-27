
<?php
// Start the session
session_start();

// Check if the product_id is set in the query parameters
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Fetch the cart from the session
    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();

    // Find the index of the product in the cart array
    $index = array_search($product_id, array_column($cart, 'id'));

    // Remove the product from the cart if found
    if ($index !== false) {
        unset($cart[$index]);

        // Reindex the array to avoid issues with numerical keys
        $cart = array_values($cart);

        // Update the cart in the session
        $_SESSION['cart'] = $cart;
    }
}

// Redirect back to the shopping cart page
echo '<script>window.location.href = "shopping-cart.php";</script>';
exit();
?>
