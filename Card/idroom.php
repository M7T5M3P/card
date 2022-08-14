<?php
include 'initclass.php';

$deck = new Deck($_GET['iddeck']);
$conn = $deck->get_connection();
$sql = "SELECT * FROM game WHERE Id=".$_GET['idgame'];
$result = $conn->query($sql);
$output = $result->fetch_assoc();
$conn->close();
$str_arr = preg_split("/\,/", $output['pioche']);
$room = new Room(null, $deck, $_GET['idplayer'], 
                $_GET['idgame'], intval($output['nbcardsperplayer']), intval($str_arr[0]), 
                intval($str_arr[2]), intval($str_arr[3]),
                intval($str_arr[4]), intval($str_arr[5]), intval($str_arr[6]));
echo $room->roomid;
?>