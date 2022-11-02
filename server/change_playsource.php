<?php

session_start();

include 'db_resources.php';

if(!$_SESSION['isserver'] == 1) {
  header("location:../client/client.php");
}

$_SESSION['playfromplaylist'] = ($_SESSION['playfromplaylist'] == 0) : 1 : 0;
header("location:server.php");

?>
