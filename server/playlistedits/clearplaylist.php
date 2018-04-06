<?php

session_start();

if($_SESSION['isserver'] == 1)
{
}
else
{

//if not, send visitor to client page.
header("location:../client/client.php");
}

include '../db_resources.php';

$con = mysql_connect("localhost", $db_user, $db_pass);
mysql_select_db($db_name);
$query = 'TRUNCATE TABLE playlist';
mysql_query($query) or die(mysql_error());

header('location:../editplaylist.php');

?>