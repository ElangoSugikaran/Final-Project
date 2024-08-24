<?php
// include("./includes/session.php");
include './includes/header.php';
include './includes/sidebar.php';
include("../database/dbconnection.php");

// Check if the user is logged in
if (!isset($_SESSION['admin_id'])) {
  // If the user is not logged in, redirect to the login page
  header("Location: ./admin/admin-login.php");
  exit();
}

// Retrieve the admin email
$admin_id = $_SESSION['admin_id'];
$sql_admin = "SELECT email FROM admin WHERE admin_id = $admin_id";
$query_run_admin = mysqli_query($conn, $sql_admin);

if ($query_run_admin) {
    $admin_result = mysqli_fetch_assoc($query_run_admin);
    $admin_email = $admin_result['email'];
} else {
    $admin_email = 'Not Available'; // Default value if there's an error
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<style>
   .dashboard-welcome {
            padding: 15px;
            background-color: #4B70F5;
            color: #fff;
            border-radius: 5px;
            margin-bottom: 20px;
        }
</style>

<body>
<br>
<div class="dashboard-welcome">
    <h1>Welcome to Admin Dashboard, <?php echo htmlspecialchars($admin_email); ?>!</h1>
    <p>Today is <?php echo date('l, F j, Y'); ?>.</p>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="card-counter primary">
                <i class="fa fa-users"></i>
                <span class="count-numbers">
                <?php
                // Fetch count from 'customers' table
                $sql = "SELECT COUNT(*) AS total_customers FROM customers";
                $query_run = mysqli_query($conn, $sql);

                if ($query_run) {
                    $result = mysqli_fetch_assoc($query_run);
                    echo $result['total_customers'];
                } else {
                    echo '0';
                }
                ?>
                </span>
                <span class="count-name">Customer</span>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-counter danger">
                <i class="fa fa-cart-arrow-down"></i>
                <span class="count-numbers">
                <?php
                // Fetch count from 'order_info' table
                $sql = "SELECT COUNT(*) AS total_orders FROM order_info";
                $query_run = mysqli_query($conn, $sql);

                if ($query_run) {
                    $result = mysqli_fetch_assoc($query_run);
                    echo $result['total_orders'];
                } else {
                    echo '0';
                }
                ?>
                </span>
                <span class="count-name">Order</span>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-counter success">
                <i class="fa fa-calendar-check-o"></i>
                <span class="count-numbers">
                <?php
                // Fetch count from 'appointments' table
                $sql = "SELECT COUNT(*) AS total_appointments FROM appointment";
                $query_run = mysqli_query($conn, $sql);

                if ($query_run) {
                    $result = mysqli_fetch_assoc($query_run);
                    echo $result['total_appointments'];
                } else {
                    echo '0';
                }
                ?>
                </span>
                <span class="count-name">Appointment</span>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-counter info">
                <i class="fa fa-comments"></i>
                <span class="count-numbers">
                <?php
                // Fetch count from 'messages' table
                $sql = "SELECT COUNT(*) AS total_messages FROM message";
                $query_run = mysqli_query($conn, $sql);

                if ($query_run) {
                    $result = mysqli_fetch_assoc($query_run);
                    echo $result['total_messages'];
                } else {
                    echo '0';
                }
                ?>
                </span>
                <span class="count-name">Message</span>
            </div>
        </div>
    </div>
</div>

<?php
include './includes/footer.php';
?>

</body>
</html>
