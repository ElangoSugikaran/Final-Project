<?php
// Include necessary files
include '../includes/session.php';
include '../includes/header.php';
include '../includes/navbar.php';
include("../database/dbconnection.php");
?>


<!-- Owl Carousel CSS -->
<link rel="stylesheet" href="../plugins/owl-carousel/assets/owl.carousel.min.css">
<link rel="stylesheet" href="../plugins/owl-carousel/assets/owl.theme.default.min.css">

<style>
.owl-prev, .owl-next {
    background: #007bff; /* Background color */
    color: #fff; /* Text color */
    border-radius: 50%; /* Make the buttons circular */
    width: 30px; /* Button width */
    height: 30px; /* Button height */
    line-height: 30px; /* Center text vertically */
    text-align: center; /* Center text horizontally */
    font-size: 20px; /* Font size for arrow */
  }

  .owl-prev {
    left: 10px; /* Position from left */
  }

  .owl-next {
    right: 10px; /* Position from right */
  }

  .brand-carousel .item {
    text-align: center;
    padding: 10px;
}
  .brand-carousel .item img {
    max-width: 100px;
    max-height: 100px;
    margin: auto;
}

/* chatbot css style code */

/* Chatbot Container */
.chatbot-container {
    position: fixed;
    bottom: 100px;
    right: 20px;
    width: 380px;
    max-width: 100%;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    display: none;
    flex-direction: column;
    overflow: hidden;
    z-index: 2000;
}

/* Chatbot Header */
.chatbot-header {
    background-color: #007bff;
    color: #fff;
    padding: 20px;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    display: flex;
    align-items: center;
}

.chatbox-image-header img {
    width: 48px; /* Adjusted to match the original image size */
    height: 48px;
    border-radius: 50%; /* Rounded image */
    margin-right: 15px;
}

.chatbox-content-header {
    flex: 1;
    text-align: left;
}

.chatbox__heading--header {
    font-size: 18px;
    margin: 0;
    color: #fff;
}

.chatbox__description--header {
    font-size: 14px;
    margin: 5px 0 0;
    color: #fff;
}

/* Chatbot Body */
.chatbot-body {
    padding: 10px;
    max-height: 300px;
    overflow-y: auto;
}

/* Chatbot Footer */
.chatbot-footer {
    display: flex;
    border-top: 1px solid #ddd;
    background-color: #007bff;
    padding: 20px;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
    margin-top: 20px;
}

.chatbot-footer input {
    width: 80%;
    padding: 10px 10px;
    border-radius: 30px;
    text-align: left;
    background-color: #f1f1f1;
    font-size: 14px;
    border: none;
    outline: none;
}

.chatbot-footer button {
    padding: 8px;
    background-color: white;
    color: #007bff;
    border: none;
    border-radius: 25px;
    outline: none;
    box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    transition: background-color 0.3s ease;
    
}

.chatbot-footer button:focus,
.chatbot-footer button:visited {
    outline: none;
}

/* Chatbot Icon */
.chatbot-icon {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 24px;
    cursor: pointer;
    z-index: 2000;
    padding: 10px;
    background: #183991;
    border: none;
    outline: none;
    box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.1);
}

.chatbot-icon:hover {
    transform: scale(1.1); /* Slightly enlarge icon on hover */
}

/* Chatbot Messages */
.chatbot-message {
    margin-bottom: 10px;
    margin-top: auto;
    padding: 8px 12px;
    border-radius: 15px;
    display: flex;
    max-width: 60.6%;
    word-wrap: break-word;
    flex-direction: column-reverse;
    width: fit-content;
}

.chatbot-message.user {
    text-align: right;
    background-color: #DCF8C6;
    color: #000;
    border-radius: 15px 15px 0 15px;
    margin-left: auto;  /* Aligns the user message to the right */
}

.chatbot-message.bot {
    text-align: left;
    background-color: #E0E0E0;
    color: #000;
    border-radius: 15px 15px 15px 0;
    margin-right: auto; /* Aligns the bot message to the left */
}

/* Clear Chat Button */
.clear-chat {
    cursor: pointer;
}


</style>

<!--image slider start-->
<?php
// Include database connection
include("../database/dbconnection.php");

// Fetch images from the database
$sql = "SELECT image_path FROM slider_images";
$result = mysqli_query($conn, $sql);
$images = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!-- Image Slider Start -->
<div id="carouselExampleIndicators" class="carousel slide" data-mdb-ride="carousel">
  <div class="carousel-indicators">
    <?php foreach ($images as $index => $image): ?>
      <button
        type="button"
        data-mdb-target="#carouselExampleIndicators"
        data-mdb-slide-to="<?= $index; ?>"
        class="<?= $index === 0 ? 'active' : ''; ?>"
        aria-current="<?= $index === 0 ? 'true' : ''; ?>"
        aria-label="Slide <?= $index + 1; ?>"
      ></button>
    <?php endforeach; ?>
  </div>
  <div class="carousel-inner">
    <?php foreach ($images as $index => $image): ?>
      <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">
        <img src="<?= $image['image_path']; ?>" class="d-block w-100" alt="Slide Image <?= $index + 1; ?>"/>
      </div>
    <?php endforeach; ?>
  </div>
  <button class="carousel-control-prev" type="button" data-mdb-target="#carouselExampleIndicators" data-mdb-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-mdb-target="#carouselExampleIndicators" data-mdb-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>


<!--image slider end-->
    
<!-- image grid start -->
<div class="image-grid">

    <div class="image-large position-relative">
        <a href="../Presentation/mens.php">
            <img src="../image/eyewear for boy.jpg" alt="Eyewear for Boys">
            <div class="position-absolute top-50 start-50 translate-middle text-white">
                <div class="display-3">Eye Wear</div>
                <div class="display-5">For Him</div>
            </div>
        </a>
    </div>
       

    <div class="image-small">
        <a href="../Presentation/kids.php">
            <img src="../image/kids category.jpeg" alt="">
            <div class="position-absolute top-50 start-50 translate-middle text-white">
            <div class="display-4">Kids</div>
        </div>
        </a>
    </div>

    <div class="image-small">
        <a href="../Presentation/contact-lenes.php">
            <img src="../image/contact lenes.jpg" alt="">
            <div class="position-absolute top-50 start-50 translate-middle text-white">
            <div class="display-4">Contact lenses</div>
        </div>
        </a>
    </div>

    <div class="image-small">
        <a href="../Presentation/sunglasses.php">
            <img src="../image/sunglass.jpg" alt="">
            <div class="position-absolute top-50 start-50 translate-middle text-white">
            <div class="display-4">Sunglasses</div>
        </div>
        </a>
    </div>

    <div class="image-small">
        <a href="../Presentation/appointment.php">
            <img src="../image/test.jpg" alt="">
            <div class="position-absolute top-50 start-50 translate-middle text-white">
            <div class="display-4">Appointment</div>
        </div>
        </a>
    </div>
</div>

<!-- image gris end -->
<br>
   <!-- New Arrival products -->
   <section>
    <div class="container my-5">
        <header class="mb-6 border-bottom">
            <h3>New Arrival products</h3>
        </header>

        <div class="owl-carousel owl-theme">
            <?php
            // Query to fetch products of "newarrival" type
            $sql = "SELECT * FROM product WHERE product_type = 'newarrival'";
            $result = $conn->query($sql);

            if ($result !== false && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    // Determine URLs and button classes based on user login status
                    $cartButtonUrl = isset($_SESSION['customer_id']) ? 
                        '../Presentation/shopping-cart.php?action=add&product_id=' . $row['product_id'] : 
                        '../Presentation/login.php';

                    $wishlistButtonUrl = isset($_SESSION['customer_id']) ? 
                        '../Presentation/wishlist.php?action=add&product_id=' . $row['product_id'] : 
                        '../Presentation/login.php';

                    $cartButtonText = 'Add to cart';
                    $wishlistButtonIcon = '<i class="fas fa-heart fa-lg px-1 text-secondary"></i>';

                    echo '<div class="item">';
                    echo '<div class="card my-2 shadow-0">';
                    echo '<a href="../Presentation/product-details.php?product_id=' . $row['product_id'] . '">'; // Link to product_detail.php with product_id parameter
                    echo '<div class="mask" style="height: 50px;">';
                    echo '<div class="d-flex justify-content-start align-items-start h-100 m-2">';
                    echo '<h6><span class="badge bg-danger pt-1">New</span></h6>';
                    echo '</div>';
                    echo '</div>';
                    echo '<img src="../Uploads/' . $row['image_1'] . '" class="card-img-top rounded-2" style="aspect-ratio: 1 / 1" />'; // Image source from the database
                    echo '</a>';
                    // Add to Cart button
                    echo '<a href="' . $cartButtonUrl . '" class="btn btn-primary shadow-0 me-1">' . $cartButtonText . '</a>';
                    echo '<div class="card-body p-0 pt-3">';
                    // Wishlist button
                    echo '<a href="' . $wishlistButtonUrl . '" class="btn btn-light border px-2 pt-2 float-end icon-hover">' . $wishlistButtonIcon . '</a>';
                    echo '<h5 class="card-title">Rs' . $row['price'] . '</h5>';
                    echo '<p class="card-text mb-0">' . $row['product_name'] . '</p>';
                    echo '<p class="text-muted">';
                    // echo 'Model: ' . $row['model_no'];
                    echo '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "No New Arrival products found.";
            }

            $conn->close();
            ?>
        </div>
    </div>
</section>

<!-- Popular Products -->
<section>
    <div class="container my-5">
        <header class="mb-6 border-bottom">
            <h3>Popular products</h3>
        </header>

        <div class="owl-carousel owl-theme">
            <?php
            include("../database/dbconnection.php");

            // Query to fetch products of "popular" type
            $sql = "SELECT * FROM product WHERE product_type = 'popular'";
            $result = $conn->query($sql);

            if ($result !== false && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Determine URLs and button classes based on user login status
                    $cartButtonUrl = isset($_SESSION['customer_id']) ? 
                        '../Presentation/shopping-cart.php?action=add&product_id=' . $row['product_id'] : 
                        '../Presentation/login.php';

                    $wishlistButtonUrl = isset($_SESSION['customer_id']) ? 
                        '../Presentation/wishlist.php?action=add&product_id=' . $row['product_id'] : 
                        '../Presentation/login.php';

                    $cartButtonText = 'Add to cart';
                    $wishlistButtonIcon = '<i class="fas fa-heart fa-lg px-1 text-secondary"></i>';
                    
                    echo '<div class="item">';
                    echo '<div class="card my-2 shadow-0">';
                    echo '<a href="../Presentation/product-details.php?product_id=' . $row['product_id'] . '">'; 
                    echo '<div class="mask" style="height: 50px;">';
                    echo '<div class="d-flex justify-content-start align-items-start h-100 m-2">';
                    echo '<h6><span class="badge bg-danger pt-1">popular</span></h6>';
                    echo '</div>';
                    echo '</div>';
                    echo '<img src="../Uploads/' . $row['image_1'] . '" class="card-img-top rounded-2" style="aspect-ratio: 1 / 1" />'; // Image source from the database
                    echo '</a>';
                    // Add to Cart button
                    echo '<a href="' . $cartButtonUrl . '" class="btn btn-primary shadow-0 me-1">' . $cartButtonText . '</a>';
                    echo '<div class="card-body p-0 pt-3">';
                    // Wishlist button
                    echo '<a href="' . $wishlistButtonUrl . '" class="btn btn-light border px-2 pt-2 float-end icon-hover">' . $wishlistButtonIcon . '</a>';                
                    echo '<h5 class="card-title">Rs' . $row['price'] . '</h5>';
                    echo '<p class="card-text mb-0">' . $row['product_name'] . '</p>';
                    echo '<p class="text-muted">';
                    // echo 'Model: ' . $row['model_no'];
                    echo '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "No Popular products found.";
            }

            $conn->close();
            ?>
        </div>
    </div>
</section>


<!-- Top Sales Products -->
<section>
    <div class="container my-5">
        <header class="mb-6 border-bottom">
            <h3>Top Sale products</h3>
        </header>

        <div class="owl-carousel owl-theme">
            <?php
            include("../database/dbconnection.php");
            // Query to fetch products of "topsale" type
            $sql = "SELECT * FROM product WHERE product_type = 'topsale'";
            $result = $conn->query($sql);

            if ($result !== false && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    // Determine URLs and button classes based on user login status
                    $cartButtonUrl = isset($_SESSION['customer_id']) ? 
                        '../Presentation/shopping-cart.php?action=add&product_id=' . $row['product_id'] : 
                        '../Presentation/login.php';

                    $wishlistButtonUrl = isset($_SESSION['customer_id']) ? 
                        '../Presentation/wishlist.php?action=add&product_id=' . $row['product_id'] : 
                        '../Presentation/login.php';

                    $cartButtonText = 'Add to cart';
                    $wishlistButtonIcon = '<i class="fas fa-heart fa-lg px-1 text-secondary"></i>';

                    echo '<div class="item">';
                    echo '<div class="card my-2 shadow-0">';
                    echo '<a href="../Presentation/product-details.php?product_id=' . $row['product_id'] . '">'; 
                    echo '<div class="mask" style="height: 50px;">';
                    echo '<div class="d-flex justify-content-start align-items-start h-100 m-2">';
                    echo '<h6><span class="badge bg-danger pt-1">topsale</span></h6>';
                    echo '</div>';
                    echo '</div>';
                    echo '<img src="../Uploads/' . $row['image_1'] . '" class="card-img-top rounded-2" style="aspect-ratio: 1 / 1" />'; // Image source from the database
                    echo '</a>';
                     // Add to Cart button
                     echo '<a href="' . $cartButtonUrl . '" class="btn btn-primary shadow-0 me-1">' . $cartButtonText . '</a>';
                     echo '<div class="card-body p-0 pt-3">';
                     // Wishlist button
                     echo '<a href="' . $wishlistButtonUrl . '" class="btn btn-light border px-2 pt-2 float-end icon-hover">' . $wishlistButtonIcon . '</a>';       
                    echo '<h5 class="card-title">Rs' . $row['price'] . '</h5>';
                    echo '<p class="card-text mb-0">' . $row['product_name'] . '</p>';
                    echo '<p class="text-muted">';
                    echo 'Model: ' . $row['model_no'];
                    echo '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "No Top Sale products found.";
            }

            $conn->close();
            ?>
        </div>
    </div>
</section>

    

    <div class="jumbotron text-center position-relative">
    <img src="../image/color-lenses.jpg" alt="Banner Image" class="img-fluid" style="max-width: 100%;">
    <div class="position-absolute top-50 start-50 translate-middle text-white">
    <!-- <div class="position-absolute top-50 start-50 translate-middle text-white"> -->
        <div class="banner-text display-4 mb-4" style="font-size: 5.7rem;">COLOR LENSES</div>
        <button class="btn btn-black btn-lg" style="font-size: 1.5rem;">
            <a href="../Presentation/contact-lenes.php" style="color: white; text-decoration: none;">Explore Now</a>
        </button>
    </div>
</div>

<br>
<br>
<br>

<!-- Brand Carousel -->
<section>
    <div class="container my-5">
        <header class="mb-6 border-bottom">
            <h3>Our Brands</h3>
        </header>
        
        <div class="owl-carousel owl-theme brand-carousel">
            <div class="item">
                <a href="../Presentation/brand-giordano.php">
                    <img src="../image/Giordan-brand-slide.jpg" class="img-fluid" alt="Brand 1">
                </a>
            </div>
            <div class="item">
                <a href="../Presentation/brand-gucci.php">
                    <img src="../image/gucci-brand-slide.jpg" class="img-fluid" alt="Brand 2">
                </a>
            </div>
            <div class="item">
               <a href="../Presentation/brand-boss.php">
                    <img src="../image/boss-brand-slide.png" class="img-fluid" alt="Brand 3">
               </a>
            </div>
            <div class="item">
              <a href="../Presentation/brand-oakley.php">
                <img src="../image/oakley-brand-slide.png" class="img-fluid" alt="Brand 4">
              </a>
            </div>
            <div class="item">
                <a href="../Presentation/brand-reebok.php">
                    <img src="../image/reebok-brand-slide.png" class="img-fluid" alt="Brand 1">
                </a>
            </div>
            <div class="item">
               <a href="brand-prada.php">
                <img src="../image/prada-brand-slide.jpg" class="img-fluid" alt="Brand 2">
               </a>
            </div>
            <div class="item">
                <a href="../Presentation/brand-rayban.php">
                    <img src="../image/rayban-brand-slide.jpg" class="img-fluid" alt="Brand 3">
                </a>
            </div>
        </div>
    </div>
</section>


<!-- Chatbot Section start -->

<!-- Chatbot Icon -->
<div class="chatbot-icon" id="chatbotIcon">
    <svg width="36" height="29" viewBox="0 0 36 29" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M28.2857 10.5714C28.2857 4.88616 21.9576 0.285714 14.1429 0.285714C6.32813 0.285714 0 4.88616 0 10.5714C0 13.8259 2.08929 16.7388 5.34375 18.6272C4.66071 20.2946 3.77679 21.0781 2.9933 21.9621C2.77232 22.2232 2.51116 22.4643 2.59152 22.846C2.65179 23.1875 2.93304 23.4286 3.23438 23.4286C3.25446 23.4286 3.27455 23.4286 3.29464 23.4286C3.89732 23.3482 4.47991 23.2478 5.02232 23.1071C7.05134 22.5848 8.93973 21.721 10.6071 20.5357C11.7321 20.7366 12.9174 20.8571 14.1429 20.8571C21.9576 20.8571 28.2857 16.2567 28.2857 10.5714ZM36 15.7143C36 12.3594 33.7902 9.38616 30.3951 7.51786C30.6964 8.50223 30.8571 9.52679 30.8571 10.5714C30.8571 14.1674 29.0089 17.4821 25.654 19.933C22.5402 22.183 18.4621 23.4286 14.1429 23.4286C13.5603 23.4286 12.9576 23.3884 12.375 23.3482C14.8862 24.9955 18.221 26 21.8571 26C23.0826 26 24.2679 25.8795 25.3929 25.6786C27.0603 26.8638 28.9487 27.7277 30.9777 28.25C31.5201 28.3906 32.1027 28.4911 32.7054 28.5714C33.0268 28.6116 33.3281 28.3504 33.4085 27.9888C33.4888 27.6071 33.2277 27.3661 33.0067 27.1049C32.2232 26.221 31.3393 25.4375 30.6563 23.7701C33.9107 21.8817 36 18.9888 36 15.7143Z" fill="#FFFFFF"/>
    </svg>
</div>

    <!-- Chatbot Container -->
    <div class="chatbot-container" id="chatbotContainer">
        <div class="chatbot-header">
            <div class="chatbox-image-header">
                    <img src="https://img.icons8.com/color/48/000000/circled-user-female-skin-type-5--v1.png" alt="image">
            </div>
            <div class="chatbox-content-header">
                <h4 class="chatbox__heading--header">Crystal Vision Optical Assistance</h4>
                <p class="chatbox__description--header">Hello! I am your Crystal Vision Optical assistant. How can I help you today?</p>
            </div>
        </div>
        <div class="chatbot-body" id="chatbotBody">
            <!-- Messages will be appended here -->
        </div>
        <div class="chatbot-footer">
            <input type="text" id="userMessage" placeholder="Type a message..." style="margin-right: 10px;">
            <button class="btn btn-primary btn-sm" id="sendMessage" style="margin-right: 10px;">Send</button>
            <button class="clear-chat btn btn-danger btn-sm" id="clearChat">Clear Chat</button>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            // Toggle chatbot visibility
            $('#chatbotIcon').click(function() {
                $('#chatbotContainer').toggle();
            });

            // Send message
            $('#sendMessage').click(function() {
                var userMessage = $('#userMessage').val();
                if (userMessage.trim() === '') return;

                // Append user's message
                $('#chatbotBody').append('<div class="chatbot-message user">' + userMessage + '</div>');
                $('#userMessage').val('');

                // Send the message to the chatbot API
                $.post('../includes/chatbot.php', { message: userMessage }, function(data) {
                    var responseMessage = data.answer;
                    $('#chatbotBody').append('<div class="chatbot-message bot">' + responseMessage + '</div>');
                }, 'json');
            });

            // Enable pressing Enter to send message
            $('#userMessage').keypress(function(e) {
                if (e.which == 13) {
                    $('#sendMessage').click();
                }
            });

            // Clear conversation
            $('#clearChat').click(function() {
                $('#chatbotBody').empty();
            });
        });
    </script>
<!-- Chatbot Section end -->



<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- Owl Carousel JS -->
<script src="../plugins/owl-carousel/owl.carousel.min.js"></script>

<!-- Custom JS -->
<script src="../js/script.js"></script>

<?php
// include '../includes/chatbot.php';
include '../includes/footer.php';
?>

