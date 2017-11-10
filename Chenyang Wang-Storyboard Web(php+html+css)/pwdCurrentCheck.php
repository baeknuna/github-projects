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

	// Create a token
	$_SESSION['token'] = substr(md5(rand()), 0, 10);

	// Get the username and current password
	$username=$_SESSION['username'];
	$input_password=$_POST['current_password'];

	// Get the length of the input password
	$p=strlen($input_password);

	// Check whether there is input
	// If it is empty...
	if($p==0){
		echo "Please enter the current password"."<br><br>";
		echo "<a href='profile.php'>Go back</a>";
		exit;
	}

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


	// Find the user's salted password from the database
	$stmt2=$mysqli->prepare("SELECT COUNT(*), pwd FROM users WHERE id=?");
    if(!$stmt2){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
    }
    $stmt2->bind_param('i', $user_id);
    $stmt2->execute();
    $stmt2->bind_result($cnt, $current_password);
    $stmt2->fetch();
    $stmt2->close();

	// Check if the input password matches the correct current password
	// If doesn't match
	if( $cnt!=1 || crypt($input_password, $current_password)!=$current_password){
		echo "Wrong Password!"."<br><br>";
		echo "<a href='profile.php'>Go back</a>"."<br><br>";
		exit;
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="style.css" media="screen">
	<title>Password Change</title>
</head>
<body>
	<h1>New Password</h1>
	<form action = "pwdchange.php" method = "post">
		<label>Set New Password:</label><br>
		<input type="password" name="new_password">
		<br><br>
		<label>Confirm:</label><br>
		<input type="password" name="confirm_new_password">
		<br><br>
		<input type="hidden" name="user_id" value="<?php echo $user_id;?>">
		<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
		<input type ="submit" name="submit" value="Submit"/>
	</form>
	<br><br>
	<a href="profile.php">Go back</a>
</body>
</html>


