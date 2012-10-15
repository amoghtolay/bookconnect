<?php
//The require section.  Scripts to include the connection settings as well as to ensure that the user is logged in!!
	require_once('auth.php');
	require_once('config.php');
?>

<html>
<head>
<title>Add an entry!</title>
<h2> Hi <? echo $_SESSION['SESS_FIRST_NAME']; ?>!!! Add any stuff that u want to share/sell!!</h2>
</head>
<p>
<?//Connection Section. 
//Include the file for connection to DB
require_once('connectdb.php');

//Include the file for sanitizing the recieved values
require_once('sanitize.php');

//Getting and sanitizing the variables obtained
$owner= $_SESSION['SESS_USERNAME'];
$stuff = clean($_POST['stuff']);
$phoneno = clean($_POST['phoneno']);
?>
	
<?//Checking for empty fields
	if($stuff=='') {
		$errmsg_arr[] = 'Item description cannot be empty!!';
		$errflag = true;
	}
	
	if(!($phoneno=='') && (!is_numeric($phoneno))) {
		$errmsg_arr[] = 'Phone no should be an integer!!';
		$errflag = true;
	}
?>
<?//If there are input validations, redirect back to the liststuff form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		header("location: liststuff.php");
		exit();
	}
?>
	
<?//Defining DB queries

$dbname=DB_DATABASE;
$cur_status='unapproved';

//Query to create a new row in stuff
$qry_add_row="INSERT INTO  `$dbname`.`stuff` (
			`id` ,
			`stuff` ,
			`owner` ,
			`phoneno` ,
			`status`
			)
			VALUES (NULL ,  '$stuff', '$owner',  '$phoneno',  '$cur_status')";

?>

<?//Executing result and redirecting appropriately
$res_add_stuff=mysql_query($qry_add_row);
	if($res_add_stuff){
	header("location: addstuff-success.php");
	exit();
	}

if(!$res_add_stuff){
	$errmsg_arr[] = 'There was some problem in entering the data, please try again later';
	$errflag = true;
	$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
	header("location: liststuff.php");
	exit();
}
?>