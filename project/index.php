<?php
session_start();

$currentUserID;
if (isset($_SESSION["userID"])) {
    $currentUserID = $_SESSION["userID"];
}

if (empty($_GET['id'])) {
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}

include "../db_connector.php";

$projectID = $_GET["id"];
$project_sql = "SELECT * FROM projects INNER JOIN users ON projects.userID=users.userID WHERE projectID=$projectID LIMIT 1";
$result = $conn->query($project_sql);
$conn->close();

if ($result->num_rows < 1) {
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}

$project = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <link href="./style.css" rel="stylesheet">
    <link href="/cmsc127_final_project/global.css" rel="stylesheet">
</head>

<body>
    <nav>
        <a class="bold" href="/cmsc127_final_project/home/">
            <h3>komshat</h3>
        </a>

        <?php

        if (isset($currentUserID)) {
            echo "<a href='/cmsc127_final_project/handlers/logout.php'>Log out</a>";
        } else {
            echo "<a href='/cmsc127_final_project/login/'>Log in</a>";
        }

        ?>

    </nav>

    <main>
        <img alt="project" src="<?php echo $project['image'] ?>" />
        <h1><?php echo $project['title'] ?></h1>
        <div class="info">
            <p class="user">By <?php echo $project['name'] ?></p>
            <p><?php echo $project['description'] ?></p>
        </div>
    </main>
</body>

</html>