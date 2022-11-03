<?php

session_start();

if(!$_SESSION['isserver'] == 1) {
  header("location:../client/client.php");
}

include '../db_resources.php';

$query = 'TRUNCATE TABLE playlist';
$dbConn->query($query);

header('location:../editplaylist.php');

?>
