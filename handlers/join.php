<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: /cmsc127_final_project/home/index.php");
    exit();
}

$currentUserID = $_SESSION["userID"];
$hackathonID = $_POST["hackathonID"];

if (!isset($currentUserID) || empty($hackathonID)) {
    header("Location: /cmsc127_final_project/home/index.php");
    exit();
}

include '../db_connector.php';

// Preliminary check if the user has submitted a project for the hackathon already
$check_sql = "SELECT * FROM participates WHERE userID=$currentUserID AND hackathonID=$hackathonID LIMIT 1";
$check_result = $conn->query($check_sql);
if ($check_result->num_rows > 0) {
    header("Location: /cmsc127_final_project/home/");
    $conn->close();
    exit();
}

$join_sql = "INSERT INTO `participates` (userID, hackathonID) VALUES('$currentUserID', '$hackathonID')";
$conn->query($join_sql);
header("Location: /cmsc127_final_project/home/");

$conn->close();