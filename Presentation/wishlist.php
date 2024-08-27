<?php
include("../includes/session.php");
include '../includes/header.php';
include '../includes/navbar.php';
include("../database/dbconnection.php");
include("../includes/function.php");
?>

<!--Main Navigation-->
<header>
  <!-- Heading -->
  <div class="bg-primary mb-4" id="backgroundDiv">
    <div class="container py-4">
      <h3 class="text-white mt-2">Wishlist</h3>
      <!-- Breadcrumb -->
      <nav class="d-flex mb-2">
        <h6 class="mb-0">
          <a href="../Presentation/home.php" class="text-white-50">Home</a>
          <span class="text-white-50 mx-2"> > </span>
          <a href="" class="text-white"><u>Wishlist</u></a>
        </h6>
      </nav>
      <!-- Breadcrumb -->
    </div>
  </div>
  <!-- Heading -->
</header>

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action === 'add' && isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $sql = "SELECT * FROM product WHERE product_id = $product_id";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $product = $result->fetch_assoc();
    
        $wishlist = isset($_SESSION['wishlist']) ? $_SESSION['wishlist'] : array();
        $wishlist[] = array(
            'id' => $product_id,
            'name' => $product['product_name'],
            'price' => $product['price'],
            'image_1' => $product['image_1'],
            'description' => $product['description'],
            'price_per_item' => $product['price'],
        );
    
        $_SESSION['wishlist'] = $wishlist;
    
        echo '<script>window.location.href = "wishlist.php";</script>';
        exit();
    } else {
        echo "Product not found.";
    }
}
?>

<!-- Wishlist Section -->
<section style="margin-bottom: 50px;">
  <div class="container">
    <div class="row">
      <div class="col-lg-9 mx-auto">
        <div class="card border shadow-0">
          <div class="m-4">
            <h4 class="card-title mb-4">Your Wishlist</h4>
            <?php
            if (empty($_SESSION['wishlist'])) {
                echo '<p>Your wishlist is empty. <a href="../Presentation/home.php">Continue shopping</a>.</p>';
            } else {
                $wishlistProducts = $_SESSION['wishlist'];
                foreach ($wishlistProducts as $product) {
                    echo '<div class="row gy-3 mb-4">';
                    echo '<div class="col-lg-5">';
                    echo '<div class="me-lg-5">';
                    echo '<div class="d-flex">';
                    if (!empty($product['image_1'])) {
                        echo '<img src="../Uploads/' . $product['image_1'] . '" class="border rounded me-3" style="width: 96px; height: 96px;" />';
                    } else {
                        echo '<span class="text-muted">No Image Available</span>';
                    }
                    echo '<div class="mx-3">';
                    echo '<a href="#" class="nav-link">' . $product['name'] . '</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="col-lg-2 col-sm-6 col-6 d-flex flex-row flex-lg-column flex-xl-row text-nowrap">';
                    echo '<div class="">';
                    echo '</div>';
                    echo '<div class="">';
                    echo '<text class="h6">' . $product['price'] . '</text> <br />';
                    echo '<small class="text-muted text-nowrap">' . $product['price_per_item'] . ' / per item </small>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="col-lg col-sm-6 d-flex justify-content-sm-center justify-content-md-start justify-content-lg-center justify-content-xl-end mb-2">';
                    echo '<div class="float-md-end">';
                    echo '<a href="../Presentation/shopping-cart.php?action=add&product_id=' . $product['id'] . '" class="btn btn-light border text-primary icon-hover-primary  me-2"> Add to Cart</a>';
                    echo '<a href="remove-from-wishlist.php?product_id=' . $product['id'] . '" class="btn btn-light border text-danger icon-hover-danger">Remove</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>


<?php
// Function to fetch recommended products from the database
function getRecommendedProducts() {
    include("../database/dbconnection.php");
    $sql = "SELECT * FROM product WHERE product_type = 'newarrival'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $recommendedProducts = array();

        while ($row = $result->fetch_assoc()) {
            $recommendedProducts[] = array(
                'id' => $row['product_id'], // Added 'id' to store the product_id
                'name' => $row['product_name'],
                'image' => '../Uploads/' . $row['image_1'],
                'price' => $row['price'],
            );
        }

        $conn->close();

        return $recommendedProducts;
    } else {
        return array();
    }
}

// Fetch recommended products
$recommendedProducts = getRecommendedProducts();
?>

<!-- Recommended start -->
<section>
  <div class="container my-5">
    <header class="mb-4">
      <h3>Recommended items</h3>
    </header>

    <div class="row">
    <?php
    foreach ($recommendedProducts as $product) {
        $cartButtonUrl = isset($_SESSION['customer_id']) ? 
            '../Presentation/shopping-cart.php?action=add&product_id=' . $product['id'] : 
            '../Presentation/login.php';

        $wishlistButtonUrl = isset($_SESSION['customer_id']) ? 
            '../Presentation/wishlist.php?action=add&product_id=' . $product['id'] : 
            '../Presentation/login.php';

        // Always display "Add to cart"
        $cartButtonText = 'Add to cart';

        $wishlistButtonIcon = '<i class="fas fa-heart fa-lg px-1 text-secondary"></i>';

        echo '<div class="col-lg-3 col-md-6 col-sm-6">';
        echo '<div class="card px-4 border shadow-0 mb-4 mb-lg-0 h-100">';
        echo '<div class="mask px-2" style="height: 50px;">';
        echo '<div class="d-flex justify-content-between">';
        echo '<h6><span class="badge bg-danger pt-1 mt-3 ms-2">New</span></h6>';
        // Wishlist button
        echo '<a href="' . $wishlistButtonUrl . '">' . $wishlistButtonIcon . '</a>';
        echo '</div>';
        echo '</div>';
        echo '<img src="' . $product['image'] . '" class="card-img-top rounded-2" style="height: 200px; object-fit: cover;" />';
        echo '<div class="card-body d-flex flex-column pt-3 border-top">';
        echo '<a href="../Presentation/product-details.php?product_id=' . $product['id'] . '" class="nav-link">' . $product['name'] . '</a>';
        echo '<div class="price-wrap mb-2">';
        echo '<strong class="">Rs ' . $product['price'] . '</strong>';
        echo '</div>';
        echo '<div class="card-footer d-flex align-items-end pt-3 px-0 pb-0 mt-auto">';
        // Add to Cart button
        echo '<a href="' . $cartButtonUrl . '" class="btn btn-outline-primary w-100">' . $cartButtonText . '</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    ?>
</div>

  </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<?php include '../includes/footer.php'; ?>
