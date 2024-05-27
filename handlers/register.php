<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: /cmsc127_final_project/register");
    exit();
}


if (empty($_POST["userID"]) || empty($_POST["password"] || empty($_POST["name"]))) {
    header("Location: /cmsc127_final_project/register/?error=Missing Fields");
    exit();
}

include "../db_connector.php";

$name = $_POST["name"];
$userID = $_POST["userID"];
$password = $_POST["password"];

$success = 0;
$user_sql = "INSERT INTO `users` (username, password, name)
    VALUES('$userID', '$password', '$name')";

try {
    if ($result = $conn->query($user_sql)) {
        $success = 1;
    }
} catch (Exception $e) {
    $error = "User already registered";
}

if ($success == 1) {
    $_SESSION["userID"] = $user["userID"];

    header("Location: /cmsc127_final_project/home");
} else {
    header("Location: /cmsc127_final_project/register/?error=$error");
}

$conn->close();
