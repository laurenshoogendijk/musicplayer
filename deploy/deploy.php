<?php

include '../server/db_resources.php';

#$con = mysql_connect('localhost', $db_user, $db_pass);
$con = new mysqli('localhost', $db_user, $db_pass, $db_name)

$query_create_database = 'CREATE DATABASE ' . $db_name;
$query_create_table_1 = 'CREATE TABLE isserver (servergestart TINYINT(1) NOT NULL, PRIMARY KEY (servergestart))';
$query_create_table_2 = 'CREATE TABLE ' . $musiclist . '(ID BIGINT(20) NOT NULL AUTO_INCREMENT, Naam TEXT NOT NULL, Pad TEXT NOT NULL, PRIMARY KEY (ID))';
$query_create_table_3 = 'CREATE TABLE ' . $nowplaying . '(ID BIGINT(20) NOT NULL AUTO_INCREMENT, muzieklijst_ID BIGINT(20) NOT NULL, PRIMARY KEY (ID))';
$query_create_table_4 = 'CREATE TABLE ' . $votetable . '(ID BIGINT(20) NOT NULL AUTO_INCREMENT, muzieklijst_ID BIGINT(20) NOT NULL, Naam TEXT NOT NULL, Pad TEXT NOT NULL, votecount INT(100) NOT NULL, PRIMARY KEY (ID))';
$query_create_table_5 = 'CREATE TABLE ' . $playlist . '(ID BIGINT(20) NOT NULL AUTO_INCREMENT, muzieklijst_ID BIGINT(20) NOT NULL, PRIMARY KEY (ID))';
$query_reset_playfrom = 'INSERT INTO isserver SET servergestart=0';

#mysql_query($query_create_database) or die(mysql_error());
#$con->query($query_create_database)

#mysql_select_db($db_name);

#mysql_query($query_create_table_1) or die(mysql_error());
$con->query($query_create_table_1)
mysql_query($query_create_table_2) or die(mysql_error());
mysql_query($query_create_table_3) or die(mysql_error());
mysql_query($query_create_table_4) or die(mysql_error());
mysql_query($query_create_table_5) or die(mysql_error());
mysql_query($query_reset_playfrom) or die(mysql_error());

$naam = 'Geen muziek in muzieklijst!';
$pad = 'Geen muziek in muzieklijst!';

for($i = 1; $i<=5; $i++)
{
  $query_insert_testmusic1 = 'INSERT INTO ' . $musiclist . ' SET ID=' . $i . ', Naam="' . $naam . '", Pad="' . $pad . '"';
  $query_insert_testmusic2 = 'INSERT INTO ' . $votetable . ' SET ID=' . $i . ', muzieklijst_ID="1", Naam="' . $naam . '", Pad="' . $pad . '", votecount="0"';
  mysql_query($query_insert_testmusic1) or die(mysql_error());
  mysql_query($query_insert_testmusic2) or die(mysql_error());


}

  $query_insert_testmusic3 = 'INSERT INTO ' . $nowplaying . ' SET ID=' . $i . ', muzieklijst_ID="1"';
  mysql_query($query_insert_testmusic3) or die(mysql_error());
  header('location:afterdeploy.php');

?>
