<?php
	session_start();
	
	 // Access the database
    require 'database.php';
    
	// Create a token
	$_SESSION['token'] = substr(md5(rand()), 0, 10);

	// Check if the user is logined
	if (!isset ($_SESSION['username'])) {
		echo "Please login first."."<br><br>";
		echo "<a href='index.php'>Go back</a>"."<br><br>";
		exit;
	}
	
	// Get the username, comment_id and story_id
	$username=$_SESSION['username'];
	$comment_id=$_POST['comment_id'];
	$story_id=$_POST['story_id'];

	// Select the content from database
	$stmt=$mysqli->prepare("SELECT content FROM comment WHERE comment_id=?");
    if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
	}
	$stmt->bind_param('i', $comment_id);
	$stmt->execute();
	$stmt->bind_result($content);
	$stmt->fetch();
	$stmt->close();
	?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="style.css" media="screen">
	<title>Edit Comment</title>
</head>
<body>
	<h1>Edit your comment here!</h1> 
	<!-- Edit your Comment -->
 	<form action = "commentedit.php" method = "post">
		<label>Comment:</label><br>
		<textarea name="comment" cols="60" rows="4" ><?php echo $content; ?></textarea>
		<br>
		<input type="hidden" name="comment_id" value="<?php echo $comment_id;?>">
		<input type="hidden" name="story_id" value="<?php echo $story_id;?>">
		<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
		<input type ="submit" name="submit" value="Submit"/>
	</form>
</body>
</html>