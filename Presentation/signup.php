<?php
// Include your database connection and session management code here
include("../includes/session.php");
include("../database/dbconnection.php");
include '../includes/header.php';
include '../includes/navbar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["Firstname"];
    $lastname = $_POST["Lastname"];
    $email = $_POST["Email"];
    $contact_no = $_POST["Contact_no"];
    $password = $_POST["Password"];
    $confirm_password = $_POST["Confirm_Password"];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        // Check if the email is already registered
        $select_query = $conn->prepare("SELECT * FROM customers WHERE email = ?");
        $select_query->bind_param("s", $email);
        $select_query->execute();
        $select_query->store_result();

        if ($select_query->num_rows > 0) {
            echo "<script>alert('The email address is already registered!');</script>";
        } else {
            // Insert the new user into the database
            $insert_query = $conn->prepare("INSERT INTO customers (firstname, lastname, email, contact_no, password) VALUES (?, ?, ?, ?, ?)");
            $insert_query->bind_param("sssss", $firstname, $lastname, $email, $contact_no, $password);

            if ($insert_query->execute()) {
                echo "<script>alert('Your registration was successful!');</script>";
                echo "<script>window.location = '../presentation/login.php';</script>";
            } else {
                echo "<script>alert('Something went wrong!');</script>";
            }
        }
    }
}
?>
<!-- Signup Form -->
<section class="home">
    <div class="signup">
        <div class="signup_container">
            <a href="../Presentation/home.php"><i class="fa fa-times form_close"></i></a>
            <div class="signup-form">
            <?php
                if(isset($_SESSION['errors']) && count($_SESSION['errors']) > 0){
                    foreach($_SESSION['errors'] as $error){
                        ?>
                        <div class="alert alert-warning"><?= htmlspecialchars($error); ?></div>
                        <?php
                    }
                    unset($_SESSION['errors']);
                }

                if(isset($_SESSION['message'])){
                    echo '<div class="alert alert-success">'.htmlspecialchars($_SESSION['message']).'</div>';
                    unset($_SESSION['message']);
                }
                ?>
                <form action="../Presentation/signup.php" method="POST">
                    <h2>Sign up</h2>
                    <div class="intput-box">
                        <input type="text" name="Firstname" placeholder="Firstname" required>
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="intput-box">
                        <input type="text" name="Lastname" placeholder="Lastname" required>
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="intput-box">
                        <input type="email" name="Email" placeholder="Enter your email" required>
                        <i class="fa fa-envelope"></i>
                    </div>
                    <div class="intput-box">
                        <input type="text" name="Contact_no" placeholder="Mobile number" required>
                        <i class="fa fa-mobile"></i>
                    </div>
                    <div class="intput-box">
                                <input type="password" name="Password" placeholder="Create password" id="password1"  required>
                                <i class="fa fa-lock"></i>
                                    <!-- Password Show and Hide-->
                                    <div class="password-showHide">
                                    <svg class="icon show-password" width="18" height="18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 3.375C5.25 3.375 2.0475 5.7075 0.75 9C2.0475 12.2925 5.25 14.625 9 14.625C12.75 14.625 15.9525 12.2925 17.25 9C15.9525 5.7075 12.75 3.375 9 3.375ZM9 12.75C6.93 12.75 5.25 11.07 5.25 9C5.25 6.93 6.93 5.25 9 5.25C11.07 5.25 12.75 6.93 12.75 9C12.75 11.07 11.07 12.75 9 12.75ZM9 6.75C7.755 6.75 6.75 7.755 6.75 9C6.75 10.245 7.755 11.25 9 11.25C10.245 11.25 11.25 10.245 11.25 9C11.25 7.755 10.245 6.75 9 6.75Z" fill="black"/>
                                    </svg>                            
                                    <svg class="icon hide-password" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12.1387 14.526L10.323 12.7091C9.62082 12.9602 8.86179 13.0067 8.13422 12.8432C7.40665 12.6797 6.74047 12.313 6.21317 11.7857C5.68588 11.2584 5.31916 10.5922 5.15568 9.86465C4.99221 9.13708 5.0387 8.37805 5.28975 7.67587L2.97225 5.35838C1.05525 7.06275 0 9 0 9C0 9 3.375 15.1875 9 15.1875C10.0805 15.1837 11.1487 14.9586 12.1387 14.526V14.526ZM5.86125 3.474C6.85131 3.04135 7.91954 2.81622 9 2.8125C14.625 2.8125 18 9 18 9C18 9 16.9436 10.9361 15.0289 12.6427L12.7091 10.323C12.9602 9.62082 13.0067 8.86179 12.8432 8.13422C12.6797 7.40665 12.313 6.74047 11.7857 6.21317C11.2584 5.68588 10.5922 5.31916 9.86465 5.15568C9.13708 4.99221 8.37805 5.0387 7.67587 5.28975L5.86125 3.47512V3.474Z"
                                            fill="black" />
                                        <path
                                            d="M6.21544 8.60156C6.15355 9.03391 6.19321 9.47473 6.33127 9.88909C6.46933 10.3035 6.70199 10.68 7.01083 10.9888C7.31966 11.2976 7.69617 11.5303 8.11053 11.6684C8.52489 11.8064 8.96571 11.8461 9.39806 11.7842L6.21431 8.60156H6.21544ZM11.7842 9.39806L8.60156 6.21431C9.03391 6.15243 9.47473 6.19209 9.88909 6.33015C10.3035 6.4682 10.68 6.70087 10.9888 7.0097C11.2976 7.31853 11.5303 7.69505 11.6684 8.10941C11.8064 8.52377 11.8461 8.96459 11.7842 9.39694V9.39806ZM15.3516 16.1481L1.85156 2.64806L2.64806 1.85156L16.1481 15.3516L15.3516 16.1481Z"
                                            fill="black" />
                                    </svg>
                                </div>
                            </div>

                            <div class="intput-box">
                                <input type="password" name="Confirm_Password" placeholder="Confirm password" id="password2" required>
                                <i class="fa fa-lock"></i>
                                <!-- Password Show and Hide-->
                                <div class="password-showHide">
                                <svg class="icon show-password" width="18" height="18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 3.375C5.25 3.375 2.0475 5.7075 0.75 9C2.0475 12.2925 5.25 14.625 9 14.625C12.75 14.625 15.9525 12.2925 17.25 9C15.9525 5.7075 12.75 3.375 9 3.375ZM9 12.75C6.93 12.75 5.25 11.07 5.25 9C5.25 6.93 6.93 5.25 9 5.25C11.07 5.25 12.75 6.93 12.75 9C12.75 11.07 11.07 12.75 9 12.75ZM9 6.75C7.755 6.75 6.75 7.755 6.75 9C6.75 10.245 7.755 11.25 9 11.25C10.245 11.25 11.25 10.245 11.25 9C11.25 7.755 10.245 6.75 9 6.75Z" fill="black"/>
                                </svg>                            
                                <svg class="icon hide-password" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12.1387 14.526L10.323 12.7091C9.62082 12.9602 8.86179 13.0067 8.13422 12.8432C7.40665 12.6797 6.74047 12.313 6.21317 11.7857C5.68588 11.2584 5.31916 10.5922 5.15568 9.86465C4.99221 9.13708 5.0387 8.37805 5.28975 7.67587L2.97225 5.35838C1.05525 7.06275 0 9 0 9C0 9 3.375 15.1875 9 15.1875C10.0805 15.1837 11.1487 14.9586 12.1387 14.526V14.526ZM5.86125 3.474C6.85131 3.04135 7.91954 2.81622 9 2.8125C14.625 2.8125 18 9 18 9C18 9 16.9436 10.9361 15.0289 12.6427L12.7091 10.323C12.9602 9.62082 13.0067 8.86179 12.8432 8.13422C12.6797 7.40665 12.313 6.74047 11.7857 6.21317C11.2584 5.68588 10.5922 5.31916 9.86465 5.15568C9.13708 4.99221 8.37805 5.0387 7.67587 5.28975L5.86125 3.47512V3.474Z"
                                        fill="black" />
                                    <path
                                        d="M6.21544 8.60156C6.15355 9.03391 6.19321 9.47473 6.33127 9.88909C6.46933 10.3035 6.70199 10.68 7.01083 10.9888C7.31966 11.2976 7.69617 11.5303 8.11053 11.6684C8.52489 11.8064 8.96571 11.8461 9.39806 11.7842L6.21431 8.60156H6.21544ZM11.7842 9.39806L8.60156 6.21431C9.03391 6.15243 9.47473 6.19209 9.88909 6.33015C10.3035 6.4682 10.68 6.70087 10.9888 7.0097C11.2976 7.31853 11.5303 7.69505 11.6684 8.10941C11.8064 8.52377 11.8461 8.96459 11.7842 9.39694V9.39806ZM15.3516 16.1481L1.85156 2.64806L2.64806 1.85156L16.1481 15.3516L15.3516 16.1481Z"
                                        fill="black" />
                                </svg>
                                </div>
                            </div>
                    <button type="submit" name="signup_btn" class="button">Sign up</button>
                    <div class="login_signup">
                        Already have an account? <a href="../Presentation/login.php">Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


<script>
    // eye script for login and signup
    
        const passwordInputs = document.querySelectorAll('input[type="password"]');
        const showPasswordIcons = document.querySelectorAll('.show-password');
        const hidePasswordIcons = document.querySelectorAll('.hide-password');
        const passwordShowHideElements = document.querySelectorAll('.password-showHide');

        passwordShowHideElements.forEach((passwordShowHide, index) => {
            showPasswordIcons[index].addEventListener('click', () => {
                passwordInputs[index].setAttribute('type', 'text');
                showPasswordIcons[index].style.opacity = 0;
                hidePasswordIcons[index].style.opacity = 1;
                passwordShowHide.classList.add('hide');
            });

            hidePasswordIcons[index].addEventListener('click', () => {
                passwordInputs[index].setAttribute('type', 'password');
                showPasswordIcons[index].style.opacity = 1;
                hidePasswordIcons[index].style.opacity = 0;
                passwordShowHide.classList.remove('hide');
            });
        });
</script>

<?php
 include '../includes/footer.php';
?>

    
