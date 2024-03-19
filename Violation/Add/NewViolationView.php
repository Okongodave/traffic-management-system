<!--
  - File Name: NewViolationView.php
  - Program Description: New Violation Form Validation
  -->
<?php
	session_start();
	include "NewViolationController.php";
					
	class NewViolationView
	{
		function NewViolationView(){}
		
		function validateInfo($license, $driver, $plateno, $violation, $vdate, $vtime, $vlocation, $penalty, $reporter, $reporterContact, $evidence)
		{
			$error = 0;
			$_SESSION['message'] = "";
			$rm = new RegistrationManager();
			
			$error = $this->scriptError($license, "scriptlicense", $error);
			$error = $this->scriptError($driver, "scriptdriver", $error);
			$error = $this->scriptError($plateno, "scriptplateno", $error);
			$error = $this->scriptError($violation, "scriptviolation", $error);
			$error = $this->scriptError($vdate, "scriptviolatedate", $error);
			$error = $this->scriptError($penalty, "scriptpenalty", $error);
			$error = $this->scriptError($reporter, "scriptreporter", $error);
			
			//$error = $this->inputIsNull($license, "licenseisnull", $error);
			//$error = $this->inputIsNull($driver, "driverisnull", $error);
			//$error = $this->inputIsNull($plateno, "platenoisnull", $error);
			$error = $this->inputIsNull($violation, "violationisnull", $error);
			$error = $this->inputIsNull($vdate, "violatedateisnull", $error);
			$error = $this->inputIsNull($penalty, "penaltyisnull", $error);
			$error = $this->inputIsNull($reporter, "reporterisnull", $error);
			
			if($license == ""){
				if(($plateno == "") && ($driver == "")){
					$_SESSION["message"] = "Enter either Driver's ID Number or Vehicle's Plate Number";
					header("Location: ./");
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
				
				if($plateno != ""){
					if(($rm->checkVehicle("plateNumber", $plateno)) == 0){
						if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
						$_SESSION['message'] .= "- Plate Number doesn't exist";
						$error = 1;
					}
				}
			}
			
			if($this->checkMoreThanCurrentDate($vdate)){
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION['message'] .= "- Violation date cannot be later than the current date";
				$error = 1;
			}
			
			if($this->checkDateFormat($vdate) == 0){
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION['message'] .= "- Violation date format is invalid";
				$error = 1;
			}
			
			if($error == 1)
			{
				$_SESSION['error'] = 1;
				$_SESSION['addlicense'] = $license;
				$_SESSION['adddriver'] = $driver;
				$_SESSION['addplateno'] = $plateno;
				$_SESSION['addviolation'] = $violation;
				$_SESSION['addviolatedate'] = $vdate;
				$_SESSION['addviolatetime'] = $vtime;
				$_SESSION['addviolatelocation'] = $vlocation;
				$_SESSION['addpenalty'] = $penalty;
				$_SESSION['addreporter'] = $reporter;
				
				header("Location: ../Add");
			}
			else
			{
				$profile = $rm->checkDriverId($driver);
			
				$to = $profile['givenName'] . " " . $profile['lastName'] . " <" . $profile['emailAddress'] . ">";
				$subject = "UPF Violation";
				$message = ""
					. "Good Day " . $profile['givenName'] . "\r\n"
					. "\r\n"
					. "This email lets you know that your vehicle with a plate number of ".$plateno." was given a violation on ".$vdate."." . "\r\n"
					. "\r\n"
					. "Below is the violation statement: " . "\r\n"
					. "          " . $violation . "\r\n"
					. "\r\n"
					. "UPF Admin"
					. "";
				$headers = "From: Admin <noreply@upfdatabase.com>";
				
				if(!mail($to, $subject, $message, $headers))
					$_SESSION['message'] = "Sending email error.";
				
				$controller = new NewViolationController();
				$controller->newViolation($license, $driver, $plateno, $violation, $vdate, $vtime, $vlocation, $penalty, $reporter, $reporterContact, $evidence);
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
		
		function requestNewViolation()
		{
			$license = $_POST['license'];
			$driver = $_POST['driver'];
			$plateno = $_POST['plateNo'];
			$violation = $_POST['violation'];
			$vdate = $_POST['violationDate'];
			$vtime = $_POST['violationTime'];
			$vlocation = $_POST['violationLocation'];
			$penalty = $_POST['penalty'];
			$reporter = $_POST['reporter'];
			$reporterContact = $_POST['reporterContact'];
			$evidence = $_FILES['evidence'];
			
			$this->validateInfo($license, $driver, $plateno, $violation, $vdate, $vtime, $vlocation, $penalty, $reporter, $reporterContact, $evidence);
		}
		
		function showMessage($flag) {
			if($flag==1) header("Location: ../../Violation/Add/?addsuccess=1");
			else header("Location: ../../Violation/Add/?addnotsuccess=1");
		}
	}
	$newviolationview = new NewViolationView();
	$newviolationview->requestNewViolation();
?>