<?php
include("../database/dbconnection.php");

if (isset($_POST['insert-inventory'])) {
    $ProductName = $_POST['product_name'];
    $Price = $_POST['product_price'];
    $Stock_Quantity = $_POST['stock-quantity'];
    $Availability = $_POST['availability'];
    $CategoryName = $_POST['category_name']; // Assuming this is the ID of the selected category


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
                $sql = "INSERT INTO inventory (product_name, image, price, stock_quantity, availability, category_name) 
                VALUES ('$ProductName', '$imageFileName', '$Price','$Stock_Quantity', '$Availability', '$CategoryName')";

                if ($conn->query($sql) === TRUE) {
                    echo "<script>alert('New Record inserted successfully')</script>";
                    echo "<script>window.location = '../admin/view-inventory.php';</script>";
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
    <h1>Add Inventory</h1>
    <form action="../admin/add-inventory.php" method="POST" enctype="multipart/form-data">
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
                <label for="stock-quantity">Stock Quantity</label>
                <input type="text" id="stock-quantity" name="stock-quantity" required>
            </div>   
        </div>
        <div class="p_row">  
            <div class="p_col">
                <label for="availability">Availability</label>
                <input type="text" id="availability" name="availability" required>
            </div>   
        </div>
        <div class="p_row">    
            <div class="p_col">
            <label for="category-name">Category</label>
        <select id="category-name" name="category-name" required>
            <option value="" disabled selected>Select Category</option>

            <?php
            // Assuming $conn is your database connection
            $sql = "SELECT category_id, category_name FROM categories";
            $result = $conn->query($sql);

            if ($result !== false && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['category_id'] . '">' . $row['category_name'] . '</option>';
                }
            }
            ?>

        </select>
            </div>   
        </div>
        <br>
        <div class="p_row">
            <button type="submit" name="insert-inventory" class="product-button">Submit</button>
        </div>
    </form>
</div>

    <?php
include './includes/footer.php';
?>  
