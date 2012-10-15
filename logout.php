<?php
	//Start session
	session_start();
	
	//Unset the variables stored in session
	unset($_SESSION['SESS_MEMBER_ID']);
	unset($_SESSION['SESS_FIRST_NAME']);
	unset($_SESSION['SESS_LAST_NAME']);
	
	unset($_SESSION['SESS_PENDREQ']);
	unset($_SESSION['SESS_STATUS']);
	unset($_SESSION['ACTIVATION_CODE']);
?>
<html>
<head>
<title>Logged Out</title>
</head>
<body>
<h1>Logged out </h1>
<p align="center">&nbsp;</p>
<h4 align="center" class="err">You have been successfully logged out.</h4>
<p align="center">Click here to <a href="login-form.php">Login</a> again</p>
</body>
</html>
