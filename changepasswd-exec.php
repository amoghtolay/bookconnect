<?php
	require_once('auth.php');
	require_once('config.php');
?>

<?//Connection and sanitize Section. 
	
//Include the file for connection to DB
require_once('connectdb.php');

//Include the file for including clean() to sanitize values
require_once('sanitize.php');
	
	//Sanitize the POST values
	$login=$_SESSION['SESS_USERNAME'];
	$curpasswd=clean($_POST['curpasswd']);
	$newpasswd=clean($_POST['newpasswd']);
	$cnewpasswd=clean($_POST['cnewpasswd']);
	
	//Array to store validation errors
	$errmsg_arr = array();
	//Validation error flag
	$errflag = false;
?>
<?//Input Validations
	if($curpasswd == '') {
		$errmsg_arr[] = 'Current Password missing';
		$errflag = true;
	}
	if($newpasswd == '') {
		$errmsg_arr[] = 'New password missing missing';
		$errflag = true;
	}
	if($cnewpasswd == '') {
		$errmsg_arr[] = 'Confirm password missing';
		$errflag = true;
	}
	if( strcmp($newpasswd, $cnewpasswd) != 0 ) {
		$errmsg_arr[] = 'The two passwords do not match';
		$errflag = true;
	}
	

?>
<?//If there are input validations, redirect back to the registration form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		header("location: changepasswd.php");
		exit();
	}
?>
<?//Create query, execution and redirection
	$qry="SELECT * FROM members WHERE login='$login' AND passwd='".md5($_POST['curpasswd'])."'";
	$result=mysql_query($qry);
	
	$updateqry="UPDATE  members 
				SET  `passwd` =  '".md5($_POST['newpasswd'])."'
				WHERE  `members`.`login` = '$login'";
	
	if(!$result){
	$errmsg_arr[] = 'Query could not be completed :(';
	$errflag = true;
	}
	
	if($result){
		if(mysql_num_rows($result) == 1) {
		//correct password and login
		$updateres=mysql_query($updateqry);
			
			if($updateres){
			header("location: changepasswd-success.php");
			exit();
			}
			else if(!$updateres){
			$errmsg_arr[] = 'Password could not be updated';
			$errflag = true;
			}
		}
		else if(mysql_num_rows($result) < 1){
		$errmsg_arr[] = 'Wrong current password. Please try again!';
		$errflag = true;
		}
	}

		
?>
<?//If there are problems like wrong curpasswd, redirect back to the registration form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		header("location: changepasswd.php");
		exit();
	}
?>