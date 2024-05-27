<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: /cmsc127_final_project/admin/");
    exit();
}

$currentAdminID = $_SESSION["adminID"];

if (!isset($currentAdminID) || empty($currentAdminID)) {
    header("Location: /cmsc127_final_project/home/");
    exit();
}

$theme = $_POST["theme"];
$description = $_POST["description"];
$dateStart = $_POST["date-start"];
$dateEnd = $_POST["date-end"];

if (date($dateStart) >= date($dateEnd)) {
    header("Location: /cmsc127_final_project/admin/?error=Invalid date");
    exit();
}

if (empty($dateStart) || empty($dateEnd) || empty($theme) || empty($description)) {
    header("Location: /cmsc127_final_project/admin/?error=Missing Fields");
    exit();
}

include "../../db_connector.php";

$edit_sql = "INSERT INTO hackathons VALUES(NULL, '$theme', '$description', '$dateStart', '$dateEnd', NULL)";
if ($conn->query($edit_sql)) {
    header("Location: /cmsc127_final_project/admin/");
} else {
    header("Location: /cmsc127_final_project/admin/?error={$conn->error}");
}


header("Location: /cmsc127_final_project/admin/");

$conn->close();
?>