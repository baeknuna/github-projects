<?php
	session_start();

	// Create a token
	$_SESSION['token'] = substr(md5(rand()), 0, 10);

	// Check if the user is logined
	if (!isset ($_SESSION['username'])) {
		echo "Please login first."."<br><br>";
		echo "<a href='index.php'>Go back</a>"."<br><br>";
		exit;
	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="style.css" media="screen">
	<title>New Story</title>
</head>
<body>
	<h1>Write your own story here!</h1> 
	<!-- Build the platform for writing story -->
 	<form action = "storywrite.php" method = "post">
		<label>Title:</label><br>
		<input type="text" name="title">
		<br><br>
		<label>Content:</label><br>
		<textarea name="content" cols="60" rows="4">Enter your story...</textarea>
		<br><br>
		<label>Link:</label><br>
		<textarea name="link" cols="60" rows="1">Put the link of the story you want to share...</textarea>
		<br><br>
		<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
		<input type ="submit" name="submit" value="Submit"/>
	</form>
</body>	 
</html>