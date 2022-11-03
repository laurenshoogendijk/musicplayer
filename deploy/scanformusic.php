<?php
session_start();

include '../server/db_resources.php';

$query_clear1 = 'TRUNCATE TABLE ' . $musiclist;
$query_clear2 = 'TRUNCATE TABLE ' . $votetable;
$dbConn->query($query_clear1);
$dbConn->query($query_clear2);

//scan the music directory, and put every file in the musiclist.
$dir = scandir('../server/music');

foreach($dir as $file) {
    if($file === '.' || $file === '..') {
        continue;
    } else {
        $filename = $file;

        $file = preg_replace('/_/', ' ', $file);
        $file = preg_replace('/.mp3/', '', $file);
        $file = preg_replace('/.wav/', '', $file);
        $file = preg_replace('/.m4a/', '', $file);
        $file = preg_replace('/.webma/', '', $file);
        $file = preg_replace('/.ogg/', '', $file);
        $file = preg_replace('/.fla/', '', $file);

        $query_fill = 'INSERT INTO ' . $musiclist . ' SET ID = NULL, Naam = "' . $file . '", Pad = "' . $filename . '"';
        $dbConn->query($query_fill);
    }
}

$query_getfirst5songs = 'SELECT * FROM ' . $musiclist . ' LIMIT 5';
$result = $dbConn->query($query_getfirst5songs);
while($row = $result->fetch_row()) {
  $query_set5votesongs = 'INSERT INTO ' . $votetable . ' SET ID=' . $row['ID'] . ', muzieklijst_ID=' . $row['ID'] . ', Naam="' . $row['Naam'] . '", Pad="' . $row['Pad'] . '", votecount=0';
  $dbConn->query($query_set5votesongs);
}

header('location:../index.php');
?>
