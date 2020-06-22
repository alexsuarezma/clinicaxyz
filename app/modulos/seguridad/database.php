<?php
$server = 'us-cdbr-east-05.cleardb.net';
$username = 'b7550b2dcd9c38';
$password = 'a16e5057';
$database = 'heroku_fe7e002859673b2';

try{
	$conn = new PDO("mysql:host=$server;dbname=$database;",$username, $password);
}catch(PDOException $e){
	die('Connected failed: '.$e->getMessage());
}
?>