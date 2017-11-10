<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="stylesheet.css" media="screen">
	<meta charset="utf-8"/>
	<title>View Story</title>
</head>

<body>
	<?php

	// Access the database
	require 'database.php';

	// Get the story id
	$story_id = $_POST['story_id'];


	// Ouput the stories and titles from the database
	$stmt1=$mysqli->prepare("SELECT title, content, link, user_id, users.user_name, story_id FROM story JOIN users on (users.id=story.user_id) WHERE story_id=?");

		if(!$stmt1){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
	    }

	    $stmt1->bind_param('i', $story_id);
		$stmt1->execute();
		$stmt1->bind_result($title, $content, $link, $user_id, $user_name, $story_id);

		while($stmt1->fetch()) {
			printf("<div style='border:1px solid #000000;'>\t
				<strong>Title: <i>%s</i></strong>
				<br>
				<strong>Author: </strong>%s
				<div style='border:1px dashed #000000;'>
				%s
				<br>
				<a href='%s' target='_blank'>link</a>
				</div>
				</div>\n",
			htmlspecialchars($title),
			htmlspecialchars($user_name),
	   		htmlspecialchars($content),
			htmlspecialchars($link)
	   		);
	   	}
	$stmt1->close();

	echo "<br>";
	echo "<hr>";


	// Display any comments from the database
	echo "<h3>Comments:</h3>";

	$stmt3=$mysqli->prepare("SELECT content, user_id, comment_id,users.user_name FROM comment JOIN users on (users.id=comment.user_id) WHERE story_id = ?");

		if(!$stmt3){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
	    }

	    $stmt3->bind_param('i', $story_id);
		$stmt3->execute();
		$stmt3->bind_result($content, $comment_user_id, $comment_id, $comment_user_name);

		while($stmt3->fetch()) {
			printf("<div style='border:1px solid #000000;'>\t
				<strong>Comment by %s</strong>
				<br>
				<div style='border:1px dashed #000000;'>
				%s
				<br><br>
				</div>
				</div>\n",
			htmlspecialchars($comment_user_name),
			htmlspecialchars($content)
	   		);
	   		echo "<br>";
	   	}
	$stmt3->close();

	// Refirection buttons
	echo "<a href='displayasguest.php'>Go back</a>"."<br><br>";
	?>

</body>
</html>