<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Creating Database</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<?php
$DBName = "newsletter";
$DBConnect = mysql_connect("localhost", "root", "");
if ($DBConnect === FALSE)
     echo "<p>Connection error: "
               . mysql_error() . "</p>\n";
else {
	$sql = "CREATE database $DBName;";
	if (mysql_query($sql, $DBConnect) === FALSE)
	  echo "<p>Could not create the \"$DBName\" " .
				"database: " . mysql_error($DBConnect) . "</p>\n";
	else
	  echo "<p>Successfully created the  " .
				"\"$DBName\" database.</p>\n";
	mysql_close($DBConnect);
}
?>
</body>
</html>

