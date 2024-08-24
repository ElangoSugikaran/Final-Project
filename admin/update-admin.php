<?php
include("../database/dbconnection.php");

if (isset($_GET['UPDATE'])) {
    $UPDATE = $_GET['UPDATE'];
    $sql = "SELECT * FROM admin WHERE admin_ID='$UPDATE' ";

    $query_run = mysqli_query($conn, $sql);

    if ($query_run) {
        $row = mysqli_fetch_array($query_run);
        if ($row) {
            $admin_id = $row['admin_ID'];
            $FirstName = $row['firstname'];
            $LastName = $row['lastname'];
            $ContactNo = $row['contact_no'];
            $Email = $row['email'];
            $Password = $row['password'];
            $ConfirmPassword = $row['confirm_password'];
        } else {
            echo "No record found.";
            exit(); // Exit the script if no record found
        }
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        exit(); // Exit the script on database error
    }
}

if (isset($_POST['update-admin'])) {
    $FirstName = $_POST['firstName'];
    $LastName = $_POST['lastName'];
    $ContactNo = $_POST['contactNo'];
    $Email = $_POST['email'];
    $Password = $_POST['password'];
    $ConfirmPassword = $_POST['confirmPassword'];

    $sql = "UPDATE admin SET firstname='$FirstName', lastname='$LastName', contact_no='$ContactNo', email='$Email', password='$Password', confirm_password='$ConfirmPassword' WHERE admin_ID='$admin_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record updated successfully');</script>";
        echo "<script>window.location = '../Presentation/view-admin.php';</script>";
    } else {
        echo "ERROR: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="../Presentation/sweetalert.js"></script>
    <!-- Include SweetAlert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Add this in the <head> section of your HTML -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <title>update admin</title>
</head>
<body>
     <!-- Admin dashboard -->
     <div class="side-menu">
        <div class="brand-name">
            <h3>Brand</h3>
        </div>
        <ul class="menu-list">
            <li><a href="../Presentation/dashboard.php" class="sm-link">Dashboard</a></li>
            <li><a href="../Presentation/view-product.php" class="sm-link">Product</a></li>
            
            <!--add more if you need-->
       
            <li><a href="../Presentation/view-category.php" class="sm-link">Category</a></li>
            <li><a href="" class="sm-link">Dashboard</a></li>
        </ul>
    </div>

    <div class="dash-container">
        <div class="dash-header">
            <div class="dash-nav">
                <div class="dash-search">
                    <input type="text" placeholder="search...">
                    <button type="submit"><img src="../image/search-icon.png" alt=""></button>
                </div>
                <div class="admin">
                    <a href="../Presentation/view-admin.php" class="admin-btn">Admin</a>
                    <img src="../image/notification1.png" alt="">
                    <div class="img-case">
                        <img src="../image/profile.png" alt="">
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
       
        <div class="add-admin-container">
        <h1>Admin infor-update</h1>
        <form action="../Presentation/update-admin.php?UPDATE=<?php echo $admin_id; ?>" method="POST" id="adminForm">
        <br>
        <div class="row">
            <div class="col">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstName" value="<?php echo $FirstName; ?>" required>
            </div>
            <div class="col">
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName" value="<?php echo $LastName; ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="contactNo">Contact No</label>
                <input type="tel" id="contactNo" name="contactNo" value="<?php echo $ContactNo; ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $Email; ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="password">Password</label>
                <input type="text" id="password" name="password" value="<?php echo $Password; ?>" required>
            </div>
            <div class="col">
                <label for="confirmPassword">Confirm Password</label>
                <input type="text" id="confirmPassword" name="confirmPassword" value="<?php echo $ConfirmPassword; ?>" required>
            </div>
        </div>
            <br>
            <br>
            <div class="row">
                <!-- <button type="submit" name="insert-admin" class="register-button">Register</button> -->
                <button type="submit" name="update-admin" value="update-admin"class="register-button">Update</button>

            </div>
        </form>
    </div>

    <script src="../Presentation/dashboard.js"></script>
    
</body>
</html>