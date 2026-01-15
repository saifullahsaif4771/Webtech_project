<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start(); // start session

// Prototype users
$users = [
    ["email" => "admin@test.com", "password" => "1234", "role" => "admin"],
    ["email" => "student@test.com", "password" => "1234", "role" => "student"]
];

// Only handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Check if action is 'login'
    if (isset($_POST['action']) && $_POST['action'] === 'login') {

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $found = false;
        foreach ($users as $user) {
            if ($user['email'] === $email && $user['password'] === $password) {
                $found = true;

                // Save user info in session
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];

                // Redirect to dashboard
                header("Location: ../view/dashboard.php");
                exit();
            }
        }

        if (!$found) {
            echo "Invalid credentials";
        }
    }
}
