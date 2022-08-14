<?php
include 'initclass.php';


$idcard = $_GET['idcard'];
$my_player = new Player($_GET['idroom'], $_GET['idplayer']);
$deck = new Deck($_GET['iddeck']);
$conn = $deck->get_connection();
$sql = "SELECT * FROM game WHERE Id=".$_GET['idgame'];
$result = $conn->query($sql);
$output = $result->fetch_assoc();
$conn->close();
$str_arr = preg_split("/\,/", $output['pioche']);
$room = new Room($_GET['idroom'], $deck, $_GET['idplayer'], 
                $_GET['idgame'], intval($output['nbcardsperplayer']), intval($str_arr[0]), 
                intval($str_arr[2]), intval($str_arr[3]),
                intval($str_arr[4]), intval($str_arr[5]), intval($str_arr[6]));
$conn = $my_player->get_connection(); 
$sql = "SELECT nbcardsperplayer FROM game WHERE Id=".$_GET['idgame'];
$result = $conn->query($sql);
$output  = $result->fetch_assoc();

$sql = "SELECT hand FROM player WHERE Id=".$_GET['idplayer'];
$result = $conn->query($sql);
$output2 = $result->fetch_assoc();
$str_arr2 = preg_split ("/\,/", $output2['hand']);
$sizehand = sizeof($str_arr2);

if ($sizehand <= (int)$output['nbcardsperplayer']) {
    $sql = "SELECT pioche FROM room WHERE Id='".$_GET['idroom']."'";
    $result = $conn->query($sql);
    $output = $result->fetch_assoc();
    $str_arr = preg_split ("/\,/", $output['pioche']); 
    for ($i = 0; $i < sizeof($str_arr); $i++) {
        if ($str_arr[$i] == $idcard) {
            array_splice($str_arr, $i, 1);
            $str = implode (", ", $str_arr);
            $sql = "UPDATE `room` SET `pioche`=('".$str."') WHERE `Id`='".$_GET['idroom']."'";
            $conn->query($sql);
            $my_player->add_to_hand(new Card($idcard));
            $room->remove_nbcardtoshow($room->get_nbcard_toshow() - 1);
            break;
        }
    }
}
$conn->close();
?>