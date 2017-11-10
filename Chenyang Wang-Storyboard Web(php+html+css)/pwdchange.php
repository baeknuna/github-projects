<?php
	// Access the database
	require 'database.php';

	session_start();

	// Check if the user is logined
	if (!isset ($_SESSION['username'])) {
		echo "Please login first."."<br><br>";
		echo "<a href='index.php'>Go back</a>"."<br><br>";
		exit;
	}

	// Check tokens
	if($_SESSION['token'] !== $_POST['token']){
		die("Request forgery detected");
	}

	// Get the username
	$username = $_SESSION['username'];

	// Get the new password
	$new_password=$_POST['new_password'];
	$confirm_password=$_POST['confirm_new_password'];

	// Get the length of the two passwords
	$p=strlen($new_password);
	$cp=strlen($confirm_password);

	// Check whether there is input
	if($p==0||$cp==0){
		echo "Please enter your new password"."<br><br>";
		echo "<a href='profile.php'>Go back</a>";
		exit;
	}
	// Check if the password exceeds the length requirement
	elseif(!(($p>=5 && $p<=16)||($cp>=5 && $cp<=16))){
		echo "The length of the password should be 5-16"."<br><br>";
		echo "<a href='profile.php'>Go back</a>";
		exit;
	}

	// Check if the confirm_password matches the new_password
	if ($new_password!=$confirm_password){
		echo "Password doesn't match. Enter again"."<br><br>";
		echo "<a href='profile.php'>Go back</a>";
		exit;
	}


	// Encrype and salt the password
	$crypted_password=crypt($new_password);


	// Find the username's userid in the database
	$stmt1=$mysqli->prepare("SELECT id FROM users WHERE user_name=?");
	if(!$stmt1){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
		$stmt1->bind_param('s', $username);
		$stmt1->execute();
		$stmt1->bind_result($user_id);
		$stmt1->fetch();
	$stmt1->close();

	// Update the new password into the database
	$stmt3 = $mysqli->prepare("UPDATE users SET pwd=? WHERE id=?");
		if(!$stmt3){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			echo "<br>.<br>";
			echo "<a href='profile.php'>Go back</a>";
			exit;
		}
		$stmt3->bind_param('si', $crypted_password, $user_id);
		$stmt3->execute();
	$stmt3->close();

	echo "Change password successfully"."<br><br>";
	echo "<a href='profile.php'>Go back</a>";

?>