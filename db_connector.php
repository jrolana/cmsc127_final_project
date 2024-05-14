<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "komshat";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Error connecting to mysql" . $conn->connect_error);
    }
?>