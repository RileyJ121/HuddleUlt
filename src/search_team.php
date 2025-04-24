<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../public/search_team.css" rel="stylesheet">
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
        <h1>Find Teams</h1>
      </div>
      <div class="main">
        <?php
        echo isset($_COOKIE["user"]) ? $_COOKIE["user"] : "Not Logged In";
        echo "<br>";
        ?>

        <a href="create_club_team.html">New Club Team</a>
        <a href="create_league_team.html">New League Team</a>
        <a href="create_pickup_team.html">New Pickup Team</a>
        <form method="get">
          <label for="lat">Latitude:</label>
          <input type="text" id="lat" name="lat" value="">
          <label for="long">Longitude:</label>
          <input type="text" id="long" name="long" value=""><br>
          <input type="radio" id="team" name="team" value="0" checked="checked">
          <label for="pickup"> Any Team</label>
          <input type="radio" id="team" name="team" value="1">
          <label for="pickup"> Pickup Team</label>
          <input type="radio" id="team" name="team" value="2">
          <label for="club"> League Team</label>
          <input type="radio" id="team" name="team" value="3">
          <label for="league"> Club Team</label>
          <input type="submit" value="Submit">
        </form>
        <?php
        include 'start_db.php';
        $lat = isset($_GET['lat']) ? $_GET["lat"] : "";
        $long = isset($_GET['long']) ? $_GET["long"] : "";
        $team = isset($_GET['team']) ? $_GET["team"] : 0;

        $sql = "SELECT * FROM team WHERE 1 = 1";

        if ($long && $lat) {
          $sql = $sql . " AND ABS(longitude - $long) < 0.6 AND ABS(latitude - $lat) < 0.6";
        }

        if ($team > 0) {
          $teamList = array("pickupteam", "leagueteam", "clubteam");
          $sql = $sql . " AND TeamID IN (SELECT TeamID FROM " . $teamList[$team - 1] . ")";
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo $row["Name"] . " (Host: " . $row["Host"] . ")<br>" . $row["TeamDesc"] . "<br><br>";
          }
        } else {
          echo "0 Teams";
        }
        $conn->close();
        ?>
      </div>
    </main>
  </div>
</body>

</html>