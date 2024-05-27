<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Komshat</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <link href="/cmsc127_final_project/home/style.css" rel="stylesheet">
    <link href="/cmsc127_final_project/global.css" rel="stylesheet">
</head>

<body>
    <nav>
        <a class="bold" href="/cmsc127_final_project/home/">
            <h3>komshat</h3>
        </a>
        <a href="/cmsc127_final_project/handlers/logout.php">Log out</a>
    </nav>

    <main>
        <?php
        include '../db_connector.php';
        $currentUserID = 2;

        $currentDate = date("Y-m-d");
        ?>
        <h1>Hackathons</h1>
        <h2>Joined Hackathons</h2>
        <ul>
            <?php
            $joined_sql = "SELECT hackathonID FROM participates WHERE userID=$currentUserID";
            $hackathons_sql = "SELECT * FROM hackathons WHERE hackathonID IN ($joined_sql) ORDER BY dateEnd DESC";
            $hackathons = $conn->query($hackathons_sql);

            if ($hackathons) {
                while ($hackathon = $hackathons->fetch_assoc()) {
                    echo "<li>" .
                        "<h3>" . $hackathon["theme"] . "</h3>" .
                        "<p>" . $hackathon["description"] . "</p>" .
                        "<p>" . $hackathon["dateStart"] . " to " . $hackathon["dateEnd"] . "</p>";

                    if ($hackathon["dateEnd"] <= $currentDate) {
                        echo "</li>";
                        continue;
                    }

                    $hackathonID = $hackathon["hackathonID"];
                    $participated_sql = "SELECT projectID FROM projects WHERE hackathonID=$hackathonID AND userID=$currentUserID";
                    $participated = $conn->query($participated_sql) != null;

                    echo "<form action='/cmsc127_final_project/submit/index.php' method='GET'>
                        <input type='hidden' name='hackathonID' value='$hackathonID'></input>
                        <input type='submit' value='Submit a project'" . ($participated ? " disabled" : "") . "/>
                        </form>";

                    if (isset($_GET["error"])) {
                        $error = $_GET["error"];
                        $errors;
                        parse_str($error, $errors);
                        foreach ($errors as $err) {
                            echo "<p class='error'>" . $err . "</p>";
                        }
                    }
                    echo "</li>";
                }
            }
            ?>
        </ul>

        <h2>Available Hackathons</h2>
        <ul>
            <?php
            $available_sql = "SELECT hackathonID FROM participates WHERE DATE(dateEnd) > '$currentDate' AND userID!=$currentUserID";
            $hackathons_sql = "SELECT * FROM hackathons WHERE hackathonID IN ($available_sql)";
            $hackathons = $conn->query($hackathons_sql);

            if ($hackathons) {
                while ($hackathon = $hackathons->fetch_assoc()) {
                    echo "<li>" .
                        "<h3>" . $hackathon["theme"] . "</h3>" .
                        "<p>" . $hackathon["description"] . "</p>" .
                        "<p>" . $hackathon["dateStart"] . " to " . $hackathon["dateEnd"] . "</p>" .

                        "<form action='/cmsc127_final_project/handlers/join.php' method='GET'>
                        <input type='hidden' name='hackathonID' value='$hackathonID'></input>
                        <input type='submit' value='Join'/>
                        </form>";
                    "</li>";
                }
            }
            ?>
        </ul>

        <h2>Past Hackathons</h2>
        <ul>
            <?php
            $past_sql = "SELECT hackathonID FROM participates WHERE DATE(dateEnd) < '$currentDate' AND userID!=$currentUserID";
            $hackathons_sql = "SELECT * FROM hackathons WHERE hackathonID IN ($past_sql)";
            $hackathons = $conn->query($hackathons_sql);

            if ($hackathons) {
                while ($hackathon = $hackathons->fetch_assoc()) {
                    echo "<li>" .
                        "<h3>" . $hackathon["theme"] . "</h3>" .
                        "<p>" . $hackathon["description"] . "</p>" .
                        "<p>" . $hackathon["dateStart"] . " to " . $hackathon["dateEnd"] . "</p>";

                    $winner_sql = "SELECT title, username FROM
                            projects INNER JOIN users ON projects.userID=users.userID
                            WHERE projectID='{$hackathon['winningProjectID']}' LIMIT 1";
                    $winner = $conn->query($winner_sql);

                    if ((!$winner) || empty($winner)) {
                        echo "</li>";
                        continue;
                    }

                    $winner  = $winner->fetch_row();

                    echo "<p class='winner'>Winner: " . $winner[0] . " by " . $winner[1] . "</p>";
                }
            }
            ?>
        </ul>
    </main>
</body>

</html>