<?php
include 'initclass.php';


$idcard = $_GET['idcard'];
$deck = new Deck($_GET['iddeck']);
$conn = $deck->get_connection();
$sql = "SELECT * FROM game WHERE Id=".$_GET['idgame'];
$result = $conn->query($sql);
$output = $result->fetch_assoc();
$conn->close();
$str_arr = preg_split("/\,/", $output['pioche']);
$player = new Room($_GET['idroom'], $deck, $_GET['idplayer'], 
                $_GET['idgame'], intval($output['nbcardsperplayer']), intval($str_arr[0]), 
                intval($str_arr[2]), intval($str_arr[3]),
                intval($str_arr[4]), intval($str_arr[5]), intval($str_arr[6]));
$nbplayer = sizeof($player->players);
$my_player = new Player($player->roomid, $_GET['idplayer']);


$conn = $player->get_connection();
$sql = "SELECT pioche FROM game WHERE Id=".$_GET['idgame'];
$result = $conn->query($sql);
$output  = $result->fetch_assoc();
$str_arr = preg_split ("/\,/", $output['pioche']);

$sql = "SELECT tapis FROM room WHERE Id='".$_GET['idroom']."'";
$result = $conn->query($sql);
$output  = $result->fetch_assoc();
$str_arr2 = preg_split ("/\,/", $output['tapis']);
$sizetapis = sizeof($str_arr2) - 1;

if ($sizetapis < $str_arr[2]) {
    $str_arr = preg_split ("/\,/", $my_player->handsid); 
    print_r($str_arr);
    for ($i = 0; $i < sizeof($str_arr); $i++) {
        if ($str_arr[$i] == $idcard) {
            array_splice($str_arr, $i, 1);
            $str = implode (", ", $str_arr);
            echo $str;
            $sql = "UPDATE `player` SET `hand`=('".$str."') WHERE `Id`='".$_GET['idplayer']."'";
            $conn->query($sql);
            $player->add_to_tapis(new Card($idcard), $_GET['idroom']);
            $my_player->add_to_trash(new Card($idcard));
            break;
        }
    }
}
$conn->close();
?>