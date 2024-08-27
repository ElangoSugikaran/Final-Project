<?php
include("../includes/session.php");
include '../includes/header.php';
include '../includes/navbar.php';
include("../database/dbconnection.php");

// Retrieve cart data from the session
function getCartProducts() {
  return isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
}

// Fetch products from the cart
$cartProducts = getCartProducts();

// Function to calculate the total price
function calculateTotalPrice($cartProducts) {
  $totalPrice = 0;

  foreach ($cartProducts as $product) {
    $quantity = isset($product['quantity']) ? $product['quantity'] : 1;
    $totalPrice += $quantity * $product['price'];
  }

  return $totalPrice;
}

// Update the total price
$totalPrice = calculateTotalPrice($cartProducts);

// Function to update the cart quantity
function updateCartQuantity($productId, $newQuantity) {
  $cartProducts = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();

  foreach ($cartProducts as &$product) {
    if ($product['id'] == $productId) {
      $product['quantity'] = $newQuantity;
      break;
    }
  }

  $_SESSION['cart'] = $cartProducts;
}

// Check if the form is submitted
if (isset($_POST['order_btn'])) {
  // Get form data
  $name = isset($_POST['name']) ? $_POST['name'] : '';
  $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
  $email = isset($_POST['email']) ? $_POST['email'] : '';
  $address = isset($_POST['address']) ? $_POST['address'] : '';
  $paymentMethod = isset($_POST['paymentMethod']) ? $_POST['paymentMethod'] : '';

  // Validate form data
  if (empty($name) || empty($phone) || empty($email) || empty($address) || empty($paymentMethod)) {
    echo "<script> alert ('Please fill in all required fields.')</script>";
  } else {
    // Insert order details into the order_info table
    foreach ($cartProducts as $product) {
      $productName = isset($product['name']) ? $product['name'] : 'Product Name Not Available';
      $quantity = isset($product['quantity']) ? $product['quantity'] : 1;
      $image = isset($product['image_1']) ? $product['image_1'] : '';

      // Insert data into the order_info table
      $sql = "INSERT INTO order_info (product_name, image, email, quantity, total_price, name, mobile_no, address, payment_method, status)
              VALUES ('$productName', '$image', '$email', '$quantity', '$totalPrice', '$name', '$phone', '$address', '$paymentMethod', 'Pending')";

      // Execute the query
      if ($conn->query($sql) === TRUE) {
        // Order details inserted successfully, you can redirect or display a success message
        echo "<script> alert ('Your Order placed successfully')</script>";
        echo "<script> window.location = '../Presentation/order-info.php';</script>";
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }

    // Clear the cart after placing the order
    $_SESSION['cart'] = array();
  }
}

// ... (existing code)
?>

<!--Main Navigation-->
<header>
  <!-- Heading -->
  <div class="bg-primary mb-4" id="backgroundDiv">
    <div class="container py-4">
      <h3 class="text-white mt-2">Shopping Cart</h3>
      <!-- Breadcrumb -->
      <nav class="d-flex mb-2">
        <h6 class="mb-0">
        <a href="" class="text-white-50">Home</a>
          <span class="text-white-50 mx-2"> > </span>
          <a href="" class="text-white-50">2. Shopping cart</a>
          <span class="text-white-50 mx-2"> > </span>
          <a href="" class="text-white"><u>3. Checkout</u></a>
        </h6>
      </nav>
      <!-- Breadcrumb -->
    </div>
  </div>
  <!-- Heading -->
</header>


<!-- Main Content -->
<section class="bg-light py-5">
  <div class="container">
    <div class="row">
      <!-- Left Section -->
      <div class="col-xl-8 col-lg-8 mb-4">
        <div class="card mb-3 border shadow-0">
          <div class="p-4">
            <form action="../Presentation/order-info.php" method="POST">
              <!-- ... (existing form content) -->
              <h5 class="card-title mb-3">Guest checkout</h5>
              <div class="row mb-4">
                <div class="col-md-6">
                  <label for="name" class="form-label">Name</label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Type here" Required/>
                </div>
                <div class="col-md-6">
                  <label for="phone" class="form-label">Phone</label>
                  <input type="tel" class="form-control" name="phone" id="phone" value="+94 " Required/>
                </div>
              </div>

              <div class="row mb-4">
                <div class="col-md-6">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" name="email" id="email" placeholder="example@gmail.com" Required/>
                </div>
                <div class="col-md-6">
                  <label for="address" class="form-label">Address</label>
                  <input type="text" class="form-control" name="address" id="address" placeholder="Type here" Required/>
                </div>
              </div>

              <div class="row mb-4">
                <div class="col-md-6">
                  <label for="paymentMethod" class="form-label">Payment Method</label>
                  <select class="form-select" name="paymentMethod" id="paymentMethod" Required>
                  <option value="">Select payment</option>
                    <option value="cod">Cash on Delivery</option>
                    <!-- Add other payment methods if needed -->
                  </select>
                </div>
              </div>

              <div class="float-end mt-4">
              <a href="../Presentation/shopping-cart.php">
                  <button type="button" class="btn btn-light border me-2">Cancel</button>
              </a>
                <button type="submit" name="order_btn" class="btn btn-success shadow-0 border">Place Order</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Right Section -->
      <div class="col-xl-4 col-lg-4 d-flex justify-content-center justify-content-lg-end">
        <div class="ms-lg-4 mt-4 mt-lg-0" style="max-width: 320px;">
          <h6 class="mb-3">Summary</h6>
          <!-- Display total price, discount, and shipping cost -->
          <div class="d-flex justify-content-between">
            <p class="mb-2">Total price:</p>
            <p id="summary-total-price" class="mb-2">Rs<?php echo number_format($totalPrice, 2); ?></p>
          </div>

          <!-- Add discount and shipping cost details here -->
          <!-- ... (existing code) -->

          <hr />

          <div class="d-flex justify-content-between">
            <p class="mb-2">Total price:</p>
            <p id="summary-total-price-bold" class="mb-2 fw-bold">Rs<?php echo number_format($totalPrice, 2); ?></p>
          </div>

          <!-- ... (existing code) -->

          <h6 class="text-dark my-4">Items in cart</h6>
          <?php
          foreach ($cartProducts as $product) {
            $quantity = isset($product['quantity']) ? $product['quantity'] : 1;
            ?>
            <div class="d-flex align-items-center mb-4">
              <div class="me-3 position-relative">
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill badge-secondary">
                  <?php echo $quantity; ?>
                </span>
                <img src="../Uploads/<?php echo $product['image_1']; ?>" style="height: 96px; width: 96px;" class="img-sm rounded border" />
              </div>
              <div class="">
                <a href="#" class="nav-link">
                  <?php echo isset($product['name']) ? $product['name'] : 'Product Name Not Available'; ?>
                </a>
                <div class="price text-muted">Total: Rs<?php echo number_format($quantity * $product['price'], 2); ?></div>
              </div>
            </div>
          <?php
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Assuming $cartProducts is available in JavaScript as a JSON-encoded array
    const products = <?php echo json_encode($cartProducts); ?>;
    const summaryTotalPriceElement = document.getElementById('summary-total-price');
    const summaryTotalPriceBoldElement = document.getElementById('summary-total-price-bold');

    function updateSummaryTotalPrice() {
      let total = 0;

      products.forEach(function (product) {
        const quantity = product.quantity || 1;
        total += quantity * product.price;
      });

      // Update total price in the summary
      summaryTotalPriceElement.textContent = 'Rs ' + total.toFixed(2);
      summaryTotalPriceBoldElement.textContent = 'Rs ' + total.toFixed(2);
    }

    // Initial calculation
    updateSummaryTotalPrice();
  });
</script>

<?php
include '../includes/footer.php';
?>
