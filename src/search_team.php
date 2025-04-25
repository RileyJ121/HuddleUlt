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
        <div class="search">
          <label class="text">Latitude</label>
          <label class="text" for="long">Longitude</label>
          <label class="select">Team Type</label>
          <label class="submit"></label>
        </div>
        <form class="search" method="get">
          <input type="text" id="lat" name="lat" placeholder="xx.xxxx">
          <input type="text" id="long" name="long" placeholder="xx.xxxx">
          <select name="team" id="team">
            <option value="0">Any</option>
            <option value="1">Pickup</option>
            <option value="2">League</option>
            <option value="3">Club</option>
          </select>
          <input type="submit" value="&#x1F50E;&#xFE0E;">
        </form>
        <p class="or">Or Create a Team:
          <a class="create" href="create_club_team.html">Pickup</a>,
          <a class="create" href="create_league_team.html">League</a>,
          <a class="create" href="create_pickup_team.html">Club</a>
        </p>

        <br>

        <div class="team_list">
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
              echo "<div class=\"team\">
                      <p class=\"title\"><a href=\"team_profile.php?teamID={$row["TeamID"]}\"><strong>{$row["Name"]}</strong></a> (Host: {$row["Host"]})<p>
                      <p>{$row["TeamDesc"]}</p>
                    </div>";
            }
          } else {
            echo "0 Teams";
          }
          $conn->close();
          ?>
        </div>
      </div>
    </main>
  </div>
</body>

</html>