<?php
include 'initclass.php';

$path = parse_ini_file("card.ini");
$servername = $path['servername'];
$username = $path['username'];
$password = $path['password'];
$dbname = $path['dbname'];
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);

$bool = 0;
$sql = "SELECT Id FROM room";
$result = $conn->query($sql);

for (; $output = $result->fetch_assoc();) {
    if ($output['Id'] == $_GET['idroom']) {
        $bool = 1;
    }
}
$conn->close();
echo $bool;
?>