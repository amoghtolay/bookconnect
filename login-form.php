<?php
	//Start session
	session_start();
	
	//Check whether the session variable SESS_MEMBER_ID is present or not
	if(isset($_SESSION['SESS_MEMBER_ID'])) {
		header("location: member-index.php");
		exit();
	}
?>
<html>
<head>
<title>Login Form</title>
</head>
<body>
<p>&nbsp;</p>
<?//check for input validations return from login-exec.php
	if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
		echo '<ul class="err">';
		foreach($_SESSION['ERRMSG_ARR'] as $msg) {
			echo '<li>',$msg,'</li>'; 
		}
		echo '</ul>';
		unset($_SESSION['ERRMSG_ARR']);
	}
?>
<!-- Login Form -->	
	<form id="loginForm" name="loginForm" method="post" action="login-exec.php">
	
	<b>Login</b>
<!-- Login ID field --> 
	<input name="login" type="text" class="textfield" id="login"/>

<p>&nbsp;</p>

    <b>Password</b>
<!-- Password field --> 
 
	<input name="password" type="password" class="textfield" id="password" />
<!-- Submit button -->

<p>&nbsp;</p>

	<input type="submit" name="Submit" value="Login" />
    
</form>
If you don't have a login ID yet, please register by <a href="register-form.php"> Clicking here!
</body>
</html>
