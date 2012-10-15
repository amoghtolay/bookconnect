<?php
	require_once('auth.php');
?>

<html>
<head>
<title>Add book </title>
<h1> Hi <? echo $_SESSION['SESS_FIRST_NAME']; ?>!!! On this page you can add your books to your list! </h1>
</head>
<p>
<?//Check if errors and returned from addbook-exec.php
if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
		echo '<ul class="err">';
		foreach($_SESSION['ERRMSG_ARR'] as $msg) {
			echo '<li>',$msg,'</li>'; 
		}
		echo '</ul>';
		unset($_SESSION['ERRMSG_ARR']);
}
?>
Your username is: <? echo $_SESSION['SESS_USERNAME'];?>
<br>
The book will be added to the table books corresponding to this login_id. <br>

<!-- Form -->	
	<form method="post" action="addbook-exec.php">
	
	<b>Name of book</b>
<!-- The name of the book to be addded --> 
	<input name="book" type="text">

<p>&nbsp;</p>


    <b>Year for which book reqd:(Enter 1/2/3/4)</b>
<!-- College year for which typically required --> 
 
	<input name="year" type="text" >

<p>&nbsp;</p>

    <b>Course ID</b>
<!-- Course ID --> 
 
	<input name="course" type="text">

<p>&nbsp;</p>	

    <b>Author(s)</b>
<!-- Authors names --> 
 
	<input name="authors" type="text" class="textfield" id="authors" >

<p>&nbsp;</p>
    <b>ISBN</b>
<!-- ISBN(if known) --> 
 
	<input name="isbn" type="text" class="textfield" id="isbn" >
	
<p>&nbsp;</p>
    <b>Price(INR)at which u want to sell (can be 0 also)</b>
<!-- Cost--> 
 
	<input name="cost" type="text" class="textfield" id="cost" >
		
<!-- Submit button -->

	<input type="submit" name="Submit" value="Add Book">
    
</form>
To return to the member-index page, please <a href="member-index.php"> Click here </a> <br>
<a href="logout.php">Logout</a>
</p>
</html>
