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

$query = 'SELECT * FROM ' . $votetable;
$result = $dbConn->query($query);
while($row = $result->fetch_row()) {
  echo 'Er is ' . $row['votecount'] . ' keer op "' . $row['Naam'] . '" gestemd.<p />';
}
?>

<form action="client.php">
<input type="submit" value="klik hier om terug te keren naar de stem-pagina">
</form>

        </div>
    </body>
</html>
