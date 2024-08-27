<?php
include("../includes/session.php");
include("../database/dbconnection.php");

// Check if the user is logged in
$is_logged_in = isset($_SESSION['customer_id']);

// Fetch user details if logged in
if ($is_logged_in) {
    $customer_id = $_SESSION['customer_id'];
    $customer_email = $_SESSION['email'];
}

// Assuming you have a function to get the order statistics
function getOrderStatistics($email, $conn) {
    // Adjust the column name and table structure as per your actual schema
    $sql = "SELECT MONTH(created_at) AS month, COUNT(order_id) AS order_count
            FROM order_info
            WHERE email = ?
            GROUP BY MONTH(created_at)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email); // Use 's' for string email
    $stmt->execute();
    $result = $stmt->get_result();
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    return $data;
}

// Fetch order statistics if logged in
$order_data = [];
if ($is_logged_in) {
    $order_data = getOrderStatistics($customer_email, $conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/client-dashboard-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css">
    <style>
        /* Add custom styles here */
        .header-icons {
            display: flex;
            align-items: center;
        }

        .username {
            margin-right: 15px;
            font-weight: bold;
        }

        .nav>li>a {
            padding: 15px 20px;
            color: #fff;
        }

        #sidebar {
            background-color: #2c3e50;
        }

        #content {
            background-color: #ecf0f1;
            padding: 20px;
        }

        .dashboard-welcome {
            padding: 15px;
            background-color: #1abc9c;
            color: #fff;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #3498db;
            color: #fff;
            padding: 15px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .card-body {
            padding: 20px;
        }
    </style>
    <title>Client Dashboard</title>
</head>
<body>
<div id="viewport">
  <!-- Sidebar -->
  <div id="sidebar">
    <header>
      <a href="#">My Dashboard</a>
    </header>
    <ul class="nav">
      <li><a href="../Presentation/client-dashboard.php"><i class="zmdi zmdi-view-dashboard"></i> Dashboard</a></li>
      <li><a href="../Presentation/order-status.php"><i class="zmdi zmdi-time-restore"></i> Order Status</a></li>
      <li><a href="../Presentation/purchase-history.php"><i class="zmdi zmdi-receipt"></i> Purchase History</a></li>
      <li><a href="../Presentation/edit-profile.php"><i class="zmdi zmdi-account-circle"></i>Profile</a></li>
      <li><a href="../Presentation/home.php"><i class="zmdi zmdi-arrow-left"></i> Back to Home</a></li>
    </ul>
  </div>
  <!-- Content -->
    
  <nav class="navbar navbar-default">
  <div class="container-fluid">
    <ul class="nav navbar-nav navbar-right">
      <li>
        <div class="header-icons">
          <?php if ($is_logged_in): ?>
            <span class="username"><?php echo htmlspecialchars($customer_email); ?></span>
          <?php endif; ?>
          <i class="zmdi zmdi-account"></i>
        </div>
      </li>
    </ul>
  </div>
</nav>

    <div class="container-fluid">
      <div class="dashboard-welcome">
        <h1>Welcome to Your Dashboard, <?php echo htmlspecialchars($customer_email); ?>!</h1>
        <p>Today is <?php echo date('l, F j, Y'); ?>.</p>
      </div>
      
      <!-- dashboard card -->
      <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                <i class="fa fa-shopping-cart fa-3x"></i>
                    <h5 class="card-title">Recent Orders</h5>
                    <p class="card-text">View and track your recent orders.</p>
                    <a href="../Presentation/order-status.php" class="btn btn-primary">View Orders</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                <i class="fa fa-history fa-3x"></i>
                    <h5 class="card-title">Purchase History</h5>
                    <p class="card-text">Review your past purchases and download invoices.</p>
                    <a href="../Presentation/purchase-history.php" class="btn btn-primary">View History</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                <i class="fa fa-user fa-3x"></i>
                    <h5 class="card-title">Profile Settings</h5>
                    <p class="card-text">Update your profile information and preferences.</p>
                    <a href="../Presentation/edit-profile.php" class="btn btn-primary">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>

      <!-- chart widget -->
      <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">Order Statistics</div>
            <div class="card-body">
              <canvas id="orderChart"></canvas>
            </div>
          </div>
        </div>
      </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script>
    // Convert PHP array to JavaScript
    var orderData = <?php echo json_encode($order_data); ?>;
    
    // Process the data to fit Chart.js format
    var labels = [];
    var data = [];
    for (var i = 1; i <= 12; i++) {
        // Initialize labels for all 12 months
        labels.push('Month ' + i);
        // Initialize data for each month
        data.push(0);
    }

    orderData.forEach(function(item) {
        var monthIndex = item.month - 1; // Months are 1-based in SQL, 0-based in JavaScript
        data[monthIndex] = item.order_count;
    });
    
    // Create the chart
    var ctx = document.getElementById('orderChart').getContext('2d');
    var orderChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Orders',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Month'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Orders'
                    }
                }
            }
        }
    });
</script>
</body>
</html>
