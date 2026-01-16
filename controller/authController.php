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

}
?>
