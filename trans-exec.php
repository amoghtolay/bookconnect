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
	$id=clean($_GET['id']);
	$username=$_SESSION['SESS_USERNAME'];
	$requested_by=$_SESSION['SESS_FIRST_NAME'].$_SESSION['SESS_LAST_NAME'];
	$cur_status='requested';	
?>

<?
$books_update = "UPDATE  `books` 
				SET  `current_status` = '$cur_status'
				WHERE `books`.`id` = '$id'
				";
				
				//Get the owners login id!!
				$get_login_owner= 	"SELECT `username` 
									FROM  `books` 
									WHERE  `id` = '$id'
									";

				$res_owner=mysql_query($get_login_owner);					
				$line = mysql_fetch_array($res_owner);
				$owner=$line['username'];		
				
				if($owner==$username){
				echo "You cannot purchase your own book!! I warned u before too!! Thus exiting...";
				exit();
				}

$requested_by_name=$_SESSION['SESS_FIRST_NAME'].$_SESSION['SESS_LAST_NAME'];			

$dbname=DB_DATABASE;
$requests_insert = "INSERT INTO  `$dbname`.`requests` (
					`id` ,
					`book_id` ,
					`owner` ,
					`request_login` ,
					`request_name`,
					`request_reply`,
					`request_time`
					)
					VALUES (NULL ,  '$id', '$owner',  '$username',  '$requested_by_name', '', NOW())
					";  

$pendreq_qry=	"UPDATE `members`
				SET pending_requests = pending_requests + 1 
				WHERE `members`.`login` = '$owner'
				";


$res_ins=mysql_query($requests_insert) or die('Query failed: ' . mysql_error());
$res_books_update=mysql_query($books_update) or die('Query failed: ' . mysql_error());

if($res_ins && $res_books_update){
$pendreq=mysql_query($pendreq_qry)  or die('Query failed: ' . mysql_error());
	if($pendreq){
	header("location:trans-success.php");
	exit();
	}
	else{
	header("location:trans-fail.php");
	exit();
	}
}

if(!$res_ins || !$res_books_update){
header("location:trans-fail.php");
exit();
}
?>