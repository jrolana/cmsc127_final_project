<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <link href="style.css" rel="stylesheet">

</head>

<body>
    <?php
    include 'db_connector.php';
    $currentUserID = 2;

    $currentDate = date("Y-m-d");
    ?>
    <h1>Hackathons</h1>
    <ul>
        <h2>Joined Hackathons</h2>
        <?php
        $joinedHackathons_sql = "SELECT hackathonID FROM participates WHERE userID=$currentUserID";
        $joined = $conn->query($joinedHackathons_sql);

        if ($joined) {
            while ($joinedHackathon = $joined->fetch_assoc()) {
                $joinedHackathonID = $joinedHackathon["hackathonID"];
                $hackathon_sql = "SELECT * FROM hackathons WHERE hackathonID=$joinedHackathonID";
                $hackathon_details = $conn->query($hackathon_sql);

                if ($hackathon_details) {
                    while ($hackathon = $hackathon_details->fetch_assoc()) {
                        if ($hackathon["dateEnd"] >= $currentDate) {
                            echo "<li>" .
                                "<h3>" . $hackathon["theme"] . "</h3>" .
                                "<p>" . $hackathon["description"] . "</p>" .
                                "<p>" . $hackathon["dateStart"] . " to " . $hackathon["dateEnd"] . "</p>" .
                                "<button>Submit a project</button>" .
                                "</li>";
                        }
                    }
                }
            }
        }
        ?>
    </ul>

    <ul>
        <h2>Available Hackathons</h2>
        <?php
        $availHackathons_sql = "SELECT hackathonID FROM participates WHERE userID!=$currentUserID";
        $available = $conn->query($availHackathons_sql);

        if ($available) {
            while ($availHackathon = $available->fetch_assoc()) {
                $availHackathonID = $availHackathon["hackathonID"];

                $hackathon_sql = "SELECT * FROM hackathons WHERE hackathonID=$availHackathonID";
                $hackathon_details = $conn->query($hackathon_sql);

                if ($hackathon_details) {
                    while ($hackathon = $hackathon_details->fetch_assoc()) {
                        if ($hackathon["dateEnd"] >= $currentDate) {
                            echo "<li>" .
                                "<h3>" . $hackathon["theme"] . "</h3>" .
                                "<p>" . $hackathon["description"] . "</p>" .
                                "<p>" . $hackathon["dateStart"] . " to " . $hackathon["dateEnd"] . "</p>" .
                                "<button>Join</button>" .
                                "</li>";
                        }
                    }
                }
            }
        }
        ?>
    </ul>

    <ul>
        <h2>Past Hackathons</h2>
        <?php
        $availHackathons_sql = "SELECT hackathonID FROM participates";
        $available = $conn->query($availHackathons_sql);

        if ($available) {
            while ($availHackathon = $available->fetch_assoc()) {
                $availHackathonID = $availHackathon["hackathonID"];

                $hackathon_sql = "SELECT * FROM hackathons WHERE hackathonID=$availHackathonID";
                $hackathon_details = $conn->query($hackathon_sql);

                if ($hackathon_details) {
                    while ($hackathon = $hackathon_details->fetch_assoc()) {
                        if ($hackathon["dateEnd"] < $currentDate) {
                            echo "<li>" .
                                "<h3>" . $hackathon["theme"] . "</h3>" .
                                "<p>" . $hackathon["description"] . "</p>" .
                                "<p>" . $hackathon["dateStart"] . " to " . $hackathon["dateEnd"] . "</p>" .
                                "</li>";
                        }
                    }
                }
            }
        }
        ?>
    </ul>
</body>

</html>