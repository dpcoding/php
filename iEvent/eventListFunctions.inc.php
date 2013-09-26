<?php
	
	// ex. "INSERT INTO event (event_user_id, event_date, title, description)
	// 		VALUE($userID, '$eventDate', '$eventTitle', '$eventDescription')";
	function addEvent($eventFile, $delimiter, $userId, $eventDate, $eventTitle, $eventDescription)
	{
		$events = get2DArray($eventFile, $delimiter);
		$eventId = rand(1, 10000);
		while (search_2d_array($events, 0, $eventId) !== false)
			$eventId = rand(1, 10000);	
		$index = count($events);
		$events[$index][0] = $eventId;
		$events[$index][1] = $userId;
		$events[$index][2] = $eventDate;
		$events[$index][3] = $eventTitle;
		$events[$index][4] = $eventDescription;	
		write2DArray($eventFile, $events, $delimiter);
	}
	
	//	"UPDATE event SET event_date = '$eventDate'";
	
	function editEvent($eventFile, $delimiter, $eventId, $userId, $eventDate, $eventTitle, $eventDescription)
	{
		$events = get2DArray($eventFile, $delimiter);
		$index = search_2d_array($events, 0, $eventId);
		if ($index !== false)
		{
			$events[$index][1] = $userId;
			$events[$index][2] = $eventDate;
			$events[$index][3] = $eventTitle;
			$events[$index][4] = $eventDescription;			
			write2DArray($eventFile, $events, $delimiter);
		}
	}
	/*
	function retrieveEvent($eventFile, $delimiter, $eventId, &$userId, &$eventDate, &$eventTitle, &$eventDescription)
	{
		$events = get2DArray($eventFile, $delimiter);
		$index = search_2d_array($events, 0, $eventId);
		if ($index !== false)
		{
			$userId = $events[$index][1];
			$eventDate = $events[$index][2];
			$eventTitle = $events[$index][3];
			$eventDescription = $events[$index][4];			
		}		
	}*/
	/* 
		need sql statment to deleteEvent
		ex. "DELETE FROM event WHERE event_ID = $eventID AND event_user_id = $userID";
	
	function deleteEvent($eventFile, $delimiter, $id)
	{
		$events = get2DArray($eventFile, $delimiter);
		$index = search_2d_array($events, 0, $id);
		if ($index !== false)
		{
			unset($events[$index]);
			$events = array_values($events);
			write2DArray($eventFile, $events, $delimiter);
		}
	}*/

	function echoEvents($events, $fields, $columns, $userId)
	{
		$filename =  $_SERVER['PHP_SELF'];
		$sortURL = $filename . "?action=sort&field=";
		$deleteURL = $filename . "?action=delete&id=";
		$editURL = $filename . "?action=edit&id=";
		$count = count($events);
		if ($count > 0)
		{
			echo "<table style=\"background-color:lightgray\"border=\"1\" width=\"100%\">\n";
			// column headings
			echo "<tr>\n";
			echo "<th width=\"5%\"><span style=\"font-weight:bold\">".
				"<a href='" . $sortURL . $fields[0] . "'>".$columns[0]."</a></span></th>";
			echo "<th width=\"10%\"><span style=\"font-weight:bold\">".
				"<a href='" . $sortURL . $fields[1] . "'>".$columns[1]."</a></span></th>";
			echo "<th width=\"10%\"><span style=\"font-weight:bold\">".
				"<a href='" . $sortURL . $fields[2] . "'>".$columns[2]."</a></span></th>";
			echo "<th width=\"10%\"><span style=\"font-weight:bold\">".
				"<a href='" . $sortURL . $fields[3] . "'>".$columns[3]."</a></span></th>";
			echo "<th width=\"55%\"><span style=\"font-weight:bold;\">".$columns[4]."</span></th>"; 
			echo "<th width=\"5%\"style=\"text-align:center\">Delete</th>\n";
			echo "<th width=\"5%\"style=\"text-align:center\">Edit</th>\n";
			echo "</tr>\n";
			$count = count($events);
			for ($i = 0; $i < $count; ++$i) {
				echo "<tr>\n";
				echo "<td width=\"5%\"style=\"text-align:center;font-weight:bold\">" . $events[$i][$fields[0]] . "</td>\n";
				echo "<td width=\"10%\">" . htmlentities($events[$i][$fields[1]]) ."</td>";
				echo "<td width=\"10%\">" . htmlentities($events[$i][$fields[2]]) ."</td>";
				echo "<td width=\"10%\">" . htmlentities($events[$i][$fields[3]]) ."</td>";
				echo "<td width=\"55%\">" . htmlentities($events[$i][$fields[4]]) ."</td>\n"; // this is description 
				if ($userId == $events[$i][$fields[1]])
				{
					echo "<td width=\"5%\"style=\"text-align:center\"><a href='"
						. $deleteURL . $events[$i][$fields[0]] ."'>Delete</a></td>\n";
					echo "<td width=\"5%\"style=\"text-align:center\"><a href='"
						. $editURL . $events[$i][$fields[0]] ."'>Edit</a></td>\n";
				}
				else
				{
					echo "<td width=\"5%\"style=\"text-align:center\">&nbsp;</td>\n";
					echo "<td width=\"5%\"style=\"text-align:center\">&nbsp;</td>\n";
				}
				echo "</tr>\n";
			 }
			 echo "</table>\n";
		 }
		 else
		 {
			echo "<h2>There are no events posted at this time.</h2>\n";
		 }
	}

?>