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
        <li><a href="create_league.html">New League</a></li>
        <form action="search_league.php" method="GET">
          <label for="fname">Longitude:</label>
          <input type="text" id="fname" name="fname" value="">
          <label for="lname">Latitude:</label>
          <input type="text" id="lname" name="lname" value=""><br>
          <input type="submit" value="Submit">
        </form>
        <?php
        include 'start_db.php';
        $lat = isset($_GET['lat']) ? $_GET["lat"] : "";
        $long = isset($_GET['long']) ? $_GET["long"] : "";
        
        $sql = "SELECT * FROM league";

        if($long && $lat) {
          $sql = $sql . "WHERE ABS(longitude - $long) < 0.6 AND ABS(latitude - $lat) < 0.6";
        }

        $result = $conn -> query($sql);

        if($result->num_rows > 0) {
          while($row = $result -> fetch_assoc()) {
            echo $row["Name"] . " (Host: " . $row["Host"] . ")<br><br>";
          }
        } else {
          echo "0 Leagues";
        }
        $conn -> close();
      ?>
      </div>
    </main>
  </div>
</body>
</html>