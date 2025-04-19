<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../public/main.css" rel="stylesheet">
  <link href="../public/user_profile.css" rel="stylesheet">
  <title>Huddle Ult</title>
</head>
<body>
  <nav>
    <img src="../public/Logo.png" alt="Logo">
    <ul>
        <li><a href="home.html">Home</a></li>
        <li><a href="search_team.php">Search</a></li>
        <li><a href="player_activity.html">Activity</a></li>
        <li><a href="user_profile.html">Profile</a></li>
    </ul>
  </nav>
  <div class="bg">
    <main>
      <div class="header">
        <a href="home.html"><h3>🢀</h3></a>
        <h1>Profile</h1>
      </div>
      <div class="main">
        <li><a href="create_user.html">New User</a></li>
        <li><a href="edit_user_profile.html">Edit User</a></li>

        <form action="login.php" method="post">
          <label for="fname">Username:</label>
          <input type="text" id="username" name="username" value="" required>
          <label for="fname">Password:</label>
          <input type="text" id="password" name="password" value="" required>
          <input type="submit" value="Log In">
        </form>

        <form action="logout.php">
          <input type="submit" Value="Log Out">
        </form>

        <br>

        <?php

          if (isset($_COOKIE["user"])) {
            $loggedInUser = $_COOKIE["user"];
            echo "<h2>{$loggedInUser}'s Player Info</h2>";


            include 'start_db.php';
            $sql = "SELECT Fname, Lname, Email, Phone, ClubID, UsauID, Gender FROM player WHERE Username = '$loggedInUser'";
            $result = $conn -> query($sql);

            if($result->num_rows > 0) {
              $user = $result -> fetch_assoc();

              switch ($user["Gender"]) {
                case 1:
                  $genderMatch = "Men";
                  break;
                case 2:
                  $genderMatch = "Woman";
                  break;
                case 3:
                  $genderMatch = "Mixed";
                  break;
                default:
                  $genderMatch = "...";
                  break;
              }
              
              echo "<p><strong>Name:</strong> {$user["Fname"]} {$user["Lname"]}</p>
                    <p><strong>Email:</strong> {$user["Email"]}</p>
                    <p><strong>Phone Number:</strong> {$user["Phone"]}</p>
                    <p><strong>USAU ID:</strong> " . (isset($user['UsauID'])? $user["UsauID"]: "No USAU ID found") . "</p>
                    <p><strong>Plays against:</strong> {$genderMatch}</p>
                  ";

              echo "<h2>{$loggedInUser}'s Teams:</h2>
                    
              ";

              // First, check for a club team
              if (isset($user["ClubID"])) {
                $sql = "SELECT * FROM clubteam as c
                        INNER JOIN team as t ON c.TeamID = t.TeamID
                        WHERE c.TeamID = '{$user["ClubID"]}'
                ";

                $result2 = $conn -> query($sql);
                $clubTeam = $result2 -> fetch_assoc();

                if (isset($clubTeam)) {
                  echo "<div class='team-listing'>
                          <h3>Club Team: </h3>{$clubTeam["Name"]} (Captain: {$clubTeam["Captain"]})
                          <p>{$clubTeam["TeamDesc"]}</p>
                          <a href='team_profile.php?teamID={$clubTeam["TeamID"]}'>View More Info</a> 
                        </div>
                  ";


                } else {
                  echo "An error occurred when fetching data.";
                }


              } else {
                echo "{$loggedInUser} is not in a Club Team";
              }

              // Fetch League Teams
              $sql = "SELECT Name, TeamDesc, Host FROM Team as t
                      INNER JOIN LeagueTeamPlayers as l ON  t.TeamID = l.TeamID
                      WHERE l.Player = '{$loggedInUser}'
              ";
              $result2 = $conn -> query($sql);
              while($leagueTeam = $result2 -> fetch_assoc()) {
                echo "<div class='team-listing'>
                        <h3>League Team: </h3> 
                        {$leagueTeam["Name"]} (Host: {$leagueTeam["Host"]})
                        <p> {$leagueTeam["TeamDesc"]} </p>
                        <a href='team_profile.php?teamID={$leagueTeam["TeamID"]}'>View More Info</a>
                      </div>
                ";
              }

              // Fetch Pickup Teams
              $sql = "SELECT Name, TeamDesc, Host, p.TeamID FROM Team as t
                      INNER JOIN PickupTeamPlayers as p ON  t.TeamID = p.TeamID
                      WHERE p.Player = '{$loggedInUser}'
                      ";

              $result2 = $conn -> query($sql);
              while($pickupTeam = $result2 -> fetch_assoc()) {
                echo "<div class='team-listing'>
                        <h3>Pickup Team: </h3> 
                        {$pickupTeam["Name"]} (Host: {$pickupTeam["Host"]})
                        <p> {$pickupTeam["TeamDesc"]} </p>
                        <a href='team_profile.php?teamID={$pickupTeam["TeamID"]}'>View More Info</a>
                      </div>
                ";
              }

            } else {
              echo "An error has occurred";
            }


            $conn -> close();

          } else {
            echo "<h2>You are not logged in</h2>";
          }

        ?>

      </div>
    </main>
  </div>
</body>
</html>