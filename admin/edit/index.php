<?php
session_start();

$adminID = $_SESSION["adminID"];

if (empty($adminID)) {
    header("Location: login/");
    exit();
}

$hackathonID = $_GET['hackathonID'];

if (empty($hackathonID)) {
    header("Location: /cmsc127_final_project/admin");
    exit();
}

include "../../db_connector.php";

$hackathon_sql = "SELECT * FROM hackathons WHERE hackathonID='$hackathonID'";
$result = $conn->query($hackathon_sql);

$hackathon;

if ($result && $result->num_rows > 0) {
    $hackathon = $result->fetch_assoc();
}

$conn->close();

if (empty($hackathon)) {
    header("Location: /cmsc127_final_project/admin");
    exit();
}

$hackathonID = $hackathon["hackathonID"];
$theme = $hackathon["theme"];
$description = $hackathon["description"];
$dateStart = $hackathon["dateStart"];
$dateEnd = $hackathon["dateEnd"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Hackathon</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <link href="../style.css" rel="stylesheet">
    <link href="./style.css" rel="stylesheet">
    <link href="/cmsc127_final_project/global.css" rel="stylesheet">
</head>

<body>
    <main>
        <form id="create" action='/cmsc127_final_project/handlers/admin/edit.php' method='POST'>
            <h3>Edit Hackathon</h3>

            <div>
                <label for="theme">Theme: </label>
                <textarea id="theme" name="theme" required
                    placeholder="Enter theme"><?php echo htmlspecialchars($theme) ?></textarea>
            </div>

            <div>
                <label for="description">Description: </label>
                <textarea id="description" name="description" required
                    placeholder="Enter description"><?php echo htmlspecialchars($description) ?></textarea>
            </div>

            <div id="date-container">
                <div>
                    <label for="date-start">Date start</label>
                    <input id="date-start" name="date-start" type="date" required value="<?php echo $dateStart ?>">
                </div>
                <div>
                    <label for="date-end">Date end</label>
                    <input id="date-end" name="date-end" type="date" required value="<?php echo $dateEnd ?>">
                </div>
            </div>

            <input type="hidden" name="hackathonID" value="<?php echo $hackathonID ?>" />
            <button type="submit">Edit</button>
            <?php
            if (isset($_GET["error"])) {
                $error = $_GET["error"];
                echo "<p class='error'>Error: " . htmlspecialchars($error) . "</p>";
            }
            ?>
        </form>
        <a href="/cmsc127_final_project/admin/"><button>Cancel</button></a>
    </main>
</body>

</html>