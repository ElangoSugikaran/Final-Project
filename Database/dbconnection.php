
    <?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "crystal_vision_optical_db";
    
    // creating database connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // check database connection
    if($conn -> connect_error)
    {
        die("connection failed: ".$conn->connect_error);
    }
    else
    {
        // echo "connected successfully";
    }
    
    ?>

