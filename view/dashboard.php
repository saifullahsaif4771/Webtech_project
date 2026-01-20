<?php

        session_start();

    if (!isset($_SESSION["email"])) {

    header("Location: views/login.php");

    exit;
    }
?>    

<h1>Welcome <?php echo $_SESSION['email']; ?> </h1>

<?php
    
    if ($_SESSION["role"] == "admin") {

    echo "<p>Admin Dashboard</p>";

    } else {

    echo "<p>Student Dashboard</p>";
    }


?>

<a href="change_password.php">
    <button type="button">Change Password</button>
</a>
<br>

<a href="../controller/logout.php">Logout</a>



