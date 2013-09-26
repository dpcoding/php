<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Message Board</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>
<body>
	<h1>Message Board</h1>
	<?php
		if (isset($_GET['action'])) 
		{
			if ((file_exists("Message/messages.txt")) && (filesize("Message/messages.txt") != 0)) 
			{
				// read the file into an array of strings
				$MessageArray = file("Message/messages.txt");
				// check the action
				switch ($_GET['action']) 
				{
					// delete the first one
					case 'Delete First':
						array_shift($MessageArray);
						break;
					// delete the last one
					case 'Delete Last': // using array_pop() to remove last element; array_push() adds 1 or more elements
						array_pop($MessageArray);
						break;
					// delete the selected message
					case 'Delete Message': // using arry_splice() first and then change to unset() 
						/*if (isset($_GET['message'])) 
							array_splice($MessageArray, $_GET['message'], 1);*/
						if (isset($_GET['message'])) 
						{
							$Index = $_GET['message'];
							unset($MessageArray[$Index]);
							$MessageArray = array_values($MessageArray);
						}
						break;
					// remove any duplicates
					case 'Remove Duplicates': // page 315-2 using array_unique() and array_values()
						$MessageArray = array_unique($MessageArray);
						$MessageArray = array_values($MessageArray);
						break;
					// sort in ascending order
					case 'Sort Ascending':
						sort($MessageArray);
						break;
					// sort in descending order
					case 'Sort Descending': 
						rsort($MessageArray);
						break;
				} // End of the switch statement
				// if there's still something left in the array after processing is done --- page 306-4.
				if (count($MessageArray) > 0) 
				{
					// create one big string from the elements of the array
					// open the file
					$NewMessages = implode($MessageArray);
					$MessageStore = fopen("Message/messages.txt", "wb"); // check what wb means
					// if there's an error opening the file
					if ($MessageStore === false)
						echo "There was an error updating the message file\n";
					// write the string and close the file
					else 
					{
						fwrite($MessageStore, $NewMessages);
						fclose($MessageStore);
					}
				}
				else
				{
					unlink("Message/messages.txt");
					//testing for refreshing problem
					//header("location: index.php");
				}
			}
		}

		// after processing the action - there may or may not be a file 
		// if the file doesn't exist or there's nothing in it - display a message
		if ((!file_exists("Message/messages.txt")) || (filesize("Message/messages.txt") == 0))
		{
			echo "<p>There are no messages posted.</p>\n";
		}
		// otherwise display the contents of the files in a table
		else 
		{
			// read the file into an array of strings
			$MessageArray = file("Message/messages.txt");
			// write the opening table tag with appropriate styling
			echo "<table style=\"background-color:lightgray\"border=\"1\" width=\"100%\">\n";
			// iterate through the array of strings, separate each string into ~ delimited fields, add the array to a 2-d array
			
			// count the number of records in the array
			$count = count($MessageArray);
			foreach($MessageArray as $Message) 
			{
				$CurrMsg = explode("~", $Message);
				$KeyMessageArray[] = $CurrMsg;
			}
			
			for ($i = 0; $i < $count; ++$i)
			{
				echo "<tr>\n";
				echo "<td width=\"5%\" style=\"text-align:center\"><span style=\"font-weight:bold\">" . ($i + 1) . "</span></td>\n"; 
				echo "<td width=\"85%\"><span style=\"font-weight:bold\">Subject: </span> " . htmlentities($KeyMessageArray[$i][0]) . "<br />\n";
				echo "<span style=\"font-weight:bold\">Name: </span> " . htmlentities($KeyMessageArray[$i][1]) . "<br />\n"; 
				echo "<span style=\"text-decoration:underline; font-weight:bold\">Message</span><br />\n" . htmlentities($KeyMessageArray[$i][2]) . "</td>\n"; 
				echo "<td width=\"10%\" style=\"text-align:center\"><a href='index.php?action=Delete%20Message&message=$i'>Delete This Message</a></td>\n"; 
				echo "</tr>\n";
			 }
			 // write the closing table tag
			 echo "</table>\n"; 
			 
			 // testing for refreshing problem
			 //header("location:" .$_SERVER["REQUEST_URI"]);
			 //exit;
			 
		} // end if there are records to display
	?> <!-- end php block -->
	<p>
		<!-- notice the href attribute of each of these anchor tags -->
		<a href="PostMessage.php">Post New Message</a><br />
		<a href="index.php?action=Sort%20Ascending">Sort Subjects A-Z</a><br />
		<a href="index.php?action=Sort%20Descending">Sort Subjects Z-A</a><br />
		<a href="index.php?action=Remove%20Duplicates">Remove Duplicate Messages</a><br />
		<a href="index.php?action=Delete%20First">Delete First Message</a><br /> 
		<a href="index.php?action=Delete%20Last">Delete Last Message</a> 
	</p>
</body>
</html>

