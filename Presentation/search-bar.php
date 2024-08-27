<?php
include '../includes/session.php';
include("../database/dbconnection.php");

if (isset($_POST['query'])) {
    $query = $_POST['query'];
    
    // Escape special characters for security
    $searchTerm = mysqli_real_escape_string($conn, $query);
    
    // Debugging output
    echo "Search Term: " . htmlspecialchars($searchTerm) . "<br>";

    // Query to search products based on name, model number, description, or brands
    $sql = "SELECT * FROM product WHERE product_name LIKE '%$searchTerm%' OR model_no LIKE '%$searchTerm%' OR description LIKE '%$searchTerm%' OR brands LIKE '%$searchTerm%'";
    $result = mysqli_query($conn, $sql);
    
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        echo '<div class="container mt-4">';
        echo '<div class="row">';
        while ($row = mysqli_fetch_assoc($result)) {
            $imagePath = "../Uploads/" . htmlspecialchars($row['image_1'], ENT_QUOTES, 'UTF-8');
    
            echo '<div class="col-md-4 mb-4">';
            echo '<div class="card">';
    
            // Corrected: Use $row['product_id'] instead of $product['id']
            echo '<a href="../Presentation/wishlist.php?action=add&product_id=' . urlencode($row['product_id']) . '">';
            echo '<i class="fas fa-heart text-primary fa-lg float-end pt-3 m-2"></i></a>';
            
            echo '<img src="' . $imagePath . '" class="card-img-top" alt="' . htmlspecialchars($row['product_name'], ENT_QUOTES, 'UTF-8') . '">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($row['product_name'], ENT_QUOTES, 'UTF-8') . '</h5>';
            echo '<p class="card-text"><strong>Price:</strong> Rs ' . number_format($row['price'], 2) . '</p>';
            
            // Corrected: Use $row['product_id'] instead of $row['id'] and correct the href URL
            echo '<a href="../Presentation/product-details.php?product_id=' . urlencode($row['product_id']) . '" class="btn btn-primary shadow-0 me-1">Add to cart</a>';
            
            echo '</div>'; // Close card-body
            echo '</div>'; // Close card
            echo '</div>'; // Close col-md-4
        }
        echo '</div>'; // Close row
        echo '</div>'; // Close container
    } else {
        echo '<div class="container mt-4"><p class="text-center">No products found.</p></div>';
    }
}
?>
