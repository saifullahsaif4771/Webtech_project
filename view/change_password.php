<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit;
}
?>

<h2>Change Password</h2>

<!-- Change Password Form -->
<form method="post" action="../controller/authController.php">
    <input type="hidden" name="action" value="change_password">

    <label for="current_password">Current Password:</label><br>
    <input type="password" name="current_password" id="current_password" required><br><br>

    <label for="new_password">New Password:</label><br>
    <input type="password" name="new_password" id="new_password" required><br><br>

    <label for="confirm_password">Confirm New Password:</label><br>
    <input type="password" name="confirm_password" id="confirm_password" required><br><br>

    <button type="submit">Change Password</button>
</form>

<br>
<a href="dashboard.php">Back to Dashboard</a>
