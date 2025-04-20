<?php

if (isset($_COOKIE["user"])) {
    $loggedInUser = $_COOKIE["user"];
    include 'start_db.php';


    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $phonenum = isset($_POST["phonenum"]) && !empty($_POST["phonenum"]) ? $_POST["phonenum"] : "NULL";
    $usauID = isset($_POST["usauID"]) && !empty($_POST["usauID"]) ? $_POST["usauID"] : "NULL";
    $gender = isset($_POST["gender"]) && !empty($_POST["gender"]) ? $_POST["gender"] : "NULL";

    // Create generic team
    $sql = "UPDATE player
            SET Fname = '$firstname', Lname = '$lastname', Email = '$email', Phone = '$phonenum', UsauID = $usauID, Gender = $gender
            WHERE username = '$loggedInUser'";

    if ($conn->query($sql) === TRUE) {
        echo "Profile updated";
    }
    $conn->close();
}
?>