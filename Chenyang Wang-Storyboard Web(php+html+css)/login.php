<?php
session_start();

if (isset ($_POST['username'])) {
	$_SESSION['username'] = $_POST['username'];
}

// Access the database
require 'database.php';
 
// Use a prepared statement
$stmt = $mysqli->prepare("SELECT COUNT(*), id, pwd FROM users WHERE user_name=?");
 
// Bind the parameter
$stmt->bind_param('s', $user);
$user = $_SESSION['username'];
$stmt->execute();
 
// Bind the results
$stmt->bind_result($cnt, $user_id, $pwd_hash);
$stmt->fetch();
 
$pwd_guess = $_POST['password'];
// Compare the submitted password to the actual password hash
if( $cnt == 1 && crypt($pwd_guess, $pwd_hash)==$pwd_hash){
	// Login succeeded; direct to the profile page
	$_SESSION['user_id'] = $user_id;
	// header("Location : profile.php");
	header("Location:display.php");
}
else{
	// Login failed; direct to the index page
	echo "Login failed. Wrong username or password"."<br><br>";
	echo "<a href='index.php'>Go back</a>";
}

?>