<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../public/team_profile.css" rel="stylesheet">
  <link href="../public/main.css" rel="stylesheet">
  <title>Huddle Ult</title>
</head>
<body>
    <?php
        $teamID = $_GET['teamID'];

        if (isset($teamID)) {
            include 'start_db.php';
            $sql = "SELECT * FROM Team WHERE TeamID = {$teamID}";
            $result = $conn -> query($sql);
            $team = $result -> fetch_assoc();

            $conn -> close();
        } else {
            $team = array("Name"=>"NO TEAM");
        }
        
    ?>
  <nav>
    <img src="../public/Logo.png" alt="Logo">
    <ul>
        <li><a href="home.html">Home</a></li>
        <li><a href="search_team.php">Search</a></li>
        <li><a href="player_activity.html">Activity</a></li>
        <li><a href="user_profile.php">Profile</a></li>
    </ul>
  </nav>
  <div class="bg">
    <main>
      <div class="header">
        <a href="search_team.php"><h3>🢀</h3></a>
        <h1><?php echo "{$team["Name"]}";?></h1>
      </div>
      <div class="main">
        
        <button>Join Team</button>
        <button>Leave Team</button>

        <br>
        <?php
            echo "<p><strong>Name:</strong> {$team["Name"]}</p>
                    <p><strong>Host:</strong> {$team["Host"]}</p>
                    <p><strong>Description:</strong> {$team["TeamDesc"]}</p>
                    <p><strong>Latitude:</strong> {$team["Latitude"]} <strong>Longitude:</strong> {$team["Longitude"]}</p>
            "; 
          
            // Check for club team info
            include 'start_db.php';
            $sql = "SELECT GenderDiv, AgeDiv, Captain 
                    FROM clubteam AS c
                    INNER JOIN team as t ON c.TeamID = t.TeamID
                    WHERE c.TeamID = {$team["TeamID"]}";
            $result = $conn -> query($sql);
            

            if ($result->num_rows > 0) {
                echo "<p><strong>Team Type:</strong> Club Team</p>";
                $clubTeamInfo = $result -> fetch_assoc();

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
                $result = $conn -> query($sql);

                echo "<h3>Players:</h3>";
                while($clubTeamPlayer = $result -> fetch_assoc()) {
                    echo "<li>
                            <a href='player_profile.php?username={$clubTeamPlayer["Username"]}'>
                                {$clubTeamPlayer["Fname"]} {$clubTeamPlayer["Lname"]} 
                                ({$clubTeamPlayer["Username"]})
                            </a>
                        </li>";

                }


            }

            $sql = "SELECT Fee, Days, Skill, MinAge, MaxAge
                    FROM pickupteam AS p
                    INNER JOIN team as t ON p.TeamID = t.TeamID
                    WHERE p.TeamID = {$team["TeamID"]}";
            $result = $conn -> query($sql);

            if ($result->num_rows > 0) {
                echo "<p><strong>Team Type:</strong> Pickup Team</p>";
                $pickupTeamInfo = $result -> fetch_assoc();

                echo "<p><strong>Fee:</strong> \${$pickupTeamInfo["Fee"]}</p>";
                echo "<p><strong>Days Played:</strong> {$pickupTeamInfo["Days"]}</p>";
                echo "<p><strong>Skill Level:</strong> {$pickupTeamInfo["Skill"]}</p>";
                echo "<p><strong>Age Range:</strong> {$pickupTeamInfo["MinAge"]}-{$pickupTeamInfo["MaxAge"]}</p>";

                $sql = "SELECT Username, Fname, Lname
                        FROM player as p
                        INNER JOIN pickupteamplayers as pu ON p.Username = pu.Player
                        WHERE pu.TeamID = {$teamID}";
                $result = $conn -> query($sql);

                echo "<h3>Players:</h3>";
                while($pickupTeamPlayer = $result -> fetch_assoc()) {
                    echo "<li>
                            <a href='player_profile.php?username={$pickupTeamPlayer["Username"]}'>
                                {$pickupTeamPlayer["Fname"]} {$pickupTeamPlayer["Lname"]} 
                                ({$pickupTeamPlayer["Username"]})
                            </a>
                        </li>";

                }

            }

            $conn -> close();

        ?>

      </div>
    </main>
  </div>
</body>
</html>