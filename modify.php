<?php
//The require section.  Scripts to include the connection settings as well as to ensure that the user is logged in!!
	require_once('auth.php');
	require_once('config.php');
?>
<html>
<head>
<title>Modify Book </title>
<h1> Hi <? echo $_SESSION['SESS_FIRST_NAME']; ?>!!! You are going to modify the selected book </h1>
</head>
<p>
Your username is: <? echo $_SESSION['SESS_USERNAME'];?>
<br>
<?//Connection and sanitize Section. 
	
//Include the file for connection to DB
require_once('connectdb.php');

//Include the file for including clean() to sanitize values
require_once('sanitize.php');
	
	//Sanitize the POST values
	$id=clean($_GET['id']);
	$username=$_SESSION['SESS_USERNAME'];
?>
<?//SQL Queries and their execution, checking if rows are returned

$query=	"SELECT * 
		FROM  `books` 
		WHERE  `id` = '$id'
		AND `username`='$username'
		";

$result=mysql_query($query) or die('Query failed: ' . mysql_error());
$rows=mysql_num_rows($result);

if($rows<1){
echo "No books with this id have been entered with your name! ";
echo '<br> To return to the member-index page, please <a href="member-index.php"> Click here </a> <br>
<a href="logout.php">Logout</a>
</p>
</html>';
exit();
}
		
$entry = mysql_fetch_array($result);
?>
<!-- Modify Form -->	
	<form method="post" action="modify-exec.php?id=<?echo "$id";?>">
	
	<b>Name of book</b>
<!-- The name of the book to be edited --> 
	<input name="book" type="text" value="<?echo "$entry[book]"?>">

<p>&nbsp;</p>


    <b>Year for which book reqd:(Enter 1/2/3/4)</b>
<!-- College year for which typically required --> 
 
	<input name="year" type="text" value="<?echo "$entry[year]";?>">

<p>&nbsp;</p>

    <b>Course ID</b>
<!-- Course ID --> 
 
	<input name="course" type="text" value="<?echo "$entry[course]";?>">

<p>&nbsp;</p>	

    <b>Author(s)</b>
<!-- Authors names --> 
 
	<input name="authors" type="text" class="textfield" id="authors" value="<?echo "$entry[authors]";?>" >

<p>&nbsp;</p>
    <b>ISBN</b>
<!-- ISBN(if known) --> 
 
	<input name="isbn" type="text" class="textfield" id="isbn" value="<?echo "$entry[isbn]";?>" >
	
<p>&nbsp;</p>
    <b>Cost</b>
<!-- Cost --> 
 
	<input name="cost" type="text" class="textfield" id="cost" value="<?echo "$entry[cost]";?>" >

		
<!-- Submit button -->

<p>&nbsp;</p>

	<input type="submit" name="Submit" value="Edit Book">
    
</form>

<br> To return to the member-index page, please <a href="member-index.php"> Click here </a> <br>
<a href="logout.php">Logout</a>
</p>
</html>
