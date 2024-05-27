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

$hackathonID = $_POST["hackathonID"];
$projectID = $_POST["projectID"];

if (empty($hackathonID) || empty($projectID)) {
    header("Location: /cmsc127_final_project/admin/");
    exit();
}

include "../../db_connector.php";

$hackathon_sql = "UPDATE hackathons SET winningProjectID='$projectID' WHERE hackathonID='$hackathonID'";
$conn->query($hackathon_sql);
header("Location: /cmsc127_final_project/admin/");

$conn->close();
?>