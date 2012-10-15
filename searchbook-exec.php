<?php
//The require section.  Scripts to include the connection settings as well as to ensure that the user is logged in!!
	require_once('auth.php');
	require_once('config.php');
?>

<html>
<head>
<h1> Search results </h1>
</head>
<body>	
<?//Connection and sanitize Section. 
	
//Include the file for connection to DB
require_once('connectdb.php');

//Include the file for including clean() to sanitize values
require_once('sanitize.php');	
	
	//Sanitize the POST values
	$choice=clean($_POST['choice']);
	$entry=$_POST['entry'];
	
	//Declaring variables
	$keyword=NULL;
	$book=NULL;
	$isbn=NULL;
	$authors=NULL;
	
	//Assigning appropriate values to the variables according to choice in drop-menu
		if($choice=="bookname"){
		$book=clean($entry);
		echo "The search is performed using $entry as bookname";
		}
		
	if($choice=="authors"){
	$authors=clean($entry);
	echo "The search is performed using $entry as author(s) names";
	}
	
		if($choice=="isbn"){
		$isbn=clean($entry);
		echo "The search is performed using $entry as ISBN";
		}
		
	if($choice=="keyword"){
	$keyword=clean($entry);
	echo "The search is performed using $entry as keyword and was searched both in books and authors";
	}
?>
	
<?//Display section.  This section contains the display function and displays the result obtained from query in tabular form.

function display_and_is_available($result)
{

echo "<table border='0' width='6000'>\n";
	
	$count = 0;
	echo "<table border='1'>
	<tr>
	<th>Book</th>
	<th>Author(s)</th>
	<th>Price of Book</th>
	<th></th>
	</tr>";
	
	while ($line = mysql_fetch_array($result)) {
	   		   echo "\t\t<td>". $line['book']. "</td>";
			   echo "\t\t<td>" .$line['authors']. "</td>";
			   echo "\t\t<td>" .$line['cost']. "</td>";
			   
			   //Check if book is available, if yes, show the transaction link, else show not available
					if($line['current_status']=='available')
					echo '<td><a href="transaction.php?id='.$line['id'].'">Click to Buy this book </a></td>';
						else if($line['current_status']=='requested')
						echo '<td>Book not available for sale :(</td>';
						else if($line['current_status']=='SOLD')
						echo '<td>Book has been SOLD!!</td>';
	   $count++;
	   echo "</tr>";
	}
	
	echo "</table>\n";

echo "<br><br>$count rows were found in the table which matched your query!!";	
}
?>

<?//Query section.  All queries are written in this block!!

	//Defining DB queries
	// Performing SQL query
	
	//The fulltext searching is performed first, coz it would lead to better results
	
	$query_fulltext=		"SELECT *, 
							MATCH(book, authors) AGAINST('$keyword') AS score 
							FROM books 
							WHERE MATCH(book, authors) AGAINST('$keyword') 
							ORDER BY score DESC";
						
	$query_book_fulltext= 	"SELECT *, 
							MATCH(book) AGAINST('$book') AS score 
							FROM books 
							WHERE MATCH(book) AGAINST('$book') 
							ORDER BY score DESC";
						
	$query_authors_fulltext="SELECT *, 
							MATCH(authors) AGAINST('$authors') AS score 
							FROM books 
							WHERE MATCH(authors) AGAINST('$authors') 
							ORDER BY score DESC";
						
	
	$query_overall= "SELECT * 
					FROM  `books` 
					WHERE  `book` LIKE  '%$book%'
					OR `authors` LIKE  '%$authors%'
					";
	
						
	$query_book= 	"SELECT * 
					FROM  `books` 
					WHERE  `book` LIKE  '%$book%'
					";
	
	$query_authors= "SELECT * 
					FROM  `books` 
					WHERE `authors` LIKE  '%$authors%'
					";
						
	$query_isbn=	"SELECT *
					FROM `books`
					WHERE `isbn` LIKE '$isbn'
					";

?>


<?//In this segment of php code, there is the search algo.  This segment only decides which sql query to execute and stuff
//and the final value is stored in the variable result
//then this variable is displayed using function display_and_is_available()

$errflag=false;
//If keyword given as choice, then check if keyword entered and do full-text search
{
if($choice=="keyword")
{
if($keyword == '') {
		$errmsg_arr[] = 'Keyword missing';
		$errflag = true;
		}
	
$result = mysql_query($query_fulltext) or die('Query failed: ' . mysql_error());
}

//If bookname given as choice, then check if book entered and do LIKE Search
if($choice=="bookname")
{
if($book == '') {
		$errmsg_arr[] = 'Books name missing';
		$errflag = true;
		}
	
$result = mysql_query($query_book_fulltext) or die('Query failed: ' . mysql_error());
}

//If authors given as choice, then check if authors entered and do LIKE search
if($choice=="authors")
{
if($authors == '') {
		$errmsg_arr[] = 'Authors name missing';
		$errflag = true;
		}
	
$result = mysql_query($query_authors_fulltext) or die('Query failed: ' . mysql_error());
}

//If isbn given as choice, then check if isbn entered and do LIKE search
if($choice=="isbn")
{
if($isbn == '') {
		$errmsg_arr[] = 'ISBN missing';
		$errflag = true;
		}
	
$result = mysql_query($query_isbn) or die('Query failed: ' . mysql_error());
}
//If a required field is empty, then display error and go back to search form
if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		header("location: searchbook.php");
		exit();
}
}
?>

<?//In this segment is the code for too few results
$rows_obtained=mysql_num_rows($result);

$totalres=mysql_query("SELECT * FROM books");
$total_rows=mysql_num_rows($totalres);

	if($rows_obtained==0){
	echo "<br><br><b>The search query did not return a single result. :(
	Please, improve the search string and try again.</b>";
	echo '<br><br>Please <a href="searchbook.php"> Try again </a>with a different keyword<br><br>';
	}
?>
<?//Display table and then close connection!!
display_and_is_available($result);

	// We will free the resultset...
	mysql_free_result($result);
	
	// Now we close the connection...
	mysql_close($link);
    
?>
<br>
<br> To return to the member-index page, please <a href="member-index.php"> Click here </a> <br>
<a href="logout.php">Logout</a>
</html>