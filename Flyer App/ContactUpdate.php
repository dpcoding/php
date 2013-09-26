<?php

  // 1 start a session
  session_start();
  // 2 include the flyerfunctions file
  include_once("flyerfunctions.php");
  // 3 redirect the user to the skywardflyers page if an element called flyerId is not in the session array
  if (empty($_SESSION['flyerId']))
	header('Location: skywardflyers.php');
  
  if (empty($_GET['first_name']) || empty($_GET['last_name']) || empty($_GET['phone']) || empty($_GET['address']) || empty($_GET['city']) || empty($_GET['state']) || empty($_GET['zip']))
          exit("<p>You must enter values in all fields of the Contact Information form! Click your browser's Back button to return to the previous page.</p>");
          
  $First = trim($_GET['first_name']);
  $Last = trim($_GET['last_name']);
  $Phone = trim($_GET['phone']);
  $Address = trim($_GET['address']);
  $City = trim($_GET['city']);
  $State = trim($_GET['state']);
  $Zip = trim($_GET['zip']);
  
  // 4 set a cookie called customerName so we can greet this person by name from now on
  setcookie("customerName", $First);
 
  // the next line is creating an array with all of the flyer information.  The first element should be the flyerID from the session array.
  // the next 2 parameters are empty strings, the other pieces of information come from the variables above
  // 5 need the flyerID from the session array as the first parameter, "", "", $First, $Last, $Phone, $Address, $City, $State, $Zip
  $flyer = array($_SESSION['flyerId'], "", "", $First, $Last, $Phone, $Address, $City, $State, $Zip);
  $flyer = writeExistingFlyer($flyer);
  if ($flyer === false)
  {
    exit("<p>Can't write your information to the file! Click your browser's Back button to
    return to the previous page.</p>");
  }
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Skyward Aviation</title>
<link rel="stylesheet" href="php_styles.css" type="text/css" />
<meta http-equiv="content-type"
content="text/html; charset=iso-8859-1" />
</head>
<body>
<h1>Skyward Aviation</h1>
<h2>Contact Info Updated</h2>
<p>Your contact information was successfully updated.</p>
<p><a href='<?php echo "FrequentFlyerClub.php?" . session_id(); ?>'>Frequent Flyer Club Home Page</a></p>
</body>
</html>
