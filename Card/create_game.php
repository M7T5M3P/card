<?php

$path = parse_ini_file("card.ini");
$servername = $path['servername'];
$username = $path['username'];
$password = $path['password'];
$dbname = $path['dbname'];
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);
//nbcardpioche | nbcardvisiblepioche | nbcardvisibletapis | tourpartour | cartepassable | distributeauto | getcardback
$sql = "INSERT INTO `game`(`name`, `nbcardsperplayer`, `pioche`, `nbcardtoshow`) VALUES (?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param( "sisi", $_GET['name'], $_GET['nbcards'], $_GET['pioche'], $_GET['nbcardtoshow']);
$stmt->execute();
echo $conn->insert_id;
$conn->close();
?>