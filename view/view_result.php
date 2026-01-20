<?php
session_start();

if (!isset($_SESSION["email"]) || $_SESSION["role"] !== "student") {
    echo "Access denied!";
    exit;
}

include "../config/database.php";

$email = $_SESSION["email"];

$query = "SELECT subject, marks FROM users WHERE email='$email'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<h2>My Result</h2>

<table border="1">
    <tr>
        <th>Subject</th>
        <th>Marks</th>
    </tr>
    <tr>
        <td><?php echo $user['subject'] ?? 'Not Assigned'; ?></td>
        <td><?php echo $user['marks'] ?? 'N/A'; ?></td>
    </tr>
</table>

<br>
<a href="dashboard.php">
    <button>Back to Dashboard</button>
</a>
