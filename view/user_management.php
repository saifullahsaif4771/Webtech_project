<?php
session_start();

if (!isset($_SESSION["email"]) || $_SESSION["role"] !== "admin") {
    echo "Access denied!";
    exit;
}

include "../config/database.php";
?>

<h2>User Management</h2>

<!-- ---------- ADD USER ---------- -->
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

<hr>

<!-- ---------- EXISTING USERS & ASSIGN SUBJECTS ---------- -->
<h3>Existing Users - Assign Subjects & Marks</h3>
<form method="post" action="../controller/authController.php">
<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Subject</th>
        <th>Marks</th>
        <th>Action</th>
    </tr>

    <?php
    $result = mysqli_query($conn, "SELECT * FROM users");
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $current_subject = $row['subject'] ?? '';
        $current_marks = $row['marks'] ?? '';
        echo "<tr>
                <td>{$id}</td>
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['role']}</td>
                <td>
                    <select name='subject[{$id}]'>
                        <option value=''>--Select--</option>
                        <option value='Math' " . ($current_subject=='Math'?'selected':'') . ">Math</option>
                        <option value='English' " . ($current_subject=='English'?'selected':'') . ">English</option>
                        <option value='Bangla' " . ($current_subject=='Bangla'?'selected':'') . ">Bangla</option>
                    </select>
                </td>
                <td>
                    <input type='number' name='marks[{$id}]' value='{$current_marks}' min='1' max='100'>
                </td>
                <td>
                    <form style='display:inline;' method='post' action='../controller/authController.php'>
                        <input type='hidden' name='action' value='delete_user'>
                        <input type='hidden' name='id' value='{$id}'>
                        <button type='submit'>Delete</button>
                    </form>
                </td>
              </tr>";
    }
    ?>
</table>
<br>
<button type="submit" name="action" value="update_subjects_marks">Update Subjects & Marks</button>
</form>

<br><br>

<a href="dashboard.php">
    <button type="button">Back to Dashboard</button>
</a>