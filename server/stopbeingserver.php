<?php

session_start();

include 'db_resources.php';

$con = mysql_connect("localhost", $db_user, $db_pass);
mysql_select_db($db_name);
$query = 'UPDATE isserver SET servergestart="0"';
$result = mysql_query($query) or die(mysql_error());
mysql_close($con);
session_destroy();
?>

<html>
  <head>
  </head>

  <body>

<p>

<h2>Je bent nu geen server meer, maar de eerstvolgende die de index.php opent zal dat worden.</h2>

<p>

<form method="POST" action="../index.php">
<input type="submit" value="naar index.php">
</form>

  </body>
</html>