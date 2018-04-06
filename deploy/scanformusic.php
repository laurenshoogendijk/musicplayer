<?php
session_start();

include '../server/db_resources.php';

//start the mysql connection.
$con = mysql_connect("localhost", $db_user, $db_pass);
mysql_select_db($db_name);


$query_clear1 = 'TRUNCATE TABLE ' . $musiclist;
$query_clear2 = 'TRUNCATE TABLE ' . $votetable;
mysql_query($query_clear1) or die(mysql_error());
mysql_query($query_clear2) or die(mysql_error());

//scan the music directory, and put every file in the musiclist.
$dir = scandir('../server/music');

foreach($dir as $file)
{
    if($file === '.' || $file === '..')
    {
        continue;
    }

    else
    {
        $filename = $file;

        $file = preg_replace('/_/', ' ', $file);
        $file = preg_replace('/.mp3/', '', $file);
        $file = preg_replace('/.wav/', '', $file);
        $file = preg_replace('/.m4a/', '', $file);
        $file = preg_replace('/.webma/', '', $file);
        $file = preg_replace('/.ogg/', '', $file);
        $file = preg_replace('/.fla/', '', $file);

        $query_fill = 'INSERT INTO ' . $musiclist . ' SET ID = NULL, Naam = "' . $file . '", Pad = "' . $filename . '"';
        mysql_query($query_fill) or die(mysql_error());
    }
}

$query_getfirst5songs = 'SELECT * FROM ' . $musiclist . ' LIMIT 5';
$result = mysql_query($query_getfirst5songs) or die(mysql_error());
while($row = mysql_fetch_assoc($result))
{
  $query_set5votesongs = 'INSERT INTO ' . $votetable . ' SET ID=' . $row['ID'] . ', muzieklijst_ID=' . $row['ID'] . ', Naam="' . $row['Naam'] . '", Pad="' . $row['Pad'] . '", votecount=0';
  mysql_query($query_set5votesongs) or die(mysql_error());
}



header('location:../index.php');




?>