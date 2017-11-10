<?php
session_start();

// Access the database
require 'database.php';

// Check tokens
if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
}

// check if the user is logined
if (!isset ($_SESSION['username'])) {
	echo "Please login first."."<br><br>";
	echo "<a href='index.php'>Go back</a>"."<br><br>";
	exit;
}

// Get the username, comment id and story id
$username=$_SESSION['username'];
$comment_id=$_POST['comment_id'];
$story_id=$_POST['story_id'];

// Delete the comment from database
$stmt=$mysqli->prepare("DELETE FROM comment WHERE comment_id=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
    }
  
   $stmt->bind_param('i', $comment_id);
   $stmt->execute();
   $stmt->close();
   
	echo "Delete Successful"."<br><br>";

   // Redirect to the storyview page
	echo "<form action='storyview.php' method='post'>
			<input type='hidden' name='story_id' value=".$story_id.">
	   		<input type='submit' value='Go back'>
		 </form>"
?>