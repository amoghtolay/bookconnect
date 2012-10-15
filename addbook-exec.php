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
	$username=$_SESSION['SESS_USERNAME'];
	$book=clean($_POST['book']);
	$year=clean($_POST['year']);
	$course=clean($_POST['course']);
	$authors=clean($_POST['authors']);
	$isbn=clean($_POST['isbn']);
	$cost=clean($_POST['cost']);
	$errflag=false;
?>
	
	
<?//Checking for empty fields
	if($book=='') {
		$errmsg_arr[] = 'Book name field cannot be empty!!';
		$errflag = true;
	}
	
	if($cost=='') {
		$errmsg_arr[] = 'Cost field cannot be empty!!';
		$errflag = true;
	}
	
	if(!is_numeric($cost)) {
		$errmsg_arr[] = 'Cost field should be an integer!!';
		$errflag = true;
	}
	
?>
<?//If there are input validations, redirect back to the addbook form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		header("location: addbook.php");
		exit();
	}
?>
	
<?//Defining DB queries

$dbname=DB_DATABASE;
$cur_book_status='available';

//Query to create a new row in books!! New way!!
$qry_add_row="INSERT INTO  `$dbname`.`books` (
			`id` ,
			`username` ,
			`book` ,
			`year` ,
			`course`,
			`authors`,
			`isbn`,
			`cost`,
			`current_status`
			)
			VALUES (NULL ,  '$username', '$book',  '$year',  '$course', '$authors', '$isbn', '$cost', '$cur_book_status')";

?>

<?//Executing result and redirecting appropriately
$res_add_book=mysql_query($qry_add_row);
	if($res_add_book){
	header("location: addbook-success.php");
	exit();
	}

if(!$res_add_book){
header("location: addbook-fail.php");
exit();
}
?>