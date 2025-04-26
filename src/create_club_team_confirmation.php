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
                <a href="search_team.php">
                    <h3>🢀</h3>
                </a>
            </div>
            <?php

            if (isset($_COOKIE["user"])) {
                $loggedInUser = $_COOKIE["user"];

                include 'start_db.php';

                $name = $_POST["name"];
                $desc = isset($_POST["desc"]) && !empty($_POST["desc"]) ? "'" . $_POST["desc"] . "'" : "NULL";
                $lat = $_POST["lat"];
                $long = $_POST["long"];

                $gender = isset($_POST["gender"]) && !empty($_POST["gender"]) ? $_POST["gender"] : "NULL";
                $age = isset($_POST["age"]) && !empty($_POST["age"]) ? $_POST["age"] : "NULL";
                $captain = isset($_POST["capt"]) && !empty($_POST["capt"]) ? "'" . $_POST["capt"] . "'" : "NULL";

                // Verify captain
                if ($captain != "NULL") {
                    $sql = "SELECT * FROM player WHERE Username = $captain";
                    $result = $conn->query($sql);
                } else {
                    $result = true;
                }

                // Create team if captain is real
                if ($captain == "NULL" || $result->num_rows > 0) {
                    // Create generic team
                    $sql = "INSERT INTO team
                VALUES (NULL, '$name', $desc, $lat, $long, '$loggedInUser')";
                    $conn->query($sql);

                    // Create club team
                    $sql = "INSERT INTO clubteam
                VALUES (LAST_INSERT_ID(), $gender, $age, $captain)";
                    $conn->query($sql);

                    echo "Team Created!";
                } else {
                    echo "Captaining player does not exist.";
                }

                $conn->close();

            } else {
                echo "Please <a href=\"user_profile.php\">log in<a> before creating a team.";
            }
            
            ?>
            <a href="search_team.php">Okay</a>
        </main>
    </div>
</body>

</html>