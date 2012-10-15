<?php
	session_start();
?>
<html>
<head><title>Registration Form</title>
<center>
<h1> Registration Form for new users! </h1>
</center>
</head>
<body>
<br> 
<?php
	if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
		echo '<ul class="err">';
		foreach($_SESSION['ERRMSG_ARR'] as $msg) {
			echo '<li>',$msg,'</li>'; 
		}
		echo '</ul>';
		unset($_SESSION['ERRMSG_ARR']);
	}
?>

<form id="loginForm" name="loginForm" method="post" action="register-exec.php">
<br>First Name <br>
<input name="fname" type="text" class="textfield" id="fname" />

<br>

<br>Last Name<br>
<input name="lname" type="text" class="textfield" id="lname" />

<br>    

<br>Your Webmail ID(complete)<br>
<input name="login" type="text" class="textfield" id="login" />

<br>    

<br>Password<br>
<input name="password" type="password" class="textfield" id="password" />

<br>

<br>Confirm Password<br>
<input name="cpassword" type="password" class="textfield" id="cpassword" />

<br><br><center>    
<input type="submit" name="Submit" value="Register" />

</center>
</form>
</body>
</html>
