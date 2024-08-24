<?php
include("../database/dbconnection.php");

if (isset($_GET['UPDATE'])) {
    $UPDATE = $_GET['UPDATE'];
    $sql = "SELECT * FROM categories WHERE category_id ='$UPDATE' ";

    $query_run = mysqli_query($conn, $sql);

    if ($query_run) {
        $row = mysqli_fetch_array($query_run);
        if ($row) {
            $category_id = $row['category_id'];
            $CategoryName = $row['category_name'];
            $Date = $row['cat_created_at'];
        } else {
            echo "No record found.";
            exit(); // Exit the script if no record found
        }
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        exit(); // Exit the script on database error
    }
}

if (isset($_POST['update-category'])) {
   $CategoryName = $_POST['category_name'];


    $sql = "UPDATE categories SET category_name=' $CategoryName' WHERE category_id='$category_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record updated successfully');</script>";
        echo "<script>window.location = '../admin/view-category.php';</script>";
    } else {
        echo "ERROR: " . $sql . "<br>" . $conn->error;
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
<br>

<div class="add-product-container">
    <h1>Update Category</h1>
    <form action="../admin/update-category.php?UPDATE=<?php echo $category_id; ?>" method="POST" enctype="multipart/form-data">
        <br>
        <div class="p_row">
            <div class="p_col">
                <label for="category_name">Category Name</label>
                <input type="text" id="category_name" name="category_name" value="<?php echo $CategoryName; ?>" required>
            </div>
        </div>
            <br>
            <div class="p_row">
            <button type="submit" name="update-category" class="product-button">Update</button>
        </div>
    </form>
</div>

<?php
include './includes/footer.php';
?>
