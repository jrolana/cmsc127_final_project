<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "komshat";

    $conn = new mysqli($servername, $username, $password);

    if ($conn->connect_error) {
        die("Error connecting to mysql" . $conn->connect_error);
    }

    $drop_sql = "DROP DATABASE IF EXISTS `$dbname`";

    if ($conn->query($drop_sql)) {
        echo "Successfully DROPPED DB: " . $dbname . "<br />";
    } else {
        echo "Error: " . $exists_sql . "<br />" . $conn->error . "<br />";
    }

    $create_sql = "CREATE DATABASE `$dbname`";

    if ($conn->query($create_sql)) {
        echo "Successfully CREATED DB: " . $dbname . "<br />";
    } else {
        echo "Error: " . $exists_sql . "<br />" . $conn->error . "<br />";
    }

    $conn->close();

    $conn = new mysqli($servername, $username, $password, $dbname);

    $users_table_sql = "CREATE TABLE `users`
                        (userID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        username VARCHAR(20) NOT NULL UNIQUE,
                        password VARCHAR(20) NOT NULL,
                        name VARCHAR(20) NOT NULL)";


    if ($conn->query($users_table_sql)) {
        echo "Successfully CREATED TABLE users" . "<br />";
    } else {
        echo "Error: " . $users_table_sql . "<br />" . $conn->error . "<br />";
    }

    $roles_table_sql = "CREATE TABLE `roles`
                        (roleID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        role VARCHAR(5))";
    
    if ($conn->query($roles_table_sql)) {
        echo "Successfully CREATED TABLE roles" . "<br />";
    } else {
        echo "Error: " . $roles_table_sql . "<br />" . $conn->error . "<br />";
    }
    
    $user_roles_sql = "CREATE TABLE `user_roles`
                       (userID INT UNSIGNED NOT NULL,
                       roleID INT UNSIGNED NOT NULL,
                       FOREIGN KEY (userID) REFERENCES users (userID),
                       FOREIGN KEY (roleID) REFERENCES roles (roleID))";

    if ($conn->query($user_roles_sql)) {
        echo "Successfully CREATED TABLE user_roles" . "<br />";
    } else {
        echo "Error: " . $user_roles_sql . "<br />" . $conn->error . "<br />";
    }

    $hackathons_table_sql = "CREATE TABLE `hackathons`
                             (hackathonID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                             theme VARCHAR(200) NOT NULL,
                             description VARCHAR(500) NOT NULL,
                             dateStart DATE NOT NULL,
                             dateEnd DATE NOT NULL CHECK (dateStart < dateEnd),
                             winningProjectID INT UNSIGNED NULL DEFAULT NULL)";

    if ($conn->query($hackathons_table_sql)) {
        echo "Successfully CREATED TABLE hackathons" . "<br />";
    } else {
        echo "Error: " . $hackathons_table_sql . "<br />" . $conn->error . "<br />";
    }

    $projects_table_sql = "CREATE TABLE `projects`
                           (projectID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                           userID INT UNSIGNED NOT NULL,
                           hackathonID INT UNSIGNED NOT NULL,
                           title VARCHAR(200) NOT NULL,
                           description VARCHAR(500) NOT NULL,
                           image VARCHAR(1024) NOT NULL,
                           dateSubmitted DATE NOT NULL,
                           FOREIGN KEY (hackathonID) REFERENCES hackathons (hackathonID),
                           FOREIGN KEY (userID) REFERENCES users (userID))";

    if ($conn->query($projects_table_sql)) {
        echo "Successfully CREATED TABLE projects" . "<br />";
    } else {
        echo "Error: " . $projects_table_sql . "<br />" . $conn->error . "<br />";
    }
                      
    $alter_hackathons_sql = "ALTER TABLE `hackathons`
                             ADD FOREIGN KEY (winningProjectID) REFERENCES projects (projectID)";
    
    if ($conn->query($alter_hackathons_sql)) {
        echo "Successfully ALTERED TABLE hackathons" . "<br />";
    } else {
        echo "Error: " . $alter_hackathons_sql . "<br />" . $conn->error . "<br />";
    }

    $participates_table_sql = "CREATE TABLE `participates`
                               (userID INT UNSIGNED NOT NULL,
                               hackathonID INT UNSIGNED NOT NULL,
                               FOREIGN KEY (userID) REFERENCES users (userID),
                               FOREIGN KEY (hackathonID) REFERENCES hackathons (hackathonID))";

    if ($conn->query($participates_table_sql)) {
        echo "Successfully CREATED TABLE participates" . "<br />";
    } else {
        echo "Error: " . $participates_table_sql . "<br />" . $conn->error . "<br />";
    }

    $conn->close();
?>