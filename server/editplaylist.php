<?php

session_start();
if(!$_SESSION['isserver'] == 1)
  header("location:../client/client.php");
}
?>

<html>
  <head>
  </head>

  <body>


<?php

include 'db_resources.php';

$con = mysql_connect("localhost", $db_user, $db_pass);
mysql_select_db($db_name);

$query_get_playlist = 'SELECT * FROM ' . $playlist;
$query_get_musiclist = 'SELECT * FROM ' . $musiclist;

echo '<form action = "playlistedits/clearplaylist.php" method="POST">';
echo '<input type="submit" value="Maak playlist leeg">';
echo '</form>';

echo '<table border = "1" width="100%"><tr><td width="50%"><h2>Playlist</h2></td><td width="50%"><h2>Muzieklijst</h2></td></tr><tr><td valign="top"><br />';

$result = mysql_query($query_get_playlist) or die(mysql_error());

$num_records = mysql_num_rows($result);
$counter = 1;

while($row = mysql_fetch_assoc($result))
{

  $query_getnamebyid = 'SELECT * FROM ' . $musiclist . ' WHERE ID = "' . $row['muzieklijst_ID'] . '"';
  $result_getnamebyid = mysql_query($query_getnamebyid) or die(mysql_error());
  while($row_getnamebyid = mysql_fetch_assoc($result_getnamebyid))
  {

    echo '<form>';
    if($counter != 1)
    {
    echo '<input type="image" src="./images/btn_up.png" width="15" formaction="playlistedits/movesongup.php" formmethod="POST"> ';
    }

    if($counter != $num_records)
    {
    echo '<input type="image" src="./images/btn_down.png" width="15" formaction="playlistedits/movesongdown.php" formmethod="POST"> ';
    }
    echo '<input type="image" src="./images/btn_del.png" width="15" formaction="playlistedits/removesong.php" formmethod="POST"> ';
    echo '<input type = "hidden" name="playlistID" value = "' . $row['ID'] . '">';
    echo $row_getnamebyid['Naam'];
    echo '</form><br />';

    $counter ++;

  }
}

echo '</td><td valign="top"><br />';

$result = mysql_query($query_get_musiclist) or die(mysql_error());
while($row = mysql_fetch_assoc($result))
{
  echo '<form>';
  echo '<input type="image" src="./images/btn_left.png" width="15" formaction="playlistedits/addsong.php" formmethod="POST">';
  echo '<input type="hidden" name="muzieklijstID" value = "' . $row['ID'] . '"> ' . $row['Naam'] . '</form><br />';
}

echo '</td></tr></table>';

?>


  </body>
</html>
