<?php
	session_start();
	// Create a token
	$_SESSION['token'] = substr(md5(rand()), 0, 10);

	// check if the user is logined
	if (!isset ($_SESSION['username'])) {
		echo "Please login first."."<br><br>";
		echo "<a href='index.php'>Go back</a>"."<br><br>";
		exit;
	}

	// Get the username
	$username = $_SESSION['username'];

	// Access the database
	require 'database.php';
?>


<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="styletable.css" media="screen">
	<title>Profile</title>
</head>

<body>
<!-- Direct to the display page -->
	<a href="display.php">Go to the playground</a>
	<br><br>
<!-- Display the username -->
	<strong>Logined as: </strong><?php echo $username; ?>
	<br><hr>

<!-- Manage the stories -->
	<h1>Story Management</h1>

<!-- 	Create a new story -->
	<a href="story.php"><h3>New Story</h3></a>

<!-- List the stories the user have written -->
	<h3>Stories you have posted:</h3>
	<table style="width:100%">
		<tr>
			<th>Title</th>
			<th>Last Modified</th>
			<th>Number of Likes</th>
			<th>Action</th>
		</tr>


		<?php  

		// Find the username's userid in the database
		$stmt=$mysqli->prepare("SELECT id FROM users WHERE user_name=?");
		if(!$stmt){
		   printf("Query Prep Failed: %s\n", $mysqli->error);
		   exit;
		}
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$stmt->bind_result($user_id);
		$stmt->fetch();
		$stmt->close();

		// Ouput the stories and titles you have posted from the database
		$stmt=$mysqli->prepare(
			"SELECT 
				title, 
				modified_time, 
				story.story_id, 
				count(storylike.like_id) as like_num
				FROM story 
				LEFT JOIN storylike on (storylike.story_id=story.story_id)
				WHERE story.user_id=?
				GROUP BY story.story_id");

		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
	    }

	    $stmt->bind_param('i', $user_id);
		$stmt->execute();
		$stmt->bind_result($title, $modified_time, $story_id, $like_num);


		while($stmt->fetch()) {
			printf("<tr><td>%s</td>
					<td>%s</td>
					<td>".$like_num."</td>",
			htmlspecialchars($title),
			htmlspecialchars($modified_time)
	   		);
	   		echo "<td><form action='storyview.php' method='post'>
	   			 	<input type='hidden' name='story_id' value=".$story_id.">
	   			 	<input type='submit' value='View'>
	   			 </form>";

	   		echo "<form action='storyeditview.php' method='post'>
	   			 	<input type='hidden' name='story_id' value=".$story_id.">
	   			 	<input type='submit' value='Edit'>
	   			 </form>";

	   		echo "<form action='storydelete.php' method='post'>
	   			 	<input type='hidden' name='story_id' value=".$story_id.">
	   			 	<input type='submit' value='Delete'>
	   			 </form></td>";
	   		echo "</tr>";
	   	}// End of the while loop
	   	$stmt->close();
		?>
	</table>



<!-- List the stories you have liked -->
	<h3>Stories you have liked:</h3>

	<table style="width:100%">
		<tr>
			<th>Title</th>
			<th>Author</th>
			<th>Action</th>
		</tr>

	<?php 
		// Ouput the stories and titles you have liked from the database
		$stmt=$mysqli->prepare(
			"SELECT 
				story.title, 
				users.user_name,
				story.story_id
				FROM story
				JOIN users on (users.id=story.user_id) 
				JOIN storylike on (storylike.story_id=story.story_id)
				WHERE storylike.user_id=?
				GROUP BY story.story_id");

		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
	    }

	    $stmt->bind_param('i', $user_id);
		$stmt->execute();
		$stmt->bind_result($title, $author_id, $liked_story_id);


		while($stmt->fetch()) {
			printf("<tr><td>%s</td>
					<td>%s</td>",
			htmlspecialchars($title),
			htmlspecialchars($author_id)
	   		);
	   		echo "<td><form action='storyview.php' method='post'>
	   			 	<input type='hidden' name='story_id' value=".$liked_story_id.">
	   			 	<input type='submit' value='View'>
	   			 </form></td>";
	   		echo "</tr>";
	   	}// End of the while loop
	   	$stmt->close();
	?>
	</table>

	<br><hr>


<!-- Change password -->
	<h3>Change Password</h3>
	 <form action = "pwdCurrentCheck.php" method = "post">
		 Current Password: 
		 <br>
		 <input type = "password" name="current_password">
		 <br><br>
		 <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
		 <input type ="submit" name="submit" value="submit"/>
	 </form>
	 <br><hr>

<!-- Logout -->
	<a href="logout.php">Logout</a>

</body>
</html>