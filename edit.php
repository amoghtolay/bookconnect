<?php
//The require section.  Scripts to include the connection settings as well as to ensure that the user is logged in!!
	require_once('auth.php');
	require_once('config.php');
?>

<html>
<head>
<title>Edit books </title>
<h1> Hi <? echo $_SESSION['SESS_FIRST_NAME']; ?>!!! On this page you can view or modify the books u have uploaded! </h1>
</head>
<p>
<?//Connection Section. 
	
//Include the file for connection to DB
require_once('connectdb.php');
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
	<th>Price of Book(INR)</th>
	<th></th>
	</tr>";
	
	while ($line = mysql_fetch_array($result)) {
	   		   echo "\t\t<td>". $line['book']. "</td>";
			   echo "\t\t<td>" .$line['authors']. "</td>";
			   echo "\t\t<td>" .$line['cost']. "</td>";
			   
			   if($line['current_status']=='available')
			   echo '<td><a href="modify.php?id='.$line['id'].'">Click to edit this entry </a></td>';
			   
			   else if($line['current_status']=='requested'){
			   $id=$line['id'];
			   $username=$_SESSION['SESS_USERNAME'];
			   $get_request_by = 	"SELECT * 
									FROM  `requests` 
									WHERE  `book_id` = '$id'
									AND `owner`= '$username'
									";

				$res_request_by=mysql_query($get_request_by);					
				$row = mysql_fetch_array($res_request_by);
				$request_by = $row['request_name'];
				echo '<td><a href="respond.php?id='.$line['id'].'">Book requested by '.$request_by.'</a></td>'; 
			   }
			   else if($line['current_status']=='SOLD'){
			   echo '<td>You have sold this book!!</td>';
			   }
	   $count++;
	   echo "</tr>";
	   }
	
	echo "</table>\n";

echo "<br><br>$count books are present in your list!!";	
}
?>
<? //Query section.  All queries are written in this block!!

	
	//Defining DB queries
	$username=$_SESSION['SESS_USERNAME'];
	$query=	"SELECT * FROM `books` WHERE `username`='$username'";
	
?>
<?//Display table and then close connection!!

$result=mysql_query($query);
$rows=mysql_num_rows($result);

if($rows<1){
echo "<br>No books have been added with your username!! Please addbooks then view them here<br><br>";
echo '<a href="logout.php">Logout</a>';
echo '<br><a href="member-index.php">Click here</a> to go to member-index';
echo '</p>';
echo '</html>';
exit();
}

if($result){	
displaytable($result);

	// We will free the resultset...
	mysql_free_result($result);
}	

if(!$result){
	echo "There was some problem in obtaining your books....<br><br>";
	echo '<a href="logout.php">Logout</a>';
	echo '</p>';
	echo '</html>';
	exit();
	}

	// Now we close the connection...
	mysql_close($link);
    
?>

<br> To return to the member-index page, please <a href="member-index.php"> Click here </a> <br>
<a href="logout.php">Logout</a>
</p>
</html>
