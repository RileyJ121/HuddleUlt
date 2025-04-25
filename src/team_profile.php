<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../public/main.css" rel="stylesheet">
  <link href="../public/user_profile.css" rel="stylesheet">
  <link href="../public/team_profile.css" rel="stylesheet">
  <title>Huddle Ult</title>
</head>

<body>
  <?php
  $teamID = $_GET['teamID'];

  if (isset($teamID)) {
    include 'start_db.php';
    $sql = "SELECT * FROM Team WHERE TeamID = {$teamID}";
    $result = $conn->query($sql);
    $team = $result->fetch_assoc();

    $conn->close();
  } else {
    $team = array("Name" => "NO TEAM");
  }

  ?>
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
        <a href="search_team.php">
          <h3>🢀</h3>
        </a>
        <h1><?php echo "{$team["Name"]}"; ?></h1>
      </div>
      <div class="main">
        <?php

        if (isset($_COOKIE["user"])) {
          echo "
            <form method=\"post\">
            <input type=\"submit\" name=\"join\"
                    class=\"button\" value=\"Join Team\" />
            
            <input type=\"submit\" name=\"leave\"
                    class=\"button\" value=\"Leave Team\" />
            </form>
            <br>";
        }
        ?>

        
        <?php
        echo "<p><strong>Name:</strong> {$team["Name"]}</p>
                    <p><strong>Host:</strong> <a href='player_profile.php?username={$team["Host"]}'>{$team["Host"]}</a></p>
                    <p><strong>Description:</strong> {$team["TeamDesc"]}</p>
                    <p><strong>Latitude:</strong> {$team["Latitude"]} <strong>Longitude:</strong> {$team["Longitude"]}</p>
            ";

        $teamType = "";

        // Check for club team info
        include 'start_db.php';
        $sql = "SELECT GenderDiv, AgeDiv, Captain 
                    FROM clubteam AS c
                    INNER JOIN team as t ON c.TeamID = t.TeamID
                    WHERE c.TeamID = {$team["TeamID"]}";
        $result = $conn->query($sql);


        if ($result->num_rows > 0) {
          $teamType = "club";
          echo "<p><strong>Team Type:</strong> Club Team</p>";

          if (isset($_POST["join"])) {
              $sql = "UPDATE Player SET ClubID = {$teamID} WHERE Username = '{$_COOKIE["user"]}'";
              $result10 = $conn->query($sql);
          } else if (isset($_POST["leave"])) {
            $sql = "UPDATE Player SET ClubID = NULL WHERE Username = '{$_COOKIE["user"]}'";
            $result10 = $conn->query($sql);
          }

          $clubTeamInfo = $result->fetch_assoc();

          switch ($clubTeamInfo["GenderDiv"]) {
            case 1:
              $genderDiv = "Men";
              break;
            case 2:
              $genderDiv = "Woman";
              break;
            case 3:
              $genderDiv = "Mixed";
              break;
            default:
              $genderDiv = "...";
              break;
          }

          echo "<p><strong>Captain:</strong> {$clubTeamInfo["Captain"]}</p>";
          echo "<p><strong>Gender Division:</strong> {$genderDiv}</p>";

          switch ($clubTeamInfo["AgeDiv"]) {
            case 1:
              $ageDiv = "Youth";
              break;
            case 2:
              $ageDiv = "College";
              break;
            case 3:
              $ageDiv = "Open";
              break;
            case 4:
              $ageDiv = "Masters";
            case 5:
              $ageDiv = "Grandmasters";
            case 6:
              $ageDiv = "Great Grandmasters";
            default:
              $ageDiv = "...";
              break;
          }

          echo "<p><strong>Age Division:</strong> {$ageDiv}</p>";

          $sql = "SELECT Username, Fname, Lname
                        FROM player 
                        WHERE ClubID = '{$teamID}'";
          $result = $conn->query($sql);

          echo "<h3>Players:</h3>";
          while ($clubTeamPlayer = $result->fetch_assoc()) {
            echo "<li>
                            <a href='player_profile.php?username={$clubTeamPlayer["Username"]}'>
                                {$clubTeamPlayer["Fname"]} {$clubTeamPlayer["Lname"]} 
                                ({$clubTeamPlayer["Username"]})
                            </a>
                        </li>";

          }


        }

        // Check for Pickup Team info
        $sql = "SELECT Fee, Days, Skill, MinAge, MaxAge
                    FROM pickupteam AS p
                    INNER JOIN team as t ON p.TeamID = t.TeamID
                    WHERE p.TeamID = {$team["TeamID"]}";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          $teamType = "pickup";
          echo "<p><strong>Team Type:</strong> Pickup Team</p>";

          if (isset($_POST["join"])) {
            $sql = "SELECT * FROM PickupTeamPlayers WHERE TeamID = {$teamID} AND Player = '{$_COOKIE["user"]}'";
            $result10 = $conn->query($sql);
            if ($result10->num_rows == 0) {
              $sql = "INSERT INTO PickupTeamPlayers VALUES ({$teamID}, '{$_COOKIE["user"]}')";
              $result10 = $conn->query($sql);
            }
          } else if (isset($_POST["leave"])) {
            $sql = "DELETE FROM PickupTeamPlayers WHERE TeamID = {$teamID} AND Player = '{$_COOKIE["user"]}'";
            $result10 = $conn->query($sql);
          }

          $pickupTeamInfo = $result->fetch_assoc();

          echo "<p><strong>Fee:</strong> \${$pickupTeamInfo["Fee"]}</p>";
          echo "<p><strong>Days Played:</strong> {$pickupTeamInfo["Days"]}</p>";
          echo "<p><strong>Skill Level:</strong> {$pickupTeamInfo["Skill"]}</p>";
          echo "<p><strong>Age Range:</strong> {$pickupTeamInfo["MinAge"]}-{$pickupTeamInfo["MaxAge"]}</p>";

          $sql = "SELECT Username, Fname, Lname
                        FROM player as p
                        INNER JOIN pickupteamplayers as pu ON p.Username = pu.Player
                        WHERE pu.TeamID = {$teamID}";
          $result = $conn->query($sql);

          echo "<h3>Players:</h3>";
          while ($pickupTeamPlayer = $result->fetch_assoc()) {
            echo "<li>
                            <a href='player_profile.php?username={$pickupTeamPlayer["Username"]}'>
                                {$pickupTeamPlayer["Fname"]} {$pickupTeamPlayer["Lname"]} 
                                ({$pickupTeamPlayer["Username"]})
                            </a>
                        </li>";

          }

        }

        $sql = "SELECT LeagueID, Skill, Captain
                    FROM leagueteam AS l
                    INNER JOIN team as t ON l.TeamID = t.TeamID
                    WHERE l.TeamID = {$team["TeamID"]}";
        $result = $conn->query($sql);


        if ($result->num_rows > 0) {
          $teamType = "league";
          echo "<p><strong>Team Type:</strong> League Team</p>";

          if (isset($_POST["join"])) {
            $sql = "SELECT * FROM LeagueTeamPlayers WHERE TeamID = {$teamID} AND Player = '{$_COOKIE["user"]}'";
            $result10 = $conn->query($sql);
            if ($result10->num_rows == 0) {
              $sql = "INSERT INTO LeagueTeamPlayers VALUES ({$teamID}, '{$_COOKIE["user"]}')";
              $result10 = $conn->query($sql);
            }
          } else if (isset($_POST["leave"])) {
            $sql = "DELETE FROM LeagueTeamPlayers WHERE TeamID = {$teamID} AND Player = '{$_COOKIE["user"]}'";
            $result10 = $conn->query($sql);
          }

          $leagueTeamInfo = $result->fetch_assoc();

          echo "<p><strong>Skill Level:</strong> {$leagueTeamInfo["Skill"]}</p>";
          echo "<p><strong>Captain:</strong> {$leagueTeamInfo["Captain"]}</p>";

          $sql = "SELECT Username, Fname, Lname
                        FROM player as p
                        INNER JOIN leagueteamplayers as l ON p.Username = l.Player
                        WHERE l.TeamID = {$teamID}";
          $result = $conn->query($sql);

          echo "<h3>Players:</h3>";
          while ($leagueTeamPlayer = $result->fetch_assoc()) {
            echo "<li>
                            <a href='player_profile.php?username={$leagueTeamPlayer["Username"]}'>
                                {$leagueTeamPlayer["Fname"]} {$leagueTeamPlayer["Lname"]} 
                                ({$leagueTeamPlayer["Username"]})
                            </a>
                        </li>";

          }
        }

        $conn->close();

        ?>

      </div>
    </main>
  </div>
</body>

</html>