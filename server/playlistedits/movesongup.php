<?php

session_start();

if(!$_SESSION['isserver'] == 1) {
  header("location:../client/client.php");
}

include '../db_resources.php';

$songtomoveup = $_POST['playlistID'];
$idtomoveup = 0;
$songtomovedown = ($_POST['playlistID'] - 1);
$idtomovedown = 0;

$query_getsongtomoveup = 'SELECT * FROM playlist WHERE ID = "' . $songtomoveup . '"';
$query_getsongtomovedown = 'SELECT * FROM playlist WHERE ID = "' . $songtomovedown . '"';

$result_up = $dbConn->query($query_getsongtomoveup);
$result_down = $dbConn->query($query_getsongtomovedown);

while($row_up = $result_up->fetch_row()) {
  $idtomoveup = $row_up['muzieklijst_ID'];
}

while($row_down = $result_down->fetch_row()) {
  $idtomovedown = $row_down['muzieklijst_ID'];
}

$query_setnewsong_up = 'UPDATE playlist SET muzieklijst_ID="' . $idtomoveup . '" WHERE ID="' . $songtomovedown . '"';
$query_setnewsong_down = 'UPDATE playlist SET muzieklijst_ID="' . $idtomovedown . '" WHERE ID="' . $songtomoveup . '"';

$dbConn->query($query_setnewsong_up);
$dbConn->query($query_setnewsong_down);

header('location:../editplaylist.php');
?>
