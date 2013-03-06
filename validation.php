<?php
// validation.php
 
/*
 *  Specify the field names that are in the form. This is meant
 *  for security so that someone can't send whatever they want
 *  to the form.
 */
// Specify the field names that you want to require...
	$requiredFields = array(
		'vendornumber',
		'ssn',
		'impounded',
		'vehicleyear',
		'vehiclemake',
		'vehiclemodel',
		'vehiclevin',
		'vehiclemile',
		'towfee',
		'contractrepairfee',
		'storagecharge'
	);
	 
	// Loop through the $_POST array, which comes from the form...
	$errors = array();
	foreach($_POST AS $key => $value)
	{
		// first need to make sure this is an allowed field
		if(in_array($key, $allowedFields))
		{
			$$key = $value;
	 
			// is this a required field?
			if(in_array($key, $requiredFields) && $value == '')
			{
				$errors[] = "The field $key is required.";
			}
		}
	}
	 
	// were there any errors?
	if(count($errors) > 0)
	{
		$errorString = '<p>There was an error processing the form.</p>';
		$errorString .= '<ul>';
		foreach($errors as $error)
		{
			$errorString .= "<li>$error</li>";
		}
		$errorString .= '</ul>';
	 
		// display the previous form
		include 'application.php';
	}
	else
	{
		require 'includes/dbconfig.php';
		require 'includes/dbopen.php';
		
		if ($_POST['impounded']=='on')
		{
			$impounded='1';
		}
		
		$sql = "Insert into application (vendornumber, ssn, datevehiclereceived,impounded,vehicleyear,vehiclemake,vehiclemodel,vehiclevin,vehiclemile,towfee,
		contractrepairfee, storagecharge,mechanicalrepair,bodyrepair) values('$_POST[vendornumber]','$_POST[ssn]','$_POST[datevehiclereceived]','$impounded'
		'$_POST[vehicleyear]','$_POST[vehiclemake]','$_POST[vehiclemodel]','$_POST[vehiclevin]','$_POST[vehiclemile]','$_POST[towfee]',
		'$_POST[contractrepairfee]','$_POST[storagecharge]','$_POST[mechanicalrepair]','$_POST[bodyrepair]')";
	
	
		$result = mysql_query($query);
		
		echo $result;
		
		require 'includes/dbclose.php';

		//header("Location:index.php");
	}


?>