<?php
	// and as model for other functions as insert, edit, update
	function insertUser($db, $name, $fname, $lname, $email, $password)
	{
		$password = md5($password);
		$sql = "insert into event_user (user_name, user_fname, user_lname, user_email, user_password) " .
			"VALUES ('$name', '$fname', '$lname', '$email', '$password')";
		$result = mysql_query($sql, $db);
		if ($result === false)
			throw new Exception("Can't run sql statement: $sql " . mysql_error());			
	}
	
	// create a new sql function for insertEvent
	function insertEvent($db, $userID, $eventTitle, $eventDescription, $eventDate)
	{
		$sql = "INSERT INTO event (event_user_id, event_title, event_description, event_date) " .
			"VALUES ('$userID', '$eventTitle', '$eventDescription', '$eventDate')";
		$result = mysql_query($sql, $db);
		if ($result === false)
			throw new Exception("Can't run sql statement: $sql " . mysql_error());			
	}
	
	// create a new sql function for deleteEvent
	function deleteEvent($db, $eventId)
	{
		$sql = "DELETE FROM event WHERE event_id = '$eventId'"; // no  AND event_user_id = '$userId'
		$result = mysql_query($sql, $db);
		if ($result === false)
			throw new Exception("Can't run sql statement: $sql " . mysql_error());
	}
	
	// create a new sql function for updateEvent
	function updateEvent($db, $eventId,  $userId, $eventTitle, $eventDescription, $eventDate)
	{
		$sql = "UPDATE event SET event_title = '$eventTitle', event_description = '$eventDescription', event_date = '$eventDate'" . 
				"WHERE event_id = '$eventId' AND event_user_id = '$userId'";		
		$result = mysql_query($sql, $db);
		if ($result === false)
			throw new Exception("Can't run sql statement: $sql " . mysql_error());
	}
	
	function retrieveEvent($db, $eventId, &$userId, &$eventDate, &$eventTitle, &$eventDescription)
	{
		$sql = "SELECT  event_id, event_user_id, event_date, event_title, event_description FROM event WHERE event_user_id = $userId AND event_id = $eventId";
		$result = mysql_query($sql, $db);
		$events = getRecordSQL($db, $sql);
		if ($events !== false)
		{
			$userId = $events['event_user_id'];
			$eventDate = $events['event_date'];
			$eventTitle = $events['event_title'];
			$eventDescription = $events['event_description'];			
		}	
		if ($result === false)
			throw new Exception("Can't run sql statement: $sql " . mysql_error());
	}
	
	function getRecordSQL($db, $sql)
	{	
		$result = mysql_query($sql, $db);
		if ($result === false)
			throw new Exception("Can't run sql statement: $sql " . mysql_error());
		
		if (($record = mysql_fetch_assoc($result)) === false)
			throw new Exception("Can't read record. $sql" . mysql_error());
		
		if (!mysql_free_result($result))
			throw new Exception ("Can't close result set.");
		
		return $record;
	}	

	function get2DArraySQL($db, $sql)
	{
		$array2D = array();
		$sql = "SELECT * FROM event_calendar.event";// added event_calender 
		$result = mysql_query($sql, $db);
		if ($result === false)
			throw new Exception("Can't run sql statement: $sql " . mysql_error());
		
		$num_records = mysql_num_rows($result);
		for ($i = 0; $i < $num_records; $i++)
		{
			if (($record = mysql_fetch_assoc($result)) !== false)
			{
				$array2D[] = $record;
			}
			else
				throw new Exception("Can't read record. " . mysql_error());
		}
		
		if (!mysql_free_result($result))
			throw new Exception ("Can't close result set.");
		
		return $array2D;
	}
	
	function db_connect($host, $user, $password, $database)
	{
		$db = mysql_connect($host, $user, $password);
		if ($db === false)
			throw new Exception("Can't connect to database server." . mysql_error());
		if (mysql_select_db($database, $db) === false)
			throw new Exception ("Can't access the $database database." . mysql_error());
		return $db;
	}
	
	// this validates userName and password, if correct correspond to a user in the database, 
	// return true and "return" via a reference parameter the userid of the user.
	function loginsql($userName, $password)
	{
		//$db = db_connect("localhost", "root", "", "event_calendar"); for local use
		$db = mysql_connect("localhost", "eventCalUser", "NQ13vg!p", "event_calendar");
		$sql = "SELECT user_id, user_name, user_fname, user_password FROM event_user WHERE user_name = '$userName' AND user_password = '$password'";
		$result = mysql_query($sql, $db);
		if ($result === false)
			throw new Exception("Can't run sql statement: $sql " . mysql_error());
		//$users = mysql_num_rows($result); //uncommet this out 3/12
		if($result !== false)
		{	
			//$user = getRecordSQL($db, $sql);
			$users = mysql_fetch_assoc($result);
			if (mysql_num_rows($result) != 0)
			{
				$_SESSION['userId'] = $users['user_id'];
				$_SESSION['userName'] = $users['user_name']; // change from $_POST to $numrows
				$_SESSION['userFirst'] = $users['user_fname'];
				return true;
			}
			else
			{
				echo "You don't have the access to the Best EVENT site.";
				return false;
			}
		}
		else
		{
			$errorMessage = "<p>The username/password combination entered is not valid.</p>\n";
			return false;
		}	
	}
	
	// search variables and function
	$searchMsg = "";
	$sortMsg = "";
	$editMsg = "";
	function highlightSQL($haystack, $needle) 
	{	
		$sql = "SELECT event_description FROM event";
		$haystack = mysql_query($sql, $db);
		$needle = $_POST['searchInput'];// I added this
		if (strlen($haystack) < 1 || strlen($needle) < 1) 
		{
			return $haystack;
		}
		preg_match_all("/$needle+/i", $haystack, $match);
		$exploded = preg_split("/$needle+/i",$haystack);
		$replaced = "";
		foreach($exploded as $e)
				foreach($match as $m)
				if($e!=$exploded[count($exploded)-1]) 
				{
					$replaced .= $e . "<font style=\"background-color:yellow\">" . $m[0] . "</font>";
				} 
				else 
				{
					$replaced .= $e;
				}
		return $replaced;
		if ($result === false)
			throw new Exception("Can't run sql statement: $sql " . mysql_error());	
	}	

/*	testing code
	{	
		$db = db_connect("localhost", "root", "", "event_calendar");
		//$userName = "dylanPan";
		//$password = "tesTing12";
		//loginsql($userName, $password);
		
		//$sql = "Select * from event_user";// those three lines for testing all fields of event_user
		//$array = get2DArraySQL($db, $sql);
		//print_r($array);
		//insertUser($db, 'goodm', 'Mari', 'Good', 'goodm@lanecc.edu', 'tesTing12');
		//insertUser($db, 'mickeyMouse', 'Mickey', 'Mouse', 'mickey@disney.com', 'tesTing12');
		//insertUser($db, 'dylanPan', 'Dylan', 'Pan', 'dylanpan78@yahoo.com', 'tesTing12');
		// try of insertEvent($db, $userID, $eventTitle, $eventDescription, $eventDate,)
		//insertEvent($db, 1, 'Event for Labs', 'This is sooooo cooooooool', '2013-03-12'); //works
		// try deleteEvent($db, $eventID)
		//deleteEvent($db, 2); //works
		// try updateEvent($db, $eventID,  $userID, $eventTitle, $eventDescription, $eventDate)
		//updateEvent($db, 5, 2, 'UPDATE', 'UPDATING.', '03/13/2013'); //works
		
		//$sql = "SELECT event_id = '$eventId', event_user_id = '$userId', event_title = '$eventTitle', event_description = '$eventDescription', event_date = '$eventDate'" . 
		//		"WHERE event_id = '$eventId' AND event_user_id = '$userId'";
		//$sql = "Select * from event";
		//$array = getRecordSQL($db, $sql);
		//print_r($array);
		mysql_close($db);
	}
	catch (Exception $e)
	{
		echo "Exception: " . $e->getMessage() . " occurred in " . $e->getFile() . " at line " . $e->getLine() . "." ; 
	}
*/
?>