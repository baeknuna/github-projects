<?php

// Access the database
require 'database.php';

$username=$_POST['username'];
$password=$_POST['password'];

// Check if the username satisfies the regular expression requirement
if( !preg_match('/^[\w_\-]+$/', $username) ){   
	echo "Invalid Username"."<br><br>";
	echo ("<a href='index.php'><img src='image/button_goback.png' alt='goback'/></a>");
	exit;
}

// Check if the username entered already exists in the database or not
$stmt=$mysqli->prepare("SELECT COUNT(*) FROM users WHERE user_name=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($cnt);
$stmt->fetch();

// If the username already exists... 
if($cnt==1){
	echo "Existing username!"."<br><br>";
	echo "<a href='register.html'>Go back</a>";
	exit;
}
$stmt->close();


// Get the length of the username and password
$n=strlen($username);
$p=strlen($password);

// Check if the username is entered
if($n==0){
	echo "Please enter your username"."<br><br>";
	echo "<a href='register.html'>Go back</a>";
	exit;

// Check if the password is entered
}elseif($p==0){
	echo "Please enter the password"."<br><br>";
	echo "<a href='register.html'>Go back</a>";
	exit;


// Check if the username exceeds the length requirement
}elseif(!($n>=4 && $n<=10)){
	echo "The length of the usernsme should be 5-16"."<br><br>";  
	echo "<a href='register.html'>Go back</a>";
	exit;


// Check if the password exceeds the length requirement
}elseif(!($p>=5 && $p<=16)){
	echo "The length of the password should be 5-16"."<br><br>";
	echo "<a href='register.html'>Go back</a>";
	exit;
}
else{  

// Encrype and salt the password
$crypted_password=crypt($password);

// Insert the username and password into the database
$stmt = $mysqli->prepare("insert into users (user_name, pwd) values (?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	echo "<br>.<br>";
	echo "<a href='register.html'>Go back</a>";
	exit;
}
 
$stmt->bind_param('ss', $username, $crypted_password);
$stmt->execute();
$stmt->close();

echo "Registration successful"."<br><br>";
echo "<a href='index.php'>Go back</a>";

}
header("Location:index.php");
?>