<?php

session_start();

include 'db_resources.php';

if($_SESSION['isserver'] == 1)
{
}
else
{

//if not, send visitor to client page.
header("location:../client/client.php");
}

if($_SESSION['playfromplaylist'] == 0)
{
$_SESSION['playfromplaylist'] = 1;
}

else
{
$_SESSION['playfromplaylist'] = 0;
}

header("location:server.php");

?>