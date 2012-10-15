<?php
//The require section.  Scripts to include the connection settings as well as to ensure that the user is logged in!!
	require_once('auth.php');
	require_once('config.php');
?>
<?//Connection and sanitize Section. 
	
//Include the file for connection to DB
require_once('connectdb.php');

//Include the file for including clean() to sanitize values
require_once('sanitize.php');	
	
	//Sanitize the POST values
	$response=clean($_POST['response']);
	$username=$_SESSION['SESS_USERNAME'];
	$id=clean($_GET['id']);

?>
<?//Query Section, lists down all queries
	
	//Obtaining the name of the person who has requested the book!!
	$get_request_by = 	"SELECT `request_login` 
						FROM  `requests` 
						WHERE  `book_id` = '$id'
						AND `owner`='$username'
						";

	$res_request_by=mysql_query($get_request_by);					
	$row = mysql_fetch_array($res_request_by);
	$request_by = $row['request_login'];

$qry_update_members = "UPDATE `members`
				SET pending_requests = pending_requests - 1 
				WHERE `members`.`login`='$username'
				";
				

$qry_update_books = "UPDATE `books`
					SET current_status = 'SOLD'
					WHERE `books`.`id` = '$id'
					AND `books`.`username`='$username'
					";
$qry_update_requests = "UPDATE `requests`
						SET request_reply = '$response'
						WHERE `requests`.`book_id` = '$id'
						AND `requests`.`owner`='$username'
						";
?>

<?//Execution  section, decides which queries to execute based on choice!!
$res=mysql_query($qry_update_requests) or die('Query to update requests and set reply failed :(');
$pend_req_res=mysql_query($qry_update_members) or die('Query to update pending requests failed. Contact Webmaster :(');
$books_update_res=mysql_query($qry_update_books) or die('Query to update books and set status to sold failed. Contact Webmaster :(');

if($response=='yes'){
header("location:responsetrue.php");
exit();
}
if($response=='no'){
$qry_book_available="UPDATE `books`
					SET current_status = 'available'
					WHERE `books`.`id` = '$id'
					AND `books`.`username`='$username'
					";
$res_book_available=mysql_query($qry_book_available) or die('Status of book could not be changed to available :(');
header("location:responsefalse.php");
exit();
}
?>