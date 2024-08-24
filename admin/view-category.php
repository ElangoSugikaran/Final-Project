<?php
 include("../database/dbconnection.php");

 if (isset($_GET['DELETE'])){
    $category_id=$_GET['DELETE'];

     $sql2="delete from categories where category_id=$category_id";
     $query_run=mysqli_query($conn,$sql2);

     if($query_run) {
      echo "<script> alert ('Delete successfully')</script>";
      echo "<script> window.location = '../admin/view-category.php';</script>";
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
        
       
   <!--<<<<<<<<<<<<<- View product ->>>>>>>>>>>>>>-->

   <div class="View-container">
    <br>
        <h1>Categories Management</h1>
        <br>
         <div class="search-bar">
             <form action="../admin/view-category.php" method="post"> 
             <input type="text" name="search" placeholder="Search...">
              <button type="submit" name="search_btn" class="search-button">Search</button>
            </form>
            <form action="../admin/add-category.php" method="post">
                <button type="submit" class="product-button">Add Category</button>
            </form>
         </div>
      
        <table>
            <thead>

                <tr>
                    <th>Category ID</th>
                    <th>Category Name</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
          
            </thead>
            <tbody>    
            
            <?php

                    include("../database/dbconnection.php");

                    if (isset($_POST['search_btn'])) {
                        $search = $_POST['search'];
                        $sql = "SELECT * FROM categories WHERE 
                        CONCAT(category_id, category_name) LIKE '%$search%'";        
                    } else {
                        $sql = "SELECT * FROM categories";
                    }
                    $query_run = mysqli_query($conn,$sql);

                    //   $Staff_id = 1;
                        $Category_id = 1;

                    while ($row = mysqli_fetch_array($query_run))
                    {
                        $category_id=$row['category_id'];
                        $CategoryName=$row['category_name'];
                        $Date=$row['cat_created_at'];
                      
                        

                    ?>

                    <tr>

                    <td><?php echo $Category_id ?></td>
                    <td><?php echo $CategoryName?></td>
                    <td><?php echo $Date?></td>
                    
                    <td>
                    <button class="btn btn-success" onclick="window.location.href='../admin/update-category.php?UPDATE=<?php echo  $category_id?>'" style="color: white; text-decoration: none;">Update</button>
                    <span class="button-space"></span>
                    <button class="btn btn-danger" onclick="window.location.href='../admin/view-category.php?DELETE=<?php echo  $category_id?>'" style="color: white; text-decoration: none;">Delete</button>
                    </td>
                                    
                    </tr>

                    <?php $Category_id  ++; } ?>                  
                                    

                                </tbody>
                                
                            </table>
                        </div>


    <?php
include './includes/footer.php';
?>  
