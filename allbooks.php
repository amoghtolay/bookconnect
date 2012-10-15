<?php
//The require section.  Scripts to include the connection settings as well as to ensure that the user is logged in!!
	require_once('auth.php');
	require_once('config.php');
?>
<html>
<head>
<title>List of all books </title>
<h1> Hi <? echo $_SESSION['SESS_FIRST_NAME']; ?>!!! This is a table showing all books in the DB </h1>
</head>
<p>
Your username is: <? echo $_SESSION['SESS_USERNAME'];?>
<br>
<?//Connection and sanitize Section. 
	
	//Include the file for connection to DB
	require_once('connectdb.php');
	//Include the file for including clean() to sanitize values
	require_once('sanitize.php');	
?>
<?//Display section.  This section contains the display function and displays the result obtained from query in tabular form.

function displaytable($result)
{
echo "<table border='0' width='6000'>\n";
	
	$count = 0;
	echo "<table border='1'>
	<tr>
	<th>S.No.</th>
	<th>Book</th>
	<th>Author(s)</th>
	<th>Course name(s)</th>
	<th>Current status of books</th>
	<th>Price of book</th>
	</tr>";
	
	while ($line = mysql_fetch_array($result)) {
				echo "\t\t<td>". $line['id']. "</td>";
				echo "\t\t<td>". $line['book']. "</td>";
				echo "\t\t<td>" .$line['authors']. "</td>";
				echo "\t\t<td>" .$line['course']. "</td>";
				echo "\t\t<td>" .$line['current_status']. "</td>";
			    echo "\t\t<td>" .$line['cost']. "</td>";
	   $count++;
	   echo "</tr>";
	}
	
	echo "</table>\n";

echo "<br><br>$count rows are present in the database!!";	
}
?>
<?//SQL Queries and their execution, checking if rows are returned

$query=	"SELECT * 
		FROM  `books`
		";

$result=mysql_query($query) or die('Query failed: ' . mysql_error());

//Display table and then close connection!!

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