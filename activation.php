<?php
	//Start session
	session_start();
	
	//Include database connection details
	require_once('config.php');
?>
<?//Connection and sanitize Section. 
	
//Include the file for connection to DB
require_once('connectdb.php');

//Include the file for including clean() to sanitize values
require_once('sanitize.php');	
	
	//Sanitize the POST values
	$login = clean($_GET['login']);
	$code = clean($_GET['code']);
	$code = stripslashes($code);
	$login = stripslashes($login);
	
	//Queries to check if code is correct

	
	$qry_check ="SELECT * 
				FROM `members`
				WHERE `members`.`login` = $login
				AND `members`.`activation_code` = $code
				";
				
	$qry_activate= "UPDATE  `members` 
					SET  `status` =  'active',
					`activation_code` =  ''
					WHERE  `members`.`login` = $login
					AND `activation_code`= $code
					"; 
				
	//Execute the queries
	$result_check=mysql_query($qry_check);
		
		if(!$result_check){
		header("location: activation-fail.php");
		exit();
		}

$num_rows=mysql_num_rows($result_check);

if($num_rows==1){
$result_activate=mysql_query($qry_activate) or die('step2');
		if(!$result_activate){
		header("location: activation-fail.php");
		exit();
		}
if($result_activate){
header("location: register-success.php");
exit();
}
}
else{
header("location: activation-fail.php");
exit();
}

?>