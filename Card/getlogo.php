<?php

$path = parse_ini_file("card.ini");
$servername = $path['servername'];
$username = $path['username'];
$password = $path['password'];
$dbname = $path['dbname'];
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);


$sql2 = "SELECT Username, Logo FROM player WHERE Id='".$_GET['idplayer']."'";
$result = $conn->query($sql2);
$output = $result->fetch_assoc();
echo $output['Username'].",".$output['Logo'];
$conn->close();
?>