<?php
include 'initclass.php';


$idcard = $_GET['idcard'];
echo $idcard;
$deck = new Deck($_GET['iddeck']);
$player = new Room($_GET['idroom'], $deck, $_GET['idplayer']);
$nbplayer = sizeof($player->players);
$my_player = new Player($player->roomid, $_GET['idplayer']);

$str_arr = preg_split ("/\,/", $my_player->handsid); 
for ($i = 0; $i < sizeof($str_arr); $i++) {
    if ($str_arr[$i] == $idcard) {
        array_splice($str_arr, $i, 1);
        $str = implode (", ", $str_arr);
        $conn = $player->get_connection();
        $sql = "SELECT * FROM card WHERE Id=".$idcard;
        $result = $conn->query($sql);
        $output = $result->fetch_assoc();
        $sql = "UPDATE `player` SET `hand`=('".$str."') WHERE `Id`='".$_GET['idplayer']."'";
        $conn->query($sql);
        $my_player->add_to_tapis(new Card($idcard), $_GET['idroom']);
        $my_player->add_to_trash(new Card($idcard));
        break;
    }
}
?>