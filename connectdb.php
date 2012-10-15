<?//Required scripts
	require_once('config.php');
?>
<?//Connection Section.   This section connnects to Database, then sanitizes the obtained values.
	
	//Connecting to the mysql account

	$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if(!$link) {
		die('Failed to connect to server: ' . mysql_error());
	}
	
	//Select database
	$db = mysql_select_db(DB_DATABASE);
	if(!$db) {
		die("Unable to select database");
	}
?>