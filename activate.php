<html>
<head>
<title>Activation code sent</title>
</head>
<body>
<h1>Awaiting Activation!</h1>
<br>
<h3>Congratulations!! We have sent you an e-mail at the login address provided by you in the registration form, ie. at [login]@iitg.ernet.in<br></h3>
You will be recieving the activation mail shortly, please click on the link given in the email to activate your account!!

<?

	//Start session
	session_start();
	
	//Include database connection details
	require_once('config.php');
	
//Connection and sanitize Section. 
	
//Include the file for connection to DB
require_once('connectdb.php');

//Include the file for including clean() to sanitize values
require_once('sanitize.php');	
	
	//Sanitize the POST values
	$login = clean($_GET['login']);

	
//Snippet to Generate a random code

function genRandomString() {
    $length = 20;
    $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $string='';    
    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, (strlen($characters)-1))];
    }
    return $string;
}


//This is the random code
$code=genRandomString();

//Write query to update the table members

$qry_add_code_members = "UPDATE  `members` 
						SET  `activation_code` =  '$code'
						WHERE  `members`.`login` = '$login'
						";
$result_add_code=mysql_query($qry_add_code_members) or die('Failed to add activation code in memebers. Contact webmaster '. mysql_error());

//Generate secret URL
$url="activation.php?login='$login'&code='$code'";

//For the time being, display the URL as is, later correct it by employing mail function to be written below
echo '<br>Since mail function is not working on localhost/free host, ';
echo 'The e-mail that should be sent is shown below:<br>';


//Write here code to send mail of the url at the address
	$subject="Activate your Bookconnect Account";
	$body = 'To activate your bookconnect account, please click on the link below.
			If clicking this does not work, just paste the following URL in the browsers address bar:<br><br>
			<a href="'.$url.'">'.$url.'</a>';
	$to = $login.'@iitg.ernet.in';
	$from='noreply@bookconnect.com';
	
//Headers, only gotta use the html content if actual html is being done
//also from header is must	

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'From: Bookconnect Webmaster <webmaster@booconnect.com>' . "\r\n";
//All headers end here
	
	echo 'The following will be the mail sent<br><br>';
	echo 'To field: '.$to.'<br>';
	echo 'From field: '.$from.'<br>';
	echo 'Subject field: '.$subject.'<br>';
	echo 'Body field: '.$body.'<br>';

/*Actually sending e-mail in the following lines of code

if (mail($to, $subject, $body, $headers)) {
   echo("<p>Message successfully sent!</p>");
  } else {
   echo("<p>Message delivery failed...</p>");
  }
Code for sending mail ends here, this should be uncommenetd when site hosted on actual webspace
*/
?>

<p><a href="index.php">Click here</a> to go to the home page.</p>
</body>
</html>
