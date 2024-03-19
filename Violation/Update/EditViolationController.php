<!--
  - File Name: EditViolationController.php
  - Program Description: data transformations
  -->
<?php
	include "../../RegistrationManager.php";

	class EditViolationController
	{
		function EditViolationController(){}
		
		function newViolation($license, $driver, $plateNo, $violation, $vdate, $vtime, $vlocation, $penalty, $reporter, $reporterContact, $evidence)
		{
			$_SESSION['editlicense'] = $license;
			$_SESSION['editplateno'] = $plateNo;
			$_SESSION['editviolation'] = $violation;
			$_SESSION['editviolatedate'] = $vdate;
			$_SESSION['editviolatedate'] = $vtime;
			$_SESSION['editviolatedate'] = $vlocation;
			$_SESSION['editpenalty'] = $penalty;
			$_SESSION['editreporter'] = $reporter;
			
			$license = trim(strtoupper($license));
			$driver = trim(ucwords(strtolower($driver)));
			$violation = trim($violation);
			$vdate = trim($vdate);
			$vtime = trim($vtime);
			$vlocation = trim($vlocation);
			$penalty = trim($penalty);
			$reporter = trim(ucwords(strtolower($reporter)));
			
			$violationView = new EditViolationView();
			$rm = new RegistrationManager();
			$success = $rm->updateViolation($license, $driver, $plateNo, $violation, $vdate, $vtime, $vlocation, $penalty, $reporter, $reporterContact, $evidence);
			
			$log = "";
			if($driver != ""){
				$log .= "(driver id)" . $driver;
				if($plateNo != "")
					$log .= " / (plate number)" . $plateNo;
			}else{
				$log .= "(plate number)" . $plateNo;
			}
			
			$rm->newLog("Update Violation: " . $log . " (" . $vdate . " " . $vtime . ")");
			
			if($success == 1)
			{
				unset($_SESSION['editdriver']);
				unset($_SESSION['editviolation']);
				unset($_SESSION['editviolatedate']);
				unset($_SESSION['editviolatetime']);
				unset($_SESSION['editviolatelocation']);
				unset($_SESSION['editpenalty']);
				unset($_SESSION['editreporter']);
				
				$violationView->showMessage(1);
			}
			else $violationView->showMessage(0);
		}
	}
?>