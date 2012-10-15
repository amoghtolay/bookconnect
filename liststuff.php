<?php
//The require section.  Scripts to include the connection settings as well as to ensure that the user is logged in!!
	require_once('auth.php');
	require_once('config.php');
?>

<html>
<head>
<title>List of all stuff uploaded </title>
<h2> Hi <? echo $_SESSION['SESS_FIRST_NAME']; ?>!!! Add or browse for all kinds of stuff!! Enjoy!</h2>
<h4>Here is the section of the site that is absolutely new and a trial... What you can do here is list anything that you want to
share with others, be it carpool or selling old bikes/cycles or selling ED sets etc. etc.<br>
Hope you guys enter details properly!!</h4>
</head>
<p>
<?//Connection Section. 
	
//Include the file for connection to DB
require_once('connectdb.php');
?>
<?//Check if errors and returned from addstuff.php
if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
		echo '<ul class="err">';
		echo '<b>';
		foreach($_SESSION['ERRMSG_ARR'] as $msg) {
			echo '<li>',$msg,'</li>'; 
		}
		echo '</ul>';
		echo '</b>';
		unset($_SESSION['ERRMSG_ARR']);
}
?>
<?//Display section.  This section contains the display function and displays the result obtained from query in tabular form.
function displaytable($result)
{

echo "<table border='0' width='6000'>\n";
	
	$count = 0;
	echo "<table border='1'>
	<tr>
	<th>Description of stuff available</th>
	<th>Webmail ID of owner</th>
	<th>Phone no. (optional)</th>
	</tr>";
	
	while ($line = mysql_fetch_array($result)) {
			
			if($line['status']=='approved'){
	   		   echo "\t\t<td>". $line['stuff']. "</td>";
			   echo "\t\t<td>" .$line['owner']. "</td>";
			   echo "\t\t<td>" .$line['phoneno']. "</td>";
			$count++;
			}
			   
	    echo "</tr>";
	   }
	
	echo "</table>\n";

	if($count==0){
	echo "<br><b>There are no approved entries, please come back within the next 24 hrs to check again...</b><br><br>";
	}	

}
?>
<? //Query section.  All queries are written in this block!!

	//Defining DB queries
	$query=	"SELECT * FROM `stuff` ";
	
?>
<?//Display table and then close connection!!

$result=mysql_query($query);

if($result){
$rows=mysql_num_rows($result);
}

if(!$result){
	echo "<br><b>It seems that either is no data to display as no request has been published/approved</b><br><br>";
	echo "Or there might be some problem <br> Please try again later....<br><br>";
	$rows=0;
	}


if($rows<1 && $result){
echo "<br>No stuff to show as of now, keep coming back to see if anything is uploaded...<br><br>";
}

if($result && $rows>0){	
displaytable($result);

	// We will free the resultset...
	mysql_free_result($result);
}	


	// Now we close the connection...
	mysql_close($link);
    
?>

<!--Here goes the form for adding new stuff -->
<br>
Here you can add your stuff to the above list!! Your entry will be listed after one of the admins approve it, that might take upto 1 day..<br>
<br>
<form method="post" action="addstuff.php">
	
	<b>Item/Service Description</b><br>
<!-- The name of the 'stuff' to be addded --> 
	<textarea name="stuff" rows="15" cols="50"></textarea>
	
<p>&nbsp;</p>


    <b>Phone no. (optional)</b>
<!-- Optional field for phone no. --> 
 
	<input name="phoneno" type="text" >

<br><br>
		
<!-- Submit button -->

	<input type="submit" name="Submit" value="Submit entry for verification by admin">
    
</form>

<br> To return to the member-index page, please <a href="member-index.php"> Click here </a> <br>
<a href="logout.php">Logout</a>
</p>
</html>
