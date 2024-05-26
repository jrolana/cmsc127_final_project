<?php

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: /cmsc127_final_project/home/index.php");
    exit();
}

$currentUserID = 2;
$hackathonID = $_POST["hackathonID"];
$projTitle = $_POST["project-title"];
$projDescription = $_POST["project-description"];
$projImage = $_FILES["project-img"];
$projDate = date('Y-m-d');

if (empty($hackathonID) || empty($projTitle) || empty($projImage) || empty($projDescription)) {
    header("Location: /cmsc127_final_project/home/index.php/?error=Missing Fields");
    exit();
}

$target_dir = "../images/projects/";
$target_file = $target_dir . basename($projImage["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$errors = array();
$error;

// Check if image file is a actual image or fake image
$check = getimagesize($projImage["tmp_name"]);
if (!$check) {
    array_push($errors, "File is not an image.");
    $uploadOk = 0;
}

// Check if file already exists
if (file_exists($target_file)) {
    array_push($errors, "Sorry, file already exists.");
    $uploadOk = 0;
}

// Check file size
if ($projImage["size"] > 500000) {
    array_push($errors, "Sorry, your file is too large.");
    $uploadOk = 0;
}

// Allow certain file formats
if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif"
) {
    array_push($errors, "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    array_push($errors, "Sorry, your file was not uploaded.");
    header("Location: /cmsc127_final_project/home/?error=$error");
    exit();
}

// if everything is ok, try to upload file
$error = http_build_query($errors);
if (!move_uploaded_file($projImage["tmp_name"], $target_file)) {
    $error = "Sorry, there was an error uploading your file.";
    header("Location: /cmsc127_final_project/home/?error=$error");
    exit();
}
include '../db_connector.php';

$project_sql = "INSERT INTO `projects` (userID, hackathonID, title, description, image, dateSubmitted)
    VALUES('$currentUserID', '$hackathonID', '$projTitle', '$projDescription', '$target_file', '$projDate')";

if ($result = $conn->query($project_sql)) {
    header("Location: /cmsc127_final_project/home/");
    $conn->close();
}
