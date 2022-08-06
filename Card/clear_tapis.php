<?php
include 'initclass.php';

$deck = new Deck($_GET['iddeck']);
$player = new Room($_GET['idroom'], $deck, $_GET['idplayer']);
$player->clear_my_tapis();
?>