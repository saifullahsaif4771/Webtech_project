<?php
session_start();

// ---------- PROTOTYPE USERS ----------
$users = [
    ["email" => "admin@test.com", "password" => "1234", "role" => "admin"],
    ["email" => "student@test.com", "password" => "1234", "role" => "student"]
];

// ---------- FUTURE DATABASE CONNECTION ----------
// include "../config/database.php";
// SELECT * FROM users WHERE email = ?

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ---------- LOGIN ----------
    if ($_POST["action"] == "login") {

        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);

        if ($email == "" || $password == "") {
            echo "All fields required";
            exit; // stops execution
        }

        foreach ($users as $user) {
            if ($user["email"] == $email && $user["password"] == $password) {
                $_SESSION["email"] = $user["email"];
                $_SESSION["role"] = $user["role"];
                header("Location: ../dashboard.php");
                exit;
            }
        }

        echo "Invalid email or password";
    }

    // ---------- REGISTER ----------
    if ($_POST["action"] == "register") {

        $name = trim($_POST["name"]);
        $email = trim($_POST["email"]);
        $password = trim($_POST["password"]);
        $role = $_POST["role"];

        if ($name == "" || $email == "" || $password == "") {
            die("All fields required");
        }

        // ---------- PROTOTYPE REGISTER ----------
        // Data is NOT saved permanently

        // ---------- FUTURE DATABASE INSERT ----------
        // INSERT INTO users (name, email, password, role) VALUES (...)

        echo "Registration successful (Prototype)";
    }
}
