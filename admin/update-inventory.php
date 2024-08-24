<?php
include("../database/dbconnection.php");

function uploadImage($file)
{
    $PATH = "../Uploads";
    $newImage = $file['name'];
    $imageExtension = pathinfo($newImage, PATHINFO_EXTENSION);
    $filename = time() . '.' . $imageExtension;
    move_uploaded_file($file['tmp_name'], $PATH . '/' . $filename);

    return $filename;
}

if (isset($_GET['UPDATE'])) {
    $UPDATE = $_GET['UPDATE'];
    $sql = "SELECT * FROM inventory WHERE inventory_id='$UPDATE' ";

    $query_run = mysqli_query($conn, $sql);

    if ($query_run) {
        $row = mysqli_fetch_array($query_run);
        if ($row) {
            $inventory_id=$row['inventory_id'];
            $ProductName=$row['product_name'];
            $Image=$row['image'];
            $Price=$row['price'];
            $Stock_Quantity=$row['stock_quantity'];
            $Availability=$row['availability'];
            $CategoryName=$row['category_name'];
        } else {
            echo "No record found.";
            exit(); // Exit the script if no record found
        }
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        exit(); // Exit the script on database error
    }
}

// Fetch categories
$sqlCategories = "SELECT DISTINCT category_name FROM inventory";
$query_run_categories = mysqli_query($conn, $sqlCategories);

if (!$query_run_categories) {
    echo "Error fetching categories: " . mysqli_error($conn);
    exit();
}

$categories = mysqli_fetch_all($query_run_categories, MYSQLI_ASSOC);

if (isset($_POST['update-inventory'])) {
    $ProductName = $_POST['product_name'];
    $Price = $_POST['product_price'];
    $Stock_Quantity = $_POST['stock-quantity'];
    $Availability = $_POST['availability'];
    $CategoryName = $_POST['category_name'];

    $newImage = $_FILES['product_image']['name'];
    $oldImage = $_POST['old_image'];

    if (!empty($newImage)) {
        $Image = uploadImage($_FILES['product_image']);
    } else {
        // Keep the existing image if no new image is selected
        $Image = $oldImage;
    }

    $sql = "UPDATE inventory SET 
    product_name='$ProductName', 
    image ='$Image', 
    price ='$Price', 
    stock_quantity ='$Stock_Quantity', 
    availability='$Availability',  
    category_name='$CategoryName' 
    WHERE inventory_id='$inventory_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record updated successfully');</script>";
        echo "<script>window.location = '../admin/view-inventory.php';</script>";
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
    <h1>Update Inventory</h1>
    <form action="../admin/update-inventory.php?UPDATE=<?php echo $inventory_id; ?>" method="POST" enctype="multipart/form-data">
        <br>
        <div class="p_row">
            <div class="p_col">
                <label for="product_name">Product Name</label>
                <input type="text" id="product_name" name="product_name" value="<?= $row['product_name']; ?>" required>
            </div>
        </div>

        <div class="p_row">
            <div class="p_col">
                <label for="product_image">Product Image</label>
                <input type="hidden" name="old_image" value="<?= $row['image']; ?>">
                <input type="file" id="product_image" name="product_image">
                <label for="product_image">Current Image</label>
                <img src="../Uploads/<?= $row['image']; ?>" alt="product_name" style="max-width: 100px; max-height: 100px;">
            </div>
            <div class="p_col">
                <label for="product_price">Product Price</label>
                <input type="number" id="product_price" name="product_price" value="<?php echo $Price; ?>" required>
            </div>
            <div class="p_col">
                <label for="stock-quantity">Stock Quantity</label>
                <input type="text" id="stock-quantity" name="stock-quantity" value="<?php echo $Stock_Quantity; ?>" required>
            </div>
        </div>
        <div class="p_row">
            <div class="p_col">
                <label for="availability">Availability</label>
                <input type="text" id="availability" name="availability" value="<?php echo $Availability; ?>" required>
            </div>
        </div>
        <div class="p_col">
                <label for="category_name">Select Category</label>
                <select name="category_name" id="category_name" required>
                    <option value="">Select Category</option>
                    <?php
                    foreach ($categories as $category) {
                        $categoryName = $category['category_name'];
                        ?>
                        <option value="<?= $categoryName; ?>" <?php echo ($categoryName === $CategoryName) ? 'selected' : ''; ?>>
                            <?= $categoryName; ?>
                        </option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        <br>
        <br>
        <div class="p_row">
            <button type="submit" name="update-inventory" class="product-button">Update</button>
        </div>
    </form>
</div>

<?php
include './includes/footer.php';
?>
