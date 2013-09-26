<?php
     session_start();
     $_SESSION = array();
     session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>College Internships</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
</head>

<body>
	<h1>College Internships</h1>
	<h2>Register / Log In</h2>
		<p>New interns, please complete the top form to
		register as a user. Returning users, please complete 
		the second form to log in.</p>
	<hr />
	<h3>New Intern Registration</h3>
	<form method="POST" action="RegisterIntern.php?<?php
			  echo SID; ?>">
		<p>Enter your name: First 
			 <input type="text" name="first" />
		Last: 
			 <input type="text" name="last" /></p>
		<p>Enter your email address: 
			 <input type="text" name="email" /></p>
		<p>Enter a password for your account:
			 <input type="password" name="password" /></p>
		<p>Confirm your password:
			 <input type="password" name="password2" /></p>
		<p><em>(Passwords are case-sensitive and 
			 must be at least 6 characters long)</em></p>
		<input type="reset" name="reset" 
			 value="Reset Registration Form" />
		<input type="submit" name="register" value="Register" />
	</form>
	<hr />
	<h3>Returning Intern Login</h3>
		<form method="POST" action="VerifyLogin.php?<?php
				  echo SID; ?>">
		<p>Enter your email address: 
			 <input type="text" name="email" /></p>
		<p>Enter your password:
			 <input type="password" name="password" /></p>
		<p><em>(Passwords are case-sensitive and 
			 must be at least 6 characters long)</em></p>
		<input type="reset" name="reset" 
			 value="Reset Login Form" />
		<input type="submit" name="login" value="Log In" />
	</form>
	<hr />

	</body>
</html>

