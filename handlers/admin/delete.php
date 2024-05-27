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

if (empty($hackathonID)) {
    header("Location: /cmsc127_final_project/admin/");
    exit();
}

include "../../db_connector.php";

$hackathon_sql = "DELETE FROM hackathons WHERE hackathonID='$hackathonID'";
$conn->query($hackathon_sql);

$participants_sql = "DELETE FROM participates WHERE hackathonID='$hackathonID'";
$conn->query($participants_sql);

$projects_sql = "DELETE FROM projects WHERE hackathonID='$hackathonID'";
$conn->query($projects_sql);

header("Location: /cmsc127_final_project/admin/");

$conn->close();
?>