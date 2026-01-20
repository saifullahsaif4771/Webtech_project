<?php

        session_start();

if (!isset($_SESSION["email"])) {
    header("Location: views/login.php");
    exit;
}
?>    

<h1>Welcome <?php echo $_SESSION['email']; ?></h1>

<?php
if ($_SESSION["role"] === "admin") {

    echo "<p>Admin Dashboard</p>";
    echo '<a href="user_management.php"><button>User Management</button></a>';

} elseif ($_SESSION["role"] === "student") {

    echo "<p>Student Dashboard</p>";
    echo '<a href="view_result.php"><button>View Result</button></a>';

} else {
    echo "<p>No dashboard available</p>";
}
?>

<br><br>

<a href="change_password.php">
    <button type="button">Change Password</button>
</a>
<br>

<a href="../controller/logout.php">Logout</a>



