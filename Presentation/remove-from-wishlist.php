<?php
// Start the session
session_start();

// Check if the product_id is set in the query parameters
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Fetch the wishlist from the session
    $wishlist = isset($_SESSION['wishlist']) ? $_SESSION['wishlist'] : array();

    // Find the index of the product in the wishlist array
    $index = array_search($product_id, array_column($wishlist, 'id'));

    // Remove the product from the wishlist if found
    if ($index !== false) {
        unset($wishlist[$index]);

        // Reindex the array to avoid issues with numerical keys
        $wishlist = array_values($wishlist);

        // Update the wishlist in the session
        $_SESSION['wishlist'] = $wishlist;
    }
}

// Redirect back to the wishlist page
echo '<script>window.location.href = "wishlist.php";</script>';
exit();
?>
