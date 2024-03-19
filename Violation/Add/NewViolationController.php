<!--
  - File Name: NewViolationController.php
  - Program Description: data transformations
  -->
<?php
	include "../../RegistrationManager.php";

	class NewViolationController
	{
		function NewViolationController(){}
		
		function newViolation($license, $driver, $plateNo, $violation, $vdate, $vtime, $vlocation, $penalty, $reporter, $reporterContact, $evidence)
		{
			$rm = new RegistrationManager();
			
			$_SESSION['addlicense'] = $license;
			$_SESSION['adddriver'] = $driver;
			$_SESSION['addplateno'] = $plateNo;
			$_SESSION['addviolation'] = $violation;
			$_SESSION['addviolatedate'] = $vdate;
			$_SESSION['addviolatedate'] = $vtime;
			$_SESSION['addviolatedate'] = $vlocation;
			$_SESSION['addpenalty'] = $penalty;
			$_SESSION['addreporter'] = $reporter;
			
			$license = trim(strtoupper($license));
			$driver = trim(ucwords(strtolower($driver)));
			$plateNo = trim(strtoupper($plateNo));
			$violation = trim($violation);
			$vdate = trim($vdate);
			$vtime = trim($vtime);
			$vlocation = trim($vlocation);
			$penalty = trim($penalty);
			$reporter = trim(ucwords(strtolower($reporter)));
			
			$driverData = $rm->checkDriverId($driver);
			$id = $driverData['profileID'];
			
			$violationView = new NewViolationView();
			$success = $rm->newViolation($license, $driver, $plateNo, $violation, $vdate, $vtime, $vlocation, $penalty, $reporter, $reporterContact, 1, $evidence);
			
			if($license != "") $rm->increaseUserViolationViaLicense($license); // no driver id, yes license number
			else $rm->increaseUserViolation($id); // no license number, yes driver id
			
			$rm->increaseVehicleViolation($plateNo);
			
			$log = "";
			if($driver != ""){
				$log .= "(driver id)" . $driver;
				if($plateNo != "")
					$log .= " / (plate number)" . $plateNo;
			}else{
				$log .= "(plate number)" . $plateNo;
			}
			
			$rm->newLog("Added Violation: " . $log . " (" . $vdate . " " . $vtime . ")");
			
			// vehicle reach maximum violation
			$vehicle = $rm->checkVehicleStatus($plateNo); // get vehicle info
			$maxvio = mysql_fetch_array($rm->retrieveOptions()); // get maximum number of violation
			if($vehicle['violation'] >= $maxvio['value']){ // check if vehicle reach maximum violation
				$rm->blockVehicle($plateNo, 1);
			}
			
			if($success == 1)
			{
				unset($_SESSION['adddriver']);
				unset($_SESSION['addplateno']);
				unset($_SESSION['addviolation']);
				unset($_SESSION['addviolatedate']);
				unset($_SESSION['addviolatetime']);
				unset($_SESSION['addviolatelocation']);
				unset($_SESSION['addpenalty']);
				unset($_SESSION['addreporter']);
				
				$violationView->showMessage(1);
			}
			else $violationView->showMessage(0);
		}
	}
?>