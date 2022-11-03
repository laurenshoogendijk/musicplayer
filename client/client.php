<?php
session_start();

include '../server/db_resources.php';

$_SESSION['algestemd'] = 0;

$query = 'SELECT * FROM ' . $nowplaying;
$result = $dbConn->query($query);

while($row = $result->fetch_row()) {
  $now_playing = $row['muzieklijst_ID'];
}
if(isset($_SESSION['nowplaying'])) {
  if($_SESSION['nowplaying'] == $now_playing) {
    $_SESSION['algestemd'] = 1;
    header('location:voted.php');
  }
} else {
  $_SESSION['nowplaying'] = 'niks';
}
?>
<html>
  <head>
  </head>

  <body>
    <div>

<p />

Kies hieronder een van de volgende nummers:

<p />

<form action="vote.php" method="POST">

<?php
$query = 'SELECT * FROM ' . $votetable;
$result = $dbConn->query($query);

while($row = $result->fetch_row()) {
  echo '<input type="radio" name="keuze" value ="' . $row['ID'] . '" > ' . $row['Naam'] . '<p />';
}
?>

<input type="submit" value="klik hier om te stemmen!">
</form>

<p />

<?php
$query = 'SELECT * FROM ' . $votetable;
$result = $dbConn->query($query);
while($row = $result->fetch_row()) {
  echo 'Er is ' . $row['votecount'] . ' keer op "' . $row['Naam'] . '" gestemd.<p />';
}
?>

    </div>
  </body>
</html>
