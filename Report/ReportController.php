<!--
  - File Name: Report/ReportController.php
  - Program Description: Report Form
  -->
<?php
	include "../RegistrationManager.php";
	session_start();
	
	class ReportController
	{
		function validateInfo($license, $driver, $plateno, $violation, $vdate, $vtime, $vlocation, $reporterName, $reporterContact, $evidence)
		{
			$error = 0;
			$_SESSION['message'] = "";
			$reporter = "";
			$penalty = "";
			$rm = new RegistrationManager();
			
			$error = $this->scriptError($license, "scriptlicense", $error);
			$error = $this->scriptError($driver, "scriptdriver", $error);
			$error = $this->scriptError($plateno, "scriptplateno", $error);
			$error = $this->scriptError($violation, "scriptviolation", $error);
			$error = $this->scriptError($vdate, "scriptviolatedate", $error);
			$error = $this->scriptError($reporterName, "scriptreportername", $error);
			$error = $this->scriptError($reporterContact, "scriptreportercontact", $error);
			
			//$error = $this->inputIsNull($license, "licenseisnull", $error);
			$error = $this->inputIsNull($violation, "violationisnull", $error);
			$error = $this->inputIsNull($vdate, "violatedateisnull", $error);
			
			if($driver == "" && $plateno == ""){
				$_SESSION["message"] = "Enter either Driver's ID Number or Vehicle's Plate Number.";
				header("Location: ./");
				die();
			}
			
			if($driver != ""){
				$temp = $rm->checkDriverID($driver);
				if($temp['driverID'] == ""){
					if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
					$_SESSION['message'] .= "- Driver ID doesn't exist.";
					$error = 1;
				}
			}
			
			if($plateno != ""){
				if(($rm->checkVehicle("plateNumber", $plateno)) == 0){
					if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
					$_SESSION['message'] .= "- Plate Number doesn't exist.";
					$error = 1;
				}
			}
			
			if($this->checkMoreThanCurrentDate($vdate)){
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION['message'] .= "- Violation Date cannot be later than the current date.";
				$error = 1;
			}
			
			if($this->checkDateFormat($vdate) == 0){
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION['message'] .= "- Violation date format is invalid.";
				$error = 1;
			}
			
			if($reporterName == "" && $reporterContact == ""){					// no name, no contact
				$reporter = "civilian";
			}elseif($reporterName != "" && $reporterContact != ""){				// have name, have contact
				$reporter = $reporterName . " (" . $reporterContact . ")";
			}elseif($reporterName != "" && $reporterContact == ""){				// have nane, no contact
				$reporter = $reporterName;
			}else{																// no name, have contact
				$reporter = $reporterContact;
			}
			
			if($error == 1){
				$_SESSION['addlicense'] = $license;
				$_SESSION['adddriver'] = $driver;
				$_SESSION['addplateno'] = $plateno;
				$_SESSION['addviolation'] = $violation;
				$_SESSION['addviolatedate'] = $vdate;
				$_SESSION['addviolatetime'] = $vtime;
				$_SESSION['addviolatelocation'] = $vlocation;
				$_SESSION['addreporterName'] = $reporterName;
				$_SESSION['addrreporterContact'] = $reporterContact;
				
				header("Location: ./");
			}
			else{
				$result = $rm->newViolation($license, $driver, $plateno, $violation, $vdate, $vtime, $vlocation, "", $reporterName, $reporterContact, 0, $evidence);
				
				if($plateno != ""){
					// vehicle reach maximum violation
					$vehicle = $rm->checkVehicleStatus($plateno); // get vehicle info
					$maxvio = mysql_fetch_array($rm->retrieveOptions()); // get maximum number of violation
					if($vehicle['violation'] >= $maxvio['value']){ // check if vehicle reach maximum violation
						$rm->blockVehicle($plateno, 1);
					}
				}
				
				$_SESSION['message'] = "Violation Reported";
				header("Location: ./");
			}
		}
		
		function scriptError($input, $scriptSession, $error) // one or more input is/are scripts that can harm the program
		{
			if((stripos($input,"script") !== false)){
				if((stripos($input,"<") !== false) && (stripos($input,">") !== false)){
					$_SESSION[$scriptSession] = 1;
					return 1;
				}
			}
			return $error;
		}
		
		function inputIsNull($input, $nullSession, $error) //one or more input is null or empty
		{
			if($input == null) {
				$_SESSION[$nullSession] = 1;
				return 1;
			}
			return $error;
		}
		
		function checkDateFormat($date)
		{
			if(preg_match('#^([0-9]?[0-9]?[0-9]{2}[- /.](0?[1-9]|1[012])[- /.](0?[1-9]|[12][0-9]|3[01]))*$#', $date))
				return 1;
			return 0;
		}
		
		function checkMoreThanCurrentDate($date)
		{
			$date = strtotime($date);
			$current = strtotime(date("Y-m-d"));
			
			if($date > $current)
				return 1;
			return 0;
		}
		
		function requestReportViolation()
		{
			$license = $_POST['license'];
			$driver = $_POST['driver'];
			$plateno = $_POST['plateNo'];
			$violation = $_POST['violation'];
			$vdate = $_POST['violationDate'];
			$vtime = $_POST['violationTime'];
			$vlocation = $_POST['violationLocation'];
			$reporterName = $_POST['reporterName'];
			$reporterContact = $_POST['reporterContact'];
			$evidence = $_FILES['evidence'];
			
			$this->validateInfo($license, $driver, $plateno, $violation, $vdate, $vtime, $vlocation, $reporterName, $reporterContact, $evidence);
		}
	}
	$pc = new ReportController();
	$pc->requestReportViolation();
?>