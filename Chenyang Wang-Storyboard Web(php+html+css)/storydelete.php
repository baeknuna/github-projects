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

// Get the story id
$story_id=$_POST['story_id'];
$username=$_SESSION['username'];

// Delete the story's comments from the database
$stmt1=$mysqli->prepare("DELETE FROM comment WHERE story_id=?");
if(!$stmt1){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
    }
  
   $stmt1->bind_param('i', $story_id);
   $stmt1->execute();
   $stmt1->close();

// Delete the story from the database
$stmt2=$mysqli->prepare("DELETE FROM story WHERE story_id=?");

if(!$stmt2){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
    }
  
   $stmt2->bind_param('i', $story_id);
   $stmt2->execute();
   $stmt2->close();

   echo "Delete Successful"."<br><br>";
   echo "<a href='display.php'>Go back to the playground</a>";
?>