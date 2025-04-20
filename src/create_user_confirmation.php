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

if($conn->query($sql) === TRUE) {
    echo "User Created And Logged In!";
    setcookie("user", $username, time() + (86400 * 30), "/"); // 86400 = 1 day
}
$conn->close();
?>