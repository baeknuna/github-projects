<?php

session_start();

// Acess the database
require 'database.php';

// Check tokens
if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}

//Get the content, comment id, and story id
$content=$_POST['comment'];
$comment_id=$_POST['comment_id'];
$story_id=$_POST['story_id'];

// Update the data in the database
$stmt=$mysqli->prepare("UPDATE comment SET content=? WHERE comment_id=?");

if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
    }
   
   $stmt->bind_param('si', $content, $comment_id);
   $stmt->execute();
   $stmt->close();

echo "Edit Successfully"."<br><br>";

// Redirect to the storyview page
echo "<form action='storyview.php' method='post'>
	   	<input type='hidden' name='story_id' value=".$story_id.">
	   	<input type='submit' value='Go back'>
	 </form>"

?>