<?php
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Verify Intern Login</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
	<h1>College Internship</h1>
	<h2>Verify Intern Login</h2>
<?php
	$errors = 0;
	// connect to the database.  Store the result in $DBConnet 
	include_once("inc_db_internships.php");
	//$DBConnect = mysql_connect("host", "user", "password"); // check values
	if ($DBConnect === FALSE) {
		 echo "<p>Unable to connect to the database server. " .
			  "Error code " . mysql_errno() . ": " .
			  mysql_error() . "</p>\n";
		 ++$errors;
	} 
	else {
		 $DBName = "internships";
		 // select the internships database.  Store the result in $result 
		 $result = mysql_select_db($DBName, $DBConnect);
		 if ($result === FALSE) {
			  echo "<p>Unable to select the database. " .
				   "Error code " . mysql_errno($DBConnect) . 
				   ": " . mysql_error($DBConnect) . "</p>\n";
			  ++$errors;
		 }
	}
	$TableName = "interns";
	$epass = md5($_POST['password']);
	$emailPost = $_POST['email'];
	if ($errors == 0) {
		// create a variable, $SQLstring, that gets the internid, first and last names
		// from the intern table where the email address and the password matches
		// the values that the user entered in the form 
		$SQLstring = "SELECT internID, first, last FROM $TableName WHERE email='$emailPost' and password_md5='$epass'";
		/* for testing
		echo $SQLstring;
		echo $epass;
		echo $emailPost; */
		// execute the query in $SQLstring
		$QueryResult = mysql_query($SQLstring, $DBConnect);
		 if (mysql_num_rows($QueryResult)==0) {
			  echo "<p>The email address/password " . 
				   " combination entered is not valid.</p>\n";
			  ++$errors;
		 }
		 else {
			  // there should just be one row that matches.  get it from
			  // the results set as an associative array and store it in a variable $Row 
			  $Row = mysql_fetch_assoc($QueryResult);
			  $_SESSION['internID'] = $Row['internID']; // this is a bit different from text
			  $InternName = $Row['first'] . " " . $Row['last'];
			  echo "<p>Welcome back, $InternName!</p>\n";     }
	}
	if ($errors > 0) {
		 echo "<p>Please use your browser's BACK button to return " .
			  " to the form and fix the errors indicated.</p>\n";
	}
	if ($errors == 0) {
	echo "<p><a href='AvailableOpportunities.php?" .
			  SID . "'>Available Opportunities</a></p>\n";
	}

?>
</body>
</html>

