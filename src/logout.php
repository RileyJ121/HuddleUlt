<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../public/home.css" rel="stylesheet">
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
        <a href="user_profile.php">
          <h3>🢀</h3>
        </a>
        <h1>Title</h1>
      </div>
      <div class="main">
        <?php
        setcookie("user", "", time() - 3600, "/");

        echo "Logged Out";
        ?>
        <a href="user_profile.php">Okay</a>
      </div>
    </main>
  </div>
</body>

</html>