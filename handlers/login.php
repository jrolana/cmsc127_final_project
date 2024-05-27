<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: /cmsc127_final_project/login");
    exit();
}


if (empty($_POST["userID"]) || empty($_POST["password"])) {
    header("Location: /cmsc127_final_project/login/?error=Missing Fields");
    exit();
}

include "../db_connector.php";

$userID = $_POST["userID"];
$password = $_POST["password"];

$success = 0;
$error = "Invalid user";

$user_sql = "SELECT userID FROM users WHERE username='$userID' AND password='$password'";

if ($result = $conn->query($user_sql)) {
    $user = $result->fetch_assoc();

    if (isset($user)) {
        $success = 1;
    }
}

if ($success == 1) {
    $_SESSION["userID"] = $user["userID"];

    header("Location: /cmsc127_final_project/home");
} else {
    header("Location: /cmsc127_final_project/login/?error=$error");
}

$conn->close();
