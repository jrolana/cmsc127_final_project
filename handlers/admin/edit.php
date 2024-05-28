<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: /cmsc127_final_project/admin/");
    exit();
}

$currentAdminID = $_SESSION["adminID"];

// Check if current user is an admin
if (!isset($currentAdminID) || empty($currentAdminID)) {
    header("Location: /cmsc127_final_project/home/");
    exit();
}

$hackathonID = $_POST["hackathonID"];
$theme = $_POST["theme"];
$description = $_POST["description"];
$dateStart = $_POST["date-start"];
$dateEnd = $_POST["date-end"];


if (empty($dateStart) || empty($dateEnd) || empty($theme) || empty($description) || empty($hackathonID)) {
    header("Location: {$_SERVER['HTTP_REFERER']}&error=Missing Fields");
    exit();
}

// Data validation check
if (date($dateStart) >= date($dateEnd)) {
    header("Location: {$_SERVER['HTTP_REFERER']}&error=Invalid date");
    exit();
}

include "../../db_connector.php";

$edit_sql = "UPDATE hackathons set theme='$theme', description='$description', dateStart='$dateStart', dateEnd='$dateEnd' WHERE hackathonID=$hackathonID";

if ($conn->query($edit_sql)) {
    header("Location: /cmsc127_final_project/admin/");
} else {
    header("Location: {$_SERVER['HTTP_REFERER']}&error={$conn->error}");
}


$conn->close();
?>