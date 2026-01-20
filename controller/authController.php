<?php
session_start(); // start session

// Include database connection
include "../config/database.php";

// Only handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


// ---------- APPLY FOR COURSE ----------
if (isset($_POST['action']) && $_POST['action'] === 'apply_course') {

    // Only students can apply
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
        echo "<script>alert('Access denied!'); window.history.back();</script>";
        exit;
    }

    $student_email = $_SESSION['email'];
    $course = $_POST['course'] ?? '';

    // Validate course
    if (!in_array($course, ['Math', 'English', 'Bangla'])) {
        echo "<script>alert('Invalid course selected!'); window.history.back();</script>";
        exit;
    }

    // Update the user's selected course in DB
    $stmt = mysqli_prepare($conn, "UPDATE users SET applied_course = ? WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "ss", $course, $student_email);
    mysqli_stmt_execute($stmt);

    echo "<script>alert('Course applied successfully!'); window.location.href='../view/dashboard.php';</script>";
    exit;
}






    // ---------- UPDATE SUBJECTS & MARKS ----------
if (isset($_POST['action']) && $_POST['action'] === 'update_subjects_marks') {

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        echo "Access denied!";
        exit;
    }

    $subjects = $_POST['subject'] ?? [];
    $marks = $_POST['marks'] ?? [];

    foreach ($subjects as $id => $subject) {
        $mark = $marks[$id] ?? NULL;

        // Validate subject
        if (!in_array($subject, ['Math', 'English', 'Bangla', ''])) {
            continue;
        }

        // Validate marks
        if ($mark !== NULL) {
            $mark = (int)$mark;
            if ($mark < 1 || $mark > 100) {
                $mark = NULL;
            }
        }

        $stmt = mysqli_prepare($conn, "UPDATE users SET subject = ?, marks = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "sii", $subject, $mark, $id);
        mysqli_stmt_execute($stmt);
    }

    echo "<script>alert('Subjects & Marks updated successfully!'); window.location.href='../view/user_management.php';</script>";
    exit;
}





    // ---------- UPDATE SUBJECTS ----------
if (isset($_POST['action']) && $_POST['action'] === 'update_subjects') {

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        echo "Access denied!";
        exit;
    }

    $subjects = $_POST['subject'] ?? [];

    foreach ($subjects as $id => $subject) {
        // Validate subject
        if (!in_array($subject, ['Math', 'English', 'Bangla', ''])) {
            continue;
        }

        $stmt = mysqli_prepare($conn, "UPDATE users SET subject = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "si", $subject, $id);
        mysqli_stmt_execute($stmt);
    }

    echo "<script>alert('Subjects updated successfully!'); window.location.href='../view/user_management.php';</script>";
    exit;
}



    // ---------- ADD USER ----------
if (isset($_POST['action']) && $_POST['action'] === 'add_user') {

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        echo "Access denied!";
        exit;
    }

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    if ($name === "" || $email === "" || $password === "") {
        echo "<script>alert('All fields required'); window.history.back();</script>";
        exit;
    }

    // Check if email exists
    $stmt_check = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ?");
    mysqli_stmt_bind_param($stmt_check, "s", $email);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);

    if (mysqli_num_rows($result_check) > 0) {
        echo "<script>alert('Email already exists'); window.history.back();</script>";
        exit;
    }

    // Insert user
    $stmt_insert = mysqli_prepare($conn, "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt_insert, "ssss", $name, $email, $password, $role);
    mysqli_stmt_execute($stmt_insert);

    echo "<script>alert('User added successfully!'); window.location.href='../view/user_management.php';</script>";
    exit;
}

// ---------- DELETE USER ----------
if (isset($_POST['action']) && $_POST['action'] === 'delete_user') {

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        echo "Access denied!";
        exit;
    }

    $id = $_POST['id'];

    // Prevent admin from deleting themselves
    if ($id == $_SESSION['id']) {
        echo "<script>alert('You cannot delete yourself'); window.history.back();</script>";
        exit;
    }

    $stmt_delete = mysqli_prepare($conn, "DELETE FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmt_delete, "i", $id);
    mysqli_stmt_execute($stmt_delete);

    echo "<script>alert('User deleted successfully'); window.location.href='../view/user_management.php';</script>";
    exit;
}


    // ---------- LOGIN ----------
    if (isset($_POST['action']) && $_POST['action'] === 'login') {

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // SQL query to find user by email AND password (plain text)
        $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $email, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {

            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];

            header("Location: ../view/dashboard.php");
            exit();

        } else {
            echo "Invalid credentials";
        }

        mysqli_stmt_close($stmt);
    }

    // ---------- REGISTER ----------
 
if (isset($_POST['action']) && $_POST['action'] === 'register') {

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['Role'] ?? 'student'; // keep your select value

    if (!empty($name) && !empty($email) && !empty($password)) {

        // Check if email already exists
        $sql_check = "SELECT * FROM users WHERE email = ?";
        $stmt_check = mysqli_prepare($conn, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "s", $email);
        mysqli_stmt_execute($stmt_check);
        $result_check = mysqli_stmt_get_result($stmt_check);

        if (mysqli_num_rows($result_check) > 0) {
            echo "<script>alert('Email already registered!');</script>";
        } else {
            // Insert user into DB
            $sql_insert = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
            $stmt_insert = mysqli_prepare($conn, $sql_insert);
            mysqli_stmt_bind_param($stmt_insert, "ssss", $name, $email, $password, $role);

            if (mysqli_stmt_execute($stmt_insert)) {
                echo "<script>alert('Registration successful! Now you can log in.'); window.location.href='../view/login.php';</script>";

            } else {
                echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
            }

            mysqli_stmt_close($stmt_insert);
        }

        mysqli_stmt_close($stmt_check);
    } else {
        echo "<script>alert('All fields are required!');</script>";
    }
}

        // ---------- CHANGE PASSWORD ----------
if (isset($_POST["action"]) && $_POST["action"] === "change_password") {

    if (!isset($_SESSION["email"])) {
        echo "Unauthorized access";
        exit;
    }

    $email = $_SESSION["email"];
    $current = trim($_POST["current_password"]);
    $new = trim($_POST["new_password"]);
    $confirm = trim($_POST["confirm_password"]);

    // Check if fields are empty
    if ($current === "" || $new === "" || $confirm === "") {
        echo "<script>alert('All fields are required!'); window.history.back();</script>";
        exit;
    }

    // Check new password confirmation
    if ($new !== $confirm) {
        echo "<script>alert('New passwords do not match!'); window.history.back();</script>";
        exit;
    }

    // ---------- DATABASE CHECK & UPDATE ----------
    $sql = "SELECT password FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user['password'] !== $current) {
        echo "<script>alert('Current password incorrect!'); window.history.back();</script>";
        exit;
    }

    // Update password in DB
    $sql = "UPDATE users SET password = ? WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $new, $email);
    mysqli_stmt_execute($stmt);

    // SUCCESS: alert and redirect to dashboard
    echo "<script>alert('Password changed successfully!'); window.location.href='../view/dashboard.php';</script>";
    exit;
}




}
?>