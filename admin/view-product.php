<?php
 include("../database/dbconnection.php");

 if (isset($_GET['DELETE'])){
    $Product_id=$_GET['DELETE'];

     $sql2="delete from product where product_id=$Product_id";
     $query_run=mysqli_query($conn,$sql2);

     if($query_run) {
      echo "<script> alert ('Delete successfully')</script>";
      echo "<script> window.location = '../admin/view-product.php';</script>";
     }
     else {
        die(mysqli_error($conn));
     }

   
 }

 $is_logged_in = isset($_SESSION['admin_id']);

 // Fetch user details if logged in
 if ($is_logged_in) {
     $admin_id = $_SESSION['admin_id'];
     $admin_email = $_SESSION['email'];
 }

?>

<?php
include './includes/header.php';
include './includes/sidebar.php';
?>
    <!-- Admin dashboard -->
    <style>
    .View-container {
        width: 100%;
        margin: 0 auto;
    }

    .table-container {
        max-height: 400px;
        overflow-y: auto;
        /* overflow-x:auto; */
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 10px;
        border: 1px solid #ccc;
        text-align: left;
    }

    th {
        background-color: #f4f4f4;
    }

</style>            
       
   <!-- <<<<<<<<<<<<<- View product ->>>>>>>>>>>>>>  -->

   <br>
   <div class="View-container">
        <h1>Product Management</h1>
        <br>
          <div class="search-bar">
             <form action="../admin/view-product.php" method="post"> 
             <input type="text" name="search" placeholder="Search...">
              <button type="submit" name="search_btn" class="search-button">Search</button>
            </form>
            <form action="../admin/add-product.php" method="post">
                <button type="submit" class="product-button">Add Product</button>
            </form>
         </div>
      
         <table>
            <thead>

                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Model No</th>
                    <th>Description</th>
                    <th>Brands</th>
                    <th>Shape</th>
                    <th>Gender</th>
                    <th>Colour</th>
                    <th>Stock level</th>
                    <th>Category ID</th>
                    <th>Product Type</th>
                    <th>Actions</th>
                </tr>
          
            </thead>
            <tbody>    
            
            <?php

                    include("../database/dbconnection.php");

                    if (isset($_POST['search_btn'])) {
                        $search = $_POST['search'];
                        $sql = "SELECT * FROM product WHERE 
                        CONCAT(product_id, product_name, price, model_no, brands, shape, colour, gender,product_type) LIKE '%$search%'";        
                    } else {
                        $sql = "SELECT * FROM product";
                    }
                    $query_run = mysqli_query($conn,$sql);

                    //   $Staff_id = 1;
                        $Product_id = 1;

                    while ($row = mysqli_fetch_array($query_run))
                    {
                        $product_id=$row['product_id'];
                        $ProductName=$row['product_name'];
                        $Image=$row['image_1'];
                        $Price=$row['price'];
                        $ModelNo=$row['model_no'];
                        $Description=$row['description'];
                        $Brands=$row['brands'];
                        $Shape=$row['shape'];
                        $Gender=$row['gender'];
                        $Color=$row['colour'];
                        $Stock=$row['stock_level'];
                        $CategoryName=$row['category_name'];
                        $ProductType=$row['product_type'];
                        
                        

                    ?>

                    <tr>

                    <td><?php echo $Product_id ?></td>
                    <td><?php echo $ProductName?></td>

                    <td>
                        <img src="../Uploads/<?php echo $Image ?>" alt="<?php echo $ProductName ?>" style="max-width: 100px; max-height: 100px;">
                    </td>


                    <td><?php echo $Price ?></td>
                    <td><?php echo $ModelNo?></td>
                    <td><?php echo $Description?></td>
                    <td><?php echo $Brands ?></td>
                    <td><?php echo $Shape ?></td>
                    <td><?php echo $Gender ?></td>
                    <td><?php echo $Color?></td>
                    <td><?php echo $Stock ?></td>
                    <td><?php echo $CategoryName ?></td>
                    <td><?php echo $ProductType?></td>
                    <td>
                    <button class="btn btn-success" onclick="window.location.href='../admin/update-product.php?UPDATE=<?php echo $product_id?>'" style="color: white; text-decoration: none;">Update</button>
                    <br>
                    <span class="button-space"></span>
                    <br>
                    <button class="btn btn-danger" onclick="window.location.href='../admin/view-product.php?DELETE=<?php echo $product_id?>'" style="color: white; text-decoration: none;">Delete</button>

                    </td>
                                    
                    </tr>

                    <?php $Product_id ++; } ?>                  
                                    

                                </tbody>
                                
                            </table>
                        </div>

<?php
include './includes/footer.php';
?>