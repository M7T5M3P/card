<?php
include 'initclass.php';

$deck = new Deck($_GET['iddeck']);
$conn = $deck->get_connection();
$sql = "SELECT * FROM game WHERE Id=".$_GET['idgame'];
$result = $conn->query($sql);
$output = $result->fetch_assoc();
$conn->close();
$str_arr = preg_split("/\,/", $output['pioche']);
$room = new Room($_GET['idroom'], $deck, $_GET['idplayer'], intval($output['nbcardsperplayer']), intval($str_arr[0]), intval($str_arr[1]));
$room->start_game();
?>