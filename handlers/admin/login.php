<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: /cmsc127_final_project/admin/login");
    exit;
}


if (empty($_POST["adminID"]) || empty($_POST["password"])) {
    header("Location: /cmsc127_final_project/admin/login/?error=Missing Fields");
    exit;
}

include "../../db_connector.php";

define('ADMIN_ROLE', 1);

$adminID = $_POST["adminID"];
$password = $_POST["password"];

$success = 0;
$error = "Invalid user";

$user_sql = "SELECT userID FROM users WHERE username='$adminID' AND password='$password'";

if ($result = $conn->query($user_sql)) {
    $user = $result->fetch_assoc();

    if (!empty($user)) {
        $role_sql = "SELECT roleID FROM user_roles WHERE userID={$user['userID']}";

        if ($result = $conn->query($role_sql)) {
            $role = $result->fetch_assoc();

            if ($role["roleID"] == ADMIN_ROLE) {
                $success = 1;
            } else {
                $error = "Not an admin";
            }
        }
    }
}

if ($success == 1) {
    $_SESSION["adminID"] = $user["userID"];

    header("Location: /cmsc127_final_project/admin");
} else {
    header("Location: /cmsc127_final_project/admin/login/?error=$error");
}

$conn->close();
?>