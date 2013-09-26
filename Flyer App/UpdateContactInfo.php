<?php

  // 1 start a session
  session_start();
  // 2 include the flyerfunctions file
  include_once("flyerfunctions.php");
  // 3 redirect the user to the skywardflyers page if an element called flyerId is not in the session array
  if (empty($_SESSION['flyerId']))
	header('Location: skywardflyers.php');
  // this function uses the flyerID session variable to get the contact info from the flyer file.  It returns an array of information about that flyter
  //// 4 use the flyerID session variable as the parameter here
  $flyer = getFlyerInfoById($_SESSION['flyerId']);
  if ($flyer !== false)
  {
    $First = $flyer[3];
    $Last = $flyer[4];
    $Phone = $flyer[5];
    $Address = $flyer[6];
    $City = $flyer[7];
    $State = $flyer[8];
    $Zip = $flyer[9];
  }
  else 
  {
    $First = "";
    $Last = "";
    $Phone = "";
    $Address = "";
    $City = "";
    $State = "";
    $Zip = "";
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
  <h2>Contact Information</h2>
  <form action="ContactUpdate.php" method="get">
    <table frame="border" rules="cols">
      <colgroup width="50%" />
      <colgroup width="50%" />
      <tr><td align="right" valign="top">
      <p>First Name <input type="text" name="first_name"
      value="<?php echo  $First ?>" size="36" /></p>
      <p>Last Name <input type="text" name="last_name"
      value="<?php echo  $Last ?>" size="36" /></p>
      <p>Phone <input type="text" name="phone"
      value="<?php echo  $Phone ?>" size="36" /></p></td>
      <td align="right" valign="top">
      <p>Address <input type="text" name="address"
      value="<?php echo  $Address ?>" size="40" /></p>
      <p>City <input type="text" name="city" value="<?php echo  $City ?>"
      size="10" />
      State <input type="text" name="state" value="<?php echo  $State ?>"
      size="2" maxlength="2" />
      Zip <input type="text" name="zip" value="<?php echo  $Zip ?>" size="10"
      maxlength="10" /></p>
      </td></tr>
    </table>
    <p>
    <input type="hidden" name="PHPSESSID" value=
      '<?php 
          echo session_id(); 
        ?>' 
    />
    <input type="submit" value="Submit" /></p>
  </form>
</body>
</html>
