<?php

session_start();

include 'db_resources.php';
if(!$_SESSION['isserver'] == 1) {
  header("location:../client/client.php");
}

$query_getnextsong = 'SELECT * FROM ' . $playlist . ' ORDER BY ID ASC LIMIT 1';
$result = $dbConn->query($query_getnextsong);
while($row = $result->fetch_row())
{
  $_SESSION['nextsong'] = $row['muzieklijst_ID'];

  $query_clear_currentsong = 'TRUNCATE TABLE ' . $nowplaying;
  $query_currentsong = 'INSERT INTO ' . $nowplaying . ' SET ID = NULL, muzieklijst_ID ="' . $row['muzieklijst_ID'] . '"';
  $query_removeplayed = 'DELETE FROM ' . $playlist . ' WHERE ID = "' . $row['ID'] . '"';

  $dbConn->query($query_clear_currentsong);
  $dbConn->query($query_currentsong);
  $dbConn->query($query_removeplayed);
}

header("location:server.php");
?>
