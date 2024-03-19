<!--
  - File Name: 
  - Program Description: 
  -->
<?php
	session_start();
	include "../RegistrationManager.php";
	class OptionController
	{
		function maxViolations()
		{
			$rm = new RegistrationManager();
			
			$max = $_POST['maxviolation'];
			
			// check is $max is non-zero digit
			if(!is_numeric($max)){
				$_SESSION["message"] = "You entered a non-digit value.";
				header("Location: ../");
			}else{
				$rm->setMaxViolation($max);
				$_SESSION["message"] = "Maximum number of violations updated.";
				header("Location: ../");
			}
		}
		
		function maxInspections()
		{
			$rm = new RegistrationManager();
			
			$max = $_POST['maxinspection'];
			
			// check is $max is non-zero digit
			if(!is_numeric($max)){
				$_SESSION["message"] = "You entered a non-digit value.";
				header("Location: ../");
			}else{
				$rm->setMaxInspection($max);
				$_SESSION["message"] = "Maximum number of inspections per day updated.";
				header("Location: ../");
			}
		}
	}
	$oc = new OptionController();
	$task = isset($_GET['task']) ? $_GET['task'] : "";
	
	if($task == "mv")
		$oc->maxViolations();
	elseif($task == "mi")
		$oc->maxInspections();
	else
		header("Location: ./");
?>