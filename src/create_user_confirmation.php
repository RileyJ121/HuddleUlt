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

            include 'start_db.php';

            $username = $_POST["username"];
            $password = $_POST["password"];
            $firstname = $_POST["firstname"];
            $lastname = $_POST["lastname"];
            $email = $_POST["email"];
            $phonenum = isset($_POST["phonenum"]) && !empty($_POST["phonenum"]) ? $_POST["phonenum"] : "NULL";
            $usauID = isset($_POST["usauID"]) && !empty($_POST["usauID"]) ? $_POST["usauID"] : "NULL";
            $gender = isset($_POST["gender"]) && !empty($_POST["gender"]) ? $_POST["gender"] : "NULL";

            // Create generic team
            $sql = "INSERT INTO player
            VALUES ('$username', '$password', '$firstname', '$lastname', '$email', $phonenum, NULL, $usauID, $gender)";

            if ($conn->query($sql) === TRUE) {
                echo "User Created And Logged In!";
                setcookie("user", $username, time() + (86400 * 30), "/"); // 86400 = 1 day
            }
            $conn->close();
            ?>
            <a href="user_profile.php">Okay</a>
        </main>
    </div>
</body>

</html>