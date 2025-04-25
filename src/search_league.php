<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../public/search_league.css" rel="stylesheet">
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
        <a href="create_league_team.html"><h3>🢀</h3></a>
        <h1>Find Leagues</h1>
      </div>
      <div class="main">
        <form class="search" method="get">
          <div class="box">
            <label>Latitude</label> <br>
            <input type="text" id="lat" name="lat" placeholder="xx.xxxx">
          </div>
          <div class="box">
            <label>Longitude</label> <br>
            <input type="text" id="long" name="long" placeholder="xx.xxxx">
          </div>
          <div class="box">
            <label>Team Type</label> <br>
            <select name="team" id="team">
              <option value="0">Any</option>
              <option value="1">Pickup</option>
              <option value="2">League</option>
              <option value="3">Club</option>
            </select>
          </div>
          <div class="submit">
            <label></label> <br>
            <input type="submit" value="&#x1F50E;&#xFE0E;">
          </div>
        </form>
        <p class="or">Or :
          <a href="create_league.html">Create a League</a>
        </p>

        <div class="team_list">
          <?php
          include 'start_db.php';
          $lat = isset($_GET['lat']) ? $_GET["lat"] : "";
          $long = isset($_GET['long']) ? $_GET["long"] : "";

          $sql = "SELECT * FROM league WHERE 1 = 1";

          if ($long && $lat) {
            $sql = $sql . " AND ABS(longitude - $long) < 0.6 AND ABS(latitude - $lat) < 0.6";
          }

          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<div class=\"team\">
                      <p class=\"title\"><a><strong>{$row["Name"]}</strong></a> (Host: {$row["Host"]}) (ID: {$row["LeagueID"]})<p>
                    </div>";
            }
          } else {
            echo "0 Leagues";
          }
          $conn->close();
          ?>
        </div>
      </div>
    </main>
  </div>
</body>
</html>