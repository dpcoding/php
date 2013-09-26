<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Create ‘subscribers’ Table</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<?php
include("inc_db_newsletter.php");
if ($DBConnect !== FALSE) {
     $TableName = "subscribers";
     $SQLstring = "SHOW TABLES LIKE '$TableName'";
     $QueryResult = @mysql_query($SQLstring, $DBConnect);
     if (mysql_num_rows($QueryResult) == 0) {
          $SQLstring = "CREATE TABLE subscribers (subscriberID
               SMALLINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
               name VARCHAR(80), email VARCHAR(100),
               subscribe_date DATE,
               confirmed_date DATE)";
          $QueryResult = @mysql_query($SQLstring, $DBConnect);
          if ($QueryResult === FALSE)
               echo "<p>Unable to create the subscribers table.</p>"
               . "<p>Error code " . mysql_errno($DBConnect)
               . ": " . mysql_error($DBConnect) . "</p>";
          else
               echo "<p>Successfully created the "
               . "subscribers table.</p>";
     }
     else
          echo "<p>The subscribers table already exists.</p>";
     mysql_close($DBConnect);
}
?>
</body>
</html>

