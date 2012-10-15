<?php
//The require section.  Scripts to include the connection settings as well as to ensure that the user is logged in!!
	require_once('auth.php');
	require_once('config.php');
?>

<html>
<head>
<title>Request Status </title>
<h1> Hi <? echo $_SESSION['SESS_FIRST_NAME']; ?>!!! On this page you can check for the status of requests that you generated!! </h1>
</head>
<p>
<?//Connection Section. 
	
//Include the file for connection to DB
require_once('connectdb.php');

$username=$_SESSION['SESS_USERNAME'];
?>

<?//Display section.  This section contains the display function and displays the result obtained from query in tabular form.
function status($result)
{


echo "<table border='0' width='6000'>\n";
	
	$count = 0;
	echo "<table border='1'>
	<tr>
	<th>Book</th>
	<th>Author(s)</th>
	<th>Price of Book(INR)</th>
	<th></th>
	</tr>";
	
	while ($line = mysql_fetch_array($result)) {
				
				$id=$line['id'];
				$qry_get_book_details = 	"SELECT *
											FROM `books`
											WHERE `id`= '$id'
											";
							
				$res_bookdata=mysql_query($qry_get_book_details) or die('Could not get book details');
				$bookdetails = mysql_fetch_array($res_bookdata);
				
	   		   echo "\t\t<td>". $bookdetails['book']. "</td>";
			   echo "\t\t<td>" .$bookdetails['authors']. "</td>";
			   echo "\t\t<td>" .$bookdetails['cost']. "</td>";
			   
			   if($line['request_reply']=='yes')
			   echo '<td>Your request has been accepted by '.$line['owner']. '</td>';
			   
			   else if($line['request_reply']=='no')
			   echo '<td>Your request has been denied</td>';
			   
			   else if($line['request_reply']=='')
			   echo '<td>Request Pending!</td>';
			   
	   $count++;
	   echo "</tr>";
	   }
	
	echo "</table>\n";

echo "<br><br>$count books have been requested by you!!";	
}
?>
<? //Query section.  All queries are written in this block!!

$qry_get_request_status = 	"SELECT * 
							FROM  `requests` 
							WHERE  `request_login` = '$username'
							";
							

							
$result=mysql_query($qry_get_request_status) or die('Query failed!! If you have requested for books, please contact webmaster');
$rows=mysql_num_rows($result);


if($rows<1){
echo "You haven't requested for any books... First please request for books, then check their status";
echo '<br> To return to the member-index page, please <a href="member-index.php"> Click here </a> <br>
<a href="logout.php">Logout</a>
</p>
</html>';
exit();
}

if($rows>=1){
status($result);
}
?>

<br> To return to the member-index page, please <a href="member-index.php"> Click here </a> <br>
<a href="logout.php">Logout</a>
</p>
</html>


	