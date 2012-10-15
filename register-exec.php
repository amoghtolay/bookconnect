<?php
	//Start session
	session_start();
	
	//Include database connection details
	require_once('config.php');
	
	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
?>
<?//Connection and sanitize Section. 
	
//Include the file for connection to DB
require_once('connectdb.php');

//Include the file for including clean() to sanitize values
require_once('sanitize.php');
	
	//Sanitize the POST values
	$fname = clean($_POST['fname']);
	$lname = clean($_POST['lname']);
	$login = clean($_POST['login']);
	$password = clean($_POST['password']);
	$cpassword = clean($_POST['cpassword']);
	
	//Input Validations
	if($fname == '') {
		$errmsg_arr[] = 'First name missing';
		$errflag = true;
	}
	if($lname == '') {
		$errmsg_arr[] = 'Last name missing';
		$errflag = true;
	}
	if($login == '') {
		$errmsg_arr[] = 'Login ID missing';
		$errflag = true;
	}
	if($password == '') {
		$errmsg_arr[] = 'Password missing';
		$errflag = true;
	}
	if($cpassword == '') {
		$errmsg_arr[] = 'Confirm password missing';
		$errflag = true;
	}
	if( strcmp($password, $cpassword) != 0 ) {
		$errmsg_arr[] = 'The two passwords do not match';
		$errflag = true;
	}
	
	//Checks added later in June to ensure nobody can enter bad values/numbers etc etc!!
	if(is_numeric($login) || !ctype_alpha($fname) || !ctype_alpha($lname)) {
		$errmsg_arr[] = 'Login ID, First name or Last Name are invalid';
		$errflag = true;
	}
	//copied code trial!!
	$pattern = "/^[a-zA-Z0-9._-]/";
	 
	if (!(preg_match('/^[a-zA-Z0-9\.-]/', $login)) || (preg_match('/[@]/', $login))){
		$errmsg_arr[] = 'Login ID should consist of only alphabets, numbers, . _ and -';
		$errflag = true;
	}
	
	
	//Check for duplicate login ID
	if($login != '') {
		$qry = "SELECT * FROM members WHERE login='$login'";
		$result = mysql_query($qry);
		if($result) {
			if(mysql_num_rows($result) > 0) {
				$errmsg_arr[] = 'Login ID already in use';
				$errflag = true;
			}
			@mysql_free_result($result);
		}
		else {
			die("Query failed");
		}
	}
	
	//If there are input validations, redirect back to the registration form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: register-form.php");
		exit();
	}

$status='pending';

	//Create INSERT query
	$qry = "INSERT INTO members(firstname, lastname, login, passwd, status, activation_code, pending_requests) 
			VALUES('$fname','$lname','$login','".md5($_POST['password'])."', '$status', '', '' )";
	$result = @mysql_query($qry);
	
	//Check whether the query was successful or not
	if($result) {
		$activate_link="activate.php?login=$login";
		//For activation code sending, redirect to activate link url
		header("location: $activate_link");
		exit();
	}else {
		die("Query failed. Could not insert user in DB");
	}
?>