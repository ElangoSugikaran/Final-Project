<?php
 include("../database/dbconnection.php");

 if (isset($_GET['DELETE'])){
    $Inventory_id=$_GET['DELETE'];

     $sql2="delete from inventory where inventory_id=$Inventory_id";
     $query_run=mysqli_query($conn,$sql2);

     if($query_run) {
      echo "<script> alert ('Delete successfully')</script>";
      echo "<script> window.location = '../admin/view-inventory.php';</script>";
     }
     else {
        die(mysqli_error($conn));
     }

   
 }

?>

<?php
include './includes/header.php';
include './includes/sidebar.php';
?>
    <!-- Admin dashboard -->
    <style>
    .View-container {
        width: 90%;
        margin: 0 auto;
    }

    .table-container {
        max-height: 400px;
        overflow-y: auto;
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
        <h1>Inventory Management</h1>
        <br>
          <div class="search-bar">
             <form action="../admin/view-product.php" method="post"> 
             <input type="text" name="search" placeholder="Search...">
              <button type="submit" name="search_btn" class="search-button">Search</button>
            </form>
            <form action="../admin/add-inventory.php" method="post">
                <button type="submit" class="product-button">Add Inventory</button>
            </form>
         </div>
      
         <table>
            <thead>

                <tr>
                    <th>Inventory ID</th>
                    <th>Product Name</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Stock Quantity</th>
                    <th>Availability</th>
                    <th>Category Name</th>
                    <th>Actions</th>
                </tr>
          
            </thead>
            <tbody>    
            
            <?php

                    include("../database/dbconnection.php");

                    if (isset($_POST['search_btn'])) {
                        $search = $_POST['search'];
                        $sql = "SELECT * FROM inventory WHERE concat( product_name, price, category_name) LIKE '%$search%' ";
                    } else {
                        $sql = "SELECT * FROM inventory";

                    }
                    $query_run = mysqli_query($conn,$sql);

                    //   $Staff_id = 1;
                        $Inventory_id = 1;

                    while ($row = mysqli_fetch_array($query_run))
                    {
                        $inventory_id=$row['inventory_id'];
                        $ProductName=$row['product_name'];
                        $Image=$row['image'];
                        $Price=$row['price'];
                        $Stock_Quantity=$row['stock_quantity'];
                        $Availability=$row['availability'];
                        $CategoryName=$row['category_name'];
                        
                        
                        

                    ?>

                    <tr>

                    <td><?php echo $inventory_id ?></td>
                    <td><?php echo $ProductName?></td>

                    <td>
                        <img src="../Uploads/<?php echo $Image ?>" alt="<?php echo $ProductName ?>" style="max-width: 100px; max-height: 100px;">
                    </td>


                    <td><?php echo $Price ?></td>
                    <td><?php echo $Stock_Quantity?></td>
                    <td><?php echo $Availability?></td>
                    <td><?php echo $CategoryName ?></td>
                    <td>
                    <button class="btn btn-success" onclick="window.location.href='../admin/update-inventory.php?UPDATE=<?php echo $inventory_id?>'" style="color: white; text-decoration: none;">Update</button>
                    <span class="button-space"></span>
                    <button class="btn btn-danger" onclick="window.location.href='../admin/view-inventory.php?DELETE=<?php echo $inventory_id?>'" style="color: white; text-decoration: none;">Delete</button>

                    </td>
                                    
                    </tr> 

                    <?php 
                    $Inventory_id ++; 
                    } ?>                  
                                    

                                </tbody>
                                
                            </table>
                        </div>

<?php
include './includes/footer.php';
?>