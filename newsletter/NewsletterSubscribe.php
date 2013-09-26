<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Subscribe to our Newsletter</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<h1>Subscribe to our Newsletter</h1>
<?php
if (isset($_POST['Submit'])) {
     $FormErrorCount = 0;
     if (isset($_POST['SubName'])) {
          $SubscriberName = stripslashes($_POST['SubName']);
          $SubscriberName = trim($SubscriberName);
          if (strlen($SubscriberName) == 0) {
               echo "<p>You must include your name!</p>\n";
               ++$FormErrorCount;
          }
     }
     else {
          echo "<p>Form submittal error (No 'SubName' field)!</p>\n";
          ++$FormErrorCount;
     }
     if (isset($_POST['SubEmail'])) {
          $SubscriberEmail = stripslashes($_POST['SubEmail']);
          $SubscriberEmail = trim($SubscriberEmail);
          if (strlen($SubscriberEmail) == 0) {
               echo "<p>You must include your email address!</p>\n";
               ++$FormErrorCount;
          }
     }
     else {
          echo "<p>Form submittal error (No 'SubEmail' field)!</p>\n";
          ++$FormErrorCount;
     }
     if ($FormErrorCount == 0) {
          $ShowForm = FALSE;
          // 1. include the inc_db file here.  It makes a connection to the db.
		  // $DBConnect will contain a connection variable or false
		  include("inc_db_newsletter.php");
          if ($DBConnect !== FALSE) {
				$TableName = "subscribers";
               $SubscriberDate = date("Y-m-d");
			   // 2. create a variable that stores a sql insert statement
			   // the statement should insert the record into the subscribers table
				$SQLstring = "INSERT INTO $TableName(name, email, subscribe_date) VAlUES('$SubscriberName', 
				'$SubscriberEmail', '$SubscriberDate')";
               // 3. execute the sql statement.  
			   // store the result in $QueryResult
			   $QueryResult = mysql_query($SQLstring, $DBConnect);//pg 468-10
               if ($QueryResult === FALSE)
			   {
					// 4. concatenate the error number and error message
                    echo "<p>Unable to insert the values into the subscriber table.</p>"
                       . "<p>Error code " . mysql_errno($DBConnect) . ": " . mysql_error($DBConnect) . "</p>";
			   }
               else 
			   {
					// 5. the subscriber id is an autonumber field
					$SubscriberID = mysql_insert_id($DBConnect);
					// get the subscriber id from the database for the record
					// that was just added and store it in $SubscriberID
                    echo "<p>" . htmlentities($SubscriberName) .
                         ", you are now subscribed to our newsletter.<br />";
                    echo "Your subscriber ID is $SubscriberID.<br />";
                    echo "Your email address is " .
                         htmlentities($SubscriberEmail) . ".</p>";
               }
			   // 6. close the database connection
			   mysql_close($DBConnect);
          }
     }
     else
        $ShowForm = TRUE;
}
else {
     $ShowForm = TRUE;
     $SubscriberName = "";
     $SubscriberEmail = "";
}
if ($ShowForm) {
   ?>
<form action="NewsletterSubscribe.php" method="POST">
<p><strong>Your Name: </strong>
<input type="text" name="SubName" value="<?php echo $SubscriberName; ?>" /></p>
<p><strong>Your Email Address: </strong>
<input type="text" name="SubEmail" value="<?php echo $SubscriberEmail; ?>" /></p>
<p><input type="Submit" name="Submit" value="Submit" /></p>
</form>
   <?php
}
?>
</body>
</html>

