<?php
include 'initclass.php';

$deck = new Deck($_GET['iddeck']);

$conn = $deck->get_connection();
$sql = "SELECT * FROM game WHERE Id=".$_GET['idgame'];
$result = $conn->query($sql);
$output = $result->fetch_assoc();
$conn->close();
$str_arr = preg_split("/\,/", $output['pioche']);
/*  $str_arr[0] nbcardpioche | $str_arr[1] : nbcardvisiblepioche | 
    $str_arr[2] : nbcardvisibletapis | $str_arr[3] : tourpartour | 
    $str_arr[4] : cartepassable | $str_arr[5] : distributeauto | 
    $str_arr[6] : getcardback*/


/*  ?string $id = null, $carddeck, ?int $idplayer = 0, 
    ?int $idgame = 0, ?int $nbcardpioche = 0, ?int $nbcardvisibletapis = 0, 
    ?int $tourpartour = 0, ?int $cartepassable = 0, ?int $distributeauto = 0, 
    ?int $getcardback = 0
*/
$room = new Room($_GET['idroom'], $deck, $_GET['idplayer'], 
                $_GET['idgame'], intval($output['nbcardsperplayer']), intval($str_arr[0]), 
                intval($str_arr[2]), intval($str_arr[3]), intval($str_arr[4]), 
                intval($str_arr[5]), intval($str_arr[6]));
echo $room->pagehtml;
?>