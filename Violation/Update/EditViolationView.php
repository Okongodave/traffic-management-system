<!--
  - File Name: EditViolationView.php
  - Program Description: Edit Violation Form Validation
  -->
<?php
	session_start();
	include "EditViolationController.php";
					
	class EditViolationView
	{
		function EditViolationView(){}
		
		function validateInfo($license, $driver, $plateNo, $violation, $vdate, $vtime, $vlocation, $penalty, $reporter, $evidence, $reporterContact, $evidenceVal)
		{
			$error = 0;
			$_SESSION['message'] = "";
			$rm = new RegistrationManager();
			
			//$error = $this->scriptError($license, "scriptlicense", $error);
			//$error = $this->scriptError($driver, "scriptdriver", $error);
			//$error = $this->scriptError($plateNo, "scriptplateno", $error);
			$error = $this->scriptError($violation, "scriptviolation", $error);
			$error = $this->scriptError($vdate, "scriptviolatedate", $error);
			$error = $this->scriptError($vtime, "scriptviolatetime", $error);
			$error = $this->scriptError($vlocation, "scriptviolatelocation", $error);
			$error = $this->scriptError($penalty, "scriptpenalty", $error);
			$error = $this->scriptError($reporter, "scriptreporter", $error);
			
			//$error = $this->inputIsNull($license, "licenseisnull", $error);
			//$error = $this->inputIsNull($driver, "driverisnull", $error);
			//$error = $this->inputIsNull($plateNo, "platenoisnull", $error);
			$error = $this->inputIsNull($violation, "violationisnull", $error);
			$error = $this->inputIsNull($vdate, "violatedateisnull", $error);
			$error = $this->inputIsNull($vtime, "violatetimeisnull", $error);
			$error = $this->inputIsNull($vlocation, "violatelocationisnull", $error);
			$error = $this->inputIsNull($penalty, "penaltyisnull", $error);
			$error = $this->inputIsNull($reporter, "reporterisnull", $error);
			
			if($driver == "" && $plateNo == ""){
				$_SESSION["message"] = "Enter either Driver's ID Number or Vehicle's Plate Number";
				header("Location: ../Update/?vn=".$_SESSION['violationNo']);
				die();
			}
			
			if($driver != ""){
				$temp = $rm->checkDriverID($driver);
				if($temp['driverID'] == ""){
					if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
					$_SESSION['message'] .= "- Driver ID doesn't exist";
					$error = 1;
				}
			}
			
			if($plateNo != ""){
				if(($rm->checkVehicle("plateNumber", $plateNo)) == 0){
					if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
					$_SESSION['message'] .= "- Plate Number doesn't exist";
					$error = 1;
				}
			}
			
			if($this->checkDateFormat($vdate) == 0){
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION['message'] .= "- Violation date format is invalid";
				$error = 1;
			}
			
			//filetype
			if($evidence['type'] != "image/jpeg")
				$filetype = "jpg";
			elseif($evidence['type'] != "image/png")
				$filetype = "png";
			elseif($evidence['type'] != "image/gif")
				$filetype = "gif";
			
			if($evidence['name'] == "")
				$evidence = $evidenceVal;
			else{
				//$target = "../";
				$target = "../../files/evidence/";
				$filename = $target.$_SESSION['violationNo'].".".$filetype;
				
				move_uploaded_file($evidence['tmp_name'], $filename);
				
				$evidence = $_SESSION['violationNo'].".".$filetype;
			}
			
			if($error == 1)
			{
				$_SESSION['editerror'] = 1;
				$_SESSION['editlicense'] = $license;
				$_SESSION['editdriver'] = $driver;
				$_SESSION['editplateno'] = $plateNo;
				$_SESSION['editviolation'] = $violation;
				$_SESSION['editviolatedate'] = $vdate;
				$_SESSION['editpenalty'] = $penalty;
				$_SESSION['editreporter'] = $reporter;
				
				header("Location: ../Update/?vn=".$_SESSION['violationNo']);
			}
			else
			{
				$controller = new EditViolationController();
				$controller->newViolation($license, $driver, $plateNo, $violation, $vdate, $vtime, $vlocation, $penalty, $reporter, $reporterContact, $evidence);
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
		
		function requestEditViolation()
		{
			$license = $_POST['license'];
			$driver = $_POST['driver'];
			$plateNo = $_POST['plateNo'];
			$violation = $_POST['violation'];
			$vdate = $_POST['violationDate'];
			$vtime = $_POST['violationTime'];
			$vlocation = $_POST['violationLocation'];
			$penalty = $_POST['penalty'];
			$reporter = $_POST['reporter'];
			$evidence = $_FILES['evidence'];
			$reporterContact = $_POST['reporterContact'];
			$evidenceVal = $_POST['evidenceVal'];
			
			$this->validateInfo($license, $driver, $plateNo, $violation, $vdate, $vtime, $vlocation, $penalty, $reporter, $evidence, $reporterContact, $evidenceVal);
		}
		
		function showMessage($flag) {
			if($flag==1) header("Location: ../../Violation/Update/?vn=".$_SESSION['violationNo']."&editsuccess=1");
			else header("Location: ../../Violation/Update/?vn=".$_SESSION['violationNo']."&editnotsuccess=1");
		}
	}
	$editviolationview = new EditViolationView();
	$editviolationview->requestEditViolation();
?>