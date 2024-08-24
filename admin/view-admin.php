<?php
include './includes/header.php';
include './includes/sidebar.php';
include("../database/dbconnection.php");

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // If the admin is not logged in, redirect to the login page
    header("Location: ./admin/admin-login.php");
    exit();
}

// Retrieve admin details
$admin_id = $_SESSION['admin_id'];
$select_query = $conn->prepare("SELECT firstname, lastname, email, contact_no, password FROM admin WHERE admin_id = ?");
$select_query->bind_param("i", $admin_id);
$select_query->execute();
$select_query->bind_result($firstname, $lastname, $email, $contact_no, $password);
$select_query->fetch();
$select_query->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .password-container {
             position: relative;
        }

        .input-group .password-showHide {
            cursor: pointer;
            background: transparent;
            border: none;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 2;
        }

        .password-showHide .hide-password {
            display: none;
        }

        .password-showHide.hide .hide-password {
            display: inline;
        }

        .password-showHide.hide .show-password {
            display: none;
        }

    </style>
</head>
<body>
    <br>
    <div class="container-fluid">
    <h1 class="text-left mb-4">Admin Profile</h1>
    <div class="form-container mt-5 p-4 shadow-lg bg-white rounded">
        <form>
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($firstname); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($lastname); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($contact_no); ?>" readonly>
            </div>
            <div class="form-group password-container">
                <label for="password">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" value="<?php echo htmlspecialchars($password); ?>" readonly>
                    <span class="input-group-text password-showHide">
                        <i class="fas fa-eye show-password"></i>
                        <i class="fas fa-eye-slash hide-password"></i>
                    </span>
                </div>
            </div>
        </form>
    </div>
       <div class="text-end mt-3 p-4">
            <button class="btn btn-info">
                <a href="../admin/dashboard.php" style="color: white; text-decoration: none;">Dashboard</a>
            </button>
        </div>
</div>

</body>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<script>
    // Eye script for password visibility toggle
const passwordInput = document.getElementById('password');
const showPasswordIcon = document.querySelector('.show-password');
const hidePasswordIcon = document.querySelector('.hide-password');
const passwordShowHide = document.querySelector('.password-showHide');

showPasswordIcon.addEventListener('click', () => {
    passwordInput.setAttribute('type', 'text');
    passwordShowHide.classList.add('hide');
});

hidePasswordIcon.addEventListener('click', () => {
    passwordInput.setAttribute('type', 'password');
    passwordShowHide.classList.remove('hide');
});

</script>
</html>
