<?php
session_start();

include 'db_resources.php';

//check if visitor is server.
if(!$_SESSION['isserver'] == 1) {
  header("location:../client/client.php");
}

//start the mysql connection.
$con = mysql_connect("localhost", $db_user, $db_pass);
mysql_select_db($db_name);

//get the winning song from votetable and save it in the session and in the currentsong table.
//$query_mostvotes = 'SELECT * FROM ' . $votetable . ' ORDER BY votecount DESC LIMIT 1'; //choose if you want the first song in the list (from the ones with most votes) to win.
$query_mostvotes_random = 'SELECT * FROM ' . $votetable . ' WHERE votecount = ( SELECT MAX( votecount ) FROM votetable)'; //choose if you want a random song from the ones with the most votes.
$result_mostvotes = mysql_query($query_mostvotes_random) or die(mysql_error());

$nrofrecords_mostvotes = mysql_num_rows($result_mostvotes);

$randomsong = rand( 1, $nrofrecords_mostvotes);

$counter = 1;

while($mostvotes = mysql_fetch_assoc($result_mostvotes)) {
  if($counter == $randomsong) {
    $_SESSION['nextsong'] = $mostvotes['muzieklijst_ID'];

    $query_clear_currentsong = 'TRUNCATE TABLE ' . $nowplaying;
    $query_currentsong = 'INSERT INTO ' . $nowplaying . ' SET ID = NULL, muzieklijst_ID ="' . $mostvotes['muzieklijst_ID'] . '"';

    mysql_query($query_clear_currentsong) or die(mysql_error());
    mysql_query($query_currentsong) or die(mysql_error());
  }
  $counter ++;
}

//clear the vote table.
$query_clear = 'TRUNCATE TABLE ' . $votetable;
mysql_query($query_clear) or die(mysql_error());

//count the number of records in musiclist.
$query_count = 'SELECT * FROM ' . $musiclist;
$result = mysql_query($query_count) or die(mysql_error());
$aantalrecords = mysql_num_rows($result);

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
for($i = 0; $i < 5; $i++)
{

$query_pick = 'SELECT * FROM ' . $musiclist . ' WHERE ID="' . $recordarray[$i] . '"';
$result = mysql_query($query_pick) or die(mysql_error());

  while($row = mysql_fetch_assoc($result))
  {

//create insert query with results from musiclist.
  $query_insert = 'INSERT INTO ' . $votetable . ' SET ID = NULL, muzieklijst_ID = "' . $row['ID'] . '", Naam = "' . $row['Naam'] . '", Pad = "' . $row['Pad'] . '", votecount = "0"';

//execute insert query.
  mysql_query($query_insert) or die(mysql_error());
  }
}

mysql_close($con);

header("location:server.php");

?>
