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

$join_sql = "INSERT INTO `participates` (userID, hackathonID) VALUES('$currentUserID', '$hackathonID')";
$conn->query($join_sql);
header("Location: /cmsc127_final_project/home/");

$conn->close();