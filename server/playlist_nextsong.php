<?php

session_start();

include 'db_resources.php';
if(!$_SESSION['isserver'] == 1) {
  header("location:../client/client.php");
}

$con = mysql_connect("localhost", $db_user, $db_pass);
mysql_select_db($db_name);

$query_getnextsong = 'SELECT * FROM ' . $playlist . ' ORDER BY ID ASC LIMIT 1';
$result = mysql_query($query_getnextsong) or die(mysql_error());
while($row = mysql_fetch_assoc($result))
{
  $_SESSION['nextsong'] = $row['muzieklijst_ID'];

  $query_clear_currentsong = 'TRUNCATE TABLE ' . $nowplaying;
  $query_currentsong = 'INSERT INTO ' . $nowplaying . ' SET ID = NULL, muzieklijst_ID ="' . $row['muzieklijst_ID'] . '"';
  $query_removeplayed = 'DELETE FROM ' . $playlist . ' WHERE ID = "' . $row['ID'] . '"';

  mysql_query($query_clear_currentsong) or die(mysql_error());
  mysql_query($query_currentsong) or die(mysql_error());
  mysql_query($query_removeplayed) or die(mysql_error());
}

header("location:server.php");
?>
