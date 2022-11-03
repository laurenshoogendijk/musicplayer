<?php
session_start();

include 'db_resources.php';

//check if visitor is server.
if(!$_SESSION['isserver'] == 1) {
  header("location:../client/client.php");
}

//get the winning song from votetable and save it in the session and in the currentsong table.
//$query_mostvotes = 'SELECT * FROM ' . $votetable . ' ORDER BY votecount DESC LIMIT 1'; //choose if you want the first song in the list (from the ones with most votes) to win.
$query_mostvotes_random = 'SELECT * FROM ' . $votetable . ' WHERE votecount = ( SELECT MAX( votecount ) FROM votetable)'; //choose if you want a random song from the ones with the most votes.
$result_mostvotes = $dbConn->query($query_mostvotes_random)

$nrofrecords_mostvotes = $result_mostvotes->num_rows;

$randomsong = rand( 1, $nrofrecords_mostvotes);

$counter = 1;

while($mostvotes = $result_mostvotes->fetch_row()) {
  if($counter == $randomsong) {
    $_SESSION['nextsong'] = $mostvotes['muzieklijst_ID'];

    $query_clear_currentsong = 'TRUNCATE TABLE ' . $nowplaying;
    $query_currentsong = 'INSERT INTO ' . $nowplaying . ' SET ID = NULL, muzieklijst_ID ="' . $mostvotes['muzieklijst_ID'] . '"';

    $dbConn->query($query_clear_currentsong);
    $dbConn->query($query_currentsong);
  }
  $counter ++;
}

//clear the vote table.
$query_clear = 'TRUNCATE TABLE ' . $votetable;
$dbConn->query($query_clear);

//count the number of records in musiclist.
$query_count = 'SELECT * FROM ' . $musiclist;
$result = $dbConn->query($query_count);
$aantalrecords = $result->num_rows;

//put 5 DIFFERENT numbers in an array (1 to number of records).
$recordarray = array();

$recordarray[0] = rand(1,$aantalrecords);
$recordarray[1] = rand(1,$aantalrecords);
$recordarray[2] = rand(1,$aantalrecords);
$recordarray[3] = rand(1,$aantalrecords);
$recordarray[4] = rand(1,$aantalrecords);

while($recordarray[1] == $recordarray[0]) {
  $recordarray[1] = rand(1,$aantalrecords);
}

while(($recordarray[2] == $recordarray[1]) || ($recordarray[2] == $recordarray[0])) {
  $recordarray[2] = rand(1,$aantalrecords);
}

while(($recordarray[3] == $recordarray[2]) || ($recordarray[3] == $recordarray[1]) || ($recordarray[3] == $recordarray[0]))
{
  $recordarray[3] = rand(1,$aantalrecords);
}

while(($recordarray[4] == $recordarray[3]) || ($recordarray[4] == $recordarray[2]) || ($recordarray[4] == $recordarray[1]) || ($recordarray[4] == $recordarray[0]))
{
  $recordarray[4] = rand(1,$aantalrecords);
}

//pick 5 records from table musiclist and put them into the vote table.
for($i = 0; $i < 5; $i++) {
  $query_pick = 'SELECT * FROM ' . $musiclist . ' WHERE ID="' . $recordarray[$i] . '"';
  $result = $dbConn->query($query_pick);

    while($row = $result->fetch_row()) {
      //create insert query with results from musiclist.
      $query_insert = 'INSERT INTO ' . $votetable . ' SET ID = NULL, muzieklijst_ID = "' . $row['ID'] . '", Naam = "' . $row['Naam'] . '", Pad = "' . $row['Pad'] . '", votecount = "0"';
      $dbConn->query($query_insert);
    }
}

header("location:server.php");
?>
