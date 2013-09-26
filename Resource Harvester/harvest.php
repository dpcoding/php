<?php
	session_start(); 	//start up PHP session! This tiny piece of code will register 
					//the user's session with the server, allow you to start saving user information and 
					//assign a UID (unique identification number) for that user's session.				
	
	$regExp = "/\w[-._\w]*\w@\w[-._\w]*\w\.\w{2,8}/";
	$regExpPhone = "/\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})/";
	$data = "";
	$output = "";
	$url = "";
	$emptyMsg = "";
	$outputMsg = "";
	
	///////////////////////////////////////////////////
	///// processing for harvesting email addresss /////
	///////////////////////////////////////////////////
	
	if (isset($_POST['Submit']))// if Harvest pushed
	{	
		//global $outputMsg;
		//global $emptyMsg;
		$tempString = "";
		$url = $_POST['Url'];//get the url from input box
		$data = $_POST['Input'];//get the content from text box
		if (empty($data) && empty($url)) // if both url and content boxes are empty
		{
			$emptyMsg = "Please enter either a URL or some content to be harvested."; // this is not showing up. 
		}
		elseif (empty($url)) // if url is empty
		{
			if(preg_match_all($regExp, $data, $emails) > 0) //process content textbox
			{
				foreach($emails[0] as $email)			
				$output .= $email ."\n";
				$filename = "harvestEmailData/" . session_id() . ".txt";
				foreach ($emails [0] as $email)
					$tempString .= ($email . "\n");
				if (file_put_contents($filename, $tempString, FILE_APPEND) > 0)
					$outputMsg = " Your data is in the file <a href='$filename' target='_blank'>$filename</a>";
				else
					$outputMsg = "Couldn't write data to a file";					
			}
			else
				$output = "There were no email addresses found.";
		}// end if !empty
		else // else process url input box
		{
			$URL = file_get_contents($url);
			if(preg_match_all($regExp, $URL, $emails) > 0)
			{
				foreach($emails[0] as $email) 
				{			
					$output .= $email ."\n";
					$filename = "harvestEmailData/" . session_id() . ".txt";
				}
				foreach ($emails [0] as $email)
					$tempString .= ($email . "\n");
				if (file_put_contents($filename, $tempString, FILE_APPEND) > 0)
					$outputMsg = " Your data is in the file <a href='$filename' target='_blank'>$filename</a>";
				else
					$outputMsg = "Couldn't write data to a file";				
			}
			else
				$output = "There were no email addresses in the URL.";
		}//end else if !empty						
	}// end of if isset
	
	
	///////////////////////////////////////////////////
	///// processing for harvesting phone numbers /////
	///////////////////////////////////////////////////
	
	if (isset($_POST['SubmitPhone']))// if Harvest pushed
	{	
		$tempString = "";
		$url = $_POST['Url'];//get the url from input box
		$data = $_POST['Input'];//get the content from text box
		if (empty($data) && empty($url)) // if both url and content boxes are empty
		{
			$emptyMsg = "Please enter either a URL or some content to be harvested.";
		}
		elseif (empty($url)) // if url is empty
		{
			if(preg_match_all($regExpPhone, $data, $emails) > 0) //process content textbox
			{
				foreach($emails[0] as $email)			
				$output .= $email ."\n";
				$filename = "harvestPhoneData/" . session_id() . ".txt";
				foreach ($emails [0] as $email)
					$tempString .= ($email . "\n");
				if (file_put_contents($filename, $tempString, FILE_APPEND) > 0)
					$outputMsg = " Your data is in the file <a href='$filename' target='_blank'>$filename</a>";
				else
					$outputMsg = "Couldn't write data to a file";	
				
			}
			else
				$output = "There were no phone numbers found.";
		}// end if !empty
		else // else process url input box
		{
			$URL = file_get_contents($url);
			if(preg_match_all($regExpPhone, $URL, $emails) > 0)
			{
				foreach($emails[0] as $email) 
				{			
					$output .= $email ."\n";
					$filename = "harvestPhoneData/" . session_id() . ".txt";
				}
				foreach ($emails [0] as $email)
					$tempString .= ($email . "\n");
				if (file_put_contents($filename, $tempString, FILE_APPEND) > 0)
					$outputMsg = " Your data is in the file <a href='$filename' target='_blank'>$filename</a>";
				else
					$outputMsg = "Couldn't write data to a file";				
			}
			else
				$output = "There were no phone numbers in the URL.";
		}//end else if !empty				
	}// end of if isset
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Email Harvester</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" type="text/css" href="default.css" media="screen"/>
	<script>
		function formReset()
		{
			alert("Form reset?"); 
			document.forms[0].reset(); 

		}
	</script>
</head>
<body>
	<div class="container">
			<div class="banner">
				<div class="title">
					<?php include ("inc_header.html"); ?>
				</div> <!-- End of title -->
			</div> <!-- End of banner -->
			
			<div class="clearer"><span></span></div>
					
			<div class="holder_top"></div><!-- End of holder_top -->
							
			<div class="holder">
				<div class="contentinfo">
					<h2>Harvest Resources</h2>
					<form id="frm1" name="harvest" action="harvest.php" method="post"> 
						<span style="color:red"><?php echo $emptyMsg; ?></span>
						<p><strong><em>Either</em></strong> enter a URL here you would like be harvested <strong><em>OR</em></strong> :<br />  
							<!-- URL input box -->
							<input type="text" name="Url" placeholder="    ----- URL -----" value="<?php echo $url; ?>" />
						</p>
						<p>Enter the content here:<br /> 
							<!-- content input box -->
							<textarea rows="5" cols="55" id="input" type="text" name="Input"><?php echo $data; ?>
								</textarea>
						</p>
					
						<p>Harvest Output:<br />
							<!-- output box set to read only -->
							<textarea rows="5" cols="55" readonly="readonly" id="output" name="Output"><?php echo $output; ?>
							</textarea>
						</p>
						<span style="color:red"><?php echo $outputMsg; ?></span><!-- show where file is saved -->
						<p>
							<input type="reset" name="Clear Form" onclick="formReset()" value="Clear Form" />
							&nbsp; &nbsp;
							<input type="submit" name="Submit" value="Harvest Email" />
							&nbsp; &nbsp;
							<input type="submit" name="SubmitPhone" value="Harvest Phone Number" />
						</p>
					</form>
				</div> <!-- End of contentinfo -->
			</div> <!-- End of holder -->		
			
			<div class="footer">
				<?php include ("inc_footer.php"); ?>
			</div><!-- End of footer -->
	</div> <!-- End of container -->

</body>
</html>
