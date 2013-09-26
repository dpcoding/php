<?php
	session_start();
	$Body = "";
	$errors = 0;
	include_once("inc_db_internships.php");
	if (!isset($_SESSION['internID'])) {
		 $Body .= "<p>You have not logged in or registered. " .
				   " Please return to the " .
				   " <a href='InternLogin.php'>Registration / " .
				   " Log In page</a>.</p>";
		 ++$errors;
	}
	if ($errors == 0) {
		 if (isset($_GET['opportunityID']))
			  $OpportunityID = $_GET['opportunityID'];
		 else {
			  $Body .= "<p>You have not selected an opportunity. " .
						" Please return to the " .
						" <a href='AvailableOpportunities.php?" .
						SID . "'>Available " .
						" Opportunities page</a>.</p>";
			  ++$errors;
		 }
	}
	if ($errors == 0) {
		 // connect to the database.  Store the result in $DBConnect 
		 //$DBConnect = mysql_connect("host", "user", "password"); /*** check this ***/
		 if ($DBConnect === FALSE) {
			  $Body .= "<p>Unable to connect to the database " .
				   " server. Error code " . mysql_errno() . ": " .
				   mysql_error() . "</p>\n";
			  ++$errors;
		 }
		 else {
			  $DBName = "internships";
			  // select the internships database.  Store the result in $result
			  $result = mysql_select_db($DBName, $DBConnect);
			  if ($result === FALSE) {
				   $Body .=  "<p>Unable to select the database. " .
						"Error code " . mysql_errno($DBConnect) .
						": " . mysql_error($DBConnect) . "</p>\n";
				   ++$errors;
			  }
		 }
	}
	$DisplayDate = date("l, F j, Y, g:i A");
	$DatabaseDate = date("Y-m-d H:i:s");
	$internID = $_SESSION['internID']; // declar and assign internID
	if ($errors == 0) {
		 $TableName = "assigned_opportunities";
		 // create a sql string, $SQLstring that inserts a record into the
		 // assigned opportunities table with the opportunityid, internid and 
		 // value in the varialbe $DatabaseDate 
		$SQLstring = "INSERT INTO $TableName (opportunityID, internID, date_selected) VALUES ($OpportunityID, $internID, $DatabaseDate)";
		 // execute the query and store the result in $QueryResult
		 $QueryResult = mysql_query($SQLstring, $DBConnect);
		 
		 if ($QueryResult === FALSE) {
			  $Body .= "<p>Unable to execute the query. " .
				   " Error code " . mysql_errno($DBConnect) .
				   ": " . mysql_error($DBConnect) . "</p>\n";
			  ++$errors;
		 }
		 else {
			  $Body .= "<p>Your request for opportunity # " .
						" $OpportunityID has been entered " .
						" on $DisplayDate.</p>\n";
		 }
		 // close the database
		mysql_close($DBConnect);
	}
	if ($_SESSION['internID'] > 0)
		 $Body .= "<p>Return to the <a href='AvailableOpportunities.php?" . SID . "'>" .
				  "Available Opportunities</a> page.</p>\n";
	else
		 $Body .= "<p>Please <a href='InternLogin.php'>Register " .
				   " or Log In</a> to use this page.</p>\n";
	if ($errors == 0)
		 setcookie("LastRequestDate", 
				   urlencode($DisplayDate),
				   time()+60*60*24*7);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Request Opportunity</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
	<h1>College Internship</h1>
	<h2>Opportunity Requested</h2>
<?php
    echo $Body;
?>

</body>
</html>

