<?php
include("../includes/session.php");
include '../includes/header.php';
include '../includes/navbar.php';
include("../database/dbconnection.php");

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['customer_id']); // Assuming customer_id is set in session on login

if (isset($_POST['contact-btn'])) {
    if ($isLoggedIn) {
        $Name = $conn->real_escape_string($_POST['name']);
        $Email = $conn->real_escape_string($_POST['email']);
        $MobileNo = $conn->real_escape_string($_POST['contactno']);
        $Message = $conn->real_escape_string($_POST['message']);

        // Insert the form data into the database
        $insertSql = "INSERT INTO message (name, email, mobile_no, message) VALUES 
        ('$Name', '$Email', '$MobileNo', '$Message')";

        if ($conn->query($insertSql) === TRUE) {
            // Message submitted successfully
            echo "<script>alert('Thank you for your message. We will get back to you soon.');</script>";
            echo "<script>window.location = '../Presentation/contact-us.php';</script>";
        } else {
            // Error during insertion
            echo "ERROR: " . $insertSql . "<br>" . $conn->error;
        }
    } else {
        // User is not logged in, show a message or redirect
        echo "<script>alert('You must be logged in to send a message.');</script>";
        echo "<script>window.location = '../Presentation/login.php';</script>";
    }

    $conn->close();
}
?>

<header>
  <!-- Heading -->
  <div class="bg-primary mb-4" id="backgroundDiv">
    <div class="container py-4">
      <h3 class="text-white mt-2">Contact us</h3>
      <!-- Breadcrumb -->
      <nav class="d-flex mb-2">
        <h6 class="mb-0">
          <a href="../Presentation/home.php" class="text-white-50">Home</a>
          <span class="text-white-50 mx-2"> > </span>
          <a href="../Presentation/contact-us.php" class="text-white"><u>Contact us</u></a>
        </h6>
      </nav>
      <!-- Breadcrumb -->
    </div>
  </div>
</header>

<div class="contactus-container">
    <div class="contact-image">
        <img src="../image/contact.jpg" alt="Contact Image">
    </div>
    <div class="contact-info">
        <ul>
            <p>Call Us:</p>
            <li>
                <i class="fas fa-phone"></i>
                <span>+1 (123) 456-7890</span>
            </li>
            <div class="contact-line"></div>
            <p>Email us:</p>
            <li>
                <i class="fas fa-envelope"></i>
                <span>contact@example.com</span>
            </li>
            <div class="contact-line"></div>
            <p>Address</p>
            <li>
                <i class="fas fa-map-marker"></i>
                <span>123 Main St, City, Country</span>
            </li>
            <div class="contact-line"></div>
        </ul>
    </div>
</div>

<br><br><br>

<div class="contact-container">
    <h1>Drop us a Message</h1>
    <form action="../Presentation/contact-us.php" method="POST">
        <br>
        <div class="A_row">
            <div class="A_col">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Name" required>
            </div>
        </div>
        <div class="A_row">
            <div class="A_col">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Email" required>
            </div>
        </div>
        <div class="A_row">
            <div class="A_col">
                <label for="contactno">Contact Number</label>
                <input type="number" id="contactno" name="contactno" placeholder="Contact No" required>
            </div>
        </div>
        <div class="A_row">
            <div class="A_col">
                <label for="message">Message</label>
                <textarea type="text" name="message" id="message" cols="108" rows="5" placeholder="Message" required></textarea>
            </div>
        </div>
        <br><br>
        <div class="A_row">
            <button type="submit" class="contact-button" name="contact-btn">Submit</button>
        </div>
    </form>
</div>

<br><br><br><br><br><br>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var isLoggedIn = <?php echo json_encode($isLoggedIn); ?>;

    // Disable the submit button if the user is not logged in
    var contactButton = document.querySelector(".contact-button");
    if (!isLoggedIn) {
        contactButton.disabled = true;
        contactButton.title = "You must be logged in to send a message";
    }

    // Show a message when trying to click the button if not logged in
    contactButton.addEventListener("click", function(event) {
        if (!isLoggedIn) {
            event.preventDefault();
            alert("You must be logged in to send a message.");
        }
    });
});
</script>

<?php
include '../includes/footer.php';
?>
