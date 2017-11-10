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

	// Get the story id and current userid
	$story_id=$_POST['story_id'];
	$current_userid=$_POST['current_userid'];




	// Select the initial number of like and the author's userid from database
	$stmt1=$mysqli->prepare("SELECT user_id FROM storylike WHERE story_id=? order by like_id");
    if(!$stmt1){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
    }
    $stmt1->bind_param('i', $story_id);
    $stmt1->execute();
    $stmt1->bind_result($liked_userid);

    while($stmt1->fetch()){
   		// Check if the current user has already liked this story
    	if ($current_userid == htmlspecialchars($liked_userid)){
    		echo "You have already liked this story."."<br><br>";
    		echo "<a href='display.php'>Go back</a>";
    		exit;
    	}
    }
    $stmt1->close();



    // Get the author's user id from the database 
    $stmt2=$mysqli->prepare("SELECT user_id FROM story WHERE story_id=?");
	if(!$stmt2){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
		$stmt2->bind_param('i', $story_id);
		$stmt2->execute();
		$stmt2->bind_result($author_id);
		$stmt2->fetch();
	$stmt2->close();

	// Check if the current user is the author of the story
	if ($author_id==$current_userid) {
		// If yes.. the author cannot like his own story
		echo "You cannot like your own story."."<br><br>";
		echo "<a href='display.php'>Go back</a>";
		exit;
	}


    // If no, process
    // Insert the story_id and current_userid into the databse
    $stmt2 = $mysqli->prepare("insert into storylike (story_id, user_id) values (?, ?)");
    if(!$stmt2){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
    }
    $stmt2->bind_param('ii', $story_id, $current_userid);
    $stmt2->execute();
    $stmt2->close();

	echo "You Liked it!"."<br><br>";
	// Redirect to the display page
	echo "<a href='display.php'>Go back</a>";

?>