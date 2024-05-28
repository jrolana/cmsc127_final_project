<?php
session_start();

$adminID = $_SESSION["adminID"];

if (empty($adminID)) {
    header("Location: login/");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

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
        <a href="/cmsc127_final_project/handlers/logout.php">Log out</a>
    </nav>
    <main>
        <form id="create" action='/cmsc127_final_project/handlers/admin/create.php' method='POST'>
            <h3>Create Hackathon</h3>

            <div>
                <label for="theme">Theme: </label>
                <textarea id="theme" name="theme" required placeholder="Enter theme"></textarea>
            </div>

            <div>
                <label for="description">Description: </label>
                <textarea id="description" name="description" required placeholder="Enter description"></textarea>
            </div>

            <div id="date-container">
                <div>
                    <label for="date-start">Date start</label>
                    <input id="date-start" name="date-start" type="date" required>
                </div>
                <div>
                    <label for="date-end">Date end</label>
                    <input id="date-end" name="date-end" type="date" required>
                </div>
            </div>

            <button type="submit">Create</button>
            <?php
            if (isset($_GET["error"])) {
                $error = $_GET["error"];
                echo "<p class='error'>Error: " . htmlspecialchars($error) . "</p>";
            }
            ?>
        </form>

        <table>
            <tr>
                <th>ID</th>
                <th>Theme</th>
                <th>Date start</th>
                <th>Date end</th>
                <th>Winner</th>
                <th>Actions</th>
            </tr>

            <?php
            include "../db_connector.php";

            $hackathons_sql = "SELECT * FROM hackathons ORDER BY dateEnd DESC";
            $hackathons = $conn->query($hackathons_sql);

            if ($hackathons) {
                while ($hackathon = $hackathons->fetch_assoc()) {

                    echo "<tr class='projects'>" .
                        "<td>" . $hackathon["hackathonID"] . "</td>" .
                        "<td>" . $hackathon["theme"] . "</td>" .
                        "<td>" . $hackathon["dateStart"] . "</td>" .
                        "<td>" . $hackathon["dateEnd"] . "</td>";


                    $submitted_sql = "SELECT projectID, title FROM projects WHERE hackathonID='{$hackathon["hackathonID"]}'";
                    $result = $conn->query($submitted_sql);
                    $hasNoWinner = $hackathon['winningProjectID'] == null ? 'selected' : '';

                    echo "<td class='winner'>
                                <form action='/cmsc127_final_project/handlers/admin/winner.php' method='POST'>
                                  <select name='projectID' required>
                                    <option disabled $hasNoWinner>None</option>";
                    if ($result->num_rows > 0) {
                        while ($project = $result->fetch_assoc()) {
                            $isSelected = $hackathon["winningProjectID"] == $project['projectID'] ? 'selected' : '';

                            echo "<option value='{$project["projectID"]}' $isSelected>" . $project['title'] . "</option>";
                        }
                    }
                    echo "      </select>
                                <input type='hidden' name='hackathonID' value='{$hackathon["hackathonID"]}'>
                                <button type='submit'>Mark as winner</button>
                            </form>
                        </td>";

                    echo "<td class='action'>
                            <form action='/cmsc127_final_project/admin/edit/' method='GET'>
                                <input type='hidden' name='hackathonID' value='{$hackathon['hackathonID']}' />
                                <button>Edit</button>
                            </form>
                            <form action='/cmsc127_final_project/handlers/admin/delete.php' method='POST'>
                                <input type='hidden' name='hackathonID' value='{$hackathon['hackathonID']}' />
                                <button>Delete</button>
                            </form>
                            <button class='view'>View Project</button>
                        </td>";
                    echo "</tr>";

                }
            }

            $conn->close();
            ?>
        </table>
    </main>

    <script>
        const projects = document.querySelectorAll('.projects');

        for (const project of projects) {
            const select = project.querySelector('select');
            const viewButton = project.querySelector('.view');

            viewButton.addEventListener('click', () => {
                if (select.value != 'None') {
                    window.location.href = `/cmsc127_final_project/project/?id=${select.value}`;
                }
            })

        }
    </script>
</body>

</html>