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
          
            include 'start_db.php';
            $sql = "SELECT GenderDiv, AgeDiv, Captain 
                    FROM clubteam AS c
                    INNER JOIN team as t ON c.TeamID = t.TeamID
                    WHERE c.TeamID = {$team["TeamID"]}";
            $result = $conn -> query($sql);
            

            if ($result->num_rows > 0) {
                echo "<p><strong>Team Type:</strong> League Team</p>";
                $clubTeamInfo = $result -> fetch_assoc();

            }

            $conn -> close();

        ?>
        
        <br><br>

        Name: [Team Name]
        Host: [Host Username]
        Description: [Description]
        Latitude: [Latitude]
        Longitude: [Longitude]

        Player List:
        <div>
          Username: [Username]
          Name: [First Name] [Last Initial]
        </div>
      </div>
    </main>
  </div>
</body>
</html>