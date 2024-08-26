<?php
include("../database/dbconnection.php");

if (isset($_GET['DELETE'])) {
    $Appointment_id = $_GET['DELETE'];

    $sql2 = "DELETE FROM appointment WHERE appointment_id = $Appointment_id";
    $query_run = mysqli_query($conn, $sql2);

    if ($query_run) {
        echo "<script> alert('Deleted successfully')</script>";
        echo "<script> window.location = '../admin/view-appointment.php';</script>";
    } else {
        die(mysqli_error($conn));
    }
}
?>

<?php
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
        overflow-x:auto;
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
<!-- <<<<<<<<<<<<<- View appointment ->>>>>>>>>>>>>>  -->

<br>
<div class="View-container">
    <h1>Appointment Management</h1>
    <br>
    <div class="search-bar">
        <form action="../admin/view-appointment.php" method="post"> 
            <input type="text" name="search" placeholder="Search...">
            <button type="submit" name="search_btn" class="search-button">Search</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Appointment ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact No</th>
                <th>Date</th>
                <th>Time</th>
                <th>Message</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>    

        <?php
        include("../database/dbconnection.php");

        if (isset($_POST['search_btn'])) {
            $search = $_POST['search'];
            $sql = "SELECT * FROM appointment WHERE CONCAT(appointment_id, name, email, mobile_no, date, time, message) LIKE '%$search%'";
        } else {
            $sql = "SELECT * FROM appointment";
        }

        $query_run = mysqli_query($conn, $sql);

        if (mysqli_num_rows($query_run) > 0) {
            while ($row = mysqli_fetch_array($query_run)) {
                $appointment_id = $row['appointment_id'];
                $Name = $row['name'];
                $Email = $row['email'];
                $Contact_No = $row['mobile_no'];
                $Date = $row['date'];
                $Time = $row['time'];
                $Message = $row['message'];
        ?>

            <tr>
                <td><?php echo $appointment_id; ?></td>
                <td><?php echo $Name; ?></td>
                <td><?php echo $Email; ?></td>
                <td><?php echo $Contact_No; ?></td>
                <td><?php echo $Date; ?></td>
                <td><?php echo $Time; ?></td>
                <td><?php echo $Message; ?></td>
                <td>
                    <button class="btn btn-success">
                        <a href="mailto:<?php echo $Email; ?>?subject=Your%20appointment%20is%20confirmed&body=Thank%20you%20for%20scheduling%20an%20appointment.%20Your%20appointment%20is%20confirmed." style="color: white; text-decoration: none;">Send Email</a>
                    </button>
                    <br>
                    <span class="button-space"></span>
                    <br>
                    <button class="btn btn-danger">
                        <a href="../admin/view-appointment.php?DELETE=<?php echo $appointment_id; ?>" style="color: white; text-decoration: none;">Delete</a>
                    </button>
                </td>
            </tr>

        <?php 
            }
        } else {
        ?>
            <tr>
                <td colspan="8">No appointment found.</td>
            </tr>
        <?php 
        } 
        ?>                  
        </tbody>
    </table>
</div>

<script>
function sendConfirmationEmail(appointmentId) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    console.log('Email sent successfully');
                } else {
                    console.error('Error sending email:', response.error);
                }
            } else {
                console.error('Error sending email:', xhr.statusText);
            }
        }
    };

    xhr.open('GET', '../admin/send-email.php?appointment_id=' + appointmentId, true);
    xhr.send();
}
</script>

<?php
include './includes/footer.php';
?>
