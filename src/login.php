<?php
include 'start_db.php';

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM player WHERE Username = '$username' AND Password = '$password'";

$result = $conn -> query($sql);

if($result->num_rows > 0) {
    $row = $result -> fetch_assoc();

    setcookie("user", $row["Username"], time() + (86400 * 30), "/"); // 86400 = 1 day
    

    echo "Logged In";
    echo "<a href=\"search_team.php\">Search</a>";
} else {
    echo "User Not Found";
}

?>