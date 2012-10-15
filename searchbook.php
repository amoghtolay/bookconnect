<?php
	require_once('auth.php');
?>

<html>
<head>
<title>Search book </title>
<h1> Hi <? echo $_SESSION['SESS_FIRST_NAME']; ?>!!! On this page you can search for the book u want! </h1>
<h2>
<?php
	if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
		echo '<ul class="err">';
		foreach($_SESSION['ERRMSG_ARR'] as $msg) {
			echo '<li>',$msg,'</li>';
		}
		echo '</ul>';
		unset($_SESSION['ERRMSG_ARR']);
	}
?>
</h2>
</head>
<p>
Your username is: <? echo $_SESSION['SESS_USERNAME'];?>
<br>
If u select a particular book, the request will be sent from the above user <br>
<b>To search a book, you can either enter a keyword, or enter the books name/authors</b><br>

<!-- Form -->

	<form method="post" action="searchbook-exec.php">

<!--Choice of Sort By which decides which SQL query to be used-->
	<br><b>Please choose method of searching!! You can either search for a keyword, a bookname, by authors or if you know the isbn, just enter the isbn!!</b>
	<br>
	<select name="choice">
	<option value="keyword"> Search by Keyword </option>
	<option value="bookname"> Search by book's name </option>
	<option value="authors"> Search by Author(s) </option>
	<option value="isbn"> Search by ISBN </option>
	</select>
	<br>

	<b><br>Please enter a keyword!!</b>
<!-- The keyword to be searched -->
	<input name="entry" type="text">

<input type="submit" name="Submit" value="Search for book">

</form>
<br> To return to the member-index page, please <a href="member-index.php"> Click here </a> <br>
<a href="logout.php">Logout</a>
</p>
</html>
