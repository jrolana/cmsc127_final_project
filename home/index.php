<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Komshat</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <link href="style.css" rel="stylesheet">

</head>

<body>
    <?php
    include '../db_connector.php';
    $currentUserID = 2;

    $currentDate = date("Y-m-d");
    ?>
    <h1>Hackathons</h1>
    <ul>
        <h2>Joined Hackathons</h2>
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

                if ($hackathon["dateEnd"] > $currentDate) {
                    echo "<form action='' method='GET'>
                        <input type='hidden' name='hackathonID' value='{$hackathon["hackathonID"]}'></input>
                        <input type='submit' value='Submit a project'></input>
                    </form>";
                }

                echo "</li>";
            }
        }
        ?>
    </ul>

    <ul>
        <h2>Available Hackathons</h2>
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
                    "<button>Join</button>" .
                    "</li>";
            }
        }
        ?>
    </ul>

    <ul>
        <h2>Past Hackathons</h2>
        <?php
        $past_sql = "SELECT hackathonID FROM participates WHERE DATE(dateEnd) < '$currentDate' AND userID!=$currentUserID";
        $hackathons_sql = "SELECT * FROM hackathons WHERE hackathonID IN ($past_sql)";
        $hackathons = $conn->query($hackathons_sql);

        if ($hackathons) {
            while ($hackathon = $hackathons->fetch_assoc()) {
                echo "<li>" .
                    "<h3>" . $hackathon["theme"] . "</h3>" .
                    "<p>" . $hackathon["description"] . "</p>" .
                    "<p>" . $hackathon["dateStart"] . " to " . $hackathon["dateEnd"] . "</p>" .
                    "</li>";
            }
        }
        ?>
    </ul>

</body>

</html>