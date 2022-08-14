<?php
include 'initclass.php';

$my_player = new Player(null,null, $_GET['name'], $_GET['logo']);
echo $my_player->id;
?>