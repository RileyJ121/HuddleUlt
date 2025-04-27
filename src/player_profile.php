<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../public/player_profile.css" rel="stylesheet">
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
        <a href="player_activity.php"><h3>🢀</h3></a>
        <h1><?php echo $_GET["username"]?></h1>
      </div>
      <div class="main">
        <?php 

          if (isset($_GET["username"])) {
            $playerUsername = $_GET['username'];
  
            include 'start_db.php';
            $sql = "SELECT Fname, Lname, ClubID, UsauID, Gender FROM player WHERE Username = '{$playerUsername}'";
            $result = $conn->query($sql);
  
            if ($result->num_rows > 0) {
              $user = $result->fetch_assoc();

              if (isset($_COOKIE["user"])) {
                echo "<form method=\"post\">";
                $sql = "SELECT * FROM follows WHERE Follows = '{$playerUsername}' AND Player = '{$_COOKIE["user"]}'";
                $result10 = $conn->query($sql);

                if ($result10->num_rows == 0) {
                  echo "<input type=\"submit\" name=\"follow\"
                          class=\"button\" value=\"Follow\" /> ";
                } else {
                  echo "<input type=\"submit\" name=\"unfollow\"
                          class=\"button\" value=\"Unfollow\" />";
                }

                if (isset($_POST["follow"])) {
                  if ($result10->num_rows == 0) {
                    $sql = "INSERT INTO follows VALUES ('{$_COOKIE["user"]}', '{$playerUsername}')";
                    $result10 = $conn->query($sql);
                    echo "<meta http-equiv='refresh' content='0'>";
                  }
                } else if (isset($_POST["unfollow"])) {
                  $sql = "DELETE FROM follows WHERE Follows = '{$playerUsername}' AND Player = '{$_COOKIE["user"]}'";
                  $result10 = $conn->query($sql);
                  echo "<meta http-equiv='refresh' content='0'>";
                }
   
                echo  "</form>";
              }

              
  
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
                      <p><strong>USAU ID:</strong> " . (isset($user['UsauID']) ? $user["UsauID"] : "No USAU ID found") . "</p>
                      <p><strong>Plays against:</strong> {$genderMatch}</p>
                    ";
  
              echo "<h2>{$playerUsername}'s Teams:</h2>";
  
              // First, check for a club team
              $sql = "SELECT * FROM clubteam as c
                      INNER JOIN team as t ON c.TeamID = t.TeamID
                      WHERE c.TeamID = '{$user["ClubID"]}' 
                            OR t.Host = '{$playerUsername}'";

              $result2 = $conn->query($sql);
              while ($clubTeam = $result2->fetch_assoc()) {
                echo "<div class='team'>
                        <h3>
                          <a href='team_profile.php?teamID={$clubTeam["TeamID"]}'>{$clubTeam["Name"]}</a> 
                          <span class='gray'>(Captain: {$clubTeam["Captain"]})</span>
                        </h3>
                        <span class='team-type'>Club Team</span>
                        <p>{$clubTeam["TeamDesc"]}</p>
                      </div>
                  ";
              }
  
              // Fetch League Teams
              $sql = "SELECT * FROM Team as t
                      INNER JOIN LeagueTeamPlayers as l ON  t.TeamID = l.TeamID
                      WHERE l.Player = '{$playerUsername}'
                            OR (t.Host = '{$playerUsername}' AND t.Host=l.Player)";
  
              $result2 = $conn->query($sql);
              while ($leagueTeam = $result2->fetch_assoc()) {
                echo "<div class='team'>
                        <h3>
                          <a href='team_profile.php?teamID={$leagueTeam["TeamID"]}'>{$leagueTeam["Name"]}</a>
                          <span class='gray'>(Host: {$leagueTeam["Host"]})</span>
                        </h3>
                        <span class='team-type'>League Team</span>
                        <p> {$leagueTeam["TeamDesc"]} </p>
                      </div>
                ";
              }
  
              // Fetch Pickup Teams
              $sql = "SELECT * FROM Team as t
                      INNER JOIN PickupTeamPlayers as p ON t.TeamID = p.TeamID
                      WHERE p.Player = '{$playerUsername}'
                            OR (t.Host = '{$playerUsername}' AND t.Host=p.Player)";
  
              $result2 = $conn->query($sql);

              while ($pickupTeam = $result2->fetch_assoc()) {
                echo "<div class='team'>
                        <h3>
                          <a href='team_profile.php?teamID={$pickupTeam["TeamID"]}'>{$pickupTeam["Name"]}</a>
                          <span class='gray'>(Host: {$pickupTeam["Host"]})</span>
                        </h3> 
                        <span class='team-type'>Pickup Team</span>
                        <p> {$pickupTeam["TeamDesc"]} </p>
                      </div>
                ";
              }
            } else {
              echo "An error has occurred";
            }
  
  
            $conn->close();

          }
        ?>
      </div>
    </main>
  </div>
</body>
</html>