<?php

  // 1 start a session
  session_start();
  // 2 include the flyerfunctions file
  include_once("flyerfunctions.php");
  
  if (empty($_GET['email']) || empty($_GET['email_confirm'])
          || empty($_GET['password']) || empty($_GET['password_confirm']))
          exit("<p>You must enter values in all fields of the Frequent Flyer Registration form! Click your browser's Back button to return to the previous page.</p>");
  else if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_GET['email']))
          exit("<p>You must enter a valid e-mail address! Click your browser's Back button to return to the previous page.</p>");
  else if ($_GET['email'] != $_GET['email_confirm'])
          exit("<p>You did not enter the same e-mail address! Click your browser's Back button to return to the previous page.</p>");
  else if ($_GET['password'] != $_GET['password_confirm'])
          exit("<p>You did not enter the same password! Click your browser's Back button to return to the previous page.</p>");
  else if (strlen($_GET['password']) < 4 || strlen($_GET['password']) > 10)
          exit("<p>Your password must be between 4 and 10 characters! Click your browser's Back button to return to the previous page.</p>");
      
  // 3 get the email address and password from the get array
  //     use $Email and $Password as your variable names 
  $Email = $_GET['email'];
  $Password = $_GET['password'];
  
  $flyer = getFlyerInfo($Email);
  if ($flyer !== false)
  {
    exit("<p>The e-mail address you entered is already
    registered! Click your browser's Back button to
    return to the previous page.</p>");
  }

  $flyer = writeNewFlyer($Email, $Password);
  if ($flyer === false)
  {
    exit("<p>Can't write your information to the file! Click your browser's Back button to
    return to the previous page.</p>");
  }
  else
  {
    // 4 store the id for this flyer in a session variable called flyerID
    // that value can be found in the $flyer array in the position given by the constant $ID_INDEX   ($flyer[$ID_INDEX])
	$flyerID = $flyer[$ID_INDEX];
	$_SESSION['flyerId'] = $flyerID;
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
<h2>Frequent Flyer Registration</h2>
<p>Your new frequent flyer ID is <strong>
<!-- echo the id from the session array. note from below echo statement -->
<?php echo $_SESSION['flyerId']; ?></strong>.</p>
<p><a href="UpdateContactInfo.php">Enter Contact Information</a></p>
</body>
</html>
