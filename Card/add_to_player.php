<?php
include 'initclass.php';

$idcard = $_GET['idcard'];
$me = new Player($_GET['idroom'], $_GET['myid']);
$otherplayer = new Player($_GET['idroom'], $_GET['idplayer']);
$conn = $me->get_connection();
$sql = "SELECT hand FROM player WHERE Id=".$_GET['myid'];
$result = $conn->query($sql);
$output  = $result->fetch_assoc();
$my_cards = preg_split ("/\,/", $output['hand']);

var_dump($my_cards);
for ($i = 0; $i < sizeof($my_cards); $i++) {
    if ($my_cards[$i] == $idcard) {
        array_splice($my_cards, $i, 1);
        $str = implode (", ", $my_cards);
        $sql = "UPDATE `player` SET `hand`=('".$str."') WHERE `Id`=".$_GET['myid'];
        $conn->query($sql);
        //$me->remove_of_hand(new Card($idcard));
        $otherplayer->add_to_hand(new Card($idcard));
        break;
    }
}
$conn->close();
?>