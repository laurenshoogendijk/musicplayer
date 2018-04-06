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

include '../db_resources.php';

$con = mysql_connect("localhost", $db_user, $db_pass);
mysql_select_db($db_name);

$songtomoveup = ($_POST['playlistID'] + 1);
$idtomoveup = 0;
$songtomovedown = $_POST['playlistID'];
$idtomovedown = 0;

$query_getsongtomoveup = 'SELECT * FROM playlist WHERE ID = "' . $songtomoveup . '"';
$query_getsongtomovedown = 'SELECT * FROM playlist WHERE ID = "' . $songtomovedown . '"';

$result_up = mysql_query($query_getsongtomoveup) or die(mysql_error());
$result_down = mysql_query($query_getsongtomovedown) or die(mysql_error());

while($row_up = mysql_fetch_assoc($result_up))
{
$idtomoveup = $row_up['muzieklijst_ID'];
}

while($row_down = mysql_fetch_assoc($result_down))
{
$idtomovedown = $row_down['muzieklijst_ID'];
}

$query_setnewsong_up = 'UPDATE playlist SET muzieklijst_ID="' . $idtomoveup . '" WHERE ID="' . $songtomovedown . '"';
$query_setnewsong_down = 'UPDATE playlist SET muzieklijst_ID="' . $idtomovedown . '" WHERE ID="' . $songtomoveup . '"';

mysql_query($query_setnewsong_up) or die(mysql_error());
mysql_query($query_setnewsong_down) or die(mysql_error());

header('location:../editplaylist.php');

?>








