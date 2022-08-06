<?php

$path = parse_ini_file("card.ini");
$servername = $path['servername'];
$username = $path['username'];
$password = $path['password'];
$dbname = $path['dbname'];
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);

$sql = "SELECT namedeck FROM room WHERE Id='".$_GET['idroom']."'";
$result = $conn->query($sql);
$output = $result->fetch_assoc();
echo $output['namedeck'];
?>