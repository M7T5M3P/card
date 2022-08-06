<?php

$path = parse_ini_file("card.ini");
$servername = $path['servername'];
$username = $path['username'];
$password = $path['password'];
$dbname = $path['dbname'];
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);


$here = 0;
$sql2 = "SELECT idplayers FROM room WHERE Id='".$_GET['idroom']."'";
$result = $conn->query($sql2);
for (; $row = $result->fetch_assoc();) {
    $str_arr = preg_split ("/\,/", $row['idplayers']); 
    //echo sizeof($str_arr);
    //print_r($str_arr);
    for ($i = 0; $i < sizeof($str_arr); $i++) {
        echo $str_arr[$i] ." ". $_GET['idplayer'] . "<br>";
        if ($str_arr[$i] == $_GET['idplayer']) {
            $here = 1;
            break;
        }
    }
}
if ($here == 0) {
    $sql = "UPDATE `room` SET `idplayers`=concat(idplayers,'".$_GET['idplayer'].",') WHERE Id='".$_GET['idroom']."'";
    echo $sql;
    $conn->query($sql);
}
echo "<br>";
echo 1;
?>