<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="stylesheet.css" media="screen">
	<meta charset="utf-8"/>
	<title>View Story</title>
</head>

<body>
	<?php
		session_start();

	// Access the database
	require 'database.php';

	// check if the user is logined
	if (!isset ($_SESSION['username'])) {
		echo "Please login first."."<br><br>";
		echo "<a href='index.php'>Go back</a>"."<br><br>";
		exit;
	}

	// Create a token
	$_SESSION['token'] = substr(md5(rand()), 0, 10);

	// Get the username
	$username = $_SESSION['username'];

	// Get the story id
	$story_id = $_POST['story_id'];

	// Ouput the stories and titles from the database
	$stmt1=$mysqli->prepare("SELECT title, content, link, user_id, users.user_name FROM story JOIN users on (users.id=story.user_id) WHERE story_id=?");

		if(!$stmt1){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
	    }

	    $stmt1->bind_param('i', $story_id);
		$stmt1->execute();
		$stmt1->bind_result($title, $content, $link, $user_id, $user_name);

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


	// Find the username's userid in the database
	$stmt2=$mysqli->prepare("SELECT id FROM users WHERE user_name=?");
	if(!$stmt2){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
		$stmt2->bind_param('s', $username);
		$stmt2->execute();
		$stmt2->bind_result($current_userid);
		$stmt2->fetch();
	$stmt2->close();

	// Check if the user is the author
	if ($user_id==$current_userid) {
		// If yes... the author can edit or delete the story
		echo "<form action='storyeditview.php' method='post'>
			<input type='hidden' name='story_id' value=".$story_id.">
			<input type='submit' value='Edit'>
			</form>";
	   	echo "<form action='storydelete.php' method='post'>
	   			 <input type='hidden' name='story_id' value=".$story_id.">
	   			 <input type='submit' value='Delete'>
	   		</form>"."<br><br>";
	}

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

			// Check if the user is the author of the comment
			if ($comment_user_id==$current_userid) {
				// If yes... the author can edit or delete the comment
			   	echo "<form action='commenteditview.php' method='post'>
			   			 <input type='hidden' name='comment_id' value=".$comment_id.">
			   			 <input type='hidden' name='story_id' value=".$story_id.">
			   			 <input type='submit' value='Edit'>
			   		</form>";
			   	echo "<form action='commentdelete.php' method='post'>
			   			 <input type='hidden' name='comment_id' value=".$comment_id.">
			   			 <input type='hidden' name='story_id' value=".$story_id.">
			   			 <input type='hidden' name='token' value=".$_SESSION['token'].">
			   			 <input type='submit' value='Delete'>
			   		</form>";
			   	echo "<br>";
			}
	   	}
	$stmt3->close();



	?>

	<hr>

	<!-- Write a Comment -->
 	<form action = "comment.php" method = "post">
		<label>Comment:</label><br>
		<textarea name="comment" cols="60" rows="4">Enter your comment...</textarea>
		<br>
		<input type="hidden" name="story_id" value="<?php echo $story_id;?>">
		<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
		<input type ="submit" name="submit" value="Submit"/>
	</form>

	<br> 
	<hr>

	<?php
	// Refirection buttons
	echo "<a href='display.php'>Go back</a>"."<br><br>";
	echo "<a href='logout.php'>Logout</a>";
	?>

</body>
</html>