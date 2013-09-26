<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Newsletter Subscribers</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<h1>Newsletter Subscribers</h1>
<?php
	// 1. include the inc_db file here.  It makes a connection to the db.
	// $DBConnect will contain a connection variable or false
	include("inc_db_newsletter.php");
	if ($DBConnect !== FALSE) 
	{	
		// 2. create a variable that stores a sql select statement
		$TableName = "subscribers";
		// the statement should select all of the records from the subscribers table
		// sort the records in a way that makes sense to you
		$SQLstring = "SELECT * FROM $TableName ORDER BY name";
		$QueryResult = mysql_query($SQLstring, $DBConnect);
		// 3. execute the sql statement.  
		// store the result in $QueryResult
		 echo "<table width='100%' border='1'>\n";
		 echo "<tr><th>Subscriber ID</th>" .
			  "<th>Name</th><th>Email</th>" .
			  "<th>Subscribe Date</th>" .
			  "<th>Confirm Date</th></tr>\n";
		// 4. call the mysql function that returns a record from the result set
		// in the form of an associative array.  Use $Row to store the result.
		// 5. the loop repeat as long as a record is returned from the function 
		 while (($Row = mysql_fetch_assoc($QueryResult)) !== FALSE) 
		 {
			  echo "<tr><td>{$Row['subscriberID']}</td>";
			  echo "<td>{$Row['name']}</td>";
			  echo "<td>{$Row['email']}</td>";
			  echo "<td>{$Row['subscribe_date']}</td>";
			  echo "<td>{$Row['confirmed_date']}</td></tr>\n";
			  // 6. copy and paste 4 here.  Note that I'm suggesting that you
			  // separate the call to the function and checking the return result
		 };
		 echo "</table>\n";
		 // 7.  call appropriate mysql functions to report the number of rows
		 $numRows = mysql_num_rows($QueryResult);
		 // and number of columns returned from the sql select previous query
		 $numCols = mysql_num_fields($QueryResult);
		 // output the results here
		 echo "<p>Your query returned the above "
			  . $numRows . " rows and "
			  . $numCols . " fields:</p>";
		 // 8. close the query and then the database connection
		 mysql_free_result($QueryResult);
		 mysql_close($DBConnect);
	}
?>
</body>
</html>

