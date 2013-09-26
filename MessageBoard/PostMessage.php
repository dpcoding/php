<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Post Message</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" href="postMessage.css" type="text/css">
</head>
<body>
	<?php
		//error_reporting(E_ALL);
		
		// if this is NOT the first time the page is loaded the user has pressed the submit button --- 
		if (isset($_POST['submit'])) 
		{
			// get rid of the escape slashes in all fields just incase magic quotes is on
			// for all fields - Subject, Name, and Message
			$Subject = stripslashes($_POST['subject']);
			$Name = stripslashes($_POST['name']);
			$Message = stripslashes($_POST['message']);
			
			// Replace any '~' characters with '-' characters
			$Subject = str_replace("~", "-", $Subject);
			$Name = str_replace("~", "-", $Name);
			$Message = str_replace("~", "-", $Message);
			
			$ExistingSubjects = array(); // declares & initializes the empty array to use to check whether a subject alreay exists
			if ((file_exists("Message/messages.txt")) && (filesize("Message/messages.txt") > 0)) 
			{
				$MessageArray = file("Message/messages.txt");
				$count = count($MessageArray);
				for ($i = 0; $i < $count; ++$i)
				{
					$CurrMsg = explode("~", $MessageArray[$i]);
					$ExistingSubjects[] = $CurrMsg[0];
				}
				//$ExistingSubjects = file("Message/messages.txt");
			}
			
			if (in_array($Subject, $ExistingSubjects))
			{
				echo "<p>The subject you entered already exists!<br />\n";
				echo "Please enter a new subject and try again.<br />\n";
				echo "Your message was not saved.</p>";
				$Subject="";
			}
			else
			{
				// create a string that delimites fields with a ~ and listst the subject then name then message
				// put a new line char at the end too
				$MessageRecord = "$Subject ~ $Name ~ $Message\n";
				// open file for appending
				$MessageFile = fopen("Message/messages.txt", "ab"); // created a new folder (Message)
				// if the file doesn't open ok, display a message
				if ($MessageFile === FALSE)
					echo "There was an error saving your message!\n";
				else 
				{
					// otherwise write the record, close the file and display a message
					fwrite($MessageFile, $MessageRecord);
					fclose($MessageFile);
					echo "Your message has been saved.\n";
					$Subject = ""; // adding those to clear fields.
					$Name = ""; 
					$Message = "";
				}
			}		
		}
		else
		{
			$Subject = "";
			$Name = "";
			$Message = "";
		}
	?>
	<div class="container">
		<h1>Post New Message</h1>
		<hr />
		<form action="PostMessage.php" method="POST">
			<span style="font-weight:bold">Subject:</span> <input type="text" name="subject" required value="<?php echo $Subject; ?>"/>
			<span style="font-weight:bold">Name:</span> <input type="text" name="name" required value="<?php echo $Name; ?>"/><br />
			<textarea name="message" required rows="6" cols="80"><?php echo $Message; ?></textarea><br />
			<input type="submit" name="submit" value="Post Message" />
			<input type="reset" name="reset" value="Reset Form" />
		</form>
		<hr />
		<p><a href="index.php">View Messages</a></p>
	</div>
</body>
</html>

