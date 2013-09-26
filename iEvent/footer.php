
	
	&copy; <?php 
	$copyYear = 2013; // Set your website start date
	$curYear = date('Y'); // Keeps the second year updated
	echo $copyYear . (($copyYear != $curYear) ? '-' . $curYear : '');
	//echo $curYear ;
	?>  <em>dpcoding</em>.
