<?php
session_start();

include '../server/db_resources.php';

$query = 'SELECT * FROM ' . $nowplaying;
$result = $dbConn->query($query);
$now_playing = "niks";

while($row = $result->fetch_row()) {
  $now_playing = $row['muzieklijst_ID'];
}

if($_SESSION['nowplaying'] == $now_playing) {
  $_SESSION['algestemd'] = 1;
  header('location:voted.php');
}

$id_1_votes = 0;
$id_2_votes = 0;
$id_3_votes = 0;
$id_4_votes = 0;
$id_5_votes = 0;

//aantal stemmen per ID ophalen om er 1 bij op te tellen.
$query = 'SELECT * FROM ' . $votetable;
$result = $dbConn->query($query);

while($row = $result->fetch_row()) {
  switch ($row['ID']) {
    case 1:
      $id_1_votes = $row['votecount'];
      break;

    case 2:
      $id_2_votes = $row['votecount'];
      break;

    case 3:
      $id_3_votes = $row['votecount'];
      break;

    case 4:
      $id_4_votes = $row['votecount'];
      break;

    case 5:
      $id_5_votes = $row['votecount'];
      break;
  }
}

switch($_POST['keuze']) {
  case 1:
    $id_1_votes += 1;
    break;

  case 2:
    $id_2_votes += 1;
    break;

  case 3:
    $id_3_votes += 1;
    break;

  case 4:
    $id_4_votes += 1;
    break;

  case 5:
    $id_5_votes += 1;
    break;
}


$query_updatevotes_1 = 'UPDATE ' . $votetable . ' SET votecount="' . $id_1_votes . '" WHERE ID = "1"';
$query_updatevotes_2 = 'UPDATE ' . $votetable . ' SET votecount="' . $id_2_votes . '" WHERE ID = "2"';
$query_updatevotes_3 = 'UPDATE ' . $votetable . ' SET votecount="' . $id_3_votes . '" WHERE ID = "3"';
$query_updatevotes_4 = 'UPDATE ' . $votetable . ' SET votecount="' . $id_4_votes . '" WHERE ID = "4"';
$query_updatevotes_5 = 'UPDATE ' . $votetable . ' SET votecount="' . $id_5_votes . '" WHERE ID = "5"';

$dbConn->query($query_updatevotes_1);
$dbConn->query($query_updatevotes_2);
$dbConn->query($query_updatevotes_3);
$dbConn->query($query_updatevotes_4);
$dbConn->query($query_updatevotes_5);

$query_update_session_nowplaying = 'SELECT * FROM ' . $nowplaying;
$result = $dbConn->query($query_update_session_nowplaying);
while($row = $result->fetch_row()) {
    $_SESSION['nowplaying'] = $row['muzieklijst_ID'];
}

header('location:voted.php');
?>
