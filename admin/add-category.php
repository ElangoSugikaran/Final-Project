<?php
include("../database/dbconnection.php");

if (isset($_POST['add-category'])) 
{
    $CategoryName = $_POST['category_name'];
   
    $sql = "INSERT INTO categories (category_name) VALUES 
    (' $CategoryName')";

    if($conn ->query ($sql)==TRUE){
      echo "<script> alert ('New Record inserted successfully')</script>";
      echo "<script> window.location = '../admin/view-category.php';</script>";
    
     }
     else {
        echo "ERROR: ".$sql."<br>".$conn->error;

     }

     $conn->close();
}

?>

<?php
include './includes/header.php';
include './includes/sidebar.php';
?>
<br>
<br>
<br>

       
        <div class="add-product-container">
        <h1>Add Category</h1>
        <form action="../admin/add-category.php" method="POST">
            <br>
            <div class="p_row">
                <div class="p_col">
                    <label for="category_name">Category Name</label>
                    <input type="text" id="category_name" name="category_name" required>
                </div>
            </div>
            <br>
            <br>
            <div class="p_row">
                <button type="submit" class="product-button" name="add-category">Submit</button>
            </div>
        </form>
    </div>


    <?php
include './includes/footer.php';
?>  
