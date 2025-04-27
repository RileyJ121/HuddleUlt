<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../public/home.css" rel="stylesheet">
    <link href="../public/main.css" rel="stylesheet">
    <title>Huddle Ult</title>
</head>

<body>
    <nav>
        <img src="../public/Logo.png" alt="Logo">
        <ul>
            <li><a href="home.html">Home</a></li>
            <li><a href="search_team.php">Search</a></li>
            <li><a href="player_activity.php">Activity</a></li>
            <li><a href="user_profile.php">Profile</a></li>
        </ul>
    </nav>
    <div class="bg">
        <main>
            <div class="header">
                <a href="user_profile.php">
                    <h3>🢀</h3>
                </a>
            </div>
            <?php

            // Only delete if logged in, and came from delete form
            if (isset($_COOKIE["user"]) && isset($_POST["delete"]) && isset($_POST["team"])) {
                $team = $_POST['team'];
                $loggedInUser = $_COOKIE["user"];
                include 'start_db.php';

                // Delete team
                $sql = "DELETE FROM team
                        WHERE Host = '$loggedInUser' AND TeamID = {$team}";

                if ($conn->query($sql) === TRUE) {
                    echo "Team deleted";
                }
                $conn->close();
            }
            ?>
            <a href="search_team.php">Okay</a>
        </main>
    </div>
</body>

</html>