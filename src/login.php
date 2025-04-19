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
      <li><a href="player_activity.html">Activity</a></li>
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
        include 'start_db.php';

        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM player WHERE Username = '$username' AND Password = '$password'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();

          setcookie("user", $row["Username"], time() + (86400 * 30), "/"); // 86400 = 1 day
        

          echo "Logged In
          <a href=\"user_profile.php\">Done</a>";
        } else {
          echo "Log In Failed
          <a href=\"user_profile.php\">Try Again</a>";
        }
        ?>

        
      </div>
    </main>
  </div>
</body>

</html>