<?php
include 'initclass.php';

//$deck = new Deck($_GET['iddeck']);
$my_player = new Room(null, $_GET['iddeck']);
echo $my_player->roomid;
?>