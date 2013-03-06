<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>Ohio Titles</title>
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
	<script src="js/jquery-1.4.1.min.js" type="text/javascript"></script>
	<script src="js/jquery.jcarousel.pack.js" type="text/javascript"></script>
	<script src="js/jquery-func.js" type="text/javascript"></script>
</head>
<body>
<div id="page" class="shell">
	<!-- Logo + Description + Navigation -->
	<div id="top">
		<h1 id="logo"><a href="#">Ohio Title</a></h1>
		<div id="description" class="separator">
			<h2 class="notext">one step ahead</h2>
		</div>
		<div id="navigation">
			<ul>
			    <li><a href="index.php"><span>home</span></a></li>
			    <li><a href="aboutus.php"><span>about us</span></a></li>
			    <li><a href="services.php"><span>services</span></a></li>
			    <li><a href="solutions.php"><span>ordering</span></a></li>
			    <li><a href="contactus.php"><span>contact</span></a></li>
			</ul>
			<div class="cl">&nbsp;</div>
		</div>
	</div>
	<!-- END Logo + Description + Navigation -->
	<!-- Header -->
	<div id="header" style="padding-top:20px;font-size:20px;font-family:arial">
		AUTO, TRUCK, MOTORCYCLE TITLE RECLAMATION
	</div>
	<?php
		global $msg;
		function check_empty_fields($method = "post") 
		{
			session_start();
			
			$req_fields = array(
			'vendornumber' => 'Vendor Number',
			'ssn' => 'SSN',
			'impounded' => 'Impounded Field',
			'vehicleyear' => 'Year of Vehicle',
			'vehiclemake' => 'Make of Vehicle',
			'vehiclemodel' => 'Model of Vehicle',
			'vehiclevin' => 'Vin Number',
			'vehiclemile' => 'Mileage',
			'towfee' => 'Tow Fee',
			'contractrepairfee' => ' Contracted Repairs to vehicle',
			'storagecharge' => 'Storage Charge'
			); 
			
			$msg = " ";
			
			$use_method = ($method == "post") ? $_POST : $_GET;
			
			$errors = "";
			$count_empty = 0;
			foreach ($req_fields as $key => $val) 
			{	
				$field_name = (array_key_exists($key, $req_fields)) ?  $req_fields[$key] : $key;
				
				if (empty($use_method[$key])) {
					
					$_SESSION[$key] = true;
					
					$errors .= "|".$field_name;
					
					$count_empty++;
				} else {
					$_SESSION[$key] = false;
				}
			}
			
			if ($count_empty == 0) {
				return true;
			} 
			
			else {
				$msg = "The following (required) fields are empty:";
				$msg_parts = explode("|", ltrim($errors, "|"));
				$num_parts = count($msg_parts);
				$msg .= "<b>";
				for ($i = 0; $i < $num_parts; $i++) {
					$msg .= $msg_parts[$i];
					if ($i <= $num_parts - 2) {
						$msg .= ($i == $num_parts - 2) ? " & " : ", ";
					}
				}
				
				$msg .= "</b>\n";
				
				echo '<br>' . $msg;
				
				return false;
			}
		}
	?>
	<?php
	if($_REQUEST["insert"]=="1")
	{
		
		// Loop through the $_POST array, which comes from the form..
		 if (check_empty_fields()) 
		{
		
			require 'includes/dbconfig.php';
			require 'includes/dbopen.php';
			
			if ($_POST['impounded']=='on')
			{
				$impounded='1';
			}
			
			$query = "Insert into application (vendornumber, ssn, datevehiclereceived,impounded,vehicleyear,vehiclemake,vehiclemodel,vehiclevin,vehiclemile,towfee,
			contractrepairfee, storagecharge,mechanicalrepair,bodyrepair) values('$_POST[vendornumber]','$_POST[ssn]','$_POST[datevehiclereceived]',$impounded,	'$_POST[vehicleyear]','$_POST[vehiclemake]','$_POST[vehiclemodel]','$_POST[vehiclevin]','$_POST[vehiclemile]','$_POST[towfee]',
			'$_POST[contractrepairfee]','$_POST[storagecharge]','$_POST[mechanicalrepair]','$_POST[bodyrepair]')";
			
			$result = mysql_query($query);
			
			
			require 'includes/dbclose.php';
			
			if($result)
			{
				//echo "success"; 
						echo '<META HTTP-EQUIV="Refresh" Content="0; URL=thankyou.php">'; 
						exit();
			}
			else
				echo "There are some issues with your data, please contact IT for help";
			
			
		}
		
		else
		{
			echo 'Please enter required infos' . $msg;
		}
	}
	?>
	<!-- END Header -->
	<!-- Main -->
	<div id="main" style="text-align:center;padding-top: 10px">
		<?php
		
			$_GET['payment'] = 'success';
		
			if(!isset($_GET['payment']))
			{
				die('You can only view this page after you made the payment');
			}
			else
			{
				if($_GET['payment']=='success')
				{
						echo $errorstring;
						
					    echo "<form action='application.php?insert=1' method='post'><br>";
						echo "<table style='width:700px'>";
						echo "<tr>";
						echo "<td class='formleft'>Vendor numbers*</td><td class='formright'><input type='text' name='vendornumber'/></td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td class='formleft'>Fedear ID Number and /or SS# of owner*</td><td class='formright'><input type='password' name='ssn'/></td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td class='formleft'>Power of Attornery:</td><td class='formright'><a href='1.pdf'>SIGN AND RETURN</a><td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td class='formleft'>Date vehicle received*</td><td class='formright'><input type='text' name='datevehiclereceived'/></td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td class='formleft'>If impounded vehcile please check*</td><td class='formright'><input type='checkbox' name='impounded'/></td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td class='formleft'>Year of Vehicle*</td><td class='formright'><input type='text' name='vehicleyear'/></td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td class='formleft'>Make of Vehicle*</td><td class='formright'><input type='text' name='vehiclemake'/><td>";
						echo "</tr><tr>";
						echo "<td class='formleft'>Model of Vehicle*</td><td class='formright'><input type='text' name='vehiclemodel'/></td>";
						echo "</tr><tr>";
						echo "<td class='formleft'>Vin number of Vehicle*</td><td class='formright'><input type='text' name='vehiclevin'/></td>";
						echo "</tr><tr>";
						echo "<td class='formleft'>Mileage on Vehicle*</td><td class='formright'><input type='text' name='vehiclemile'/></td>";
						echo "</tr><tr>";
						echo "<td class='formleft'>Amount of tow to shop if any (if none enter 0)*</td><td class='formright'><input type='text' name='towfee'/></td>";
						echo "</tr><tr>";
						echo "<td class='formleft'>Contracted repairs to vehicle*</td><td class='formright'><input type='text' name='contractrepairfee'/></td>";
						echo "</tr><tr>";
						echo "<td class='formleft'>Your daily storage charge for vehicles not picked up*</td><td class='formright'><input type='text' name='storagecharge'/></td>";
						echo "</tr></table>";
						echo "<p style='font-size:16px'>NOTE:When we return your paperwork you will have to attached the signed repair order to the paperwork from the individual who brought the vehicle in for repair(Does not have to be owner of vehivle) to present to your local title bureau (Do not add storage charges: storage changes on repair order will void repair order: We will take care of all storage charges on different paperwork)<p>";						
						echo "<table style='width:700px'><tr>";
						echo "<td class='formleft'>Mechanical repairs needed (if none enter 0):</td><td class='formright'><input type='text' name='mechanicalrepair'/></td>";
						echo "</tr><tr>";
						echo "<td class='formleft'>Body repairs needed other than on repair order (if none enter 0):</td><td class='formright'><input type='text' name='bodyrepair'/></td>";
						echo "</tr><tr>";
						echo "<td class='formleft' style='width:100px'><input style='font-size:20px' type='submit' value='Submit'/></td></tr></table>";
						echo "</form>";				
				}						
			}	
		
		?>
	</div>
	<!-- END Main -->
	<!-- Footer -->
	<div id="footer">
		<p class="right">&copy; 2012 - Ohio Titles</p>
		<p><a href="index.php">home</a><span>|</span><a href="aboutus.php">about us</a><span>|</span><a href="services.php">services</a><span>|</span><a href="solutions.php">solutions</a><span>|</span><a href="contactus.php">contact</a></p>
		<div class="cl">&nbsp;</div>
	</div>
	<!-- END Footer -->
</div>
</body>
</html>