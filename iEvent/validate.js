window.onload = startForm;

function startForm()
{
	document.loginForm.username.focus();
	document.loginForm.onsubmit = checkForm;
}

// ADD an else if that checks the password for 8 to 16 digits etc
// ideally this function would display ONE alert box with all of the error messages
// rather than separate alert boxes with each error message.  That way the user 
// gets all of the information about invalid data at one time

// variables of regular ex
var ck_length =  /^\w{8,16}$/;
var ck_upper =  /[A-Z]/;
var ck_lower =  /[a-z]/;
var ck_numeric =  /[0-9]/;

function checkForm()
{
	var username = loginForm.username.value;
	var password = loginForm.password.value; // same as document.loginForm.password.value
	var errors = [];
	
	if (document.loginForm.username.value == "")
	{
		errors[errors.length] = "Please enter a username.";
		document.loginForm.username.focus();
	}
		
	if (document.loginForm.password.value == "")
	{
		errors[errors.length] = "Please enter a password.";
		document.loginForm.password.focus();
	}
	// ADD an else if that checks the password for 8 to 16 digits etc
	if (!ck_upper.test(password))
	{
		errors[errors.length] = "Please enter at least 1 uppercase letter.";
		document.loginForm.password.focus();
	}
	
	if (!ck_lower.test(password))
	{
		errors[errors.length] = "Please enter at least 1 lowercase letter.";
		document.loginForm.password.focus();
	}
	
	if (!ck_numeric.test(password))
	{
		errors[errors.length] = "Please enter at least 1 digit.";
		document.loginForm.password.focus();
	}
	
	if (!ck_length.test(password))
	{
		errors[errors.length] = "Please enter between 8 and 16 characters.";
		document.loginForm.password.focus();
	}
	
	if (errors.length > 0) 
	{
	  	reportErrors(errors);
	  	return false;
	}
	
	return true;
}

function reportErrors(errors)
{
 	var msg = "Please Enter Valide Data...\n";

	for (var i = 0; i<errors.length; i++) 
	{
	  	var numError = i + 1;
	  	msg += "\n" + numError + ". " + errors[i];
	}
	 	alert(msg);
}

