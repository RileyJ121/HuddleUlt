<?php

if (isset($_COOKIE["user"])) {
    $loggedInUser = $_COOKIE["user"];

    include 'start_db.php';

    $name = $_POST["name"];
    $fee = isset($_POST["fee"]) && !empty($_POST["fee"]) ? $_POST["fee"] : "NULL";
    $start = isset($_POST["start"]) && !empty($_POST["start"]) ? $_POST["start"] : "NULL";
    $end = isset($_POST["end"]) && !empty($_POST["end"]) ? $_POST["end"] : "NULL";
    $days = isset($_POST["days"]) && !empty($_POST["days"]) ? $_POST["days"] : "NULL";
    $minage = isset($_POST["minage"]) && !empty($_POST["minage"]) ? $_POST["minage"] : "NULL";
    $maxage = isset($_POST["maxage"]) && !empty($_POST["maxage"]) ? $_POST["maxage"] : "NULL";
    $ppt = isset($_POST["ppt"]) && !empty($_POST["ppt"]) ? $_POST["pptt"] : 21;
    $lat = $_POST["lat"];
    $long = $_POST["long"];

    // Create generic team
    $sql = "INSERT INTO league
            VALUES (NULL, '$name', $fee, $start, $end, $days, $minage, $maxage, $ppt, $lat, $long, '$loggedInUser')";
    $conn->query($sql);

    echo "League Created!";

    $conn->close();

} else {
    echo "Please <a href=\"user_profile.php\">log in<a> before creating a team";
}

?>