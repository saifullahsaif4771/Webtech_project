<?php
session_start();

if (!isset($_SESSION["email"]) || $_SESSION["role"] !== "admin") {
    echo "Access denied!";
    exit;
}

// Include database connection
include "../config/database.php";
?>

<h2>User Management</h2>

<h3>Add User</h3>
<form method="post" action="../controller/authController.php">
    <input type="hidden" name="action" value="add_user">

    Name: <input type="text" name="name"><br><br>
    Email: <input type="email" name="email"><br><br>
    Password: <input type="password" name="password"><br><br>
    Role: 
    <select name="role">
        <option value="student">Student</option>
        <option value="admin">Admin</option>
    </select><br><br>

    <button type="submit">Add User</button>
</form>

<h3>Existing Users</h3>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Action</th>
    </tr>

    <?php
    $result = mysqli_query($conn, "SELECT * FROM users");
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['role']}</td>
                <td>
                    <form style='display:inline;' method='post' action='../controller/authController.php'>
                        <input type='hidden' name='action' value='delete_user'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <button type='submit'>Delete</button>
                    </form>
                </td>
              </tr>";
    }
    ?>
</table>
