<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

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
                echo "Login successful! Role: " . $user['role'];
                break;
            }
        }

        if (!$found) {
            echo "Invalid credentials";
        }
    }
}
