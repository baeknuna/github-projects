<?php

// connect to the database 'news'

$mysqli = new mysqli('localhost', 'root', 'justin880624', 'news');
 
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
 ?>