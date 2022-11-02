<?php
session_start();

include 'db_resources.php';

if(!$_SESSION['isserver'] == 1) {
  header("location:../client/client.php");
}




$query_setserver = 'UPDATE isserver SET servergestart="1"';
$dbConn->query($query_setserver);

$dir = './music/';

if(isset($_SESSION['nextsong'])) {
  $id = 0;
  $naam = "";
  $pad = "";

  $query_getsong = 'SELECT * FROM ' . $musiclist . ' WHERE ID = "' . $_SESSION['nextsong'] . '"';

  $result = $dbConn->query($query_getsong);
  while($row = $result->fetch_row()) {
    $id = $row['ID'];
    $naam = $row['Naam'];
    $pad = $dir . $row['Pad'];
  }
} else {
  header("location:playnextsong.php");
}
?>



<html>

  <head>

    <link href="./css/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />
    <link href="./images/custombuttons.css" rel="stylesheet" type="text/css" />
    <style>
input {width:420;}
    </style>
    <script type="text/javascript" src="./player/jquery.min.js"></script>
    <script type="text/javascript" src="./player/jquery.jplayer.min.js"></script>

    <script type="text/javascript">


$(document).ready(function() {
    $("#jquery_jplayer_1").jPlayer(
      {
        ready: function(event) {
            $(this).jPlayer("setMedia", {
              mp3: "<?php echo $pad; ?>",
              wav: "<?php echo $pad; ?>",
              oga: "<?php echo $pad; ?>",
              m4a: "<?php echo $pad; ?>",
              webma: "<?php echo $pad; ?>",
              flv: "<?php echo $pad; ?>"
            }).jPlayer("play");
        },
        ended: function() {
            window.location = "playnextsong.php";
        },
        swfPath: "./player/jplayer.swf",
        supplied: "mp3, wav, m4a, webma, oga, fla"
    });
});

function playnext() {
  window.location = "playnextsong.php";
}

function logout() {
  window.location = "stopbeingserver.php";
}

function rescanmusic() {
  window.location = "scanformusic.php";
}

function editplaylist() {
  window.open("editplaylist.php")
}

function changeplaysource() {
  window.location = "change_playsource.php";
}
    </script>
  </head>
  <body>
    <div class="playerelements">
        <div id="jquery_jplayer_1" class="jp-jplayer"></div>
        <div id="jp_container_1" class="jp-audio">
            <div class="jp-type-single">
                <div class="jp-gui jp-interface">
                    <ul class="jp-controls">
                      <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
                      <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>

<?php
if($_SESSION['playfromplaylist'] == 1) {
  echo '<li><a href="javascript:;" class="jp-stop" tabindex="1" style="position:relative; top:-14px;">stop</a></li>';
  echo '<li><a href="javascript:;" class="jp-next" tabindex="1" onclick="playnext()">next</a></li>';
}

else {
  echo '<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>';
}
?>
                        <li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
                        <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
                        <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
                    </ul>
                    <div class="jp-progress">
                        <div class="jp-seek-bar">
                            <div class="jp-play-bar"></div>
                        </div>
                    </div>

                    <div class="jp-volume-bar">
                        <div class="jp-volume-bar-value"></div>
                    </div>
                    <div class="jp-current-time"></div>
                    <div class="jp-duration"></div>
                </div>
                <div class="jp-title">
                    <ul>
                        <li><?php echo 'Now playing: ' . $naam; ?></li>
                    </ul>
                </div>

                <div class="jp-no-solution">
                    <span>Update Required</span>
                    To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                </div>
            </div>
        </div>
<br />
<div class="custombuttonsdiv">
<ul class="custombuttons">
<li><a href="javascript:;" onclick="logout()" class="logout" tabindex="1">deze pc afmelden als server</a></li>
<li><a href="javascript:;" onclick="rescanmusic()" class="rescanmusic" tabindex="1">muziekmap opnieuw scannen</a></li>

<?php

if($_SESSION['playfromplaylist'] == 0) {
  echo '<li><a href="javascript:;"  onclick="changeplaysource()" class="changetoplaylist" tabindex="1">afspelen vanaf playlist</a></li>';
} else {
  echo '<li><a href="javascript:;"  onclick="changeplaysource()" class="changetovotesystem" tabindex="1">play from votesystem</a></li>';
  echo '<li><a href="javascript:;"  onclick="editplaylist()" class="editplaylist" tabindex="1">editplaylist</a></li>'
  echo '</ul>';
  echo '</div>';
  echo '</div>';
  echo '<div class="playlist">';
  echo '<h2>Muziek in de wachtrij:</h2>';

  $query_get_playlist = 'SELECT * FROM ' . $playlist;
  $result = $dbConn->query($query_get_playlist);

  while($row = mysql_fetch_assoc($result)) {
    $query_getnamebyid = 'SELECT * FROM ' . $musiclist . ' WHERE ID = "' . $row['muzieklijst_ID'] . '"';
    $result_getnamebyid = $dbConn->query($query_getnamebyid);
    while($row_getnamebyid = $result_getnamebyid->fetch_row()) {
      echo $row_getnamebyid['Naam'] . '<br />';
    }
  }
  echo '</div>';
}
?>
  </body>
</html>
