<?php
session_start();

include './server/db_resources.php';

if(isset($_SESSION['nowplaying']))
{
  header("location:./client/client.php");
}

if($_SESSION['isserver'] == 1)
{
  header("location:server.php");
}

$isserver = 0;

mysql_connect("localhost", $db_user, $db_pass);

$query_checkifdbexists = 'SELECT IF(EXISTS(SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = "' . $db_name . '"), 1, 0)AS doesexist';
$result = mysql_query($query_checkifdbexists) or die (mysql_error());
$db_does_exist = 0;
while($row=mysql_fetch_assoc($result))
{
  $db_does_exist = $row['doesexist'];
}

if($db_does_exist == 0)
{
  header('location:./deploy/deploy.php');
}

else
{

  mysql_select_db($db_name);

  $query = 'SELECT * FROM isserver';
  $result = mysql_query($query) or die(mysql_error());

  while($row = mysql_fetch_array($result))
  {
    $isserver = $row['servergestart'];
  }

  if($isserver == 0)
  {
    $_SESSION['isserver'] = 1;
    $_SESSION['playfromplaylist'] = 0;
    header("location:./server/server.php");
  }

  else
  {
    header("location:./client/client.php");
  }
}
?>