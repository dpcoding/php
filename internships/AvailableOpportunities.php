<?php
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Available Opportunities</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<h1>College Internship</h1>
<h2>Available Opportunities</h2>
<?php
	include_once("inc_db_internships.php");
	if (isset($_COOKIE['LastRequestDate']))
		 $LastRequestDate = $_COOKIE['LastRequestDate'];
	else
		 $LastRequestDate = "";
	$errors = 0;
	// connect to the database.  Store the result in $DBConnect
	//$DBConnect = mysql_connect("host", "user", "password"); /*** check this ***/
	if ($DBConnect === FALSE) {
		 echo "<p>Unable to connect to the database server. " . 
			  "Error code " . mysql_errno() . ": " . 
			  mysql_error() . "</p>\n";
		 ++$errors;
	}
	else {
		 $DBName = "internships";
		 // select the internships database.  Store the result in $result pg510.4
		 $result = mysql_select_db($DBName, $DBConnect);
		 if ($result === FALSE) {
			  echo "<p>Unable to select the database. " . 
				   "Error code " . mysql_errno($DBConnect) . ": " .
				   mysql_error($DBConnect) . "</p>\n";
			  ++$errors;
		 }
	}
	$TableName = "interns";
	if ($errors == 0) {
		// create a variable $SQLstring that selects all of the information 
		// from the interns table for the intern who is logged in.
		// use this internID stored in the session array
		$internID = $_SESSION['internID'];
		$SQLstring = "SELECT * FROM $TableName WHERE internID='$internID'";
		// execute the query store the result in $QueryResult pg 510.5
		$QueryResult = mysql_query($SQLstring, $DBConnect);
		 if ($QueryResult === FALSE) {
			  echo "<p>Unable to execute the query. " . 
				   "Error code " . mysql_errno($DBConnect) . ": " .
				   mysql_error($DBConnect) . "</p>\n";
			  ++$errors;
		 }
		 else {
			  if (mysql_num_rows($QueryResult) == 0) {
				   echo "<p>Invalid Intern ID!</p>";
				   ++$errors;
			  }
		 }
	}
	if ($errors == 0) {
		 // get the record from the record set as an associative array
		 // store it in a varialbe $Row
		 $Row = mysql_fetch_assoc($QueryResult);
		 $InternName = $Row['first'] . " " . $Row['last'];
	} else
		 $InternName = "";
	$TableName = "assigned_opportunities";
	$ApprovedOpportunities = 0;
	// create a SQLstring that counts the number of approved opportunities
	// for this intern (date approved is not null) pg511.7
	$SQLstring = "SELECT COUNT(opportunityID) FROM $TableName WHERE internID='$internID' AND date_approved IS NOT NULL";
	// execute the query.  STore the result in $QueryResult
	$QueryResult = mysql_query($SQLstring, $DBConnect);
	if (mysql_num_rows($QueryResult) > 0) {
		 $Row = mysql_fetch_row($QueryResult);
		 $ApprovedOpportunities = $Row[0];
		 mysql_free_result($QueryResult);
	}
	$SelectedOpportunities = array();
	// create a sql string, $SQLstring, that selects just the opportunity id
	// for all of the assigned opportunities that have been selected by this intern pg511.8
	$SQLstring = "SELECT opportunityID FROM $TableName WHERE internID='$internID' AND date_selected IS NOT NULL";
	// execute the query and store the result in $QueryResult
	$QueryResult = mysql_query($SQLstring, $DBConnect);
	if (mysql_num_rows($QueryResult) > 0) {
		 while (($Row = mysql_fetch_row($QueryResult)) !== FALSE)
			  $SelectedOpportunities[] = $Row[0];
		
		mysql_free_result($QueryResult);
		//print_r($SelectedOpportunities); // check the array value
		//print_r($SQLstring);
	}
	$AssignedOpportunities = array();
	// create a sql string, $SQLstring, that gets just the opportunity id from 
	// the assigned opportunities that have already been approved pg512.9
	$SQLstring = "SELECT opportunityID FROM $TableName WHERE date_approved IS NOT NULL";
	// execute the query and store the result in $QueryResult
	$QueryResult = mysql_query($SQLstring, $DBConnect);
	if (mysql_num_rows($QueryResult) > 0) {
		 while (($Row = mysql_fetch_row($QueryResult)) !== FALSE)
			  $AssignedOpportunities[] = $Row[0];
		 mysql_free_result($QueryResult);
	}
	$TableName = "opportunities";
	$Opportunities = array();
	// create a sql string, $SQLstring, that gets all of the opportunties pg 512.10
	//$SQLstring = "SELECT opportunityID, company, city, start_date, end_date, position, description FROM $TableName";
	$SQLstring = "SELECT * FROM $TableName";
	// execute the query and store the result in $QueryResult
	$QueryResult = mysql_query($SQLstring, $DBConnect);
	if (mysql_num_rows($QueryResult) > 0) {
		 while (($Row = mysql_fetch_assoc($QueryResult)) !== FALSE)
			  $Opportunities[] = $Row;
		 mysql_free_result($QueryResult);
	}
	// close the database connection page 512.10
	mysql_close($DBConnect);
	if (!empty($LastRequestDate))
		 echo "<p>You last requested an internship opportunity " .
				   " on $LastRequestDate.</p>\n";

	echo "<table border='1' width='100%'>\n";
	echo "<tr>\n";
	echo "     <th style='background-color:cyan'>Company</th>\n";
	echo "     <th style='background-color:cyan'>City</th>\n";
	echo "     <th style='background-color:cyan'>Start Date</th>\n";
	echo "     <th style='background-color:cyan'>End Date</th>\n";
	echo "     <th style='background-color:cyan'>Position</th>\n";
	echo "     <th style='background-color:cyan'>Description</th>\n";
	echo "     <th style='background-color:cyan'>Status</th>\n";
	echo "</tr>\n";
	foreach ($Opportunities as $Opportunity) {
		 if (!in_array($Opportunity['opportunityID'],
				   $AssignedOpportunities)) {
			  echo "<tr>\n";
			  echo "     <td>" . 
						htmlentities($Opportunity['company']) . 
						"</td>\n";
			  echo "     <td>" . 
						htmlentities($Opportunity['city']) . 
						"</td>\n";
			  echo "     <td>" . 
						htmlentities($Opportunity['start_date']) . 
						"</td>\n";
			  echo "     <td>" . 
						htmlentities($Opportunity['end_date']) . 
						"</td>\n";
			  echo "     <td>" . 
						htmlentities($Opportunity['position']) . 
						"</td>\n";
			  echo "     <td>" . 
						htmlentities($Opportunity['description']) . 
						"</td>\n";
			  echo "     <td>";
			  if (in_array($Opportunity['opportunityID'],
						$SelectedOpportunities))
				   echo "Selected";
			  else {
				   if ($ApprovedOpportunities>0)
						echo "Open";
				   else
						echo "<a href='RequestOpportunity.php?" .
							 SID . "&opportunityID=" . 
							 $Opportunity['opportunityID'] .
							 "'>Available</a>";
			  }
			  echo "</td>\n";
			  echo "</tr>\n";
		 }
	}
	echo "</table>\n";
	echo "<p><a href='InternLogin.php'>Log Out</a></p>\n";

?>
</body>
</html>

