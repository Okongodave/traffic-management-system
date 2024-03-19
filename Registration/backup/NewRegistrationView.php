<!--
  - File Name: NewRegistrationView.php
  - Program Description: New Registration Form Validation
  -->
<?php
session_start();
include "NewRegistrationController.php";
//include "../RegistrationManager.php";
				
class NewRegistrationView
{
	//constructor
	function NewRegistrationView() {
	}
	
	function validateInfo($profiletype,$uname,$pword,$lname,$fname,$mname,$contactno,$gender,$civil,$homeadd,$homebrgy,$hometown,$homeprov,
		$offbrgy,$offtown,$offprov,$officeadd,$birthplace,$birthday,$occupation,$email,$cit,$license,$where,$when,$expiry,$picture,$licensepic) {
		
		$error = 0;
		$target = "../files/profile/";
		$target2 = "../files/license/";
		$_SESSION['message'] = "";
		$rm = new RegistrationManager();
		
		$error = $this->scriptError($uname, "scriptuname", $error);
		$error = $this->scriptError($pword, "scriptpword", $error);
		$error = $this->scriptError($lname, "scriptlname", $error);
		$error = $this->scriptError($fname, "scriptfname", $error);
		$error = $this->scriptError($mname, "scriptmname", $error);
		
		$error = $this->inputIsNull($uname, "unameisnull", $error);
		$error = $this->inputIsNull($pword, "pwordisnull", $error);
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
		$error = $this->inputIsNull($picture, "pictureisnull", $error);
		$error = $this->inputIsNull($licensepic, "licensepicisnull", $error);
		
		if(!(preg_match('/^[a-z\d_]{4,20}$/i', $uname))){
			$_SESSION['message'] .= "- Invalid username. It should consist of alpha-numeric (a-z, A-Z, 0-9), underscores, and has 4-20 characters.";
			$error = 1;
		}
		
		if($rm->checkProfile('userName', $uname) > 0){
			if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
			$_SESSION['message'] .= "- Username already exists.";
			$error = 1;
		}
		
		if($rm->checkProfile('emailAddress', $email) > 0){
			if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
			$_SESSION['message'] .= "- Email Address already exists.";
			$error = 1;
		}
		elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
			$_SESSION['message'] .= "- Email Address format is invalid.";
			$error = 1;
		}
		
		if($rm->checkProfile('licenseNumber', $license) > 0){
			if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
			$_SESSION['message'] .= "- License already exists.";
			$error = 1;
		}
		
		if($this->checkMoreThanCurrentDate($birthday)==1){
			if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
			$_SESSION['message'] .= "- Birthday cannot be earlier than the current date.";
			$error = 1;
		}
		
		if($this->checkMoreThanCurrentDate($when)==1){
			if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
			$_SESSION['message'] .= "- License Issued Date cannot be later than the current date.";
			$error = 1;
		}
		
		if($this->checkDateFormat($birthday) == 0){
			if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
			$_SESSION['message'] .= "- Birthday format is invalid.";
			$error = 1;
		}
		
		if($this->checkDateFormat($when) == 0){
			if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
			$_SESSION['message'] .= "- License Issued date format is invalid.";
			$error = 1;
		}
		
		if($this->checkDateFormat($expiry) == 0){
			if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
			$_SESSION['message'] .= "- License Expiration date format is invalid.";
			$error = 1;
		}
		
		if($this->checkLicenseFormat($license) == 0){
			if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
			$_SESSION['message'] .= "- License Number format is invalid.";
			$error = 1;
		}
		
		if($when != "" && $expiry != ""){
			$issued = strtotime($when);
			$expired = strtotime($expiry);
			
			if($expired < $issued){
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION['message'] .= "- License Expiration date must be more than the Issued Date";
				$error = 1;
			}
		}
		
		if($picture['name'] == ""){
			//$picture = "default.gif";
			$_SESSION['message'] .= "<br>- No 2x2 picture uploaded.";
			$error = 1;
		}
		elseif($picture['name'] != ""){
			if($uname != null){
				$fileType = $this->fileType($picture);
				$filename = $uname . "." . $fileType;
				
				if(move_uploaded_file( $picture['tmp_name'], ($target.$filename) )){
					$picture = $filename;
				}
				else{
					if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
					$_SESSION['message'] .= "- Error in picture uploading.";
					$error = 1;
				}
			}
			else{
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION['message'] .= "- Please provide a valid username.";
				$error = 1;
			}
		}
		
		if($licensepic['name'] == ""){
			//$picture = "default.gif";
			$_SESSION['message'] .= "<br>- No license uploaded.";
			$error = 1;
		}
		elseif($licensepic['name'] != ""){
			if($uname != null){
				$fileType = $this->fileType($licensepic);
				$filename = $uname . "." . $fileType;
				
				if(move_uploaded_file( $licensepic['tmp_name'], ($target2.$filename) )){
					$licensepic = $filename;
				}
				else{
					if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
					$_SESSION['message'] .= "- Error in license uploading.";
					$error = 1;
				}
			}
			else{
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION['message'] .= "- Please provide a valid username.";
				$error = 1;
			}
		}
		
		/*if($plateno!=null && (!ereg('^([A-Za-z]{3})\-([0-9]{3})$',$plateno) || strlen($plateno)!=7)) {
			$_SESSION['wrongplateno'] = 1;
			$error = 1;
		}*//*wrong plate number format*/
		

		if($error==1){
			$_SESSION['error'] = 1;
			$_SESSION['profiletype'] = $profiletype;
			$_SESSION['adduname'] = $uname;
			$_SESSION['addlname'] = $lname;
			$_SESSION['addfname'] = $fname;
			$_SESSION['addmname'] = $mname;
			
			$_SESSION['addcontactnumber'] = $contactno;
			
			$_SESSION['addgender'] = $gender;
			$_SESSION['addcivil'] = $civil;
			$_SESSION['addhomeadd'] = $homeadd;
			$_SESSION['addofficeadd'] = $officeadd;
			$_SESSION['addoffbrgy'] = $offbrgy;
			$_SESSION['addofftown'] = $offtown;
			$_SESSION['addoffprov'] = $offprov;
			$_SESSION['addhomebrgy'] = $homebrgy;				
			$_SESSION['addhometown'] = $hometown;
			$_SESSION['addhomeprov'] = $homeprov;
			$_SESSION['addbirthday'] = $birthday;
			$_SESSION['addbirthplace'] = $birthplace;
			
			$_SESSION['addoccupation'] = $occupation;
			$_SESSION['addemail'] = $email;
			$_SESSION['addcit'] = $cit;
			$_SESSION['addlicense'] = $license;
			$_SESSION['addwhere'] = $where;
			$_SESSION['addwhen'] = $when;
			$_SESSION['addexpiry'] = $expiry;
			header("Location: ../Registration");//there are errors present
		}
		else{
			$asc = new NewRegistrationController();
			$asc->newRegistration($profiletype,$uname,$pword,$lname,$fname,$mname,$contactno,$gender,$civil,$homeadd,$homebrgy,$hometown,$homeprov,
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
		
		if($date < $current)
			return 0;
		return 1;
	}
	
	function requestNewRegistration()
	{
		/*get submitted information*/
		$profiletype = "APPLICANT";
		$uname = $_POST['uname'];
		$pword = $_POST['pword'];
		$lname = $_POST['lname'];
		$fname = $_POST['fname'];							
		$mname = $_POST['mname'];
		$contactno = $_POST['contactnumber'];
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
		$picture = $_FILES['picture'];
		$licensepic = $_FILES['licensepic'];
		
		$this->validateInfo($profiletype,$uname,$pword,$lname,$fname,$mname,$contactno,$gender,$civil,$homeadd,$homebrgy,$hometown,$homeprov,
			$offbrgy,$offtown,$offprov,$officeadd,$birthplace,$birthday,$occupation,$email,$cit,$license,$where,$when,$expiry,$picture,$licensepic);
	}
	
	function showMessage($flag) {
		if($flag==1) header("Location: ../Registration/?addsuccess=1");
		else header("Location: ../Registration/?addnotsuccess=1");
	}//show message if add student is successful or not
}

$newregistrationview = new NewRegistrationView(); //instance of AddStudentView
$newregistrationview->requestNewRegistration();

?>