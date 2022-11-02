<?php
session_start();
?>

<html>
    <head>
    </head>

    <body>
        <div>
            <p />

<?php

if($_SESSION['algestemd'] == 1) {
    echo 'je kunt pas weer stemmen als dit liedje is afgelopen.<p />';
    $_SESSION['algestemd'] == 0;
} else {
    echo 'Bedankt voor je stem.<br />je kunt weer stemmen als dit liedje is afgelopen.<p />';
}

echo '<p />';

include '../server/db_resources.php';

$con = mysql_connect('localhost', $db_user, $db_pass);
$db = mysql_select_db($db_name);
$query = 'SELECT * FROM ' . $votetable;
$result = mysql_query($query) or die(mysql_error());
while($row = mysql_fetch_assoc($result)) {
  echo 'Er is ' . $row['votecount'] . ' keer op "' . $row['Naam'] . '" gestemd.<p />';
}
?>

<form action="client.php">
<input type="submit" value="klik hier om terug te keren naar de stem-pagina">
</form>

        </div>
    </body>
</html>
