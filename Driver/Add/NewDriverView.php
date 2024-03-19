<!--
  - File Name: NewDriverView.php
  - Program Description: New Driver Form Validation
  -->
<?php
session_start();
include "NewDriverController.php";

class NewDriverView
{
	//constructor
	function NewDriverView() {}
	
	function validateInfo($username, $surname, $givenName, $middleName, $age, $civilStatus, $homeAddress, $homeBarangay, $homeTown, $homeProvince, $licenseNumber, $validUntil, $spouseName, $spouseOccupation, $picture, $licensepic)
	{
		$error = 0;
		$target = "../../files/profile/";
		$target2 = "../../files/license/";
		$_SESSION['message'] = "";
		$rm = new RegistrationManager();
		$operatorID = $_SESSION['profileID'];
		
		
		if($_SESSION['profileType'] == "ADMIN" || $_SESSION['profileType'] == "OVCCA" ) $error = $this->inputIsNull($username, "usernameisnull", $error);
		$error = $this->inputIsNull($surname, "surnameisnull", $error);
		$error = $this->inputIsNull($givenName, "givennameisnull", $error);
		$error = $this->inputIsNull($middleName, "middlenameisnull", $error);
		$error = $this->inputIsNull($age, "ageisnull", $error);
		$error = $this->inputIsNull($civilStatus, "civilstatusisnull", $error);
		$error = $this->inputIsNull($homeAddress, "homeaddressisnull", $error);
		$error = $this->inputIsNull($homeBarangay, "barangayisnull", $error);
		$error = $this->inputIsNull($homeTown, "hometownisnull", $error);
		$error = $this->inputIsNull($homeProvince, "provinceisnull", $error);
		$error = $this->inputIsNull($licenseNumber, "licensenoisnull", $error);
		$error = $this->inputIsNull($validUntil, "validuntilisnull", $error);
		//$error = $this->inputIsNull($spouseName, "spousenameisnull", $error);
		//$error = $this->inputIsNull($spouseOccupation, "spouseoccupisnull", $error);
		
		if($_SESSION['profileType'] == "ADMIN" || $_SESSION['profileType'] == "OVCCA" ){
			//echo $username;
			if($username == ""){
				$this->setDefaults($username, $surname, $givenName, $middleName, $age, $civilStatus, $homeAddress, $homeBarangay, $homeTown, $homeProvince, $licenseNumber, $validUntil, $spouseName, $spouseOccupation);
				$_SESSION['message'] = "Please type the applicant's username.";
				header("Location: ../Add");
				die();
			}
			
			$profile = $rm->retrieveProfile($username);
			$profileData = mysql_fetch_array($profile);
			$profileCount = mysql_num_rows($profile);
			
			if($profileCount != 1){
				$this->setDefaults($username, $surname, $givenName, $middleName, $age, $civilStatus, $homeAddress, $homeBarangay, $homeTown, $homeProvince, $licenseNumber, $validUntil, $spouseName, $spouseOccupation);
				$_SESSION['message'] = "Username doesn't exist.";
				header("Location: ../Add");
				die();
			}
			
			$operatorID = $profileData['profileID'];
		}
		
		// check if driver profile already exist. if exist, just attach the driver into its new operator
		$checkDriver = $rm->checkDriverProfile($licenseNumber);
		$data = mysql_fetch_assoc($checkDriver);
		if($data['profileType'] != "DRIVER"){
			$this->setDefaults($username, $surname, $givenName, $middleName, $age, $civilStatus, $homeAddress, $homeBarangay, $homeTown, $homeProvince, $licenseNumber, $validUntil, $spouseName, $spouseOccupation);
			//$_SESSION['message'] = "Person doesn't have a driver profile yet.";
			//header("Location: ../Add");
			//die();
		}
		$count = mysql_num_rows($checkDriver);
		
		$row = mysql_fetch_assoc($checkDriver);
		
		if($count > 0){
			$cdo = $rm->checkDriverOperator($row['profileID']);
			$count = mysql_num_rows($cdo);
			//echo $count;
			
			if($count == 0){
				$rm->attachDriver($row['profileID'], $operatorID);
				
				unset($_SESSION['addsurname']);
				unset($_SESSION['addgivenname']);
				unset($_SESSION['addmiddlename']);
				unset($_SESSION['addage']);
				unset($_SESSION['addcivilstatus']);
				unset($_SESSION['addhomeaddress']);
				unset($_SESSION['addbarangay']);
				unset($_SESSION['addhometown']);
				unset($_SESSION['addprovince']);
				unset($_SESSION['addlicenseno']);
				unset($_SESSION['addvaliduntil']);
				unset($_SESSION['addspousename']);
				unset($_SESSION['addspouseoccup']);
				if(isset($_SESSION['addusername'])) unset($_SESSION['addusername']);
				
				if(isset($_SESSION['scriptsurname'])) unset($_SESSION['scriptsurname']);
				if(isset($_SESSION['scriptgivenname'])) unset($_SESSION['scriptgivenname']);
				if(isset($_SESSION['scriptmiddlename'])) unset($_SESSION['scriptmiddlename']);
				if(isset($_SESSION['scriptage'])) unset($_SESSION['scriptage']);
				if(isset($_SESSION['scriptcivilstatus'])) unset($_SESSION['scriptcivilstatus']);
				if(isset($_SESSION['scripthomeaddress'])) unset($_SESSION['scripthomeaddress']);
				if(isset($_SESSION['scriptbarangay'])) unset($_SESSION['scriptbarangay']);
				if(isset($_SESSION['scripthometown'])) unset($_SESSION['scripthometown']);
				if(isset($_SESSION['scriptprovince'])) unset($_SESSION['scriptprovince']);
				if(isset($_SESSION['scriptlicenseno'])) unset($_SESSION['scriptlicenseno']);
				if(isset($_SESSION['scriptvaliduntil'])) unset($_SESSION['scriptvaliduntil']);
				if(isset($_SESSION['scriptspousename'])) unset($_SESSION['scriptspousename']);
				if(isset($_SESSION['scriptspouseoccup'])) unset($_SESSION['scriptspouseoccup']);
				
				if(isset($_SESSION['usernameisnull'])) unset($_SESSION['usernameisnull']);
				if(isset($_SESSION['surnameisnull'])) unset($_SESSION['surnameisnull']);
				if(isset($_SESSION['givennameisnull'])) unset($_SESSION['givennameisnull']);
				if(isset($_SESSION['middlenameisnull'])) unset($_SESSION['middlenameisnull']);
				if(isset($_SESSION['ageisnull'])) unset($_SESSION['ageisnull']);
				if(isset($_SESSION['civilstatusisnull'])) unset($_SESSION['civilstatusisnull']);
				if(isset($_SESSION['homeaddressisnull'])) unset($_SESSION['homeaddressisnull']);
				if(isset($_SESSION['barangayisnull'])) unset($_SESSION['barangayisnull']);
				if(isset($_SESSION['hometownisnull'])) unset($_SESSION['hometownisnull']);
				if(isset($_SESSION['provinceisnull'])) unset($_SESSION['provinceisnull']);
				if(isset($_SESSION['licensenoisnull'])) unset($_SESSION['licensenoisnull']);
				if(isset($_SESSION['validuntilisnull'])) unset($_SESSION['validuntilisnull']);
				if(isset($_SESSION['spousenameisnull'])) unset($_SESSION['spousenameisnull']);
				if(isset($_SESSION['spouseoccupisnull'])) unset($_SESSION['spouseoccupisnull']);
				if(isset($_SESSION['pictureisnull'])) unset($_SESSION['pictureisnull']);
				if(isset($_SESSION['licensepicisnull']))unset($_SESSION['licensepicisnull']);
				
				$_SESSION['message'] = "Driver added";
				header("Location: ../Add");
				die();
			}
		}
		
		if($rm->checkProfile('licenseNumber', $licenseNumber) > 0){
			if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
			$_SESSION['message'] .= "- License Number already exists in the system.";
			$error = 1;
		}
		
		if($this->checkDateFormat($validUntil) == 0){
			if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
			$_SESSION['message'] .= "- License Expiry date format is invalid.";
			$error = 1;
		}
		
		if($this->checkMoreThanCurrentDate($validUntil)){
			if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
			$_SESSION['message'] .= "- License Expiry Date cannot be earlier than the current date.";
			$error = 1;
		}
		
		if($picture['name'] == ""){
			//$picture = "default.gif";
			$_SESSION['message'].= "<br>- No picture uploaded.";
			$error = 1;
		}
		elseif($picture['name'] != ""){
			$fileType = $this->fileType($picture);
			$filename = strtolower($surname.$givenName.$middleName) . "." . $fileType;
			
			if(move_uploaded_file( $picture['tmp_name'], ($target.$filename) )){
				$picture = $filename;
			}
			else{
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION['message'] .= "- There is an error in uploading picture.";
				$error = 1;
			}
		}
		
		if($licensepic['name'] == ""){
			//$licensepic = "default.gif";
			$_SESSION['message'].= "<br>- No license uploaded.";
			$error = 1;
		}
		elseif($licensepic['name'] != ""){
			$fileType = $this->fileType($licensepic);
			$filename = strtolower($surname.$givenName.$middleName) . "." . $fileType;
			
			if(move_uploaded_file( $licensepic['tmp_name'], ($target2.$filename) )){
				$licensepic = $filename;
			}
			else{
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION['message'] .= "- There is an error uploading the license.";
				$error = 1;
			}
		}
		
		if($error == 1){
			$_SESSION['error'] = 1;
			$this->setDefaults($username, $surname, $givenName, $middleName, $age, $civilStatus, $homeAddress, $homeBarangay, $homeTown, $homeProvince, $licenseNumber, $validUntil, $spouseName, $spouseOccupation);
			
			header("Location: ../Add");//there are errors present
		}
		else{
			$ndc = new NewDriverController();
			$ndc->newDriver($operatorID, $username, $surname, $givenName, $middleName, $age, $civilStatus, $homeAddress, $homeBarangay, $homeTown, $homeProvince, $licenseNumber, $validUntil, $spouseName, $spouseOccupation, $picture, $licensepic);
		}
	}
	
	function setDefaults($username, $surname, $givenName, $middleName, $age, $civilStatus, $homeAddress, $homeBarangay, $homeTown, $homeProvince, $licenseNumber, $validUntil, $spouseName, $spouseOccupation)
	{
		$_SESSION['addusername'] = $username;
		$_SESSION['addsurname'] = $surname;
		$_SESSION['addgivenname'] = $givenName;
		$_SESSION['addmiddlename'] = $middleName;
		$_SESSION['addage'] = $age;
		$_SESSION['addcivilstatus'] = $civilStatus;
		$_SESSION['addhomeaddress'] = $homeAddress;
		$_SESSION['addbarangay'] = $homeBarangay;
		$_SESSION['addhometown'] = $homeTown;
		$_SESSION['addprovince'] = $homeProvince;
		$_SESSION['addlicenseno'] = $licenseNumber;
		$_SESSION['addvaliduntil'] = $validUntil;
		$_SESSION['addspousename'] = $spouseName;
		$_SESSION['addspouseoccup'] = $spouseOccupation;
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
	
	function fileType($file)
	{
		if($file['type'] != "image/jpeg")
			return "jpg";
		elseif($file['type'] != "image/png")
			return "png";
		elseif($file['type'] != "image/gif")
			return "gif";
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
			return 0;
		return 1;
	}
	
	
	function requestNewDriver()
	{
		$username = isset($_POST['username']) ? $_POST['username'] : $_SESSION['username'];
		$surname = $_POST['surname'];
		$givenName = $_POST['givenName'];
		$middleName = $_POST['middleName'];
		$age = $_POST['age'];
		$civilStatus = $_POST['civilStatus'];
		$homeAddress = $_POST['homeAddress'];
		$homeBarangay = $_POST['homeBarangay'];
		$homeTown = $_POST['homeTown'];
		$homeProvince = $_POST['homeProvince'];
		$licenseNumber = $_POST['licenseNumber'];
		$validUntil = $_POST['validUntil'];
		$spouseName = $_POST['spouseName'];
		$spouseOccupation = $_POST['spouseOccupation'];
		$picture = $_FILES['picture'];
		$licensepic = $_FILES['licensepic'];
		
		$this->validateInfo($username, $surname, $givenName, $middleName, $age, $civilStatus, $homeAddress, $homeBarangay, $homeTown, $homeProvince, $licenseNumber, $validUntil, $spouseName, $spouseOccupation, $picture, $licensepic);
	}
	
	function showMessage($flag)
	{
		if($flag==1) header("Location: ../Add/?addsuccess=1");
		else header("Location: ../Add/?addnotsuccess=1");
	}
}

$newdriverview = new NewDriverView();
$newdriverview->requestNewDriver();
?>