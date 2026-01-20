<?php
session_start(); // start session

// Include database connection
include "../config/database.php";

// Only handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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