<?php
	  // 1 start a session
	  session_start();
	  // 2 include the flyerfunctions file
	  include_once("flyerfunctions.php");
	  // 3 make sure that the email address and password were provided by the user on the previous page
	  if ((!empty($_GET['email'])) && (!empty($_GET['password'])))
	  // 4 get the email address and password from the get array and store them in variables.  
	  //    use $FlyerEmail and $FlyerPassword as your variable names
	  
		$FlyerEmail = $_GET['email'];
		$FlyerPassword = $_GET['password'];
	  
    /*********************************************
	changed original $FlyerEmail to $_GET['email'] 
	otherwise will show FlyerEmail is undefied 
	when login is clicked 
	$flyer = getFlyerInfo($FlyerEmail);
	*********************************************/
  $flyer = getFlyerInfo($_GET['email']); 
  if ($flyer === false)
          die("<p>You must enter a registered e-mail address! Click
  your browser's Back button to return to the
  Registration form.</p>");
  
  if ($FlyerPassword != $flyer[$PASSWORD_INDEX])
          die("<p>You did not enter a valid password! Click your browser's Back button to return to the Registration form.</p>");
  else
    // 5 store the id for this flyer in a session variable called flyerID
    //   that value can be found in the $flyer array in the position given by the constant $ID_INDEX   ($flyer[$ID_INDEX])
	$flyerID = $flyer[$ID_INDEX];
	$_SESSION['flyerId'] = $flyerID;
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
  <h2>Login Successful</h2>
  <!-- echo "FrequentFlyerClub.php?" . session_id();. note from below echo statement -->
  <p><a href='<?php echo "FrequentFlyerClub.php?" . session_id(); ?>'>Frequent Flyer Club Home Page</a></p>
</body>
</html>
