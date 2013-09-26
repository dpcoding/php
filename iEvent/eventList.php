<?php
	session_start();
	//$_SESSION['userId'] = 3; // will need to comment it out when getting userId
	//$_SESSION['userId'] = $_POST['userId']; //comment it out because it has been defined in indexLogin.inc.php
	//$_SESSION['userName'] = "dylanPan";
	//$_SESSION['userName'] = $_POST['userName'];
	$_SESSION['sortKey'] = null;
	
	//echo those to see what I get
	
	
	//$fields = array("eventID", "userId", "eventDate", "eventTitle", "eventDescription");
	$fields = array('event_id', 'event_user_id', 'event_title', 'event_date', 'event_description');
	$columns = array("Id", "Posted By", "Title", "Date", "Description"); // those are headings
	//$eventFile = "files\events.txt";
	//$delimiter = "\t"; 
	
	$eventId = "";
	$eventDate = "";
	$eventTitle = "";
	$eventDescription = "";
	
	$submitValue = "Add";
	
	include_once("fileFunctions.inc.php"); // keep all functions in different files
	include_once("arrayFunctions.inc.php");
	include_once("eventListFunctions.inc.php"); //HAVE SAME FUNCTIONS AS DATABASEFUNCTION FILE
	include_once("databaseFunctions.inc.php");
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Post Message</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<script language="javascript">
		function confirm_logout()
		{
			if (confirm("Are you sure you want to logout?")==true)
			{
				window.location = "index.php";
				return true;
			}
			else
				return false;
		}
	</script>
</head>
<body>
	<h2>Best Event List</h2>
	<?php
	echo "Welcome back, " . $_SESSION['userFirst'] . "! ";
	echo "Your user ID is " . $_SESSION['userId'] . ".<br />";
	echo "Life is short. Please create some cool events so that others might enjoy this world better.";
	?>
		<form style="float:right" action="eventList.php" method="POST">
			<span style="color:red"><?php echo $searchMsg; ?></span>
			<input type="search" name="searchInput" placeholder="search">&nbsp;
			<input type="submit" name="search" value="Go!">	
		</form><span style="color:red"><?php echo $sortMsg; echo $editMsg; ?></span><br /><br />
		<hr />
<?php
	
	try
	{
		// need to call function connecing the database here first and close in the end
		//$db = db_connect("localhost", "root", "", "event_calendar");
		$db = mysql_connect("localhost", "eventCalUser", "NQ13vg!p", "event_calendar");//For citstudent db
		if ($result === false)
			throw new Exception("Can't run sql statement: $sql " . mysql_error());
		$sql = "Select * from event"; // I think here needs to join to get user_name
		$array = get2DArraySQL($db, $sql); // this prints out table data *** need to check if comment is right
		//print_r($array);
		
		//this switch is for action on table
		if (isset($_GET['action'])) 
		{
			switch ($_GET['action'])
			{
				case 'sort':
					$_SESSION['sortKey'] = $_GET['field'];
					break;
				case 'delete':
					$eventId = trim($_GET['id']); // I added this using $_GET['id'] and works
					//deleteEvent($eventFile, $delimiter, $_GET['id']); // original file()
					deleteEvent($db, $eventId);
					break;
				case 'edit':
					$eventId = $_GET['id'];
					$userId = $_SESSION['userId'];
					retrieveEvent($db, $eventId, $userId, $eventDate, $eventTitle, $eventDescription); // those parameters referenceing
					$submitValue = 'Update';
					break;
			}
		}
		// this switch is for add/edit an event form
		if (isset($_POST['submit']))
		{
			switch ($_POST['submit'])
			{
				case 'Add':
					$userId = $_SESSION['userId'];
					$eventDate = trim($_POST['eventDate']);
					$eventTitle = trim($_POST['eventTitle']);
					$eventDescription = trim($_POST['eventDescription']);
					//addEvent($eventFile, $delimiter, $userId, $eventDate, $eventTitle, $eventDescription); //original fileFunction call
					insertEvent($db, $userId, $eventTitle, $eventDescription, $eventDate);
					$userId = "";
					$eventDate = "";
					$eventTitle = "";
					$eventDescription = "";					
					break;
				case 'Update':
					$eventId = trim($_POST['eventId']);
					$userId = $_SESSION['userId'];
					$eventDate = trim($_POST['eventDate']);
					$eventTitle = trim($_POST['eventTitle']);
					$eventDescription = trim($_POST['eventDescription']);
					//editEvent($eventFile, $delimiter, $eventId, $userId, $eventDate, $eventTitle, $eventDescription); //replacede sql function below
					updateEvent($db, $eventId,  $userId, $eventTitle, $eventDescription, $eventDate);
					$eventId = "";
					$userId = "";
					$eventDate = "";
					$eventTitle = "";
					$eventDescription = "";
					$submitValue = 'Add'; // this changes back to "Add"
					break;
			}
		}
		
		// **** here needs to create sql statements 
		//$events = get2DAssocArray($eventFile, $delimiter, $fields);
		$events = get2DArraySQL($db, $sql);
		if ($_SESSION['sortKey'] != null)
			usortByKey($events, $_SESSION['sortKey']);
		echoEvents($events, $fields, $columns, $_SESSION['userId']); // replaced $userId with $_SESSION['userId'] when login page is created
		mysql_close($db);// close db
	}
	catch (Exception $e)
	{
		echo "Exception: " . $e->getMessage() . " occurred in " . $e->getFile() . " at line " . $e->getLine() . "." ; 
	}
?>	

	<hr />
	<h2>Add / Edit an Event</h2>
	<form action='<?php echo $_SERVER['PHP_SELF']; ?>' method="POST">
		<input type="hidden" name="eventId" value="<?php echo $eventId; ?>" />
		<span style="font-weight:bold">Date:</span> 
			<input type="text" name="eventDate" value="<?php echo $eventDate; ?>" required /><br /><br />
		<span style="font-weight:bold">Title:</span> 
			<input type="text" name="eventTitle" value="<?php echo $eventTitle; ?>" required /><br /><br />
		<textarea name="eventDescription" rows="6" cols="80" >
			<?php echo $eventDescription; ?></textarea><br /><br />
		<input type="submit" name="submit" value="<?php echo $submitValue; ?>" />
		&nbsp; &nbsp; &nbsp;
		<input type="button" name="logout" onclick="confirm_logout()" value="Log out" />
	</form>
	
	<div>
		<?php include 'footer.php'; ?> 
	</div>
</body>
</html>
	

