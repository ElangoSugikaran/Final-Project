<?php
// Include database connection
include("../database/dbconnection.php");

// Function to ensure the upload directory exists
function ensureUploadDirectory($dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Define the upload directory
$uploadDir = "../admin/image/";
ensureUploadDirectory($uploadDir);

// Handle image upload
if (isset($_POST['upload-image'])) {
    $imageFile = $_FILES['slider_image'];
    $imageName = $imageFile['name'];
    $imageTmpName = $imageFile['tmp_name'];
    $imageError = $imageFile['error'];
    
    if ($imageError === 0) {
        $imagePath = $uploadDir . time() . '_' . $imageName;
        
        if (move_uploaded_file($imageTmpName, $imagePath)) {
            // Save the image path to the database
            $sql = "INSERT INTO slider_images (image_path) VALUES ('$imagePath')";

            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('Image uploaded successfully!');</script>";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "Failed to upload image.";
        }
    } else {
        echo "Error: " . $imageError;
    }
}

// Handle image deletion
if (isset($_GET['delete_image'])) {
    $imageId = intval($_GET['delete_image']);
    
    // Retrieve the image path
    $sql = "SELECT image_path FROM slider_images WHERE id = $imageId";
    $result = mysqli_query($conn, $sql);
    $imageData = mysqli_fetch_assoc($result);
    $imagePath = $imageData['image_path'];
    
    // Delete the image file
    if (unlink($imagePath)) {
        // Delete the record from the database
        $sql = "DELETE FROM slider_images WHERE id = $imageId";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Image deleted successfully!');</script>";
            echo "<script>window.location = 'admin-image-slider.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Failed to delete image file.";
    }
}

// Close the database connection
mysqli_close($conn);
?>

<?php
include './includes/header.php';
include './includes/sidebar.php';
?>

<style>
    .View-container {
        width: 100%;
        margin: 0 auto;
    }

    .table-container {
        max-height: 400px;
        overflow-y: auto;
        ovrflow-x:auto;
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

<br>
<br>

<div class="View-container">
<h1>Promotion Management</h1>
<br>
<br>
    <!-- Image Upload Form -->
    <form action="admin-image-slider.php" method="POST" enctype="multipart/form-data">
        <label for="slider_image">Select Image to Upload:</label>
        <input type="file" name="slider_image" id="slider_image" required>
        <br><br>
        <button type="submit" name="upload-image" class="btn btn-primary">Upload Image</button>
    </form>

    <br><br>

    <!-- Display Uploaded Images -->
    <h2>Uploaded Images</h2>
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Fetch images from the database
        include("../database/dbconnection.php");
        $sql = "SELECT * FROM slider_images";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            $imageId = $row['id'];
            $imagePath = $row['image_path'];
        ?>
            <tr>
                <td><img src="<?php echo $imagePath; ?>" alt="Slider Image" width="150"></td>
                <td>
                <button class="btn btn-danger">
                    <a href="admin-image-slider.php?delete_image=<?php echo $imageId; ?>" 
                    onclick="return confirm('Are you sure you want to delete this image?');" 
                    style="color: white; text-decoration: none;">
                    Delete
                    </a>
                </button>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<?php
include './includes/footer.php';
?>
