<!--
  - File Name: /Driver/Update/EditDriverView.php
  - Program Description: Edit Driver Form Validation
  -->
<?php
session_start();
include "EditDriverController.php";
class EditDriverView
{
	function validateInfo($surname, $givenName, $middleName, $age, $civilStatus, $homeAddress, $homeBarangay, $homeTown, $homeProvince, $licenseNumber, $validUntil, $spouseName, $spouseOccupation, $picture, $pictureVal, $licensepic, $licensepicVal)
	{
		$error = 0;
		$target = "../../files/profile/";
		$target2 = "../../files/license/";
		$_SESSION['message'] = "";
		$rm = new RegistrationManager();
		
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
		
		if($this->checkDateFormat($validUntil) == 0){
			if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
			$_SESSION['message'] .= "- License Expiry date format is invalid.";
			$error = 1;
		}
		
		if($this->checkLicenseFormat($licenseNumber) == 0){
			if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
			$_SESSION['message'] .= "- License Number format is invalid.";
			$error = 1;
		}
		
		if(is_array($picture)){
			if($picture['tmp_name'] == ""){
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION['message'] .= "- Please select a 2x2 Picture.";
				$error = 1;
				$picture = $pictureVal;
			}else{
				$fileType = $this->fileType($picture);
				$filename = strtolower($surname.$givenName.$middleName) . "." . $fileType;
				//$filename = $uname . "." . $fileType;
				
				if(move_uploaded_file( $picture['tmp_name'], ($target.$filename) )){
					$picture = $filename;
				}else{
					if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
					$_SESSION['message'] .= "- There is an error in uploading picture.";
					$error = 1;
				}
			}
		}
		
		if(is_array($licensepic)){
			if($licensepic['tmp_name'] == ""){
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION['message'] .= "- Please select a scanned image of license.";
				$error = 1;
				$licensepic = $licensepicVal;
			}else{
				$fileType = $this->fileType($licensepic);
				$filename = strtolower($surname.$givenName.$middleName) . "." . $fileType;
				//$filename = $uname . "." . $fileType;
				
				if(move_uploaded_file( $licensepic['tmp_name'], ($target2.$filename) )){
					$licensepic = $filename;
				}else{
					if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
					$_SESSION['message'] .= "- There is an error in uploading scanned license.";
					$error = 1;
				}
			}
		}
		
		
		if($error == 1){
			$_SESSION['error'] = 1;
			$_SESSION['editsurname'] = $surname;
			$_SESSION['editgivenname'] = $givenName;
			$_SESSION['editmiddlename'] = $middleName;
			$_SESSION['editage'] = $age;
			$_SESSION['editcivilstatus'] = $civilStatus;
			$_SESSION['edithomeaddress'] = $homeAddress;
			$_SESSION['editbarangay'] = $homeBarangay;
			$_SESSION['edithometown'] = $homeTown;
			$_SESSION['editprovince'] = $homeProvince;
			$_SESSION['editlicenseno'] = $licenseNumber;
			$_SESSION['editlicenseexpirydate'] = $validUntil;
			$_SESSION['editspousename'] = $spouseName;
			$_SESSION['editspouseoccup'] = $spouseOccupation;
			$_SESSION['editpicture'] = $picture;
			$_SESSION['editlicensepic'] = $licensepic;
			
			header("Location: ../Update/?id=".$_SESSION['editdriverprofileid']);//there are errors present
		}
		else{
			$ndc = new EditDriverController();
			$ndc->editDriver($surname, $givenName, $middleName, $age, $civilStatus, $homeAddress, $homeBarangay, $homeTown, $homeProvince, $licenseNumber, $validUntil, $spouseName, $spouseOccupation, $picture, $licensepic);
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
	
	function checkLicenseFormat($license)
	{
		if(preg_match('/^([A-Za-z][0-9]{2})\-([0-9]{2})\-([0-9]{6})$/',$license)) // LNN-NN-NNNNNN
			return 1;
		return 0;
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
	
	function requestEditDriver()
	{
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
		
		// picture
		$pictureVal = "";
		if(isset($_POST['pictureCheck'])){
			$picture = $_FILES['picture'];
			$pictureVal = $_POST['pictureVal'];
		}else{
			$pictureVal = $picture = $_POST['pictureVal'];
		}
		
		$licensepicVal = "";
		if(isset($_POST['licensepicCheck'])){
			$licensepic = $_FILES['licensepic'];
			$licensepicVal = $_POST['licensepicVal'];
		}else{
			$licensepicVal = $licensepic = $_POST['licensepicVal'];
		}
		
		$this->validateInfo($surname, $givenName, $middleName, $age, $civilStatus, $homeAddress, $homeBarangay, $homeTown, $homeProvince, $licenseNumber, $validUntil, $spouseName, $spouseOccupation, $picture, $pictureVal, $licensepic, $licensepicVal);
	}
	
	function showMessage($licenseNumber, $flag)
	{
		if($flag==1) header("Location: ../Update/?id=".$_SESSION['editdriverprofileid']."&editsuccess=1");
		else header("Location: ../Update/?id=".$_SESSION['editdriverprofileid']."&editnotsuccess=1");
	}
}

$editdriverview = new EditDriverView();
$editdriverview->requestEditDriver();
?>