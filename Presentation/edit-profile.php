<?php
include("../includes/session.php");
include("../database/dbconnection.php");

// Check if the user is logged in
$is_logged_in = isset($_SESSION['customer_id']);

if ($is_logged_in) {
    $customer_id = $_SESSION['customer_id'];

    // Fetch user details from the database
    $select_query = $conn->prepare("SELECT firstname, lastname, email, contact_no, password FROM customers WHERE customer_id = ?");
    $select_query->bind_param("i", $customer_id);
    $select_query->execute();
    $select_query->bind_result($firstname, $lastname, $email, $contact_no, $password);
    $select_query->fetch();
    $select_query->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["first_name"];
    $lastname = $_POST["last_name"];
    $email = $_POST["email"];
    $contact_no = $_POST["phone"];
    // Password field is read-only, so it won't be updated from this form

    // Update the user details in the database
    $update_query = $conn->prepare("UPDATE customers SET firstname = ?, lastname = ?, email = ?, contact_no = ? WHERE customer_id = ?");
    $update_query->bind_param("ssssi", $firstname, $lastname, $email, $contact_no, $customer_id);

    if ($update_query->execute()) {
        echo "<script>alert('Your profile has been successfully updated!');</script>";
        echo "<script>window.location = 'edit-profile.php';</script>";
    } else {
        echo "<script>alert('Something went wrong! Please try again.');</script>";
    }

    $update_query->close();
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
    <title>Client Dashboard</title>
    <style>
        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: auto;
            margin-top: 20px;
        }

        .form-container h1 {
            margin-bottom: 20px;
            color: #34495e;
        }

        .btn-primary {
            background-color: #3498db;
            border-color: #3498db;
        }

        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }

        .form-group .form-control[readonly] {
            background-color: #e9ecef;
            cursor: not-allowed;
        }
    </style>
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
      <li><a href="../Presentation/edit-profile.php"><i class="zmdi zmdi-account-circle"></i> Profile</a></li>
      <li><a href="../Presentation/home.php"><i class="zmdi zmdi-arrow-left"></i> Back to Home</a></li>
    </ul>
  </div>

  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <ul class="nav navbar-nav navbar-right">
        <li>
          <div class="header-icons">
            <?php if ($is_logged_in): ?>
              <span class="username"><?php echo htmlspecialchars($email); ?></span>
            <?php endif; ?>
            <i class="zmdi zmdi-account"></i>
          </div>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Content -->
  <div id="content">
    <div class="container-fluid">
      <div class="form-container">
        <h1>Update My Profile</h1>
        <form action="edit-profile.php" method="post">
          <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter your first name" value="<?php echo htmlspecialchars($firstname); ?>" required>
          </div>
          <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter your last name" value="<?php echo htmlspecialchars($lastname); ?>" required>
          </div>
          <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($email); ?>" required>
          </div>
          <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" value="<?php echo htmlspecialchars($contact_no); ?>">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="********" value="<?php echo htmlspecialchars($password); ?>" readonly>
          </div>
          <button type="submit" class="btn btn-primary btn-block">Update Profile</button>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>
