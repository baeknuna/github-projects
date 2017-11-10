<?php

	// Access the database
	require 'database.php';

	session_start();

	// check if the user is logined
	if (!isset ($_SESSION['username'])) {
		echo "Please login first."."<br><br>";
		echo "<a href='index.php'>Go back</a>"."<br><br>";
		exit;
	}

	// Check tokens
	if($_SESSION['token'] !== $_POST['token']){
		die("Request forgery detected");
	}

	// Get the username
	$username=$_SESSION['username'];

	// Find the username's userid in the database
	$stmt=$mysqli->prepare("SELECT id FROM users WHERE user_name=?");
	if(!$stmt){
	   printf("Query Prep Failed: %s\n", $mysqli->error);
	   exit;
	}

	$stmt->bind_param('s', $username);
	$stmt->execute();
	$stmt->bind_result($user_id);
	$stmt->fetch();
	$stmt->close();


	// Get the title and content
	$title=$_POST['title'];
	$content=$_POST['content'];
	$link=$_POST['link'];

	// Input the stories into the database
	$stmt = $mysqli->prepare("insert into story (content, title, user_id, link) values (?, ?, ?, ?)");

	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	 
	$stmt->bind_param('ssis', $content, $title, $user_id, $link);
	$stmt->execute();
	$stmt->close();


	// Redirect to the profile page
	echo "Your story is published successfully!"."<br><br>";
	echo "<a href='profile.php'>Go back to profile</a>";

?>