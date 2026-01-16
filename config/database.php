<?php

    $host = "localhost";
    $user = "root";
    $pass = "";       // XAMPP default
    $db   = "Webtech_project";

    $conn = mysqli_connect($host, $user, $pass, $db);

    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
}

?>
