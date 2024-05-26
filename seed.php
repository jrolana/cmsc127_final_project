<?php
include "drop_create.php";
include "db_connector.php";

echo "<br />Successfully connected to " . $dbname . "<br />";
echo "Populating DB...<br />";

echo "Creating users...<br/>";
$users_sql = "INSERT INTO `users` (userID, username, password, name)

                  VALUES (1, 'admin', 'admin', 'admin'), (2, 'ezra', 'password', 'ezra'),
                        (3, 'jhoanna', 'password', 'jhoanna')";


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

                  VALUES (1, 1), (2, 2), (3, 2)";


if ($conn->query($user_roles_sql)) {
    echo "Successfully assigned user roles.<br />";
} else {
    echo "Error: " . $user_roles_sql . "<br />" . $conn->error . "<br />";
}

echo "Creating a hackathon...<br />";
$hackathon_sql = "INSERT INTO `hackathons` (hackathonID, theme, description, dateStart, dateEnd, winningProjectID)
                       VALUES (1, 'Innovating the Green Landscapes', 'Create and Innovate for our farmers and fishermen.',
                               '2024-06-16', '2024-06-23', NULL)";

if ($conn->query($hackathon_sql)) {
    echo "Successfully created a hackathon.<br />";
} else {
    echo "Error: " . $hackathon_sql . "<br />" . $conn->error . "<br />";
}

$hackathon_sql = "INSERT INTO `hackathons` (theme, description, dateStart, dateEnd, winningProjectID)
                       VALUES ('Sustainable Agriculture Innovations for Urban Food Deserts', 'The hackathon will focus on addressing the challenge of food deserts in urban areas, where residents have limited access to fresh and affordable produce, leading to higher rates of diet-related health issues and food insecurity.',
                               '2024-06-22', '2024-06-29', NULL)";

if ($conn->query($hackathon_sql)) {
    echo "Successfully created a hackathon.<br />";
} else {
    echo "Error: " . $hackathon_sql . "<br />" . $conn->error . "<br />";
}

$hackathon_sql = "INSERT INTO `hackathons` (theme, description, dateStart, dateEnd, winningProjectID)
                       VALUES ('Mental Health Matters: Innovating for Youth Well-being', 'The hackathon will focus on addressing mental health challenges faced by youth, such as rising rates of anxiety and depression, lack of access to affordable mental health services, and stigma surrounding mental illness in schools and communities.',
                               '2024-05-03', '2024-05-10', NULL)";

if ($conn->query($hackathon_sql)) {
    echo "Successfully created a hackathon.<br />";
} else {
    echo "Error: " . $hackathon_sql . "<br />" . $conn->error . "<br />";
}

$hackathon_sql = "INSERT INTO `hackathons` (theme, description, dateStart, dateEnd, winningProjectID)
                       VALUES ('Lorem ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                               '2024-04-03', '2024-04-10', NULL)";


if ($conn->query($hackathon_sql)) {
    echo "Successfully created a hackathon.<br />";
} else {
    echo "Error: " . $hackathon_sql . "<br />" . $conn->error . "<br />";
}

echo "Joining a hackathon...<br />";
$participate_sql = "INSERT INTO `participates` (userID, hackathonID)
                        VALUES (2, 1), (3, 2), (3,3), (2, 4)";

if ($conn->query($participate_sql)) {
    echo "Successfully joined a hackathon.<br />";
} else {
    echo "Error: " . $participate_sql . "<br />" . $conn->error . "<br />";
}

echo "Submitting a project...<br />";
$project_sql = "INSERT INTO `projects` (projectID, userID, hackathonID, title, description, image, dateSubmitted)
                       VALUES (NULL, 2, 1, 'Innovative submission', 'This is a very innovative solution for the current problem',
                  'images/projects/project1.png', '2024-05-22')";

if ($conn->query($project_sql)) {
    echo "Successfully submitted a project.<br />";
} else {
    echo "Error: " . $project_sql . "<br />" . $conn->error . "<br />";
}

echo "Submitting a project...<br />";
$project_sql = "INSERT INTO `projects` (projectID, userID, hackathonID, title, description, image, dateSubmitted)
                       VALUES (NULL, 3, 3, 'Innovative submission', 'This is a very innovative solution for the current problem',
                  'images/projects/project1.png', '2024-05-01')";

if ($conn->query($project_sql)) {
    echo "Successfully submitted a project.<br />";
} else {
    echo "Error: " . $project_sql . "<br />" . $conn->error . "<br />";
}

$hackathon_sql = "UPDATE `hackathons` SET winningProjectID=2 WHERE hackathonID=3";

if ($conn->query($hackathon_sql)) {
    echo "Successfully updated a hackathon.<br />";
} else {
    echo "Error: " . $hackathon_sql . "<br />" . $conn->error . "<br />";
}

$conn->close();
