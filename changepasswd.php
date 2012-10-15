<?php
	require_once('auth.php');
	require_once('config.php');
?>

<html>
<head>
<title>Change Password</title>
<h1>On this page, you can change your password!!</h1>
</head>
<body>
<br>
You have been logged in using the username: <?echo $_SESSION['SESS_USERNAME'];?><br>

<?//Returns error if returned from changepaswd-exec.php with errflag=true!!
	if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
		echo '<ul class="err">';
		foreach($_SESSION['ERRMSG_ARR'] as $msg) {
			echo '<li>',$msg,'</li>'; 
		}
		echo '</ul>';
		unset($_SESSION['ERRMSG_ARR']);
	}
?>

<!-- Change Password Form -->	
	<form id="changepasswd" name="changepasswd" method="post" action="changepasswd-exec.php">
	
    <b>Current Password</b>
<!-- Current Password field --> 
 
	<input name="curpasswd" type="password" class="textfield" id="curpasswd" />

<!--New Password-->	
<br>	
    <b>New Password</b>
<!-- New Password field --> 
 
	<input name="newpasswd" type="password" class="textfield" id="newpasswd" />
<br>
    <b>Confirm New Password</b>
<!-- New Password field --> 
 
	<input name="cnewpasswd" type="password" class="textfield" id="cnewpasswd" />
	
	
<!-- Submit button -->

<p>&nbsp;</p>

	<input type="submit" name="Submit" value="Change Password" />
    
</form>

To return to the member-index page, please <a href="member-index.php"> Click here </a> <br>
<a href="logout.php">Logout</a>
</p>
</html>
