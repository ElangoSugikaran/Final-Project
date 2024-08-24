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
    $sql = "SELECT * FROM product WHERE product_id='$UPDATE' ";

    $query_run = mysqli_query($conn, $sql);

    if ($query_run) {
        $row = mysqli_fetch_array($query_run);
        if ($row) {
            $product_id = $row['product_id'];
            $ProductName = $row['product_name'];
            $Image = $row['image_1'];
            $Price = $row['price'];
            $ModelNo = $row['model_no'];
            $Description = $row['description'];
            $Brands = $row['brands'];
            $Shape = $row['shape'];
            $Gender = $row['gender'];
            $Color = $row['colour'];
            $Stock = $row['stock_level'];
            $CategoryName = $row['category_name'];
            $ProductType = $row['product_type'];
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
$sqlCategories = "SELECT DISTINCT category_name FROM product";
$query_run_categories = mysqli_query($conn, $sqlCategories);

if (!$query_run_categories) {
    echo "Error fetching categories: " . mysqli_error($conn);
    exit();
}

$categories = mysqli_fetch_all($query_run_categories, MYSQLI_ASSOC);

if (isset($_POST['update-product'])) {
    $ProductName = $_POST['product_name'];
    $Price = $_POST['product_price'];
    $ModelNo = $_POST['model-no'];
    $Description = $_POST['product_description'];
    $Brands = $_POST['product_brands'];
    $Shape = $_POST['product_shape'];
    $Gender = $_POST['gender'];
    $Color = $_POST['product_color'];
    $Stock = $_POST['product_stock'];
    $CategoryName = $_POST['category_name'];
    $ProductType = $_POST['product-type'];

    $newImage = $_FILES['product_image']['name'];
    $oldImage = $_POST['old_image'];

    if (!empty($newImage)) {
        $Image = uploadImage($_FILES['product_image']);
    } else {
        // Keep the existing image if no new image is selected
        $Image = $oldImage;
    }

    $sql = "UPDATE product SET 
        product_name='$ProductName', 
        image_1='$Image', 
        price='$Price', 
        model_no='$ModelNo', 
        description='$Description', 
        brands='$Brands', 
        shape='$Shape', 
        gender='$Gender', 
        colour='$Color', 
        stock_level='$Stock', 
        category_name='$CategoryName', 
        product_type='$ProductType' 
        WHERE product_id='$product_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record updated successfully');</script>";
        echo "<script>window.location = '../admin/view-product.php';</script>";
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
    <h1>Update Product</h1>
    <form action="../admin/update-product.php?UPDATE=<?php echo $product_id; ?>" method="POST" enctype="multipart/form-data">
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
                <input type="hidden" name="old_image" value="<?= $row['image_1']; ?>">
                <input type="file" id="product_image" name="product_image">
                <label for="product_image">Current Image</label>
                <img src="../Uploads/<?= $row['image_1']; ?>" alt="product_name" style="max-width: 100px; max-height: 100px;">
            </div>
            <div class="p_col">
                <label for="product_price">Product Price</label>
                <input type="number" id="product_price" name="product_price" value="<?php echo $Price; ?>" required>
            </div>
            <div class="p_col">
                <label for="model-no">Model No</label>
                <input type="text" id="model-no" name="model-no" value="<?php echo $ModelNo; ?>" required>
            </div>
        </div>
        <div class="p_row">
            <div class="p_col">
                <label for="product_description">Product Description</label>
                <br>
                <textarea id="product_description" name="product_description" cols="180" rows="5"
                    required><?php echo $Description; ?></textarea>
            </div>
        </div>

        <div class="p_row">
            <div class="p_col">
                <label for="product_brands">Brands</label>
                <input type="text" id="product_brands" name="product_brands" value="<?php echo $Brands; ?>"
                    required>
            </div>
            <div class="p_col">
                <label for="product_shape">Shape</label>
                <input type="text" id="product_shape" name="product_shape" value="<?php echo $Shape; ?>" required>
            </div>
        </div>
        <div class="p_row">
            <div class="p_col">
                <label for="gender">Gender</label>
                <select name="gender" id="gender" required>
                    <option value="">Select Gender</option>
                    <option value="male" <?php echo ($Gender === 'male') ? 'selected' : ''; ?>>Male</option>
                    <option value="female" <?php echo ($Gender === 'female') ? 'selected' : ''; ?>>Female</option>
                    <option value="unisex" <?php echo ($Gender === 'unisex') ? 'selected' : ''; ?>>Unisex</option>
                </select>
            </div>
            <div class="p_col">
                <label for="product_color">Color</label>
                <input type="text" id="product_color" name="product_color" value="<?php echo $Color; ?>" required>
            </div>
        </div>
        <div class="p_row">
            <div class="p_col">
                <label for="product_stock">Stock level</label>
                <input type="text" id="product_stock" name="product_stock" value="<?php echo $Stock; ?>" required>
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
        </div>
        <div class="p_row">
            <div class="p_col">
                <label for="product-type">Product Type</label>
                <select name="product-type" id="product-type">
                    <option value="">Select Product Type</option>
                    <option value="normal" <?php echo ($ProductType === 'normal') ? 'selected' : ''; ?>>Normal Product
                    </option>
                    <option value="newarrival" <?php echo ($ProductType === 'newarrival') ? 'selected' : ''; ?>>New
                        Arrival Product</option>
                    <option value="popular" <?php echo ($ProductType === 'popular') ? 'selected' : ''; ?>>Popular
                        Products</option>
                    <option value="topsale" <?php echo ($ProductType === 'topsale') ? 'selected' : ''; ?>>Top Sale
                        Product</option>
                </select>
            </div>
        </div>
        <br>
        <br>
        <div class="p_row">
            <button type="submit" name="update-product" class="product-button">Update</button>
        </div>
    </form>
</div>

<?php
include './includes/footer.php';
?>
