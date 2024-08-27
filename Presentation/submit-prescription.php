<?php
include("../includes/session.php");
include("../database/dbconnection.php");

// Ensure the session is started
session_start();

// Check if the user is logged in and the email is available in the session
if (!isset($_SESSION['customer_id']) || !isset($_SESSION['email'])) {
    // Handle the error, e.g., redirect to login page
    header("Location: ../Presentation/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data
    $product_id = intval($_POST['product_id']);
    $lens_type = $_POST['lens_type'];
    $fileUpload = $_FILES['fileUpload'];
    $frame_price = floatval($_POST['frame_price']);
    $email = $_SESSION['email']; // Get the email from session

    // Determine the lens price based on selected type
    $lens_price = 0;
    switch ($lens_type) {
        case 'single_vision_uncoated':
            $lens_price = 3000;
            break;
        case 'single_vision_coated':
            $lens_price = 4000;
            break;
        case 'single_vision_crizal':
            $lens_price = 10000;
            break;
        case 'single_vision_crizal_prevencia':
            $lens_price = 14000;
            break;
        case 'bifocal_uncoated':
            $lens_price = 3000;
            break;
        case 'bifocal_coated':
            $lens_price = 8000;
            break;
        case 'bifocal_crizal':
            $lens_price = 10000;
            break;
    }

    // Handle file upload if applicable
    $upload_file_path = null;
    if ($fileUpload['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../Uploads/";
        $target_file = $target_dir . basename($fileUpload["name"]);
        if (move_uploaded_file($fileUpload["tmp_name"], $target_file)) {
            $upload_file_path = basename($fileUpload["name"]);
        } else {
            // Handle file move error
            die("Error moving uploaded file.");
        }
    }

    // Insert into the prescription table with product_id and email
    if ($upload_file_path !== null) {
        $stmt = $conn->prepare("INSERT INTO prescription (product_id, lens_type, lens_price, upload_file, email) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $product_id, $lens_type, $lens_price, $upload_file_path, $email);
    } else {
        $stmt = $conn->prepare("INSERT INTO prescription (product_id, lens_type, lens_price, email) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $product_id, $lens_type, $lens_price, $email);
    }

    $stmt->execute();
    $stmt->close();

    // Redirect to the shopping cart page
    header("Location: ../Presentation/shopping-cart.php?product_id=" . $product_id);
    exit;
}

$conn->close();
