<?php

session_start();

include 'db_resources.php';

$query = 'UPDATE isserver SET servergestart="0"';
$dbConn->query($query);
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
