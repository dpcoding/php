<?php
  // 1 start a session
  session_start();
  // 2 set the session array equal to a new array
  $_SESSION = array();
  // 3 destroy the session too
  session_destroy(); //? why destroy right after session_start
  //$_COOKIE['customerName'] = ""; // added this to clear. this only works at SkywardFlyers.php 
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
  <h1>Skyward Aviation Frequent Flyer Program</h1>
  <h2>New Flyer Registration</h2>
  <form action="RegisterFlyer.php" method="get">
    <table frame="border" rules="cols">
      <colgroup width="50%" />
      <colgroup width="50%" />
      <tr><td align="left" valign="top">
        <p>E-Mail Address</p>
        <p><input type="text" name="email" size="36" /></p>
        <p>Confirm E-Mail Address</p>
        <p><input type="text" name="email_confirm" size="36" /></p>
        </td>
        <td align="left" valign="top">
        <p>Password (5-10 characters)</p>
        <p><input type="password" name="password" size="36" /></p>
        <p>Confirm Password</p>
        <p><input type="password" name="password_confirm" size="36" /></p>
      </td></tr>
      <tr>
        <td align="center" colspan="2"><input type="submit" value="     Register     " /></td>
      </tr>
    </table>
  </form>
  <h2>Returning Flyers</h2>
  <?php 
    // 4 if there's a cookie called customerName on the machine, greet the existing user by name
	if (!empty($_COOKIE['customerName']))
		echo "Welcome back, " . $_COOKIE['customerName'] . "!<br />";
  ?>
  <form method="get" action="ValidateUser.php">
    <table frame="border" rules="cols">
      <colgroup width="50%" />
      <colgroup width="50%" />
      <tr><td align="left" valign="top">
        <p>E-Mail Address</p>
        <p><input type="text" name="email" size="36" /></p>
        </td>
        <td align="left" valign="top">
        <p>Password</p>
        <p><input type="password" name="password" size="36" /></p>
      </td></tr>
      <tr>
        <td align="center" colspan="2"><input type="submit" value="     Log In     " /></td>
      </tr>
    </table>
  </form>
</body>

</html>
