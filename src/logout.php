<?php
setcookie("user", "", time() - 3600, "/");

echo "Logged Out";
echo "<a href=\"search_team.php\">Search</a>";
?>