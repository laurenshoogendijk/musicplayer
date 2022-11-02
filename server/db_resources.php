<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = 'usbw';
$db_name = 'musicplayer';

$db = new mysqli($db_host,$db_user,$db_pass,$db_name);

if($dbConn->connect_error) {
	die("Database Connection Error, Error No.: ".$dbConn->connect_errno." | ".$dbConn->connect_error);
}

$musiclist = 'musiclist';
$playlist = 'playlist';
$nowplaying = 'nowplaying';
$votetable = 'votetable';
?>
