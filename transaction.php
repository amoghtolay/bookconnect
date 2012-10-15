<?php
//The require section.  Scripts to include the connection settings as well as to ensure that the user is logged in!!
	require_once('auth.php');
	require_once('config.php');
?>

<html>
<head>
<h1> Transaction </h1>
</head>
<body>	

<?//Connection and sanitize Section. 
	
//Include the file for connection to DB
require_once('connectdb.php');

//Include the file for including clean() to sanitize values
require_once('sanitize.php');	
	
	//Sanitize the POST values
	$id=clean($_GET['id']);
?>

<?//Display section.  This section contains the display function and displays the result obtained from query in tabular form.

function displaytable($result)
{
$username=$_SESSION['SESS_USERNAME'];
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
	
		if($line['username']!= $username){
	   		   echo "\t\t<td>". $line['book']. "</td>";
			   echo "\t\t<td>" .$line['authors']. "</td>";
			   echo "\t\t<td>" .$line['cost']. "</td>";
			   echo "\t\t<td>" .$line['course']. "</td>";
	   $count++;
	   echo "</tr>";
	   }
	   
	   if($line['username']==$username){
	   echo 'This is your book only!! You obviously cannot buy your own book!! :)';
	   echo '<br><br><br> To return to the member-index page, please <a href="member-index.php"> Click here </a> <br>
			<a href="logout.php">Logout</a>
			</p>
			</body>
			</html>';
	   exit();
	   }
	}
	
	echo "</table>\n";
}
?>

<?//Execute query and redirect appropriately
$qry="SELECT * FROM `books` WHERE `id` = '$id'";
$res=mysql_query($qry) or die('Query failed: ' . mysql_error());
$rows=mysql_num_rows($res);

if(($res) && ($rows==1)){
displaytable($res);
echo '<br><center><a href="trans-exec.php?id='.$id.'">Click Here</a> to send the request to the owner of the book';
}

else{
header("location:trans-fail.php");
exit();
}
	// We will free the resultset...
	mysql_free_result($res);
	
	// Now we close the connection...
	mysql_close($link);
    
?>

<br> To return to the member-index page, please <a href="member-index.php"> Click here </a> <br>
<a href="logout.php">Logout</a>
</p>
</body>
</html>