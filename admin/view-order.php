<?php
//  include("../database/dbconnection.php");

//  if (isset($_GET['DELETE'])){
//     $Product_id=$_GET['DELETE'];

//      $sql2="delete from product where product_id=$Product_id";
//      $query_run=mysqli_query($conn,$sql2);

//      if($query_run) {
//       echo "<script> alert ('Delete successfully')</script>";
//       echo "<script> window.location = '../admin/view-product.php';</script>";
//      }
//      else {
//         die(mysqli_error($conn));
//      }

   
//  }

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

    .delete-link {
        color: #ff0000;
        font-weight: bold;
        text-decoration: none;
        padding: 5px 10px;
        border: 1px solid #ff0000;
        border-radius: 3px;
    }

    .delete-link:hover {
        background-color: #ff0000;
        color: #ffffff;
    }
</style>   
   <!-- <<<<<<<<<<<<<- View product ->>>>>>>>>>>>>>  -->

   <br>
   <div class="View-container">
        <h1>Order Management</h1>
        <br>
          <div class="search-bar">
             <form action="../admin/view-product.php" method="post"> 
             <input type="text" name="search" placeholder="Search...">
              <button type="submit" name="search_btn" class="search-button">Search</button>
            </form>
         </div>
      
         <table>
            <thead>

                <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Image</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Created at</th>
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
                    $sql = "SELECT * FROM order_info ORDER BY created_at DESC";
                }
                $query_run = mysqli_query($conn, $sql);

                $Order_id = 1;

                while ($row = mysqli_fetch_array($query_run)) {
                    $order_id = $row['order_id'];
                    $ProductName = $row['product_name'];
                    $Image = $row['image'];
                    $Quantity = $row['quantity'];
                    $TotalPrice = $row['total_price'];
                    $Date = $row['created_at'];
                ?>

                <tr>
                    <td><?php echo $Order_id ?></td>
                    <td><?php echo $ProductName ?></td>
                    <td>
                        <img src="../Uploads/<?php echo $Image ?>" alt="<?php echo $ProductName ?>" style="max-width: 100px; max-height: 100px;">
                    </td>
                    <td><?php echo $Quantity ?></td>
                    <td><?php echo $TotalPrice ?></td>
                    <td><?php echo $Date ?></td>
                    <td>
                        <button class="btn btn-success" onclick="window.location.href='../admin/update-order.php?UPDATE=<?php echo $order_id ?>'" style="color: white; text-decoration: none;">View</button>
                    </td> 
                </tr>

                <?php $Order_id++; } ?>                  
                                    
            </tbody>
        </table>
    </div>

<?php
include './includes/footer.php';
?>
