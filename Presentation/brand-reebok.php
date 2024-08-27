<?php
include("../includes/session.php");
include '../includes/header.php';
include '../includes/navbar.php';
include("../database/dbconnection.php");
?>

<!-- include the jquery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Main Navigation -->
<header>
  <!-- Heading -->
  <div class="bg-primary mb-4" id="backgroundDiv">
    <div class="container py-4">
      <h3 class="text-white mt-2">Brands</h3>
      <!-- Breadcrumb -->
      <nav class="d-flex mb-2">
        <h6 class="mb-0">
          <a href="../Presentation/home.php" class="text-white-50">Home</a>
          <span class="text-white-50 mx-2"> > </span>
          <a href="../Presentation/brand-reebok.php" class="text-white"><u>Reebok EyeWear</u></a>
        </h6>
      </nav>
      <!-- Breadcrumb -->
    </div>
  </div>
</header>

<!-- Sidebar + Content -->
<section class="">
  <div class="container">
    <div class="row">
      <!-- sidebar -->
      <div class="col-lg-3">
        <!-- Toggle button -->
        <button
          class="btn btn-outline-secondary mb-3 w-100 d-lg-none"
          type="button"
          data-mdb-toggle="collapse"
          data-mdb-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span>Show filter</span>
        </button>
        <!-- Collapsible wrapper -->
        <div class="collapse card d-lg-block mb-5" id="navbarSupportedContent">
          <div class="accordion" id="accordionPanelsStayOpenExample">
          <div class="accordion-item">
              <h2 class="accordion-header" id="headingOne">
                <button
                  class="accordion-button text-dark bg-light"
                  type="button"
                  data-mdb-toggle="collapse"
                  data-mdb-target="#panelsStayOpen-collapseOne"
                  aria-expanded="true"
                  aria-controls="panelsStayOpen-collapseOne"
                >
                  Related items
                </button>
              </h2>
              <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                <div class="accordion-body">
                  <ul class="list-unstyled">
                    <li><a href="../Presentation/frames.php" class="text-dark">Frames </a></li>
                    <li><a href="../Presentation/sunglasses.php" class="text-dark">SunGlasses</a></li>
                    <li><a href="../Presentation/contact-lenes.php" class="text-dark">Contact-Lenses </a></li>
                  </ul>
                </div>
              </div>
            </div>
            <!-- Brands Filter -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTwo">
                <button
                  class="accordion-button text-dark bg-light"
                  type="button"
                  data-mdb-toggle="collapse"
                  data-mdb-target="#panelsStayOpen-collapseTwo"
                  aria-expanded="true"
                  aria-controls="panelsStayOpen-collapseTwo"
                >
                  Brands
                </button>
              </h2>
              <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo">
                <div class="accordion-body">
                  <div id="brandsContainer">
                    <?php
                      $sql = "SELECT DISTINCT brands FROM product ORDER BY brands";
                      $result = $conn->query($sql);

                      while ($row = $result->fetch_assoc()) {
                        $brand = htmlspecialchars($row['brands']); // Prevent XSS
                    ?>
                      <div>
                        <input class="form-check-input product-checkbox" type="checkbox" id="brand_<?= $brand; ?>" value="<?= $brand; ?>" />
                        <label class="form-check-label" for="brand_<?= $brand; ?>"><?= $brand; ?></label>
                      </div>
                    <?php
                      }
                    ?>
                  </div>
                </div>
              </div>
            </div>
             <!-- prices filter-->
             <div class="accordion-item">
              <h2 class="accordion-header" id="headingThree">
                <button
                        class="accordion-button text-dark bg-light"
                        type="button"
                        data-mdb-toggle="collapse"
                        data-mdb-target="#panelsStayOpen-collapseThree"
                        aria-expanded="false"
                        aria-controls="panelsStayOpen-collapseThree"
                        >
                  Price
                </button>
              </h2>
              <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree">
                <div class="accordion-body">
                  <div class="range">
                    <input type="range" class="form-range" id="customRange1" />
                  </div>
                  <div class="row mb-3">
                    <div class="col-6">
                      <p class="mb-0">
                        Min
                      </p>
                      <div class="form-outline">
                        <input type="number" id="typeNumber" class="form-control" />
                        <label class="form-label" for="typeNumber">Rs0</label>
                      </div>
                    </div>
                    <div class="col-6">
                      <p class="mb-0">
                        Max
                      </p>
                      <div class="form-outline">
                        <input type="number" id="typeNumber" class="form-control" />
                        <label class="form-label" for="typeNumber">Rs1,0000</label>
                      </div>
                    </div>
                  </div>
                  <button type="button" class="btn btn-white w-100 border border-secondary">apply</button>
                </div>
              </div>
            </div>

            <!-- Shape Filter -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingFour">
                <button
                  class="accordion-button text-dark bg-light"
                  type="button"
                  data-mdb-toggle="collapse"
                  data-mdb-target="#panelsStayOpen-collapseFour"
                  aria-expanded="false"
                  aria-controls="panelsStayOpen-collapseFour"
                >
                  Shape
                </button>
              </h2>
              <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse show" aria-labelledby="headingFour">
                <div class="accordion-body" id="shapeContainer">
                  <?php
                    $sql = "SELECT DISTINCT shape FROM product ORDER BY shape";
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {
                      $shape = htmlspecialchars($row['shape']); // Prevent XSS
                  ?>
                    <div>
                      <input class="form-check-input product-checkbox" type="checkbox" id="shape_<?= $shape; ?>" value="<?= $shape; ?>" />
                      <label class="form-check-label" for="shape_<?= $shape; ?>"><?= $shape; ?></label>
                    </div>
                  <?php
                    }
                  ?>
                </div>
              </div>
            </div>
            <!-- Gender Filter -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingFive">
                <button
                  class="accordion-button text-dark bg-light"
                  type="button"
                  data-mdb-toggle="collapse"
                  data-mdb-target="#panelsStayOpen-collapseFive"
                  aria-expanded="false"
                  aria-controls="panelsStayOpen-collapseFive"
                >
                  Gender
                </button>
              </h2>
              <div id="panelsStayOpen-collapseFive" class="accordion-collapse collapse show" aria-labelledby="headingFive">
                <div class="accordion-body" id="genderContainer">
                  <?php
                    $sql = "SELECT DISTINCT gender FROM product ORDER BY gender";
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {
                      $gender = htmlspecialchars($row['gender']); // Prevent XSS
                  ?>
                    <div>
                      <input class="form-check-input product-checkbox" type="checkbox" id="gender_<?= $gender; ?>" value="<?= $gender; ?>" />
                      <label class="form-check-label" for="gender_<?= $gender; ?>"><?= $gender; ?></label>
                    </div>
                  <?php
                    }
                  ?>
                </div>
              </div>
            </div>

            
           
          </div>
        </div>
      </div>
      <!-- sidebar -->

      <!-- content -->
      <div class="col-lg-9">
        <header class="d-sm-flex align-items-center border-bottom mb-4 pb-3">
          <strong class="d-block py-2">Items found</strong>
          <div class="ms-auto">
            <select id="sortOptions" class="form-select d-inline-block w-auto border pt-1">
              <option value="0">Sort</option>
              <option value="low">Low Price</option>
              <option value="medium">Medium Price</option>
              <option value="high">High Price</option>
            </select>
          </div>
        </header>


        <div class="row" id="result">
          <!-- Products will be displayed here -->
          <?php
            // Define the number of items per page
            $items_per_page = 9;

            // Determine the current page number, default to 1 if not set
            $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

            // Calculate the offset for the SQL query
            $offset = ($page - 1) * $items_per_page;

            // SQL query to fetch products from the database for a specific brand (Reebok)
            $sql = "SELECT * FROM product WHERE brands = 'reebok' LIMIT $items_per_page OFFSET $offset";
            $result = $conn->query($sql);

            // Check if there are any products returned from the query
            if ($result->num_rows > 0) {
                // Loop through the products and display each one
                while ($row = $result->fetch_assoc()) {
                    // Determine the URLs for Add to Cart and Wishlist buttons based on user login status
                    $cartButtonUrl = isset($_SESSION['customer_id']) ? 
                        '../Presentation/shopping-cart.php?action=add&product_id=' . $row['product_id'] : 
                        '../Presentation/login.php';

                    $wishlistButtonUrl = isset($_SESSION['customer_id']) ? 
                        '../Presentation/wishlist.php?action=add&product_id=' . $row['product_id'] : 
                        '../Presentation/login.php';

                    // Button text and icon
                    $cartButtonText = 'Add to cart';
                    $wishlistButtonIcon = '<i class="fas fa-heart fa-lg px-1 text-secondary"></i>';

                    // Display the product card
                    echo '<div class="col-lg-4 col-md-6 col-sm-6 d-flex">';
                    echo '<div class="card w-100 my-2 shadow-2-strong">';
                    echo '<a href="../Presentation/product-details.php?product_id=' . $row['product_id'] . '">';
                    echo '<img src="../Uploads/' . $row['image_1'] . '" class="card-img-top" style="aspect-ratio: 1 / 1"/>'; // Image source from the database
                    echo '</a>';
                    echo '<div class="card-body d-flex flex-column">';
                    echo '<div class="d-flex flex-row">';
                    echo '<h5 class="mb-1 me-1">Rs' . $row['price'] . '</h5>';
                    echo '</div>';
                    echo '<p class="card-text">' . $row['product_name'] . '</p>';
                    echo '<div class="card-footer d-flex align-items-end pt-3 px-0 pb-0 mt-auto">';
                    // Add to cart button
                    echo '<a href="' . $cartButtonUrl . '" class="btn btn-primary shadow-0 me-1">' . $cartButtonText . '</a>';
                    // Add to wishlist button
                    echo '<a href="' . $wishlistButtonUrl . '" class="btn btn-light border icon-hover px-2 pt-2">' . $wishlistButtonIcon . '</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }

                // Fetch the total number of products to calculate pagination
                $result_total = $conn->query("SELECT COUNT(*) as total FROM product WHERE brands = 'reebok'");
                $total_rows = $result_total->fetch_assoc()['total'];
                $total_pages = ceil($total_rows / $items_per_page);

                // Display pagination controls
                echo '<nav aria-label="Page navigation example" class="d-flex justify-content-center mt-3">';
                echo '<ul class="pagination">';
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo '<li class="page-item ' . (($i == $page) ? 'active' : '') . '">';
                    echo '<a class="page-link" href="?page=' . $i . '">' . $i . '</a>';
                    echo '</li>';
                }
                echo '</ul>';
                echo '</nav>';
            } else {
                // Display a message if no products are found
                echo '<div class="text-center mb-3">No products found.</div>';
            }
        ?>
         <hr/>
        </div>
        
      </div>
      <!-- Content -->
      
    </div>
  </div>
</section>

<script>
  $(document).ready(function () {
    $('.product-checkbox').click(function () {
      var brands = get_filter('brands');
      var shapes = get_filter('shape');
      var genders = get_filter('gender');
      var page = 1; // Reset to the first page on filter change

      $.ajax({
        url: "action.php",
        method: "POST",
        data: {
          brands: brands,
          shapes: shapes,
          genders: genders,
          page: page
        },
        success: function (data) {
          $('#result').html(data);
        }
      });
    });

    function get_filter(text_id) {
      var filterData = [];
      $('#' + text_id + 'Container .product-checkbox:checked').each(function () {
        filterData.push($(this).val());
      });
      return filterData;
    }

    // Handle pagination click event
    $(document).on('click', '.pagination a', function (event) {
      event.preventDefault();
      var page = $(this).attr('href').split('page=')[1];
      var brands = get_filter('brand');
      var shapes = get_filter('shape');
      var genders = get_filter('gender');

      $.ajax({
        url: "action.php",
        method: "POST",
        data: {
          brands: brands,
          shapes: shapes,
          genders: genders,
          page: page
        },
        success: function (data) {
          $('#result').html(data);
        }
      });
    });
  });
</script>

<?php
include '../includes/footer.php';
?>
