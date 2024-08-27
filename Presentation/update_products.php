<?php
// Include your database connection code
include("../database/dbconnection.php");

// Collect filter values from the AJAX request
$brands = isset($_GET['brands']) ? $_GET['brands'] : array();
$shapes = isset($_GET['shapes']) ? $_GET['shapes'] : array();
$genders = isset($_GET['genders']) ? $_GET['genders'] : array();

// Build the SQL query based on selected filters
$sql = "SELECT * FROM product WHERE category_name = 1";

if (!empty($brands)) {
    $brandFilter = implode("','", $brands);
    $sql .= " AND brands IN ('$brandFilter')";
}

if (!empty($shapes)) {
    $shapeFilter = implode("','", $shapes);
    $sql .= " AND shape IN ('$shapeFilter')";
}

if (!empty($genders)) {
    $genderFilter = implode("','", $genders);
    $sql .= " AND gender IN ('$genderFilter')";
}

// Execute the query
$result = $conn->query($sql);

if ($result !== false) {
    if ($result->num_rows > 0) {
        // Display the updated product list
        while ($row = $result->fetch_assoc()) {
            echo '<div class="col-lg-4 col-md-6 col-sm-6 d-flex">';
            echo '<a href="../Presentation/product-details.php?product_id=' . $row['product_id'] . '">';
            echo '<div class="card w-100 my-2 shadow-2-strong">';
            echo '<img src="../Uploads/' . $row['image_1'] . '" class="card-img-top" style="aspect-ratio: 1 / 1"/>'; // Image source from the database
            echo '<div class="card-body d-flex flex-column">';
            echo '<div class="d-flex flex-row">';
            echo '<h5 class="mb-1 me-1">Rs' . $row['price'] . '</h5>';
            echo '</div>';
            echo '<p class="card-text">' . $row['product_name'] . '</p>';
            echo '<div class="card-footer d-flex align-items-end pt-3 px-0 pb-0 mt-auto">';
            // Add to cart button
            echo '<a href="../Presentation/shopping-cart.php?action=add&product_id=' . $row['product_id'] . '" class="btn btn-primary shadow-0 me-1">Add to cart</a>';
            // Add to wishlist button
            echo '<a href="../Presentation/wishlist.php?action=add&product_id=' . $row['product_id'] . '" class="btn btn-light border icon-hover px-2 pt-2"><i class="fas fa-heart fa-lg text-secondary px-1"></i></a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            
        }
    } else {
        echo "No products found.";
    }

    // Close the result set
    $result->close();
} else {
    // Handle the query execution failure
    echo "Error executing the query: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
