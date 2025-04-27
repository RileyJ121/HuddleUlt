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
            <div class="box">
              <label>First Name*</label>
              <input type="text" id="firstname" name="firstname" value=<?php echo $user["Fname"] ?> required/><br />
            </div><br>
            <div class="box">
              <label>Last Name*</label>
              <input type="text" id="lastname" name="lastname" value=<?php echo $user["Lname"] ?> required/><br />
            </div><br>
            <div class="box">
              <label>Email*</label>
              <input type="text" id="email" name="email" value=<?php echo $user["Email"] ?> required/><br />
            </div><br>
            <div class="box">
              <label>Phone Number</label>
              <input type="text" id="phonenum" name="phonenum" value=<?php echo $user["Phone"] ?> /><br />
            </div><br>
            <div class="box">
              <label>USAU ID</label>
              <input type="text" id="usauID" name="usauID" value=<?php echo $user["UsauID"] ?> /><br />
            </div><br>
            <div class="box">
              <label>Gender Matching</label>
              <select name="gender" id="gender">
                <?php if($user["Gender"]==2) echo "<option value=\"2\">Female</option>";?>
                <option value="1">Male</option>
                <?php if($user["Gender"]==1) echo "<option value=\"2\">Female</option>";?>
              </select>
            </div><br>
            <input type="submit" value="Submit" />
          </form>
          <br><br>
          <form action="delete_user_confirmation.php" method="POST">
            <input type="submit" name="delete" value="Delete User" class="delete-button"  />  
          </form>
      </div>
    </main>
  </div>
</body>

</html>