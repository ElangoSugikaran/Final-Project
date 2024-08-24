<?php
include("../database/dbconnection.php");

// Deleting a message
if (isset($_GET['DELETE'])) {
    $Message_id = intval($_GET['DELETE']);

    $sql = "DELETE FROM message WHERE message_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $Message_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Message deleted successfully');</script>";
        echo "<script>window.location = '../admin/view-message.php';</script>";
    } else {
        die("Error: " . mysqli_error($conn));
    }
}

include './includes/header.php';
include './includes/sidebar.php';
?>
<!-- Admin dashboard -->

<!-- CSS to make the delete button visible and add scrolling -->
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

<!-- <<<<<<<<<<<<<- View Messages ->>>>>>>>>>>>>>  -->

<br>
<div class="View-container">
    <h1>Message Management</h1>
    <br>
    <div class="search-bar">
        <form action="../admin/view-message.php" method="post"> 
            <input type="text" name="search" placeholder="Search by ID, Name, or Email...">
            <button type="submit" name="search_btn" class="search-button">Search</button>
        </form>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Message ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact No</th>
                    <th>Message</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Handling search functionality
            if (isset($_POST['search_btn'])) {
                $search = mysqli_real_escape_string($conn, $_POST['search']);
                $sql = "SELECT * FROM message WHERE CONCAT(message_id, name, email, mobile_no) LIKE '%$search%'";
            } else {
                $sql = "SELECT * FROM message";
            }

            $query_run = mysqli_query($conn, $sql);

            // Displaying messages
            if (mysqli_num_rows($query_run) > 0) {
                while ($row = mysqli_fetch_array($query_run)) {
                    $message_id = $row['message_id'];
                    $Name = $row['name'];
                    $Email = $row['email'];
                    $Contact_No = $row['mobile_no'];
                    $Message = $row['message'];
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($message_id); ?></td>
                    <td><?php echo htmlspecialchars($Name); ?></td>
                    <td><?php echo htmlspecialchars($Email); ?></td>
                    <td><?php echo htmlspecialchars($Contact_No); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($Message)); ?></td>
                    <td>
                    <button class="btn btn-danger"> <a href="../admin/view-message.php?DELETE=<?php echo $message_id; ?>" onclick="return confirm('Are you sure you want to delete this message?');" style="color: white; text-decoration: none;">Delete</a></button>
                    </td>
                </tr>
            <?php 
                } 
            } else {
            ?>
                <tr>
                    <td colspan="6">No messages found.</td>
                </tr>
            <?php 
            } 
            ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include './includes/footer.php';
?>

                
