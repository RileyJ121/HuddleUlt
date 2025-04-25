<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../public/player_activity.css" rel="stylesheet">
  <link href="../public/main.css" rel="stylesheet">
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
        <h1>Activity</h1>
      </div>
      <div class="main">
        <div>
          <div class="team_list">
            <?php
            if (isset($_COOKIE["user"])) {
              include 'start_db.php';
              $loggedInUser = $_COOKIE["user"];
              // Fetch League Teams
              $sql = "SELECT Team.TeamID, Name, TeamDesc, Count(*)
                    FROM Team, LeagueTeamPlayers
                    WHERE Team.TeamID = LeagueTeamPlayers.TeamID
                    AND Player IN (SELECT Follows FROM Follows WHERE Player = '$loggedInUser')
                    GROUP BY Team.TeamID";
              $result1 = $conn->query($sql);
              if ($result1->num_rows > 0) {
                echo "<h4>League Teams</h4>";
                while ($leagueTeam = $result1->fetch_assoc()) {
                  echo "<div class=\"team\">
                    <p class=\"title\"><a href=\"team_profile.php?teamID={$leagueTeam["TeamID"]}\"><strong>{$leagueTeam["Name"]}</strong></a> (Following {$leagueTeam["Count(*)"]} Players)<p>
                    <p>{$leagueTeam["TeamDesc"]}</p>
                    </div>";
                }
              }

              // Fetch Pickup Teams
              $sql = "SELECT Team.TeamID, Name, TeamDesc, Count(*)
                    FROM Team, PickupTeamPlayers
                    WHERE Team.TeamID = PickupTeamPlayers.TeamID
                    AND Player IN (SELECT Follows FROM Follows WHERE Player = '$loggedInUser')
                    GROUP BY Team.TeamID";
              $result2 = $conn->query($sql);
              if ($result2->num_rows > 0) {
                echo "<h4>Pickup Teams</h4>";
                while ($pickupTeam = $result2->fetch_assoc()) {
                  echo "<div class=\"team\">
                    <p class=\"title\"><a href=\"team_profile.php?teamID={$pickupTeam["TeamID"]}\"><strong>{$pickupTeam["Name"]}</strong></a> (Following {$pickupTeam["Count(*)"]} Players)<p>
                    <p>{$pickupTeam["TeamDesc"]}</p>
                    </div>";
                }
              }

              // Fetch Club Teams
              $sql = "SELECT Team.TeamID, Name, TeamDesc, Count(*)
                        FROM Player, Team
                        WHERE TeamID = ClubID
                        AND Username IN (SELECT Follows FROM Follows WHERE Player = '$loggedInUser')
                        GROUP BY TeamID";
              $result3 = $conn->query($sql);
              if ($result3->num_rows > 0) {
                echo "<h4>Club Teams</h4>";
                while ($clubTeam = $result3->fetch_assoc()) {
                  echo "<div class=\"team\">
                    <p class=\"title\"><a href=\"team_profile.php?teamID={$clubTeam["TeamID"]}\"><strong>{$clubTeam["Name"]}</strong></a> (Following {$clubTeam["Count(*)"]} Players)<p>
                    <p>{$clubTeam["TeamDesc"]}</p>
                    </div>";
                }
              }
            } else {
              echo "Please Log In";
            }
            ?>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>

</html>
<?php
/*
Select Team.TeamID, Name, TeamDesc, Count(*) From Team, LeagueTeamPlayers Where Team.TeamID = LeagueTeamPlayers.TeamID AND Player In (Select Follows From Follows Where Player = "Noah.W") Group By Team.TeamID;

Select Team.TeamID, Name, TeamDesc, Count(*) From Team, PickupTeamPlayers Where Team.TeamID = PickupTeamPlayers.TeamID AND Player In (Select Follows From Follows Where Player = "Noah.W") Group By Team.TeamID;

Select TeamID, Name, TeamDesc, Count(*) From Player, Team where TeamID = ClubID AND Username In (Select Follows From Follows Where Player = "Noah.W") Group By TeamID;
*/
?>