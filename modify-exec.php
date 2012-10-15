<html>
<head>
<title>MODIFY SUCCESS</title>
<h1>Modified as follows:</h1>
</head>
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
	
	//Sanitize the POST and GET values
	$username=$_SESSION['SESS_USERNAME'];
	
	$book=clean($_POST['book']);
	$authors=clean($_POST['authors']);
	$isbn=clean($_POST['isbn']);
	$course=clean($_POST['course']);
	$year=clean($_POST['year']);
	$id=clean($_GET['id']);
	$cost=clean($_POST['cost']);
?>
<?
$update="UPDATE  `books` 
		SET  `book` =  '$book',
		`authors`= '$authors',
		`isbn`= '$isbn',
		`course` = '$course',
		`year` = '$year',
		`cost` = '$cost'
		 WHERE  `books`.`id` = '$id'
		 AND `username`= '$username'
		 ";


$updateresult=mysql_query($update);
$query=	"SELECT * FROM `books` WHERE `id`='$id'";

if(!$updateresult){
echo "<br><br>Query Failed and $updateresult is False";
echo '<br> To return to the member-index page, please <a href="member-index.php"> Click here </a> <br>
<a href="logout.php">Logout</a>
</p>
</html>';
exit();
}
?>

<?//Display section.  This section contains the display function and displays the result obtained from query in tabular form.

function displaytable($result)
{
echo "<table border='0' width='6000'>\n";
	
	$count = 0;
	echo "<table border='1'>
	<tr>
	<th>Book</th>
	<th>Author(s)</th>
	<th>Price of book</th>
	</tr>";
	
	while ($line = mysql_fetch_array($result)) {
	   		   echo "\t\t<td>". $line['book']. "</td>";
			   echo "\t\t<td>" .$line['authors']. "</td>";
			   echo "\t\t<td>" .$line['cost']. "</td>";
	   $count++;
	   echo "</tr>";
	}
	
	echo "</table>\n";

echo "<br><br>$count rows were affected and modified in your table of books!!";	
}
?>
<?//Display table and then close connection!!
$result=mysql_query($query);
displaytable($result);

	// We will free the resultset...
	mysql_free_result($result);
	
	// Now we close the connection...
	mysql_close($link);
    
?>


<br> To return to the member-index page, please <a href="member-index.php"> Click here </a> <br>
<a href="logout.php">Logout</a>
</p>
</html>