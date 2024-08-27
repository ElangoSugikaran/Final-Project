<?php
include("../includes/session.php");
include '../includes/header.php';
include '../includes/navbar.php';
include("../database/dbconnection.php");

// Initialize cart products from session
$cartProducts = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

$totalPrice = 0; // Initialize total price

if (isset($_GET['product_id'])) {
    $product_id = intval($_GET['product_id']);

    // Fetch product details
    $stmt = $conn->prepare("SELECT product_name, category_name AS category, price, image_1 FROM product WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product_result = $stmt->get_result();

    if ($product_result !== false && $product_result->num_rows > 0) {
        $product_row = $product_result->fetch_assoc();
        $product_name = $product_row['product_name'];
        $product_category = $product_row['category'];
        $product_price = $product_row['price'];
        $product_image = $product_row['image_1'];
    } else {
        echo "Product not found.";
        exit;
    }

    $lens_type = "N/A";
    $lens_price = 0;
    $total_price = 0; // Initialize total price

   // Initialize per item price
$per_item_price = floatval($product_price);

if ($product_category === "1" || strtolower($product_category) === "frames") {
    // Frames category
    $stmt = $conn->prepare("SELECT lens_type, lens_price FROM prescription WHERE product_id = ? ORDER BY prescription_id DESC LIMIT 1");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $prescription_result = $stmt->get_result();

    if ($prescription_result !== false && $prescription_result->num_rows > 0) {
        $prescription_row = $prescription_result->fetch_assoc();
        $lens_type = $prescription_row['lens_type'];
        $lens_price = $prescription_row['lens_price'];
    } else {
        $lens_type = "Frame_only";
        $lens_price = 0;
    }

    // Total price includes frame price and lens price if applicable
    $total_price = floatval($product_price) + ($lens_type === "Frame_only" ? 0 : floatval($lens_price));
} elseif (strtolower($product_category) === "sunglasses" || strtolower($product_category) === "contact lenses") {
    // Sunglasses or Contact Lenses category
    $total_price = floatval($product_price);
} else {
    // Default to item price
    $total_price = floatval($product_price);
}

// Add product to cart
$cartProducts[] = [
    'id' => $product_id,
    'name' => $product_name,
    'price' => $total_price, // Total price already calculated
    'per_item_price' => $per_item_price, // Per item price for display
    'frame_price' => ($product_category === "1" || strtolower($product_category) === "frames") ? $product_price : 0,
    'lens_price' => ($product_category === "1" || strtolower($product_category) === "frames") ? $lens_price : 0,
    'sunglass_price' => ($product_category === "3" || strtolower($product_category) === "sunglasses") ? $product_price : 0,
    'contact_lens_price' => ($product_category === "4" || strtolower($product_category) === "contact lenses") ? $product_price : 0,
    'image_1' => $product_image,
];

// Save cart to session
$_SESSION['cart'] = $cartProducts;

// Calculate total price for the cart after adding the new product
$totalPrice = array_sum(array_column($cartProducts, 'frame_price')) +
              array_sum(array_column($cartProducts, 'lens_price')) +
              array_sum(array_column($cartProducts, 'sunglass_price')) +
              array_sum(array_column($cartProducts, 'contact_lens_price'));

    $stmt->close();
    $conn->close();
}
?>



<!-- Main Navigation -->
<header>
    <!-- Heading -->
    <div class="bg-primary mb-4" id="backgroundDiv">
        <div class="container py-4">
            <h3 class="text-white mt-2">Shopping Cart</h3>
            <!-- Breadcrumb -->
            <nav class="d-flex mb-2">
                <h6 class="mb-0">
                    <a href="../Presentation/home.php" class="text-white-50">Home</a>
                    <span class="text-white-50 mx-2"> > </span>
                    <a href="../Presentation/shopping-cart.php" class="text-white"><u>Shopping Cart</u></a>
                </h6>
            </nav>
            <!-- Breadcrumb -->
        </div>
    </div>
    <!-- Heading -->
</header>

<br><br>

<!-- cart + summary -->
<section>
    <div class="container">
        <div class="row">
            <!-- cart -->
            <div class="col-lg-9">
                <div class="card border shadow-0">
                    <div class="m-4">
                        <h4 class="card-title mb-4">Your shopping cart</h4>

                        <?php if (empty($cartProducts)): ?>
                            <p>Your shopping cart is empty. <a href="../Presentation/home.php">Continue shopping</a>.</p>
                        <?php else: ?>
                          <?php 
                          foreach ($cartProducts as $product): 
                              $productTotal = $product['price']; // Total price is already calculated
                              $totalPrice += $productTotal;
                          ?>
                          <div class="row gy-3 mb-4">
                              <div class="col-lg-5">
                                  <div class="me-lg-5">
                                      <div class="d-flex">
                                          <img src="../Uploads/<?= htmlspecialchars($product['image_1']); ?>" class="border rounded me-3" style="width: 96px; height: 96px;" />
                                          <div class="mx-2">
                                              <a href="#" class="nav-link"><?= htmlspecialchars($product['name']) ?></a>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-lg-2 col-sm-6 col-6 d-flex flex-row flex-lg-column flex-xl-row text-nowrap">
                                <div class="quantity-selector">
                                    <select style="width: 80px;" class="form-select quantity-select mx-4" data-product-id="<?= htmlspecialchars($product['id']) ?>">
                                        <?php for ($i = 1; $i <= 10; $i++): ?>
                                            <option value="<?= htmlspecialchars($i) ?>"><?= htmlspecialchars($i) ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="price-display mx-6 ms-4">
                                    <span class="h6 product-price">
                                        Rs <?= htmlspecialchars(number_format($product['price'], 2)) ?><br> 
                                        <small class="text-muted">
                                            <?= htmlspecialchars(
                                                $product_category === "1" ? "Per frame price" :
                                                ($product_category === "3" ? "Per sunglass price" :
                                                ($product_category === "4" ? "Per contact lens price" : "Per item price"))
                                            ) ?>
                                        </small>
                                    </span>
                                    <br />
                                </div>

                              </div>

                              <div class="col-lg col-sm-6 d-flex justify-content-sm-center justify-content-md-start justify-content-lg-center justify-content-xl-end mb-2">
                                  <div class="float-md-end">
                                  <a href="../Presentation/wishlist.php?action=add&product_id=<?php echo $product_id; ?>" 
                                    class="btn btn-light border px-2 icon-hover-primary me-2">
                                        <i class="fas fa-heart fa-lg px-1 text-secondary"></i>
                                  </a>
                                      <a href="remove-from-cart.php?product_id=<?= htmlspecialchars($product['id']) ?>" class="btn btn-light border text-danger icon-hover-danger">Remove</a>
                                  </div>
                              </div>
                          </div>
                          <?php endforeach; ?>

                        <?php endif; ?> 
                    </div>
                </div>
            </div>

            <!-- summary -->
            <div class="col-lg-3">
                <div class="card mb-3 border shadow-0">
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label class="form-label">Have coupon?</label>
                                <div class="input-group">
                                    <input type="text" class="form-control border" name="" placeholder="Coupon code" />
                                    <button class="btn btn-light border">Apply</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card mb-3 shadow-0 border">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="mb-2">Frame price:</p>
                            <p class="mb-2 text-success">
                                Rs <?= htmlspecialchars(number_format(array_sum(array_column($cartProducts, 'frame_price')), 2)) ?>
                            </p>
                        </div>

                        <?php if (array_sum(array_column($cartProducts, 'lens_price')) > 0): // Check if lens price is applicable ?>
                        <div class="d-flex justify-content-between">
                            <p class="mb-2">Lens price:</p>
                            <p class="mb-2 text-success">
                                Rs <?= htmlspecialchars(number_format(array_sum(array_column($cartProducts, 'lens_price')), 2)) ?>
                            </p>
                        </div>
                        <?php endif; ?>

                        <div class="d-flex justify-content-between">
                            <p class="mb-2">Sunglass price:</p>
                            <p class="mb-2 text-success">
                                Rs <?= htmlspecialchars(number_format(array_sum(array_column($cartProducts, 'sunglass_price')), 2)) ?>
                            </p>
                        </div>

                        <div class="d-flex justify-content-between">
                            <p class="mb-2">Contact lens price:</p>
                            <p class="mb-2 text-success">
                                Rs <?= htmlspecialchars(number_format(array_sum(array_column($cartProducts, 'contact_lens_price')), 2)) ?>
                            </p>
                        </div>


                        <div class="d-flex justify-content-between">
                            <p class="mb-2">Discount:</p>
                            <p class="mb-2 text-success">-Rs 00.00</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="mb-2">TAX:</p>
                            <p class="mb-2">Rs 00.00</p>
                        </div>
                        <hr />
                        <div class="d-flex justify-content-between">
                            <p class="mb-2">Total price:</p>
                            <p id="total-price" class="mb-2">Rs <?= htmlspecialchars(number_format($totalPrice, 2)) ?></p>
                        </div>
                    </div>
                </div>

                <div class="card border shadow-0 mb-3">
                    <div class="card-body">
                    <div class="mt-3">
                        <a href="../Presentation/order-info.php?update_cart=true&quantity=<INSERT_QUANTITY_HERE>" class="btn btn-success w-100 shadow-0 mb-2"> Make Purchase </a>
                        <a href="../Presentation/home.php" class="btn btn-light w-100 border mt-2"> Back to shop </a>
                        </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</section>

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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const quantitySelectors = document.querySelectorAll('.quantity-select');
        const totalPriceElement = document.getElementById('total-price');
        const checkoutLink = document.querySelector('.btn-success');

        const products = <?php echo json_encode($cartProducts); ?>;

        function updateTotalPrice() {
        let total = 0;

        quantitySelectors.forEach(function (quantitySelect) {
            const productId = quantitySelect.dataset.productId;
            const selectedQuantity = parseInt(quantitySelect.value, 10);
            const product = products.find(p => p.id == productId);

            if (product) {
                const framePrice = parseFloat(product.frame_price) || 0;
                const lensPrice = parseFloat(product.lens_price) || 0;
                const sunglassPrice = parseFloat(product.sunglass_price) || 0;
                const contactLensPrice = parseFloat(product.contact_lens_price) || 0;
                const pricePerItem = framePrice + lensPrice + sunglassPrice + contactLensPrice;

                total += selectedQuantity * pricePerItem;
            }
        });

    totalPriceElement.textContent = `Rs ${total.toFixed(2)}`;

    // Update the href attribute of the checkout link
    checkoutLink.href = `../Presentation/order-info.php?total=${total.toFixed(2)}`;
}

        quantitySelectors.forEach(function (quantitySelect) {
            quantitySelect.addEventListener('change', updateTotalPrice);
        });

        // Initial update of the total price
        updateTotalPrice();
    });
</script>


<?php include '../includes/footer.php'; ?>