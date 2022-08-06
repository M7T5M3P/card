<?php

$path = parse_ini_file("card.ini");
$servername = $path['servername'];
$username = $path['username'];
$password = $path['password'];
$dbname = $path['dbname'];
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);


$sql = "INSERT INTO `deck`(`gamename`, `gamenamev`, `request`) VALUES (?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param( "sss", $_GET['name'], $_GET['realname'], $_GET['request']);
$stmt->execute();
echo $conn->insert_id;
?>