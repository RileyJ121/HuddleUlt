<?php

if (isset($_COOKIE["user"])) {
  $loggedInUser = $_COOKIE["user"];

  include 'start_db.php';

  $sql = "SELECT * FROM player WHERE Username = '$loggedInUser'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
  }
}

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="../public/edit_user_profile.css" rel="stylesheet" />
  <link href="../public/main.css" rel="stylesheet" />
  <title>Huddle Ult</title>
</head>

<body>
  <nav>
    <img src="../public/Logo.png" alt="Logo" />
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
        <h1>Edit Profile</h1>
      </div>
      <div class="main">
        
        <form action="edit_user_confirmation.php" method="POST">
          <label for="firstname">First Name:</label>
          <input type="text" id="firstname" name="firstname" value=<?php echo $user["Fname"] ?> required /><br />
          <label for="lastname">Last Name:</label>
          <input type="text" id="lastname" name="lastname" value=<?php echo $user["Lname"] ?> required /><br />
          <label for="email">Email:</label>
          <input type="text" id="email" name="email" value=<?php echo $user["Email"] ?> required /><br />
          <label for="phonenum">Phone Number:</label>
          <input type="text" id="phonenum" name="phonenum"  value=<?php echo $user["Phone"] ?> /><br />
          <label for="usauID">USAU ID:</label>
          <input type="text" id="usauID" name="usauID" value=<?php echo $user["UsauID"] ?> /><br />
          <fieldset>
            <legend>Gender Matching Player</legend>
            <?php 
            if($user["Gender"]==1) {
              echo "<input type=\"radio\" id=\"gender\" name=\"gender\" value=\"1\" checked >
              <label for=\"pickup\">Male</label>";
            } else {
              echo "<input type=\"radio\" id=\"gender\" name=\"gender\" value=\"1\" >
              <label for=\"pickup\">Male</label>";
            }
            if($user["Gender"]==2) {
              echo "<input type=\"radio\" id=\"gender\" name=\"gender\" value=\"2\" checked >
              <label for=\"pickup\">Female</label>";
            } else {
              echo "<input type=\"radio\" id=\"gender\" name=\"gender\" value=\"2\" >
              <label for=\"pickup\">Female</label>";
            }
            ?>
          </fieldset>
          <input type="submit" value="Submit" />
        </form>
      </div>
    </main>
  </div>
</body>

</html>