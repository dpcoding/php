<?php
	session_start();
	//$userId= $_POST['userName']; // set usrname as session userID	
	//$_SESSION['userName'] = $UserID;
	
	$userName = "";
	$userError = "";
	$errorMessage = "";
	$password = "";
	
	//following inc file validates login inputs
	
	include 'databaseFunctions.inc.php';// this has valLoginsql() in it so I include it here as well.
	include 'indexLogin.inc.php'; // include file order METTERS when functions are in different files or they excute in order
	
	if (isset($_POST['Submit']))
	{	
		$userName = validateInput($_POST['userName'], "User Name");
		$password = validatePassword($_POST['password']);
		
		if ($password == true && $userName == true)
		{
			$password = md5($_POST['password']);		
			if (loginsql($userName, $password) == true)
			{
				header('location: eventList.php');
			}
			else 
			{
				$password = $_POST['password'];
				echo "Can't not match any user name and password in the database. Keep trying...";
				return false;
			}
		}
	}
	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>The Best Events - Login</title>
	<script src="validate.js" type="text/javascript"/></script>
	
</head>
<body>
	<h1>Login Page</h1>
	<form id="loginForm" name="loginForm" action="index.php" method="post"><!-- action="index.php" -->
		<p>User Name:
			<!-- hidden userId handcode to 3 for testing
			<input type="hidden" name="userId" value="3" /> -->
			<input type="text" name="userName" id="userName" value="<?php echo $userName; ?>"/> <br />
			<span style="color:red"><?php echo $userError; ?></span>
		</p>
		<p>Password:
			<input type="text" name="password" id="password" value="<?php echo $password; ?>"/> <br />
			<span style="color:red"><?php echo $errorMessage; ?></span>
		</p>	
		<p>
			<input type="reset" name="Clear Form" onclick="formReset()" value="Clear Form" /> 
			&nbsp; &nbsp;
			<input type="submit" name="Submit" value="Submit" />
		</p>
	</form>
	
	<div>
		<?php include 'footer.php'; ?> 
	</div>
</body>


</html>