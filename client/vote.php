<?php
session_start();

include '../server/db_resources.php';

$con = mysql_connect('localhost', $db_user, $db_pass);
$db = mysql_select_db($db_name);
$query = 'SELECT * FROM ' . $nowplaying;
$result = mysql_query($query) or die(mysql_error());
$now_playing = "niks";
while($row = mysql_fetch_assoc($result))
{
$now_playing = $row['muzieklijst_ID'];
}

if($_SESSION['nowplaying'] == $now_playing)
{
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
$result = mysql_query($query) or die(mysql_error());
while($row = mysql_fetch_assoc($result))
{
    if($row['ID'] == 1)
    {
        $id_1_votes = $row['votecount'];
    }
    if($row['ID'] == 2)
    {
        $id_2_votes = $row['votecount'];
    }
    if($row['ID'] == 3)
    {
        $id_3_votes = $row['votecount'];
    }
    if($row['ID'] == 4)
    {
        $id_4_votes = $row['votecount'];
    }
    if($row['ID'] == 5)
    {
        $id_5_votes = $row['votecount'];
    }
}

if($_POST['keuze'] == 1)
{
    $id_1_votes += 1;
}
if($_POST['keuze'] == 2)
{
    $id_2_votes += 1;
}
if($_POST['keuze'] == 3)
{
    $id_3_votes += 1;
}
if($_POST['keuze'] == 4)
{
    $id_4_votes += 1;
}
if($_POST['keuze'] == 5)
{
    $id_5_votes += 1;
}

$query_updatevotes_1 = 'UPDATE ' . $votetable . ' SET votecount="' . $id_1_votes . '" WHERE ID = "1"';
$query_updatevotes_2 = 'UPDATE ' . $votetable . ' SET votecount="' . $id_2_votes . '" WHERE ID = "2"';
$query_updatevotes_3 = 'UPDATE ' . $votetable . ' SET votecount="' . $id_3_votes . '" WHERE ID = "3"';
$query_updatevotes_4 = 'UPDATE ' . $votetable . ' SET votecount="' . $id_4_votes . '" WHERE ID = "4"';
$query_updatevotes_5 = 'UPDATE ' . $votetable . ' SET votecount="' . $id_5_votes . '" WHERE ID = "5"';

mysql_query($query_updatevotes_1) or die(mysql_error());
mysql_query($query_updatevotes_2) or die(mysql_error());
mysql_query($query_updatevotes_3) or die(mysql_error());
mysql_query($query_updatevotes_4) or die(mysql_error());
mysql_query($query_updatevotes_5) or die(mysql_error());

$query_update_session_nowplaying = 'SELECT * FROM ' . $nowplaying;
$result = mysql_query($query_update_session_nowplaying) or die(mysql_error());
while($row = mysql_fetch_assoc($result))
{
    $_SESSION['nowplaying'] = $row['muzieklijst_ID'];
}

header('location:voted.php');

?>