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
$sql2 = "SELECT Id FROM player";
$result = $conn->query($sql2);
for (; $row = $result->fetch_assoc();) {
    if ($row['Id'] == $_GET['idplayer']) {
        $here = 1;
        break;
    }
}
$conn->close();
echo $here;
?>