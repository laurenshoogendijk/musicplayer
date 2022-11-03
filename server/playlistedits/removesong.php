<?php

session_start();

if(!$_SESSION['isserver'] == 1) {
  header("location:../client/client.php");
}

$playlistID = $_POST['playlistID'];

include '../db_resources.php';

$query_removesong = 'DELETE FROM playlist WHERE ID = "' . $playlistID . '"';
$query_update_ai = 'SELECT * FROM playlist';

$dbConn->query($query_removesong);
$result_update_ai = $dbConn->query($query_update_ai);
$counter = 1;

while($row_update_ai = $result_update_ai->fetch_row()) {
  $query1 = 'UPDATE playlist set muzieklijst_ID="' . $row_update_ai['muzieklijst_ID'] . '" WHERE ID="' . $counter . '"';
  $dbConn->query($query1);
  if($dbConn->affected_rows == 0) {
    $dbConn->query('DELETE FROM playlist WHERE ID = "' . $row_update_ai['ID'] . '"');
    $dbConn->query('INSERT INTO playlist SET ID="' . $counter . '", muzieklijst_ID="' . $row_update_ai['muzieklijst_ID'] . '"');
  }
  $counter++;
}

header('location:../editplaylist.php');
?>
