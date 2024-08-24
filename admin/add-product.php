<?php
include("../database/dbconnection.php");

if (isset($_POST['insert-product'])) {
    $ProductName = $_POST['product_name'];
    $Price = $_POST['product_price'];
    $ModelNo = $_POST['model-no'];
    $Description = $_POST['product_description'];
    $Brands = $_POST['product_brands'];
    $Shape = $_POST['product_shape'];
    $Gender = $_POST['gender'];
    $Color = $_POST['product_color'];
    $Stock = $_POST['product_stock'];
    $CategoryID = $_POST['category_name']; // Assuming this is the ID of the selected category
    $ProductType = $_POST['product-type'];

    // File upload process
    if (isset($_FILES['product_image'])) {
        $imageFile = $_FILES['product_image'];
        $imageFileName = $imageFile['name'];
        $imageTmpName = $imageFile['tmp_name'];
        $imageFileSize = $imageFile['size'];
        $imageFileError = $imageFile['error'];

        // Check for image file errors
        if ($imageFileError === 0) {
            $uploadPath = "../Uploads/" . $imageFileName;

            // Move the uploaded file to the desired location
            if (move_uploaded_file($imageTmpName, $uploadPath)) {
                // Image uploaded successfully
                $sql = "INSERT INTO product (product_name, image_1, price, model_no, description, brands, shape, gender, colour, stock_level, category_name, product_type) 
                VALUES ('$ProductName', '$imageFileName', '$Price', '$ModelNo', '$Description', '$Brands', '$Shape', '$Gender', '$Color', '$Stock', '$CategoryID', '$ProductType')";

                if ($conn->query($sql) === TRUE) {
                    echo "<script>alert('New Record inserted successfully')</script>";
                    echo "<script>window.location = '../admin/view-product.php';</script>";
                } else {
                    echo "ERROR: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Error uploading the image.";
            }
        } else {
            echo "Error: " . $imageFileError;
        }
    } else {
        echo "No image uploaded.";
    }

    $conn->close();
}
?>


<?php
include './includes/header.php';
include './includes/sidebar.php';
?>

    <!-- Admin dashboard -->
     <br>
     <br>
     <br>
     <br>
    <div class="add-product-container">
    <h1>Add Product</h1>
    <form action="../admin/add-product.php" method="POST" enctype="multipart/form-data">
        <br>
        <div class="p_row">
            <div class="p_col">
                <label for="product_name">Product Name</label>
                <input type="text" id="product_name" name="product_name" required>
            </div>
        </div>
        <div class="p_row">
            <div class="p_col">
                <label for="product_image">Product Image</label>
                <input type="file" id="product_image" name="product_image" required>

            </div>
            <div class="p_col">
                <label for="product_price">Product Price</label>
                <input type="number" id="product_price" name="product_price" required>
            </div>
        </div>
        <div class="p_row">  
            <div class="p_col">
                <label for="model-no">Model No</label>
                <input type="text" id="model-no" name="model-no" required>
            </div>   
        </div>
        <div class="p_row">
            <div class="p_col">
                <label for="product_description">Product Description</label>
                    <!-- <input type="text" id="product_description" name="product_description" required> -->
                <textarea name="product_description" id="product_description" cols="180" rows="4" required></textarea>
                <!-- <textarea type="text" name="message" id="message" cols="108" rows="5" required></textarea> -->
            </div>
        </div>
        <div class="p_row">
            <div class="p_col">
                <label for="product_brands">Brands</label>
                <input type="text" id="product_brands" name="product_brands" required>
            </div>
            <div class="p_col">
                <label for="product_shape">Shape</label>
                <input type="text" id="product_shape" name="product_shape" required>
            </div>
        </div>
        <div class="p_row">
            <div class="p_col">
                <label for="gender">Gender</label>
                <select name="gender" id="gender" required>
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="unisex">Unisex</option>
                </select>
            </div>
            <div class="p_col">
                <label for="product_color">Color</label>
                <input type="text" id="product_color" name="product_color" required>
            </div>
        </div>
        <div class="p_row">
            <div class="p_col">
                <label for="product_stock">Stock level</label>
                <input type="text" id="product_stock" name="product_stock" required>
            </div>
            <div class="p_col">
                <label for="category_name">Select Category</label>
                <select name="category_name" id="category_name" required>
                    <option value="">Select Category</option>
                    <?php
                    include("../database/dbconnection.php");

                    $sql = "SELECT DISTINCT category_name FROM categories";
                    $query_run = mysqli_query($conn, $sql);

                    if ($query_run) {
                        foreach ($query_run as $row) {
                            ?>
                            <option value="<?= $row['category_name']; ?>"><?= $row['category_name']; ?></option>
                            <?php
                        }
                    } else {
                        ?>
                        <option value="">No Record Found</option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>   
        <div class="p_row">  
            <div class="p_col">
                <label for="product-type">Product Type</label>
                    <select name="product-type" id="product-type" required>
                        <option value="product-type">Select Product Type</option>
                        <option value="normal">Normal</option>
                        <option value="newarrival">New Arrivel Product</option>
                        <option value="popular">Popular Products</option>
                        <option value="topsale">Top Sale Product</option>
                    </select>
            </div>   
        </div>
        <br>
        <br>
        <div class="p_row">
            <button type="submit" name="insert-product" class="product-button">Submit</button>
        </div>
    </form>
</div>

    <?php
include './includes/footer.php';
?>  
