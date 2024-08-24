<?php
session_start(); // Start the session

include("../database/dbconnection.php");

// Check if the user is logged in
if (!isset($_SESSION['admin_id'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: admin-login.php");
    exit();
}

// Retrieve the admin email
$admin_id = $_SESSION['admin_id'];
$sql_admin = "SELECT email FROM admin WHERE admin_id = $admin_id";
$query_run_admin = mysqli_query($conn, $sql_admin);

if ($query_run_admin) {
    $admin_result = mysqli_fetch_assoc($query_run_admin);
    $admin_email = $admin_result['email'];
} else {
    $admin_email = 'Not Available'; // Default value if there's an error
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>
<style>
    /* Custom styles */
    .header-info .btn {
        font-size: 14px; /* Adjust font size as needed */
        padding: 0.5rem 1rem; /* Adjust padding for button size */
    }
    .header-info .btn i {
        font-size: 18px; /* Adjust icon size */
    }
     /* Add hover effect for nav links */
  .nav_link {
    transition: background-color 0.3s ease, color 0.3s ease;
    border-radius: 5px;
  }
  
  .nav_link:hover {
    background-color: #1e3d8f;
    color: #ffffff;
    text-decoration: none;
  }

  /* Add active state styling */
  .nav_link.active {
    background-color: #1b3690;
  }
</style>
<body id="body-pd">

<header class="header" id="header">
    <div class="header_toggle"> 
        <i class='bx bx-menu' id="header-toggle"></i> 
    </div>

    <div class="container-fluid">
    <div class="d-flex justify-content-end align-items-center p-2">
        <a href="../admin/logout.php" class="btn btn-outline-danger d-flex align-items-center me-2">
            <i class="bx bx-log-out me-2"></i>
            <span>Logout</span>
        </a>
        <a href="../admin/view-admin.php" class="btn btn-outline-secondary d-flex align-items-center">
            <i class="bx bx-user me-2"></i>
            <span>Admin</span>
        </a>
    </div>
</div>

</div>


</header>

<div class="l-navbar" id="nav-bar" style="background: #2a4dab;">
  <nav class="nav">
    <div>
      <a href="../admin/dashboard.php" class="nav_logo" style="display: flex; align-items: center; padding: 10px;">
      <i class="fa fa-eye" style="color: white; font-size: 24px; margin-left: 5px; margin-right: 10px;"></i>
        <span class="nav_logo-name" style="font-size: 15px; font-weight: bold; color: white;">Crystal Vision Optical</span>
      </a>
      <div class="nav_list">
        <a href="../admin/dashboard.php" class="nav_link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>" style="color: white; padding: 10px 20px; display: flex; align-items: center;">
          <i class="bx bx-grid-alt nav_icon" style="margin-right: 10px;"></i>
          <span class="nav_name">Dashboard</span>
        </a>
        <a href="../admin/view-product.php" class="nav_link <?php echo basename($_SERVER['PHP_SELF']) == 'view-product.php' ? 'active' : ''; ?>" style="color: white; padding: 10px 20px; display: flex; align-items: center;">
          <i class="fa fa-cube nav_icon" style="margin-right: 10px;"></i>
          <span class="nav_name">Products</span>
        </a>
        <a href="../admin/view-category.php" class="nav_link <?php echo basename($_SERVER['PHP_SELF']) == 'view-category.php' ? 'active' : ''; ?>" style="color: white; padding: 10px 20px; display: flex; align-items: center;">
          <i class="fa fa-list-alt nav_icon" style="margin-right: 10px;"></i>
          <span class="nav_name">Category</span>
        </a>
        <a href="../admin/view-inventory.php" class="nav_link <?php echo basename($_SERVER['PHP_SELF']) == 'view-inventory.php' ? 'active' : ''; ?>" style="color: white; padding: 10px 20px; display: flex; align-items: center;">
          <i class="fa fa-cubes nav_icon" style="margin-right: 10px;"></i>
          <span class="nav_name">Inventory</span>
        </a>
        <a href="../admin/view-order.php" class="nav_link <?php echo basename($_SERVER['PHP_SELF']) == 'view-order.php' ? 'active' : ''; ?>" style="color: white; padding: 10px 20px; display: flex; align-items: center;">
          <i class="fa fa-cart-arrow-down nav_icon" style="margin-right: 10px;"></i>
          <span class="nav_name">Order</span>
        </a>
        <a href="../admin/view-appointment.php" class="nav_link <?php echo basename($_SERVER['PHP_SELF']) == 'view-appointment.php' ? 'active' : ''; ?>" style="color: white; padding: 10px 20px; display: flex; align-items: center;">
          <i class="fa fa-calendar-check-o nav_icon" style="margin-right: 10px;"></i>
          <span class="nav_name">Appointment</span>
        </a>
        <a href="../admin/view-customer.php" class="nav_link <?php echo basename($_SERVER['PHP_SELF']) == 'view-customer.php' ? 'active' : ''; ?>" style="color: white; padding: 10px 20px; display: flex; align-items: center;">
          <i class="bx bx-user nav_icon" style="margin-right: 10px;"></i>
          <span class="nav_name">Customer</span>
        </a>
        <a href="../admin/view-message.php" class="nav_link <?php echo basename($_SERVER['PHP_SELF']) == 'view-message.php' ? 'active' : ''; ?>" style="color: white; padding: 10px 20px; display: flex; align-items: center;">
          <i class="fa fa-comments nav_icon" style="margin-right: 10px;"></i>
          <span class="nav_name">Message</span>
        </a>
        <a href="../admin/admin-image-slider.php" class="nav_link <?php echo basename($_SERVER['PHP_SELF']) == 'admin-image-slider.php' ? 'active' : ''; ?>" style="color: white; padding: 10px 20px; display: flex; align-items: center;">
          <i class="fa fa-image nav_icon" style="margin-right: 10px;"></i>
          <span class="nav_name">Image slider</span>
        </a>
      </div>
    </div>
  </nav>
</div>

</body>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</html>
