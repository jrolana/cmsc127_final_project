<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Project</title>

    <link href="/cmsc127_final_project/submit/style.css" rel="stylesheet">
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
        include '..\db_connector.php';

        $hackathonID = $_GET['hackathonID'];
        $hackathon_sql = "SELECT * FROM hackathons WHERE hackathonID=$hackathonID LIMIT 1";
        $result = $conn->query($hackathon_sql);

        if ($result) {
            $hackathon = $result->fetch_assoc();
            $theme = $hackathon["theme"];
            $hackathonDesc = $hackathon["description"];
            $start = $hackathon["dateStart"];
            $end = $hackathon["dateEnd"];
        }
        ?>

        <ul>
            <li>
                <h3><?php echo $theme ?></h3>
            </li>
            <li>
                <p><?php echo $hackathonDesc ?></p>
            </li>
            <li>
                <p><?php echo $start ?> to <?php echo $end ?></p>
            </li>
        </ul>

        <form action="/cmsc127_final_project/handlers/submit.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="hackathonID" value="<?php echo $hackathonID ?>" />
            <ul>
                <li>
                    <h3>Submit a Project</h3>
                </li>
                <li>
                    <label for=" project-title">Title</label>
                    <input type="text" name="project-title" placeholder="Enter your project title" required />
                </li>
                <li>
                    <label for=" project-description">Description</label>
                    <textarea name="project-description" required>Enter your project description</textarea>
                </li>
                <li>
                    <label for="project-img">Choose project thumbnail</label>
                    <input type="file" name="project-img" accept="image/*" required />
                </li>
                <li>
                    <input type="submit" />
                </li>
            </ul>
        </form>
    </main>
</body>

</html>