<?php
session_start();

include 'db_resources.php';

//check if visitor is server.
if(!$_SESSION['isserver'] == 1) {
  header("location:../client/client.php");
}

$query_clear = 'TRUNCATE TABLE ' . $musiclist;
$dbConn->query($query_clear);

//scan the music directory, and put every file in the musiclist.
$dir = scandir('./music');

foreach($dir as $file) {
    if($file === '.' || $file === '..')     {
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

header('location:server.php');
?>
