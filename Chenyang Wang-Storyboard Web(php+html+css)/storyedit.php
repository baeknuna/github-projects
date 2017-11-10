<?php

session_start();

// Acess the database
require 'database.php';

//Get the content and story id
$title=$_POST['title'];
$content=$_POST['content'];
$link=$_POST['link'];
$story_id=$_POST['story_id'];

if ($_SESSION['token'] !== $_POST['token']) {
	die("Request forgery detected");
}

// Update the data in the database
$stmt=$mysqli->prepare("UPDATE story SET content=?, title=?, link=? WHERE story_id=?");

if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
    }
   
   $stmt->bind_param('sssi', $content, $title, $link, $story_id);
   $stmt->execute();
   $stmt->close();

echo "Edit Successfully"."<br><br>";
echo "<a href='display.php'>Go back to the playground</a>";
?>