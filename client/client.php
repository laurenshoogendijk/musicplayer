<?php
session_start();

include '../server/db_resources.php';

$_SESSION['algestemd'] = 0;

$con = mysql_connect('localhost', $db_user, $db_pass);
$db = mysql_select_db($db_name);
$query = 'SELECT * FROM ' . $nowplaying;
$result = mysql_query($query) or die(mysql_error());
while($row = mysql_fetch_assoc($result))
{
$now_playing = $row['muzieklijst_ID'];
}
if(isset($_SESSION['nowplaying']))
{
  if($_SESSION['nowplaying'] == $now_playing)
  {
    $_SESSION['algestemd'] = 1;
    header('location:voted.php');
  }
}
else
{
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
$con = mysql_connect('localhost', $db_user, $db_pass);
$db = mysql_select_db($db_name);

$query = 'SELECT * FROM ' . $votetable;
$result = mysql_query($query) or die(mysql_error());

while($row = mysql_fetch_assoc($result))
{
echo '<input type="radio" name="keuze" value ="' . $row['ID'] . '" > ' . $row['Naam'] . '<p />';
}

?>

<input type="submit" value="klik hier om te stemmen!">
</form>

<p />

<?php
$query = 'SELECT * FROM ' . $votetable;
$result = mysql_query($query) or die(mysql_error());
while($row = mysql_fetch_assoc($result))
{
echo 'Er is ' . $row['votecount'] . ' keer op "' . $row['Naam'] . '" gestemd.<p />';
}

?>

    </div>
  </body>
</html>