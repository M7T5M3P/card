<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', '1');

$path = parse_ini_file("card.ini");
$servername = $path['servername'];
$username = $path['username'];
$password = $path['password'];
$dbname = $path['dbname'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

echo "
 <html>
 <head>
 <link rel='shortcut icon' href='card.png'/>
 <title>Card</title>
 <link rel='stylesheet' href='card.css'>
 <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
 </head>
 <body>
";
echo "</body>";
echo "</html>";
$conn->close();
?>