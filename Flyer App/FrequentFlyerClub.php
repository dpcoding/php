<?php

  // 1 start a session
  session_start();
  // 2 include the flyerfunctions file
  include_once("flyerfunctions.php");
  // 3 redirect the user to the skywardflyers page if an element called flyerId is not in the session array
  if (empty($_SESSION['flyerId']))
	header('Location: skywardflyers.php');
  $CustomerName = "";
  // 4 set CustomerName to the value of the customerName cookie if possible
	if (!empty($_COOKIE['customerName']))
		$CustomerName = $_COOKIE['customerName'];
  // the function call below uses the flyerID as a parameter to get the mileage for this flyer from the mileage
  // 5 get the flyerID from the session variable here and use it as the parameter
  $Mileage = getFlyerMileageById($_SESSION['flyerId']);

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
<h2>Frequent Flyer Club</h2>
<table frame="border" rules="cols">
<colgroup width="50%" />
<colgroup width="50%" />
<tr><td align="left">
<p><strong>Customer Name:</strong> <?php echo  $CustomerName ?> </p>
<p><strong>Frequent Flyer #:</strong>
<!--  //6 echo the id from the session array -->
<?php echo $_SESSION['flyerId']; ?></p>
<p><strong>Mileage Credit:</strong> <?php echo  $Mileage ?></p>
</td>
<td align="center">
<p><a href='<?php echo "RequestMileage.php?" . session_id(); ?>'>Request Mileage Credit - under construction</a></p>
<p><a href='<?php echo "UpdateContactInfo.php?" . session_id(); ?>'>Update Contact Info</a></p>
</td></tr></table>
<p><a href="SkywardFlyers.php">Log Out</a></p>
</body>
</html>
