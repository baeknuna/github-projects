<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="stylesheet.css" media="screen">
	<meta charset="utf-8"/>
	<title>News Site - Guest Visit</title>
</head>

<body>
	<h1> <i>NEWS STORY SITE</i> </h1>
	<?php

	// Access the database
	require 'database.php';


	// Ouput the stories, titles, # of likes from the databases
	$stmt=$mysqli->prepare(
		"SELECT 
			title, 
			content, 
			link, 
			users.user_name, 
			story.story_id,
			count(storylike.like_id) as like_num
		FROM story 
		JOIN users on (users.id=story.user_id) 
		LEFT JOIN storylike on (storylike.story_id=story.story_id)
		GROUP BY story.story_id");

		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
	    }
		$stmt->execute();
		$stmt->bind_result($title, $content, $link, $user_name, $story_id, $like_num);

		while($stmt->fetch()) {
			// Check if there is a living link
			if ($link == 'Put the link of the story you want to share...') {
				// If no... don't display the link
				printf("<div style='border:1px solid #000000;'>\t
					<strong>Title: <i>%s</i></strong>
					<br>
					<strong>Author: </strong>%s
					<br>
					<strong>Stats: </strong>".$like_num." likes
					<br>
					<div style='border:1px dashed #000000;'>
					%s
					<br>
					</div>

	   					<form action='storyviewGuest.php' method='post'>
	   			 			<input type='hidden' name='story_id' value=".$story_id.">
	   			 			<input type='submit' value='View'>
	   			 		</form>

					</div>\n",
				htmlspecialchars($title),
				htmlspecialchars($user_name),
		   		htmlspecialchars($content)
		   		);
		   	}
		   	// If yes, it does have a link, then display the link
		   	else {
				printf("<div style='border:1px solid #000000;'>\t
					<strong>Title: <i>%s</i></strong>
					<br>
					<strong>Author: </strong>%s
					<br>
					<strong>Stats: </strong>".$like_num." likes
					<div style='border:1px dashed #000000;'>
					%s
					<br>
					<a href='%s' target='_blank'>link</a>
					</div>

	   					<form action='storyviewGuest.php' method='post'>
	   			 			<input type='hidden' name='story_id' value=".$story_id.">
	   			 			<input type='submit' value='View'>
	   			 		</form>
	   			 		
					</div>\n",
				htmlspecialchars($title),
				htmlspecialchars($user_name),
		   		htmlspecialchars($content),
				htmlspecialchars($link)
		   		);
		   	}
		   	echo "<br>";
	   	} // End of while loop


	?>

	<br><br>
	<a href='index.php'>Go back</a>
</body>
</html>
