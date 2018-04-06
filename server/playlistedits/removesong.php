<?php

session_start();

if($_SESSION['isserver'] == 1)
{
}
else
{

//if not, send visitor to client page.
header("location:../client/client.php");
}

$playlistID = $_POST['playlistID'];

include '../db_resources.php';

$con = mysql_connect("localhost", $db_user, $db_pass);
mysql_select_db($db_name);

$query_removesong = 'DELETE FROM playlist WHERE ID = "' . $playlistID . '"';
$query_update_ai = 'SELECT * FROM playlist';

mysql_query($query_removesong) or die(mysql_error());
$result_update_ai = mysql_query($query_update_ai) or die(mysql_error());
$counter = 1;

while($row_update_ai = mysql_fetch_assoc($result_update_ai))
{
  $query1 = 'UPDATE playlist set muzieklijst_ID="' . $row_update_ai['muzieklijst_ID'] . '" WHERE ID="' . $counter . '"';
  mysql_query($query1) or die(mysql_error());
  if(mysql_affected_rows() == 0)
  {
    mysql_query('DELETE FROM playlist WHERE ID = "' . $row_update_ai['ID'] . '"');
    mysql_query('INSERT INTO playlist SET ID="' . $counter . '", muzieklijst_ID="' . $row_update_ai['muzieklijst_ID'] . '"');
  }

  $counter++;
}

header('location:../editplaylist.php');

?>