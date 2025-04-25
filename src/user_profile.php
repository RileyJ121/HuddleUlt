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
      <li><a href="player_activity.php">Activity</a></li>
      <li><a href="user_profile.php">Profile</a></li>
    </ul>
  </nav>
  <div class="bg">
    <main>
      <div class="header">
        <a href="home.html">
          <h3>🢀</h3>
        </a>
        <h1>Profile</h1>
      </div>
      <div class="main">
        <?php
        if (isset($_COOKIE["user"])) {
          $loggedInUser = $_COOKIE["user"];

          include 'start_db.php';
          $sql = "SELECT Fname, Lname, Email, Phone, ClubID, UsauID, Gender FROM player WHERE Username = '$loggedInUser'";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

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

            echo "<div class=\"box\">
                    <label>Name</label> <br>
                    <p>{$user["Fname"]} {$user["Lname"]}</p>
                  </div>";
            echo "<div class=\"box\">
                    <label>Email</label> <br>
                    <p>{$user["Email"]}</p>
                  </div>";
            echo "<div class=\"box\">
                    <label>Phone</label> <br>
                    <p>{$user["Phone"]}</p>
                  </div>";
            echo "<div class=\"box\">
                    <label>USAU ID</label> <br>
                    <p>" . (isset($user['UsauID']) ? $user["UsauID"] : "No USAU ID found") . "</p>
                  </div>";
            echo "<div class=\"box\">
                    <label>Gender Match</label> <br>
                    <p>{$genderMatch}</p>
                  </div>";
            ?>
            <div class="box">
              <label><a class="create" href="edit_user_profile.php">Edit Profile</a> or <a class="create"
                  href="logout.php">Log Out</a></label>
            </div>

            <div class="team_list">
              <h4>Your Teams:</h4>
              <?php
              // First, check for a club team
              $sql = "SELECT * FROM clubteam as c
                    INNER JOIN team as t ON c.TeamID = t.TeamID
                    WHERE c.TeamID = '{$user["ClubID"]}' 
                          OR t.Host = '{$loggedInUser}'";

              $result2 = $conn->query($sql);
              while ($clubTeam = $result2->fetch_assoc()) {
                echo "<div class=\"team\">
                      <p class=\"title\"><a href=\"team_profile.php?teamID={$clubTeam["TeamID"]}\"><strong>{$clubTeam["Name"]}</strong></a> (Host: {$clubTeam["Host"]})<p>
                      <p>{$clubTeam["TeamDesc"]}</p>
                    </div>";
              }

              // Fetch League Teams
              $sql = "SELECT * FROM Team as t
                    INNER JOIN LeagueTeamPlayers as l ON  t.TeamID = l.TeamID
                    WHERE l.Player = '{$loggedInUser}'
                          OR (t.Host = '{$loggedInUser}' AND t.Host=l.Player)";

              $result2 = $conn->query($sql);
              while ($leagueTeam = $result2->fetch_assoc()) {
                echo "<div class=\"team\">
                      <p class=\"title\"><a href=\"team_profile.php?teamID={$leagueTeam["TeamID"]}\"><strong>{$leagueTeam["Name"]}</strong></a> (Host: {$leagueTeam["Host"]})<p>
                      <p>{$leagueTeam["TeamDesc"]}</p>
                    </div>";
              }

              // Fetch Pickup Teams
              $sql = "SELECT * FROM Team as t
                    INNER JOIN PickupTeamPlayers as p ON t.TeamID = p.TeamID
                    WHERE p.Player = '{$loggedInUser}'
                          OR (t.Host = '{$loggedInUser}' AND t.Host=p.Player)";

              $result2 = $conn->query($sql);
              while ($pickupTeam = $result2->fetch_assoc()) {
                echo "<div class=\"team\">
                      <p class=\"title\"><a href=\"team_profile.php?teamID={$pickupTeam["TeamID"]}\"><strong>{$pickupTeam["Name"]}</strong></a> (Host: {$pickupTeam["Host"]})<p>
                      <p>{$pickupTeam["TeamDesc"]}</p>
                    </div>";
              }
          } else {
            echo "An error has occurred";
          }

          echo "</div>";


          $conn->close();

        } else {
          echo "<h4>Log In:</h4>
          <form class=\"search\" action=\"login.php\" method=\"post\">
            <div class=\"box\">
              <label>Username</label> <br>
              <input type=\"text\" id=\"username\" name=\"username\" placeholder=\"username\" required>
            </div>
            <div class=\"box\">
              <label>Password</label> <br>
              <input type=\"text\" id=\"password\" name=\"password\" placeholder=\"∗∗∗∗∗∗∗∗\" required>
            </div>
            <div class=\"submit\">
              <label></label> <br>
              <input type=\"submit\" value=\"&crarr;\">
            </div>
          </form>";
          echo "<p class=\"or\">Or
                  <a href=\"create_user.html\">Create a User</a>
                </p>";
        }
        ?>
        </div>
    </main>
  </div>
</body>

</html>