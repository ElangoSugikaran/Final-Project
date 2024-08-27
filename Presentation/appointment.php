<?php
include ("../includes/session.php");
include '../includes/header.php';
include '../includes/navbar.php';
include("../database/dbconnection.php");

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['customer_id']); // Assuming customer_id is set in session on login

if (isset($_POST['appointment-btn'])) {
    if ($isLoggedIn) {
        $Name = $conn->real_escape_string($_POST['name']);
        $Email = $conn->real_escape_string($_POST['email']);
        $ContactNo = $conn->real_escape_string($_POST['contactno']);
        $Date = $conn->real_escape_string($_POST['date']);
        $Time = $conn->real_escape_string($_POST['time']);
        $Message = $conn->real_escape_string($_POST['message']);

        // Check if the selected date and time are available
        $availabilitySql = "SELECT * FROM appointment WHERE date = '$Date' AND time = '$Time'";
        $availabilityResult = $conn->query($availabilitySql);

        if ($availabilityResult->num_rows > 0) {
            // Time and date are not available, inform the user
            echo "<script>alert('The selected date and time are not available. Please choose a different date or time.');</script>";
            echo "<script>window.location = '../Presentation/appointment.php';</script>";
        } else {
            // Time and date are available, proceed with the insertion
            $Sql = "INSERT INTO appointment (name, email, mobile_no, date, time, message) VALUES 
            ('$Name', '$Email', '$ContactNo', '$Date', '$Time', '$Message')";

            if ($conn->query($Sql) === TRUE) {
                // Appointment booked successfully
                echo "<script>alert('Appointment booked successfully.');</script>";
                echo "<script>window.location = '../Presentation/appointment.php';</script>";
            } else {
                // Error during insertion
                echo "ERROR: " . $Sql . "<br>" . $conn->error;
            }
        }
    } else {
        // User is not logged in, show a message or redirect
        echo "<script>alert('You must be logged in to book an appointment.');</script>";
        echo "<script>window.location = '../Presentation/login.php';</script>";
    }
    
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Booking</title>
</head>
<body>

<header>
  <!-- Heading -->
  <div class="bg-primary" id="backgroundDiv">
    <div class="container py-4">
      <h3 class="text-white mt-2">Appointment</h3>
      <!-- Breadcrumb -->
      <nav class="d-flex mb-2">
        <h6 class="mb-0">
          <a href="../Presentation/home.php" class="text-white-50">Home</a>
          <span class="text-white-50 mx-2"> > </span>
          <a href="../Presentation/appointemnt.php" class="text-white"><u>Appointment</u></a>
        </h6>
      </nav>
      <!-- Breadcrumb -->
    </div>
  </div>
  <!-- Heading -->
</header>

<div class="container-fluid p-0">
    <div class="app-banner">
        <img src="../image/appointment.jpg" class="img-fluid" alt="Appointment">
    </div>
</div>

<!-- form for appointment -->
<div class="appointment-container">
    <h1>Fill the form to get an appointment</h1>
    <form action="../Presentation/appointment.php" method="POST">
        <br>
        <div class="A_row">
            <div class="A_col">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Name" required>
            </div>
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            <div class="A_col">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Email" required>
            </div>
        </div>
        <div class="A_row">
                <div class="A_col">
                    <label for="contactno">Contact Number</label>
                    <input type="number" id="contactno" name="contactno" placeholder="contact no" required>
                </div>
            </div>
        <div class="A_row">
            <div class="A_col">
                <label for="date">Date</label>
                <input type="date" id="date" name="date" required>
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <div class="A_col">
                <label for="time">Time</label>
                <input type="time" id="time" name="time" required>
            </div>
        </div>
        <div class="A_row">
            <div class="A_col">
                <label for="message">Message</label>
                <textarea name="message" id="message" cols="108" rows="5" placeholder="Message" required></textarea>
            </div>
        </div>
        <br><br>
        <div class="A_row">
            <button type="submit" class="appointment-button" name="appointment-btn">Submit</button>
        </div>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var isLoggedIn = <?php echo json_encode($isLoggedIn); ?>;

    // Disable the submit button if the user is not logged in
    var appointmentButton = document.querySelector(".appointment-button");
    if (!isLoggedIn) {
        appointmentButton.disabled = true;
        appointmentButton.title = "You must be logged in to book an appointment";
    }

    // Show a message when trying to click the button if not logged in
    appointmentButton.addEventListener("click", function(event) {
        if (!isLoggedIn) {
            event.preventDefault();
            alert("You must be logged in to book an appointment.");
        }
    });
});
</script>

<?php
include '../includes/footer.php';
?>

</body>
</html>
