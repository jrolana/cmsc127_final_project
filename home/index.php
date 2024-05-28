<?php
session_start();

$currentUserID;
if (isset($_SESSION["userID"])) {
    $currentUserID = $_SESSION["userID"];
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Komshat</title>

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
        <?php
        include '../db_connector.php';

        $currentDate = date("Y-m-d");
        ?>

        <h1>Hackathons</h1>

        <?php
        // Show joined hackathons if user is logged-in
        if (isset($currentUserID)) {
            echo "<h2>Joined Hackathons</h2>";
            echo "<ul>";

            $joined_sql = "SELECT hackathonID FROM participates WHERE userID=$currentUserID";
            $hackathons_sql = "SELECT * FROM hackathons WHERE hackathonID IN ($joined_sql) ORDER BY dateEnd DESC";
            $hackathons = $conn->query($hackathons_sql);

            if ($hackathons) {
                while ($hackathon = $hackathons->fetch_assoc()) {
                    echo "<li>" .
                        "<div>" .
                        "<h3>" . $hackathon["theme"] . "</h3>" .
                        "<p>" . $hackathon["description"] . "</p>" .
                        "<p>" . $hackathon["dateStart"] . " to " . $hackathon["dateEnd"] . "</p>" .
                        "</div>";

                    // If hackathon is completed, show only the winning project
                    if (date($hackathon["dateEnd"]) <= $currentDate) {
                        $winner_sql = "SELECT title, username, projectID FROM
                            projects INNER JOIN users ON projects.userID=users.userID
                            WHERE projectID='{$hackathon['winningProjectID']}' LIMIT 1";
                        $winner = $conn->query($winner_sql);

                        if (!empty($winner = $winner->fetch_row())) {
                            echo "<a class='winner underline pointer' href='/cmsc127_final_project/project/?id={$winner[2]}'>Winner: " . $winner[0] . " by " . $winner[1] . "</a>";
                        }
                        echo "</li>";
                        continue;
                    }

                    // Determine if user has already submitted a project
                    $hackathonID = $hackathon["hackathonID"];
                    $submitted_sql = "SELECT projectID FROM projects WHERE hackathonID=$hackathonID AND userID=$currentUserID";
                    $result = $conn->query($submitted_sql);
                    $submitted = $result->num_rows > 0;

                    echo "<form action='/cmsc127_final_project/submit/index.php' method='GET'>
                            <input type='hidden' name='hackathonID' value='$hackathonID'></input>
                            <input type='submit' value=" . ($submitted ? "'Submitted project' disabled" : "'Submit a project'") . "/>
                            </form>";

                    if (isset($_GET["error"])) {
                        $error = $_GET["error"];
                        $errors;
                        parse_str($error, $errors);
                        foreach ($errors as $err) {
                            echo "<p class='error'>Error: " . htmlspecialchars($err) . "</p>";
                        }
                    }

                    // Show a link to the submitted project
                    if ($submitted) {
                        $project = $result->fetch_assoc();
                        $projectID = $project["projectID"];

                        echo "<a class='view' href='/cmsc127_final_project/project/?id=$projectID'>View project</a>";
                    }

                    echo "</li>";
                }
            }

            echo "</ul>";
        }
        ?>
        <h2>Available Hackathons</h2>
        <ul>
            <?php
            $hackathons_sql = "SELECT * FROM hackathons WHERE DATE(dateEnd) > '$currentDate'";

            // Get hackathons the user has not yet joined
            if (isset($currentUserID)) {
                $joined_sql = "SELECT hackathonID FROM participates WHERE userID='$currentUserID'";
                $hackathons_sql = "SELECT * FROM hackathons WHERE DATE(dateEnd) > '$currentDate' AND hackathonID NOT IN ($joined_sql)";
            }

            $hackathons = $conn->query($hackathons_sql);

            if ($hackathons) {
                while ($hackathon = $hackathons->fetch_assoc()) {
                    echo "<li>" .
                        "<div>" .
                        "<h3>" . $hackathon["theme"] . "</h3>" .
                        "<p>" . $hackathon["description"] . "</p>" .
                        "<p>" . $hackathon["dateStart"] . " to " . $hackathon["dateEnd"] . "</p>" .
                        "</div>";

                    if (isset($currentUserID)) {
                        echo "<form action='/cmsc127_final_project/handlers/join.php' method='POST'>
                        <input type='hidden' name='hackathonID' value='{$hackathon['hackathonID']}'></input>
                        <input type='submit' value='Join'/>
                        </form>";
                    }

                    echo "</li>";
                }
            }
            ?>
        </ul>

        <h2>Past Hackathons</h2>
        <ul>
            <?php
            $hackathons_sql = "SELECT * FROM hackathons WHERE DATE(dateEnd) < '$currentDate'";

            // Exclude past hackathons the user has joined, since it is already displayed in the first section
            if (isset($currentUserID)) {
                $joined_sql = "SELECT hackathonID FROM participates WHERE userID='$currentUserID'";
                $hackathons_sql = "SELECT * FROM hackathons WHERE DATE(dateEnd) < '$currentDate' AND hackathonID NOT IN ($joined_sql)";
            }

            $hackathons = $conn->query($hackathons_sql);

            if ($hackathons) {
                while ($hackathon = $hackathons->fetch_assoc()) {
                    echo "<li>" .
                        "<div>" .
                        "<h3>" . $hackathon["theme"] . "</h3>" .
                        "<p>" . $hackathon["description"] . "</p>" .
                        "<p>" . $hackathon["dateStart"] . " to " . $hackathon["dateEnd"] . "</p>" .
                        "</div>";

                    $winner_sql = "SELECT title, username, projectID FROM
                            projects INNER JOIN users ON projects.userID=users.userID
                            WHERE projectID='{$hackathon['winningProjectID']}' LIMIT 1";
                    $winner = $conn->query($winner_sql);

                    // Show the winner if there is one
                    if (!empty($winner = $winner->fetch_row())) {
                        echo "<a class='winner underline pointer' href='/cmsc127_final_project/project/?id={$winner[2]}'>Winner: " . $winner[0] . " by " . $winner[1] . "</a>";
                    }

                    echo "</li>";
                }
            }
            ?>
        </ul>
    </main>
</body>

</html>