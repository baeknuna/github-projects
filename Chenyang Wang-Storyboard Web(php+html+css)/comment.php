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
	if($_SESSION['token'] != $_POST['token']){
		die("Request forgery detected");
	}
	
	// Get the username
	$username = $_SESSION['username'];

	// Get the userid from username
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


   // Get the story id and comment
   $story_id = $_POST['story_id'];
   $content = $_POST['comment'];

   // Insert the comment into the database
   $stmt = $mysqli->prepare("insert into comment (user_id, story_id, content) values (?,?,?)");
   if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
 	
	$stmt->bind_param('iis', $user_id, $story_id, $content);
	$stmt->execute();
	$stmt->close();

echo "Comment Successfully"."<br><br>";

// Redirect to the storyview page
echo "<form action='storyview.php' method='post'>
	   	<input type='hidden' name='story_id' value=".$story_id.">
	   	<input type='submit' value='Go back'>
	 </form>"
?>