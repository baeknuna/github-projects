<?php
 // Access the database
    require 'database.php';

	session_start();

	// Create a token
	$_SESSION['token'] = substr(md5(rand()), 0, 10);

	// Check if the user is logined
	if (!isset ($_SESSION['username'])) {
		echo "Please login first."."<br><br>";
		echo "<a href='index.php'>Go back</a>"."<br><br>";
		exit;
	}
	
	// Get the username and story_id
	$username=$_SESSION['username'];
	$story_id=$_POST['story_id'];

	// Select the content, title, link from database
	$stmt=$mysqli->prepare("SELECT content, title, link FROM story WHERE story_id=?");
    if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
	}

	$stmt->bind_param('i', $story_id);
	$stmt->execute();
	$stmt->bind_result($content,$title,$link);
	$stmt->fetch();
	$stmt->close();
	?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="style.css" media="screen">
	<title>Edit Story</title>
</head>
<body>
	<h1>Edit your story here!</h1> 
	<!-- Edit your writing story here-->
 	<form action = "storyedit.php" method = "post">
		<label>Title:</label><br>
		<input type="text" name="title" value="<?php echo $title ?>">
		<br><br>
		<label>Content:</label><br>
		<textarea name="content" cols="60" rows="7"><?php echo $content ?></textarea>
		<br><br>
		<label>Link:</label><br>
		<textarea name="link" cols="60" rows="2"><?php echo $link ?></textarea>
		<br><br>
		<input type="hidden" name="story_id" value="<?php echo $story_id;?>">
		<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
		<input type ="submit" name="submit" value="Submit"/>
	</form>
</body>	 
</html>