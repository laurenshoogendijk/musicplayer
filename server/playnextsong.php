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

if($_SESSION['playfromplaylist'] == 0)
{
header('location:prepare_db.php');
}

else
{
header('location:playlist_nextsong.php');
}

?>
