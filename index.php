<?php
session_start();

include './server/db_resources.php';

if(isset($_SESSION['nowplaying'])) {
  header("location:./client/client.php");
}

if($_SESSION['isserver'] == 1) {
  header("location:server.php");
}

$isserver = 0;

$query_checkifdbexists = 'SELECT IF(EXISTS(SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = "' . $db_name . '"), 1, 0)AS doesexist';
$result = $dbConn->query($query_checkifdbexists);
$db_does_exist = $result->fetch_row()['doesexist'];

if($db_does_exist == 0) {
  header('location:./deploy/deploy.php');
} else {
  $query = 'SELECT * FROM isserver';
  $result = $dbConn->query($query);
  $isserver = $result->fetch_row()['servergestart'];

  if($isserver == 0) {
    $_SESSION['isserver'] = 1;
    $_SESSION['playfromplaylist'] = 0;
    header("location:./server/server.php");
  } else {
    header("location:./client/client.php");
  }
}
?>
