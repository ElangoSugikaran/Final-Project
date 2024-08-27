<?php
include("../includes/session.php");
include("../database/dbconnection.php");

// Check if the database connection is established
if (!$conn) {
    die('Database connection failed: ' . $conn->connect_error);
}

// Check if the user is logged in
$is_logged_in = isset($_SESSION['customer_id']);

if ($is_logged_in) {
    $customer_email = $_SESSION['email'];

    // Prepare the SQL statement to fetch order information
    $query = "SELECT * FROM order_info WHERE email = ?";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param('s', $customer_email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    } else {
        die('Error preparing statement: ' . $conn->error);
    }
} else {
    die('User not logged in');
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/client-dashboard-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <title>Client Dashboard</title>
</head>
<body>
<div id="viewport">
  <!-- Sidebar -->
  <div id="sidebar">
    <header>
      <a href="#">My Dashboard</a>
    </header>
    <ul class="nav">
      <li><a href="../Presentation/client-dashboard.php"><i class="zmdi zmdi-view-dashboard"></i> Dashboard</a></li>
      <li><a href="../Presentation/order-status.php"><i class="zmdi zmdi-time-restore"></i> Order Status</a></li>
      <li><a href="../Presentation/purchase-history.php"><i class="zmdi zmdi-receipt"></i> Purchase History</a></li>
      <li><a href="../Presentation/edit-profile.php"><i class="zmdi zmdi-account-circle"></i> Profile</a></li>
      <li><a href="../Presentation/home.php"><i class="zmdi zmdi-arrow-left"></i> Back to Home</a></li>
    </ul>
  </div>

  <!-- Content -->
  <div id="content">
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <ul class="nav navbar-nav navbar-right">
          <li>
            <div class="header-icons">
              <?php if ($is_logged_in): ?>
                <span class="username"><?php echo htmlspecialchars($customer_email); ?></span>
              <?php endif; ?>
              <i class="zmdi zmdi-account"></i>
            </div>
          </li>
        </ul>
      </div>
    </nav>

    <div class="container-fluid">
      <h1>Order Status</h1>
      
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Product Name</th>
            <th>Image</th>
            <th>Total Price</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                <td>
                  <?php 
                  $imagePath = "../Uploads/" . htmlspecialchars($row['image']);
                  if (file_exists($imagePath) && !empty($row['image'])) {
                      echo "<img src='$imagePath' alt='Product Image' width='100'>";
                  } else {
                      echo "<img src='../images/placeholder.png' alt='Placeholder Image' width='100'>";
                  }
                  ?>
               </td>
                <td><?php echo htmlspecialchars($row['total_price']); ?></td>
                <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                <td>
                  <?php
                  switch ($row['status']) {
                      case 0:
                          echo "In Process";
                          break;
                      case 1:
                          echo "Completed";
                          break;
                      case 2:
                          echo "Cancelled";
                          break;
                      default:
                          echo "Unknown Status";
                          break;
                  }
                  ?>
              </td>
              <td>
                  <a href="order-status-details.php?order_id=<?php echo htmlspecialchars($row['order_id']); ?>" class="btn btn-primary">View</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="6">No orders found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
