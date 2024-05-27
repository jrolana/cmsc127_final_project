<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User | Register</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <link href="/cmsc127_final_project/register/style.css" rel="stylesheet">
    <link href="/cmsc127_final_project/global.css" rel="stylesheet">
</head>

<body>
    <form action="/cmsc127_final_project/handlers/register.php" method="POST">
        <h3>User Registration</h3>

        <div>
            <label for="name">Name: </label>
            <input id="name" name="name" type="text" placeholder="Name" required />
        </div>
        <div>
            <label for="id">User ID: </label>
            <input id="id" name="userID" type="text" placeholder="User ID" required />
        </div>
        <div>
            <label for="password">Password: </label>
            <input id="password" name="password" type="password" placeholder="Password" required />
        </div>

        <button type="submit">Register</button>
        <?php
        if (isset($_GET["error"])) {
            $error = $_GET["error"];
            echo "<p class='error'>Error: " . htmlspecialchars($error) . "</p>";
        }
        ?>
    </form>
</body>

</html>