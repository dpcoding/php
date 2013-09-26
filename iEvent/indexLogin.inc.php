<?php
	/**
	* this file validates event login page input included_once in index.php
	*/
	
	// this validate if userName is empty 
	function validateInput($data, $fieldName) 
	{
		global $userError;
	    if (empty($data)) 
		{
	        //$userError = "\"$fieldName\" is a required field.<br />\n";
			$userError = "Please enter user name.";
	    }
		else
		{
			return ($data);
			return true;
		}
		
	}
	// did not use this one for this app.
	function correctPassword($password)
	{
		$correctString = "studenT13";
		if ($password == $correctString) 
			return true;
		else 
			return false;
	}

/*
	$password = "studenT13";
	// either 1 or true works. 
	if (correctPassword($password) == true) 
		{
			echo "Correct!";
		}
	else 
		echo "Incorrect!";
	echo "<br/>";
*/
	
	
	function validatePassword($password)
	{
		//$p = false;
		global $errorMessage;
		if (empty($password))
		{
			$errorMessage .= "Please enter password.<br />";
		}
		else
		{
			if (!preg_match("/\d{1,}/",$password)) 		
				$errorMessage .= "Password does not contain at least 1 digit.<br />";
			if (!preg_match("/[a-z]{1,}/",$password)) 
				$errorMessage .= "Password does not contain at least 1 lowercase letter.<br />";
			if (!preg_match("/[A-Z]{1,}/",$password)) 
				$errorMessage .= "Password does not contain at least 1 uppercase letter.<br />";
			if (!preg_match("/\w{8,16}/",$password)) 		
				$errorMessage .= "Password does not contain between 8 and 16 characters.<br />";		
			If (strlen($errorMessage) == 0)
			{
				//$errorMessage = "You entered the right password!";		
				return $password;
				return true;
			}
		}

	}
	
	//validatePassword("kJl54567s");

	
/*	
	try
	{
		$password = "3333j44F";
		validatePassword($password);
		echo $errorMessage . "<br />";
		echo "You entered: " . $password;
	}
	catch (Exception $e)
	{
		echo "Exception: " . $e->getMessage() . " occurred in " . $e->getFile() . " at line " . $e->getLine() . "." ; 
	}
*/	
?>