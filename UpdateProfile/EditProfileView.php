<!--
  - File Name: Edit/profileView.php
  - Program Description: Edit Profile Form Validation
  -->
<?php
session_start();
include "EditProfileController.php";
class EditProfileView
{
	function validateInfo($profiletype,$uname,$pword,$lname,$fname,$mname,$contactno,$gender,$civil,$homeadd,$homebrgy,$hometown,$homeprov,
		$offbrgy,$offtown,$offprov,$officeadd,$birthplace,$birthday,$occupation,$email,$cit,$license,$where,$when,$expiry,$picture,$pictureVal,$licensepic,$licensepicVal) {
		
		$error = 0;
		$target = "../files/profile/";
		$target2 = "../files/license/";
		$_SESSION['message'] = "";
		$rm = new RegistrationManager();
		
		$error = $this->scriptError($pword, "scriptpword", $error);
		$error = $this->scriptError($lname, "scriptlname", $error);
		$error = $this->scriptError($fname, "scriptfname", $error);
		$error = $this->scriptError($mname, "scriptmname", $error);
		
		$error = $this->inputIsNull($pword, "pwordisnull", $error);
		switch($_SESSION['profileType']){
			//case "PUBLIC":
			//case "PRIVATE":
			//case "OPERATOR":
			case "APPLICANT";
				//$error = $this->inputIsNull($driverid, "driveridisnull", $error);
				$error = $this->inputIsNull($uname, "unameisnull", $error);
				$error = $this->inputIsNull($lname, "lnameisnull", $error);
				$error = $this->inputIsNull($fname, "fnameisnull", $error);
				$error = $this->inputIsNull($mname, "mnameisnull", $error);
				$error = $this->inputIsNull($contactno, "contactnumberisnull", $error);
				$error = $this->inputIsNull($gender, "genderisnull", $error);
				$error = $this->inputIsNull($homeadd, "homeaddisnull", $error);
				$error = $this->inputIsNull($homebrgy, "homebrgyisnull", $error);
				$error = $this->inputIsNull($hometown, "hometownisnull", $error);
				$error = $this->inputIsNull($homeprov, "homeprovisnull", $error);
				//$error = $this->inputIsNull($offbrgy, "offbrgyisnull", $error);
				//$error = $this->inputIsNull($offtown, "offtownisnull", $error);
				//$error = $this->inputIsNull($offprov, "offprovisnull", $error);
				//$error = $this->inputIsNull($officeadd, "officeaddisnull", $error);
				$error = $this->inputIsNull($birthplace, "birthplaceisnull", $error);
				$error = $this->inputIsNull($birthday, "birthdayisnull", $error);
				$error = $this->inputIsNull($occupation, "occupationisnull", $error);
				$error = $this->inputIsNull($email, "emailisnull", $error);
				$error = $this->inputIsNull($cit, "citisnull", $error);
				$error = $this->inputIsNull($license, "licenseisnull", $error);
				$error = $this->inputIsNull($where, "whereisnull", $error);
				$error = $this->inputIsNull($when, "whenisnull", $error);
				$error = $this->inputIsNull($expiry, "expiryisnull", $error);
				
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
					if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
					$_SESSION['message'] .= "- Email Address format invalid";
					$error = 1;
				}
				
				/*if($driverid != ""){
					if(!is_numeric($driverid)){
						if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
						$_SESSION['message'] .= "- Driver ID Number must be composed of numbers only";
						$error = 1;
					}
					
					if(strlen($driverid) != 4){
						if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
						$_SESSION['message'] .= "- Driver ID Number must be four digits";
						$error = 1;
					}
				}*/
				
				if($this->checkMoreThanCurrentDate($birthday)){
					if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
					$_SESSION['message'] .= "- Birthday cannot be later than the current date";
					$error = 1;
				}
				
				if($this->checkMoreThanCurrentDate($when)){
					if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
					$_SESSION['message'] .= "- License Issued Date cannot be later than the current date";
					$error = 1;
				}
				
				if($this->checkDateFormat($birthday) == 0){
					if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
					$_SESSION['message'] .= "- Birthday format is invalid";
					$error = 1;
				}
				
				if($this->checkDateFormat($when) == 0){
					if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
					$_SESSION['message'] .= "- License Issued date format is invalid";
					$error = 1;
				}
				
				if($this->checkDateFormat($expiry) == 0){
					if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
					$_SESSION['message'] .= "- License Expiration date format is invalid";
					$error = 1;
				}
				
				if($this->checkLicenseFormat($license) == 0){
					if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
					$_SESSION['message'] .= "- License Number format is invalid";
					$error = 1;
				}
				
				if($when != "" && $expiry != ""){
					$issued = strtotime($when);
					$expired = strtotime($expiry);
					
					if($expired < $issued){
						if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
						$_SESSION['message'] .= "- License Expiration date must be later than the Issued Date";
						$error = 1;
					}
				}
				
				if(is_array($picture)){
					if($picture['tmp_name'] == ""){
						if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
						$_SESSION['message'] .= "- Please select 2x2 Picture.";
						$error = 1;
						$picture = $pictureVal;
					}else{
						$fileType = $this->fileType($picture);
						$filename = $uname . "." . $fileType;
						
						if(move_uploaded_file( $picture['tmp_name'], ($target.$filename) )){
							$picture = $filename;
						}else{
							if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
							$_SESSION['message'] .= "- Error in uploading picture.";
							$picture = $pictureVal;
							$error = 1;
						}
					}
				}
				if(is_array($licensepic)){
					if($licensepic['tmp_name'] == ""){
						if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
						$_SESSION['message'] .= "- Please select a scanned image of your license.";
						$error = 1;
						$licensepic = $licensepicVal;
					}else{
						$fileType = $this->fileType($licensepic);
						$filename = $uname . "." . $fileType;
						
						if(move_uploaded_file( $licensepic['tmp_name'], ($target2.$filename) )){
							$licensepic = $filename;
						}else{
							if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
							$_SESSION['message'] .= "- Error in uploading license.";
							$licensepic = $licensepicVal;
							$error = 1;
						}
					}
				}
				
		}
		
		if($error == 1){
			$_SESSION['editerror'] = 1;
			//$_SESSION['editdriverid'] = $driverid;
			$_SESSION['edituname'] = $uname;
			$_SESSION['editpword'] = $pword;
			$_SESSION['editlname'] = $lname;
			$_SESSION['editfname'] = $fname;
			$_SESSION['editmname'] = $mname;
			$_SESSION['editcontactnumber'] = $contactno;
			
			$_SESSION['editgender'] = $gender;
			$_SESSION['editcivil'] = $civil;
			$_SESSION['edithomeadd'] = $homeadd;
			$_SESSION['editofficeadd'] = $officeadd;
			$_SESSION['editoffbrgy'] = $offbrgy;
			$_SESSION['editofftown'] = $offtown;
			$_SESSION['editoffprov'] = $offprov;
			$_SESSION['edithomebrgy'] = $homebrgy;				
			$_SESSION['edithometown'] = $hometown;
			$_SESSION['edithomeprov'] = $homeprov;
			$_SESSION['editbirthday'] = $birthday;
			$_SESSION['editbirthplace'] = $birthplace;
			
			$_SESSION['editoccupation'] = $occupation;
			$_SESSION['editemail'] = $email;
			$_SESSION['editcit'] = $cit;
			$_SESSION['editlicense'] = $license;
			$_SESSION['editwhere'] = $where;
			$_SESSION['editwhen'] = $when;
			$_SESSION['editexpiry'] = $expiry;
			
			$_SESSION['editpicture'] = $picture;
			$_SESSION['editlicensepic'] = $licensepic;
			header("Location: ../UpdateProfile");//there are errors present
		}
		else{
			$asc = new EditProfileController();
			$asc->editProfile($profiletype,$uname,$pword,$lname,$fname,$mname,$contactno,$gender,$civil,$homeadd,$homebrgy,$hometown,$homeprov,
				$offbrgy,$offtown,$offprov,$officeadd,$birthplace,$birthday,$occupation,$email,$cit,$license,$where,$when,$expiry,$picture,$licensepic);
		}//there are no errors
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
	
	function checkLicenseFormat($license)
	{
		if(preg_match('/^([A-Za-z][0-9]{2})\-([0-9]{2})\-([0-9]{6})$/',$license)) // LNN-NN-NNNNNN
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
	
	function requestEditProfile(){
		/*get submitted information*/
			
		$profiletype = $_SESSION['profileType'];
		//$driverid = $_POST['driverid'];
		$uname = $_SESSION['username'];
		$pword = $_POST['pword'];
		$lname = $_POST['lname'];
		$fname = $_POST['fname'];
		$mname = $_POST['mname'];
		$contactno = $_POST['contactnumber'];
		$pword = $_POST['pword'];
		$gender = $_POST['gender'];
		$civil = $_POST['civil'];
		$homeadd = $_POST['homeadd'];
		$homebrgy = $_POST['homebrgy'];
		$hometown = $_POST['hometown'];
		$homeprov = $_POST['homeprov'];
		$officeadd = $_POST['officeadd'];
		$offbrgy = $_POST['offbrgy'];
		$offtown = $_POST['offtown'];
		$offprov = $_POST['offprov'];
		$birthday = $_POST['birthday'];
		$birthplace = $_POST['birthplace'];
		$occupation = $_POST['occupation'];
		$email = $_POST['email'];
		$cit = $_POST['cit'];
		$license = $_POST['license'];
		$where = $_POST['where'];
		$when = $_POST['when'];
		$expiry = $_POST['expiry'];
		
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
		
		$this->validateInfo($profiletype,$uname,$pword,$lname,$fname,$mname,$contactno,$gender,$civil,$homeadd,$homebrgy,$hometown,$homeprov,
			$offbrgy,$offtown,$offprov,$officeadd,$birthplace,$birthday,$occupation,$email,$cit,$license,$where,$when,$expiry,$picture,$pictureVal,$licensepic,$licensepicVal);
	}
	
	function showMessage($flag) {
		if($flag>0) header("Location: ../HomePage?editsuccess=$flag");
		else header("Location: ../UpdateProfile/?editnotsuccess=$flag");
	}
}

$editprofileview = new EditProfileView(); //instance of EditStudentView
$editprofileview->requestEditProfile();
?>