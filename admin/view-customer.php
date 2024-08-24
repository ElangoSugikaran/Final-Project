<?php
include("../database/dbconnection.php");

// Deleting a customer
if (isset($_GET['DELETE'])) {
    $Customer_id = intval($_GET['DELETE']);

    $sql = "DELETE FROM customers WHERE customer_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $Customer_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Customer deleted successfully');</script>";
        echo "<script>window.location = '../admin/view-customer.php';</script>";
    } else {
        die("Error: " . mysqli_error($conn));
    }
}

include './includes/header.php';
include './includes/sidebar.php';
?>

<!-- Admin dashboard -->

<style>
    .View-container {
        width: 100%;
        margin: 0 auto;
    }

    .table-container {
        max-height: 400px;
        overflow-y: auto;
        overflow-x: auto;
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

<!-- <<<<<<<<<<<<<- View Customers ->>>>>>>>>>>>>> -->

<br>
<div class="View-container">
    <h1>Customer Management</h1>
    <br>
    <div class="search-bar">
        <form action="../admin/view-customer.php" method="post"> 
            <input type="text" name="search" placeholder="Search by ID, Name, or Email...">
            <button type="submit" name="search_btn" class="search-button">Search</button>
        </form>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Contact No</th>
                    <th>Password</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Handling search functionality
            if (isset($_POST['search_btn'])) {
                $search = mysqli_real_escape_string($conn, $_POST['search']);
                $sql = "SELECT * FROM customers WHERE CONCAT(customer_id, firstname, lastname, email, contact_no) LIKE '%$search%'";
            } else {
                $sql = "SELECT * FROM customers";
            }

            $query_run = mysqli_query($conn, $sql);

            // Displaying customers
            if (mysqli_num_rows($query_run) > 0) {
                $CUSTOMER_id = 1;
                while ($row = mysqli_fetch_array($query_run)) {
                    $Customer_id = $row['customer_id'];
                    $FirstName = $row['firstname'];
                    $LastName = $row['lastname'];
                    $Email = $row['email'];
                    $ContactNo = $row['contact_no'];
                    $Password = $row['password'];
            ?>
                <tr>
                    <td><?php echo $CUSTOMER_id; ?></td>
                    <td><?php echo htmlspecialchars($FirstName); ?></td>
                    <td><?php echo htmlspecialchars($LastName); ?></td>
                    <td><?php echo htmlspecialchars($Email); ?></td>
                    <td><?php echo htmlspecialchars($ContactNo); ?></td>
                    <td><?php echo str_repeat('*', strlen($Password)); ?></td>
                    <td>
                        <button class="btn btn-danger"> 
                            <a href="../admin/view-customer.php?DELETE=<?php echo $Customer_id; ?>" 
                               onclick="return confirm('Are you sure you want to delete this customer information?');" 
                               style="color: white; text-decoration: none;">
                               Delete
                            </a>
                        </button>
                    </td>
                </tr>
            <?php 
                    $CUSTOMER_id++;
                } 
            } else {
            ?>
                <tr>
                    <td colspan="7">No customers found.</td>
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
