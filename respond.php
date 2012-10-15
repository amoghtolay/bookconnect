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
	$book_id=clean($_GET['id']);
	$username=$_SESSION['SESS_USERNAME'];

?>

<html>
<head>
<title>Respond to Request</title>
<h1>Respond to the request to buy the following book:</h1>
<?//Display section.  This section contains the display function and displays the result obtained from query in tabular form.

function displaytable($result)
{

echo "<table border='0' width='6000'>\n";
	
	$count = 0;
	echo "<table border='1'>
	<tr>
	<th>Book</th>
	<th>Author(s)</th>
	<th>Price of Book</th>
	<th>Course Name</th>
	</tr>";
	
	while ($line = mysql_fetch_array($result)) {
	   		   echo "\t\t<td>". $line['book']. "</td>";
			   echo "\t\t<td>" .$line['authors']. "</td>";
			   echo "\t\t<td>" .$line['cost']. "</td>";
			   echo "\t\t<td>" .$line['course']. "</td>";
	   $count++;
	   echo "</tr>";
	}
	
	echo "</table>\n";
}
?>
<?
$qry_book_show="SELECT *
				FROM `books`
				WHERE `id`='$book_id'
				AND `username` = '$username'
				";
				
$get_request_by = 	"SELECT * 
					FROM  `requests` 
					WHERE  `book_id` = '$book_id'
					AND `owner`='$username'
					";

$res_request_by=mysql_query($get_request_by);					
$row = mysql_fetch_array($res_request_by);

$request_by = $row['request_name'];
$reply=$row['request_reply'];

$res_show_book=mysql_query($qry_book_show) or die('Query could not be completed: ' . mysql_error());
displaytable($res_show_book);

if($reply=='yes'){
echo "You have already accepted this request!! Exiting...";
echo '<br> To return to the member-index page, please <a href="member-index.php"> Click here </a> <br>
<a href="logout.php">Logout</a>
</p>';
exit();
}
if($reply=='no'){
echo "You have already denied this request!! Exiting...";
echo '<br> To return to the member-index page, please <a href="member-index.php"> Click here </a> <br>
<a href="logout.php">Logout</a>
</p>';
exit();
}
?>
<p>
<br><br>Do you want to sell this book to <?echo $request_by ;?>??<br><br>

<!-- Form for Accepting or rejecting request, can be modified to include reasons also!! -->

	<form method="post" action="respond-exec.php?id=<?echo $book_id;?>">

<!--Choice-->
	<select name="response">
	<option value="yes"> YES!! I want to sell the book to this person!! </option>
	<option value="no"> NO! I don't want to sell my book to this person :( </option>
	</select>
	<br>

<input type="submit" name="Submit" value="Submit">

</form> 
<br> To return to the member-index page, please <a href="member-index.php"> Click here </a> <br>
<a href="logout.php">Logout</a>
</p>
</body>
</html>