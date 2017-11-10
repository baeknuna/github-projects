<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" media="screen">
<!-- 	<link rel="stylesheet" type="text/css" href="stylesheet.css" media="screen"> -->
	<meta charset="utf-8"/>
	<title>News Site</title>
</head>

<body>
	<h1> <i>NEWS STORY SITE</i> </h1>
	<h1>Start Sharing Your Stories!</h1>

	<!-- Login button -->
	<h2>Log in:</h2>
	<form action="login.php" method="post">
	Username:
	<input type="text" name="username" id="username">
	<br/> <br/>
	Password: <input type = "password" name="password">
	<br/> <br/>
	<input type ="submit" name="submit" value="login">
	</form>
	<br>

	<!-- Guest visit button -->
	<a href="displayasguest.php"><h3>Guest Visit</h3></a>

	<!-- Registration button -->
	<a href="register.html"><h3>Register</h3></a>
</body>
</html>
