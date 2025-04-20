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
        echo "Captaining player does not exist";
    }

    $conn->close();

} else {
    echo "Please <a href=\"user_profile.php\">log in<a> before creating a team";
}

?>