<?php
	require_once('auth.php');
?>

<html>
<head>
<title>Member Index</title>
</head>
<body>
<h1>Welcome <?php echo $_SESSION['SESS_FIRST_NAME'];?></h1>
<h4>You have <?echo $_SESSION['SESS_PENDREQ'];?> Pending requests...</h4>
<a href="logout.php">Logout</a>
<p>This is a password protected area only accessible to members. 
<br>
<ul>
<li><a href="addbook.php">Click here</a> to add your book that you want to sell/rent<br><br></li>
<li><a href="searchbook.php">Click here</a> to search for a book that you want to buy<br><br></li>
<li><a href="edit.php">Click here</a> to view or modify the books that you have uploaded, and also to grant/deny book requests<br><br></li>
<li><a href="request-status.php">Click here</a> to view status of books requested by you!<br><br></li>
<li><a href="changepasswd.php">Click here</a> to change your password<br><br></li>
<li><a href="allbooks.php">Click here</a> to view all books present in the database<br><br></li>
<li><a href="liststuff.php">Click here</a> to access available stuff/service, eg. ED Sets, cycles, carpool etc.<br><br></li>
</ul>

</p>
</body>
</html>
