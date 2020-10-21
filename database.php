<?php

$servername = 'localhost:3307';
$username = 'root';
$password = '';
$dbname = 'students';
$conn = mysqli_connect($servername, $username, $password, $dbname);
if(!$conn)
{
	echo 'Connection Error '.mysqli_connect_error();
}

?>