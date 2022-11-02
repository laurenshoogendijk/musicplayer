<?php

session_start();

if(!$_SESSION['isserver'] == 1) {
  header("location:../client/client.php");
}

if($_SESSION['playfromplaylist'] == 0) {
  header('location:prepare_db.php');
} else {
  header('location:playlist_nextsong.php');
}

?>
