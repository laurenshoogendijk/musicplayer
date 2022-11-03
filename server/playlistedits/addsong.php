<?php

session_start();

if(!$_SESSION['isserver'] == 1) {
  header("location:../client/client.php");
}

include '../db_resources.php';

$query = 'INSERT INTO playlist SET ID = NULL, muzieklijst_ID ="' . $_POST['muzieklijstID'] . '"';
$dbConn->query($query);

header('location:../editplaylist.php');
?>
