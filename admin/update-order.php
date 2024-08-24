<?php
include("../database/dbconnection.php");
include './includes/header.php';
include './includes/sidebar.php';

$ProductName = $Quantity = $TotalPrice = $Email = $PaymentMethod = $Status = "";
$UserName = $MobileNo = $Address = $Order_id = "";
$Image = $LensType = $LensPrice = $PrescriptionFile = "";

// Fetch order details and prescription if UPDATE parameter is set
if (isset($_GET['UPDATE'])) {
    $UPDATE = intval($_GET['UPDATE']); // Ensure integer type for order_id

    // Correct the join condition based on the given table schema
    $sql = "SELECT order_info.*, 
                   prescription.lens_type, 
                   prescription.lens_price, 
                   prescription.upload_file
            FROM order_info
            LEFT JOIN prescription ON order_info.email = prescription.email
            WHERE order_info.order_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $UPDATE);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $row = $result->fetch_assoc();
        if ($row) {
            // Process the result
            $Order_id = $row['order_id'];
            $ProductName = $row['product_name'];
            $Image = $row['image'];
            $Quantity = $row['quantity'];
            $TotalPrice = $row['total_price'];
            $Date = $row['created_at'];
            $UserName = $row['name'];
            $MobileNo = $row['mobile_no'];
            $Email = $row['email'];
            $Address = $row['address'];
            $Status = $row['status'];
            $PaymentMethod = $row['payment_method'];
            $LensType = isset($row['lens_type']) ? htmlspecialchars($row['lens_type']) : 'N/A';
            $LensPrice = isset($row['lens_price']) ? 'Rs' . htmlspecialchars($row['lens_price']) : 'N/A';
            $PrescriptionFile = isset($row['upload_file']) ? htmlspecialchars($row['upload_file']) : 'N/A';
        } else {
            echo "No record found.";
            exit();
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        exit();
    }

    $stmt->close();
}

// Check if the form is submitted
if (isset($_POST['update-status'])) {
    $Order_id = $_POST['order_id'];
    $Status = $_POST['status'];
    $MobileNo = $_POST['Mobile_no']; // Capture the mobile number

    $sql = "UPDATE order_info SET status=?, mobile_no=? WHERE order_id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $Status, $MobileNo, $Order_id);

    if ($stmt->execute()) {
        echo "<script>alert('Order status updated successfully');</script>";
        echo "<script>window.location = '../admin/view-order.php?UPDATE=$Order_id';</script>";
    } else {
        echo "ERROR: " . $sql . "<br>" . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<br>
<br>
<h1>View Order</h1>
<br>
<div class="add-product-container">
    <form action="" method="POST" enctype="multipart/form-data">
        <h3>Delivery details</h3>
        <br>
        <div class="p_row">
            <div class="p_col">
                <label for="name">Customer Name</label>
                <input type="text" id="name" name="UserName" value="<?= htmlspecialchars($UserName); ?>" required>
            </div>
        </div>

        <div class="p_row">
            <div class="p_col">
                <label for="Mobile_no">Mobile No</label>
                <input type="text" id="Mobile_no" name="Mobile_no" value="<?= htmlspecialchars($MobileNo); ?>" required>
            </div>
            <div class="p_col">
                <label for="Email">Email</label>
                <input type="text" id="Email" name="Email" value="<?= htmlspecialchars($Email); ?>" required>
            </div>
        </div>

        <div class="p_row">
            <div class="p_col">
                <label for="Address">Address</label>
                <input type="text" id="Address" name="Address" value="<?= htmlspecialchars($Address); ?>" required>
            </div>
        </div>
        <hr/>
        <h3>Order details</h3>
        <br>
        <div class="p_row">
            <div class="p_col">
                <label for="product_name">Product Name</label>
                <input type="hidden" name="order_id" value="<?= htmlspecialchars($Order_id); ?>">
                <input type="hidden" name="old_image" value="<?= htmlspecialchars($Image); ?>">
                <input type="text" id="product_name" name="product_name" value="<?= htmlspecialchars($ProductName); ?>" required>
                <?php if (!empty($Image)): ?>
                    <img src="../Uploads/<?= htmlspecialchars($Image); ?>" alt="product_name" style="max-width: 100px; max-height: 100px;">
                <?php endif; ?>
            </div>
            <div class="p_col">
                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" value="<?= htmlspecialchars($Quantity); ?>" required>
            </div>
            <div class="p_col">
                <label for="total_price">Total Price</label>
                <input type="text" id="total_price" name="total_price" value="Rs<?= htmlspecialchars($TotalPrice); ?>" required>
            </div>
        </div>
        <div class="p_row">
            <div class="p_col">
                <label for="LensType">Lens Type</label>
                <input type="text" id="LensType" name="LensType" value="<?= $LensType; ?>" readonly>
            </div>
            <div class="p_col">
                <label for="LensPrice">Lens Price</label>
                <input type="text" id="LensPrice" name="LensPrice" value="<?= $LensPrice; ?>" readonly>
            </div>
            <!-- Prescription File Section -->
            <div class="p_col">
                <label for="PrescriptionFile">Prescription File</label>
                <?php if ($PrescriptionFile !== 'N/A'): ?>
                    <?php 
                    // Get the file extension
                    $fileExtension = strtolower(pathinfo($PrescriptionFile, PATHINFO_EXTENSION));
                    ?>
                    <!-- Display the file -->
                    <?php if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                        <a href="../Uploads/<?= htmlspecialchars($PrescriptionFile); ?>" 
                        target="_blank">
                        <img src="../Uploads/<?= htmlspecialchars($PrescriptionFile); ?>" 
                                alt="Prescription Image" 
                                style="max-width: 100%; max-height: 100px; cursor: pointer;">
                        </a>
                    <?php elseif ($fileExtension === 'pdf'): ?>
                        <a href="../Uploads/<?= htmlspecialchars($PrescriptionFile); ?>" 
                        target="_blank">
                        View PDF
                        </a>
                    <?php else: ?>
                        <input type="text" id="PrescriptionFile" name="PrescriptionFile" value="Unsupported file type" readonly>
                    <?php endif; ?>
                <?php endif; ?> <!-- Closing the if statement -->
            </div>

            <br>
            <br>

        <div class="p_row">
            <div class="p_col">
                <label for="payment_method">Payment Method</label>
                <input type="text" id="payment_method" name="payment_method" value="<?= htmlspecialchars($PaymentMethod); ?>" required>
            </div>
            <div class="p_col">
                <label for="status">Status</label>
                <select name="status" id="status" class="form select">
                    <option value="0" <?= $Status == 0 ? "selected" : ""; ?>>in process</option>
                    <option value="1" <?= $Status == 1 ? "selected" : ""; ?>>completed</option>
                    <option value="2" <?= $Status == 2 ? "selected" : ""; ?>>cancelled</option>
                </select>
                <br>
                <br>
                <div class="row">
                    <div class="col-md-6">
                     <button type="submit" name="update-status" class="product-button" style="width:100%;">Update Status</button>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <a href="../admin/view-order.php" class="btn btn-primary">Back to Orders</a>
                    </div>
                </div>
            </div>
        </div>
           
        <br>
    </form>
</div>


<?php
include './includes/footer.php';
?>
