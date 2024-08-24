<?php
include("../database/dbconnection.php");

if (isset($_POST['insert-admin'])) 
{
    $FirstName = $_POST['firstName'];
    $LastName = $_POST['lastName'];
    $ContactNo = $_POST['contactNo'];
    $Email = $_POST['email'];
    $Password = $_POST['password'];
    $ConfirmPassword = $_POST['confirmPassword'];

    $sql = "INSERT INTO admin (firstname, lastname, contact_no, email, password, confirm_password) VALUES 
    ('$FirstName', '$LastName', '$ContactNo', '$Email', '$Password', '$ConfirmPassword')";

    if($conn ->query ($sql)==TRUE){
      echo "<script> alert ('New Record inserted successfully')</script>";
      echo "<script> window.location = '../presentation/view-admin.php';</script>";
    
     }
     else {
        echo "ERROR: ".$sql."<br>".$conn->error;

     }

     $conn->close();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="../Presentation/sweetalert.js"></script>
    <!-- Include SweetAlert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Add this in the <head> section of your HTML -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>


    <title>Admin Dashboard</title>
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
        <h1>Admin Registration</h1>
        <!-- <form action="../Src/insert_code_admin.php" method="POST" id="adminForm"> -->
        <form action="../Src/insert_code_admin.php" method="POST" id="adminForm">
            <br>
            <div class="row">
                <div class="col">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="firstName" required>
                </div>
                <div class="col">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="lastName" required>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="contactNo">Contact No</label>
                    <input type="tel" id="contactNo" name="contactNo" required>
                </div>
            </div>
            <div class="row">
            <div class="col">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                   
                </div>
                <div class="col">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" required>
                  
                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <!-- <button type="submit" name="insert-admin" class="register-button">Register</button> -->
                <button type="submit" name="insert-admin" class="register-button">Register</button>

            </div>
        </form>
    </div>

    <script src="../Presentation/dashboard.js"></script>
    
   
</body>
</html>