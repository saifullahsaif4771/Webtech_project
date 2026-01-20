<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'student') {
    echo "Access denied!";
    exit;
}
?>

<h2>Apply for a Course</h2>
<form method="post" action="../controller/authController.php">
    <input type="hidden" name="action" value="apply_course">

    <label>Select Course:</label>
    <select name="course">
        <option value="">--Select--</option>
        <option value="Math">Math</option>
        <option value="English">English</option>
        <option value="Bangla">Bangla</option>
    </select><br><br>

    <button type="submit">Apply</button>
</form>
<br>
<a href="dashboard.php"><button>Back to Dashboard</button></a>
