<?php
include "drop_create.php";
include "db_connector.php";

echo "<br />Successfully connected to " . $dbname . "<br />";
echo "Populating DB...<br />";

echo "Creating users...<br/>";
$users_sql = "INSERT INTO `users` (userID, username, password, name)
                  VALUES (1, 'admin', 'admin', 'admin'), (2, 'ezra', 'password', 'ezra')";

if ($conn->query($users_sql)) {
    echo "Successfully created users.<br />";
} else {
    echo "Error: " . $users_sql . "<br />" . $conn->error . "<br />";
}

echo "Creating user roles...<br />";
$roles_sql = "INSERT INTO `roles` (roleID, role)
                  VALUES (1, 'admin'), (2, 'user')";

if ($conn->query($roles_sql)) {
    echo "Successfully created roles.<br />";
} else {
    echo "Error: " . $roles_sql . "<br />" . $conn->error . "<br />";
}

echo "Assigning user roles...<br />";
$user_roles_sql = "INSERT INTO `user_roles` (userID, roleID)
                  VALUES (1, 1), (2, 2)";

if ($conn->query($user_roles_sql)) {
    echo "Successfully assigned user roles.<br />";
} else {
    echo "Error: " . $user_roles_sql . "<br />" . $conn->error . "<br />";
}

echo "Creating a hackathon...<br />";
$hackathon_sql = "INSERT INTO `hackathons` (hackathonID, theme, description, dateStart, dateEnd, winningProjectID)
                       VALUES (1, 'Innovating the Green Landscapes', 'Create and Innovate for our farmers and fishermen.',
                               '2024-05-16', '2024-05-23', NULL)";

if ($conn->query($hackathon_sql)) {
    echo "Successfully created a hackathon.<br />";
} else {
    echo "Error: " . $hackathon_sql . "<br />" . $conn->error . "<br />";
}

echo "Joining a hackathon...<br />";
$participate_sql = "INSERT INTO `participates` (userID, hackathonID)
                        VALUES (2, 1)";

if ($conn->query($participate_sql)) {
    echo "Successfully joined a hackathon.<br />";
} else {
    echo "Error: " . $participate_sql . "<br />" . $conn->error . "<br />";
}

echo "Submitting a project...<br />";
$project_sql = "INSERT INTO `projects` (projectID, userID, hackathonID, title, description, image, dateSubmitted)
                       VALUES (NULL, 2, 1, 'Innovative submission', 'This is a very innovative solution for the current problem',
                               'test_binary_wrong', '2024-05-22')";

if ($conn->query($project_sql)) {
    echo "Successfully submitted a project.<br />";
} else {
    echo "Error: " . $project_sql . "<br />" . $conn->error . "<br />";
}

$conn->close();
?>