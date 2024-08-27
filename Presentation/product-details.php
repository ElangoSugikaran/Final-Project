<?php
// Your existing code to fetch product details
include("../includes/session.php");
include '../includes/header.php';
include '../includes/navbar.php';
include("../database/dbconnection.php");

$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

$stmt = $conn->prepare("SELECT product_name, category_name, price, description, image_1, brands, shape, colour, model_no FROM product WHERE product_id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

$product_name = "Product Not Found";
$category_name = "1"; // Default to Frames
$frame_price = 0;

if ($product) {
    $product_name = $product['product_name'];
    $category_name = $product['category_name'];
    $frame_price = $product['price'];
    $product_price = $product['price'];
    $description = $product['description'];
    $imageSrc = "../Uploads/" . $product['image_1'];
    $brands = $product['brands'];
    $shape = $product['shape'];
    $colour = $product['colour'];
    $modelNo = $product['model_no'];
} else {
    echo "Product not found.";
    exit;
}

$stmt->close();
?>

<!-- HTML content -->
<header>
    <div class="bg-primary" id="backgroundDiv">
        <div class="container py-4">
            <nav class="d-flex">
                <h6 class="mb-0">
                    <a href="../Presentation/home.php" class="text-white-50">Home</a>
                    <?php if ($category_name === "Frames") : ?>
                        <a href="#" class="text-white-50">Frames</a>
                    <?php endif; ?>
                    <span class="text-white-50 mx-2"> > </span>
                    <a href="#" class="text-white"><u><?php echo htmlspecialchars($product_name); ?></u></a>
                </h6>
            </nav>
        </div>
    </div>
</header>

<section class="py-5">
    <div class="container">
        <div class="row gx-5">
            <aside class="col-lg-6">
                <div class="border rounded-4 mb-3 d-flex justify-content-center">
                    <a data-fslightbox="mygalley" class="rounded-4" target="_blank" data-type="image" href="<?php echo htmlspecialchars($imageSrc); ?>">
                        <img style="max-width: 100%; max-height: 100vh; margin: auto;" class="rounded-4 fit" src="<?php echo htmlspecialchars($imageSrc); ?>" alt="Product Image"/>
                    </a>
                </div>
                <!-- Display additional product images here -->
            </aside>
            <main class="col-lg-6">
                <form name="productForm" action="../Presentation/submit-prescription.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                    <input type="hidden" name="total_price" id="total_price_input" value="<?php echo $frame_price; ?>">
                    <input type="hidden" name="lens_price" id="lens_price_input" value="0">
                    <input type="hidden" name="lens_type" id="lens_type_input" value="frame_only">

                    <div class="ps-lg-3">
                        <h4 class="title text-dark"><?php echo htmlspecialchars($product_name); ?></h4>
                        <div class="d-flex flex-row my-3">
                            <span class="text-success ms-2">In stock</span>
                        </div>
                        <div class="mb-3">
                            <span id="price" class="h5">Rs <?php echo $frame_price; ?></span>
                        </div>
                        <div class="row">
                            <dt class="col-3">Model No</dt>
                            <dd class="col-9"><?php echo htmlspecialchars($modelNo); ?></dd>
                            <dt class="col-3">Brand</dt>
                            <dd class="col-9"><?php echo htmlspecialchars($brands); ?></dd>
                            <dt class="col-3">Color</dt>
                            <dd class="col-9"><?php echo htmlspecialchars($colour); ?></dd>
                            <dt class="col-3">Shape</dt>
                            <dd class="col-9"><?php echo htmlspecialchars($shape); ?></dd>
                        </div>

                        <?php if ($category_name === "1") : // Assuming 1 is the category for frames ?>
                            <div class="border rounded-2 px-3 py-2 bg-white mt-4">
                                <label for="selectOption" class="form-label">
                                    <span style="color: red;">* Required Information</span> Select Your Lens Type:
                                </label>
                                <select class="form-select" id="selectOption" name="lens_type">
                                    <option value="">--please select--</option>
                                    <option value="frame_only" data-price="0">Frame only</option>
                                    <option value="single_vision_uncoated" data-price="3000">Single Vision Un-Coated +Rs 3000.00</option>
                                    <option value="single_vision_coated" data-price="4000">Single Vision Coated +Rs 4000.00</option>
                                    <option value="single_vision_crizal" data-price="10000">Single Vision Crizal +Rs 10000.00</option>
                                    <option value="single_vision_crizal_prevencia" data-price="14000">Single Vision Crizal Prevencia +Rs 14000.00</option>
                                    <option value="bifocal_uncoated" data-price="3000">Bi-Focal Un-coated +Rs 3000.00</option>
                                    <option value="bifocal_coated" data-price="8000">Bi-Focal coated +Rs 8000.00</option>
                                    <option value="bifocal_crizal" data-price="10000">Bifocal Crizal +Rs 10000.00</option>
                                </select>
                                <label for="fileUpload" class="form-label mt-3">
                                    <span style="color: red;">* Required Information</span> Upload a file (JPEG, PNG, PDF only):
                                </label>
                                <input type="file" class="form-control" id="fileUpload" name="fileUpload" accept=".jpeg,.jpg,.png,.pdf">
                            </div>

                            <script>
                                document.getElementById("selectOption").addEventListener("change", function() {
                                    var selectedOption = this.options[this.selectedIndex];
                                    var lensPrice = selectedOption.getAttribute("data-price");
                                    document.getElementById("lens_price_input").value = lensPrice || 0;
                                    document.getElementById("lens_type_input").value = this.value;
                                    document.getElementById("total_price_input").value = parseFloat(<?php echo $frame_price; ?>) + parseFloat(lensPrice || 0);
                                    document.getElementById("price").innerText = "Rs " + document.getElementById("total_price_input").value;
                                });

                                function validateAndSubmit() {
                                    var selectOption = document.getElementById("selectOption").value;
                                    var fileUpload = document.getElementById("fileUpload").value;
                                    if (selectOption === "frame_only") {
                                        document.forms["productForm"].submit();
                                    } else if (selectOption !== "" && fileUpload !== "") {
                                        document.forms["productForm"].submit();
                                    } else {
                                        alert("Please fill in all required information.");
                                    }
                                }
                            </script>
                        <?php endif; ?>

                        <div class="my-4"></div>

                        <div class="button-group d-flex">
                            <?php
                            // Determine URLs and button texts based on user login status
                            $cartButtonUrl = isset($_SESSION['customer_id']) ? 
                                '../Presentation/shopping-cart.php?action=add&product_id=' . $product_id : 
                                '../Presentation/login.php';

                            $wishlistButtonUrl = isset($_SESSION['customer_id']) ? 
                                '../Presentation/wishlist.php?action=add&product_id=' . $product_id : 
                                '../Presentation/login.php';

                            $cartButtonText = 'Add to cart';
                            $wishlistButtonIcon = '<i class="fas fa-heart fa-lg px-1 text-secondary"></i>';
                            ?>

                            <?php if ($category_name === "1") : ?>
                                <button type="button" class="btn btn-primary shadow-0 me-1" onclick="validateAndSubmit()">Add to cart</button>
                            <?php else : ?>
                                <a href="<?php echo htmlspecialchars($cartButtonUrl); ?>" class="btn btn-primary shadow-0 me-1"><?php echo htmlspecialchars($cartButtonText); ?></a>
                            <?php endif; ?>

                            <a href="<?php echo htmlspecialchars($wishlistButtonUrl); ?>" class="btn btn-light border px-2 icon-hover-primary me-2">
                                <?php echo $wishlistButtonIcon; ?>
                            </a>
                        </div>

                    </div>
                </form>
            </main>
        </div>
    </div>
</section>

<!-- Tab Content -->
<section class="bg-light border-top py-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="border rounded-2 px-3 py-2 bg-white">
                    <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="ex3-tab-1" data-mdb-toggle="pill" href="#ex3-pills-1" role="tab" aria-controls="ex3-pills-1" aria-selected="true">Product Details</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="ex3-tab-2" data-mdb-toggle="pill" href="#ex3-pills-2" role="tab" aria-controls="ex3-pills-2" aria-selected="false">Information</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="ex3-tab-3" data-mdb-toggle="pill" href="#ex3-pills-3" role="tab" aria-controls="ex3-pills-3" aria-selected="false">Seller</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="ex2-content">
                        <div class="tab-pane fade show active" id="ex3-pills-1" role="tabpanel" aria-labelledby="ex3-tab-1">
                            <p><?php echo htmlspecialchars($description); ?></p>
                        </div>
                        <div class="tab-pane fade" id="ex3-pills-2" role="tabpanel" aria-labelledby="ex3-tab-2">
                            <p>Tab content or sample information now.</p>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                            <p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                        <div class="tab-pane fade" id="ex3-pills-3" role="tabpanel" aria-labelledby="ex3-tab-3">
                            <p>Another tab content or sample information now.</p>
                            <p>Et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
                            <p>Duis aute irure dolor in reprehenderit in voluptate velit esse.</p>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            // Function to fetch similar products from the database
            function getSimilarProducts() {
                include("../database/dbconnection.php"); // Include the database connection
                $sql = "SELECT * FROM product WHERE product_type = 'newarrival'"; // Query to fetch products
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $similarProducts = array();

                    while ($row = $result->fetch_assoc()) {
                        $similarProducts[] = array(
                            'id' => $row['product_id'], // Assuming there's a product_id column in your table
                            'name' => $row['product_name'],
                            'image' => '../Uploads/' . $row['image_1'],
                            'price' => $row['price'],
                        );
                    }

                    $conn->close(); // Close the database connection

                    return $similarProducts;
                } else {
                    return array(); // Return an empty array if no products found
                }
            }

            // Fetch similar products
            $similarProducts = getSimilarProducts();
            ?>

            <div class="col-lg-4">
                <div class="px-0 border rounded-2 shadow-0">
                    <div class="card-body">
                        <h5 class="card-title">Similar items</h5>
                        <?php
                        $counter = 0; // Initialize counter
                        foreach ($similarProducts as $product) {
                            if ($counter >= 6) break; // Stop after displaying 6 products
                            
                            // Create a link to the product-details.php page with the product ID as a parameter
                            $productDetailUrl = "product-details.php?product_id=" . $product['id'];
                            
                            echo '<div class="d-flex mb-3">';
                            echo '<a href="' . $productDetailUrl . '" class="me-3">'; // Link to product details
                            echo '<img src="' . $product['image'] . '" style="height: 96px; width: 96px;" class="img-md img-thumbnail" />';
                            echo '</a>';
                            echo '<div class="info">';
                            echo '<a href="' . $productDetailUrl . '" class="nav-link mb-1">' . $product['name'] . '</a>'; // Link to product details
                            echo '<strong class="text-dark">Rs ' . $product['price'] . '</strong>';
                            echo '</div>';
                            echo '</div>';

                            $counter++; // Increment counter
                        }

                        if ($counter === 0) {
                            echo '<p>No similar items found.</p>'; // Message if no products are found
                        }
                        ?>
                    </div>
                </div>
            </div>


           
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>

