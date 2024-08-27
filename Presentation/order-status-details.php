<?php
include("../includes/session.php");
include("../database/dbconnection.php");

// Check if the database connection is established
if (!$conn) {
    die('Database connection failed: ' . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['customer_id'])) {
    die('User not logged in');
}

$customer_email = $_SESSION['email'];
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

if ($order_id > 0) {
    // Prepare the SQL statement to fetch order information
    $query = "SELECT order_info.*, 
                     prescription.lens_type, 
                     prescription.lens_price, 
                     prescription.upload_file
              FROM order_info
              LEFT JOIN prescription ON order_info.email = prescription.email AND order_info.email = prescription.email
              WHERE order_info.email = ? AND order_info.order_id = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die('Error preparing statement: ' . $conn->error);
    }

    $stmt->bind_param('si', $customer_email, $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
        // Assign fetched data to variables
        $Order_id = $order['order_id'];
        $ProductName = $order['product_name'];
        $Image = $order['image'];
        $Quantity = $order['quantity'];
        $TotalPrice = $order['total_price'];
        $LensType = isset($order['lens_type']) ? htmlspecialchars($order['lens_type']) : 'N/A';
        $LensPrice = isset($order['lens_price']) ? 'Rs' . htmlspecialchars($order['lens_price']) : 'N/A';
        $PrescriptionFile = isset($order['upload_file']) ? htmlspecialchars($order['upload_file']) : 'N/A';
    } else {
        die('No order information found for this user.');
    }

    $stmt->close();
} else {
    die('Invalid order ID');
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
    <style>
        .form-control[readonly] {
            background-color: #f9f9f9;
        }

        .order-detail-container h1 {
            margin-bottom: 20px;
        }
        .img-thumbnail {
            display: block;
            margin: 0 auto;
        }
        .input-group {
            margin-bottom: 15px;
            margin-left: 70px;
        }
        .input-group img {
            display: block;
            /* margin-top: 10px; */
         }
        .btn-primary {
            margin-top: 20px;
        } 
    </style>
</head>
<body>
<div id="viewport">
    <!-- Sidebar -->
    <div id="sidebar">
        <header><a href="#">My Dashboard</a></header>
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
                            <?php if (isset($customer_email)): ?>
                                <span class="username"><?php echo htmlspecialchars($customer_email); ?></span>
                            <?php endif; ?>
                            <i class="zmdi zmdi-account"></i>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container-fluid ">
    <h1>Order Details</h1>
    <br>
    <!-- Row for Product Name and Image -->
    <div class="p-row">
        <div class="col-md-6 input-group">
            <label for="product_name">Product Name</label>
            <input type="hidden" name="order_id" value="<?= htmlspecialchars($Order_id); ?>">
            <input type="hidden" name="old_image" value="<?= htmlspecialchars($Image); ?>">
            <input type="text" id="product_name" name="product_name" class="form-control" value="<?= htmlspecialchars($ProductName); ?>" readonly>
        </div>
        <div class="col-md-6 input-group">
            <?php if (!empty($Image)): ?>
                <img src="../Uploads/<?= htmlspecialchars($Image); ?>" alt="product_name" class="img-thumbnail" style="max-width: 100%; max-height: 150px;">
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Row for Quantity and Total Price -->
    <div class="p-row">
        <div class="col-md-6 input-group">
            <label for="quantity">Quantity</label>
            <input type="number" id="quantity" name="quantity" class="form-control" value="<?= htmlspecialchars($Quantity); ?>" readonly>
        </div>
        <div class="col-md-6 input-group">
            <label for="total_price">Total Price</label>
            <input type="text" id="total_price" name="total_price" class="form-control" value="Rs<?= htmlspecialchars($TotalPrice); ?>" readonly>
        </div>
    </div>
    
    <!-- Row for Lens Type, Lens Price, and Prescription File -->
    <div class="p-row">
        <div class="col-md-4 input-group">
            <label for="LensType">Lens Type</label>
            <input type="text" id="LensType" name="LensType" class="form-control" value="<?= htmlspecialchars($LensType); ?>" readonly>
        </div>
        <div class="col-md-4 input-group">
            <label for="LensPrice">Lens Price</label>
            <input type="text" id="LensPrice" name="LensPrice" class="form-control" value="<?= htmlspecialchars($LensPrice); ?>" readonly>
        </div>
        <div class="col-md-4 input-group">
            <label for="PrescriptionFile">Prescription File</label>
            <?php if ($PrescriptionFile !== 'N/A'): ?>
                <?php 
                $fileExtension = strtolower(pathinfo($PrescriptionFile, PATHINFO_EXTENSION));
                if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                    <a href="../Uploads/<?= htmlspecialchars($PrescriptionFile); ?>" target="_blank">
                        <img src="../Uploads/<?= htmlspecialchars($PrescriptionFile); ?>" alt="Prescription Image" class="img-thumbnail" style="max-width: 100%; max-height: 100px; cursor: pointer;">
                    </a>
                <?php elseif ($fileExtension === 'pdf'): ?>
                    <a href="../Uploads/<?= htmlspecialchars($PrescriptionFile); ?>" target="_blank">View PDF</a>
                <?php else: ?>
                    <input type="text" id="PrescriptionFile" name="PrescriptionFile" value="Unsupported file type" readonly>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Back to Orders Button -->
    <div class="p-row">
        <div class="col-md-12">
            <a href="order-status.php" class="btn btn-primary">Back to Orders</a>
        </div>
    </div>
</div>
<br>

</body>
</html>
