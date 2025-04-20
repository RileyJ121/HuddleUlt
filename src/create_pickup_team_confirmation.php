<?php

if (isset($_COOKIE["user"])) {
    $loggedInUser = $_COOKIE["user"];

    include 'start_db.php';

    $name = $_POST["name"];
    $desc = isset($_POST["desc"]) && !empty($_POST["desc"]) ? "'" . $_POST["desc"] . "'" : "NULL";
    $lat = $_POST["lat"];
    $long = $_POST["long"];

    $skill = isset($_POST["skill"]) && !empty($_POST["skill"]) ? $_POST["skill"] : "NULL";
    $minage = isset($_POST["minage"]) && !empty($_POST["minage"]) ? $_POST["minage"] : "NULL";
    $maxage = isset($_POST["maxage"]) && !empty($_POST["maxage"]) ? $_POST["maxage"] : "NULL";
    $days = isset($_POST["days"]) && !empty($_POST["days"]) ? "'" . $_POST["days"] . "'" : "NULL";
    $fee = isset($_POST["fee"]) && !empty($_POST["fee"]) ? $_POST["fee"] : 0;

    // Create generic team
    $sql = "INSERT INTO team
            VALUES (NULL, '$name', '$desc', $lat, $long, '$loggedInUser')";
    $conn->query($sql);

    // Create club team
    $sql = "INSERT INTO pickupteam
            VALUES (LAST_INSERT_ID(), $fee, $days, $skill, $minage, $maxage)";
    $conn->query($sql);

    echo "Team Created!";

    $conn->close();

} else {
    echo "Please <a href=\"user_profile.php\">log in<a> before creating a team";
}

?>