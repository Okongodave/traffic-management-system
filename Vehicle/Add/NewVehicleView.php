<!--
  - File Name: NewVehicleView.php
  - Program Description: New Vehicle Form Validation
  -->
<?php
session_start();
include "NewVehicleController.php";
				
class NewVehicleView
{
	//constructor
	function NewVehicleView() {
	}

	function validateInfo($uname,$vehicletype,$plateno,$model,$year,$motor,$chassis,$color,$laststickeryear,
		$laststicker,$reference,$certReg,$receiptReg,$ltfrbFranchise,$insurance,$deed,$inspection)
	{
		
		$error = 0;
		$target = "../../files/"; 
		$_SESSION['message'] = "";
		$rm = new RegistrationManager();
		
		$error = $this->scriptError($plateno, "scriptplateno", $error);
		$error = $this->scriptError($color, "scriptcolor", $error);
		
		if($_SESSION['profileType'] == "ADMIN" || $_SESSION['profileType'] == "OVCCA"){
			$error = $this->scriptError($uname, "usernameisnull", $error);
		}
		$error = $this->inputIsNull($plateno, "platenoisnull", $error);
		$error = $this->inputIsNull($year, "yearisnull", $error);
		$error = $this->inputIsNull($motor, "motorisnull", $error);
		$error = $this->inputIsNull($chassis, "chassisisnull", $error);
		$error = $this->inputIsNull($color, "colorisnull", $error);
		//$error = $this->inputIsNull($laststickeryear, "laststickeryearisnull", $error);
		//$error = $this->inputIsNull($laststicker, "laststickerisnull", $error);
		$error = $this->inputIsNull($inspection, "inspectionisnull", $error);
		
		//if($vehicletype == "public") $error = $this->inputIsNull($reference, "referenceisnull", $error);
		
		/*if($inspection != ""){
			if($this->checkDateFormat($inspection) == 1){
				$schedCount = $rm->checkInspectionSchedule($inspection);
				if($schedCount >= 50){
					$_SESSION['message'] = "- Inspection Schedule date is full. Please choose another date.";
					$this->setDefaults($uname,$vehicletype,$plateno,$model,$year,$motor,$chassis,$color,$laststickeryear,$laststicker,$reference,$certReg,$receiptReg,$ltfrbFranchise,$insurance,$driverID,$inspection);
					header("Location: ../Add/");
					die();
				}
			}else{
				$_SESSION['message'] = "- Inspection Schedule date format is invalid";
				$this->setDefaults($uname,$vehicletype,$plateno,$model,$year,$motor,$chassis,$color,$laststickeryear,$laststicker,$reference,$certReg,$receiptReg,$ltfrbFranchise,$insurance,$driverID,$inspection);
				header("Location: ../Add/");
				die();
			}	
		}*/
		
		/*if($vehicletype == "public" && $plateno != ""){
			$inspection = $rm->checkReferencePlate($plateno);
			if($inspection == 0){
				$_SESSION['message'] = "- Cannot register vehicle yet for it didn't gone through inspection yet";
				$this->setDefaults($uname,$vehicletype,$plateno,$model,$year,$motor,$chassis,$color,$laststickeryear,$laststicker,$reference,$certReg,$receiptReg,$ltfrbFranchise,$insurance,$driverID);
				header("Location: ../Add/");
				die();
			}elseif($inspection['result'] == "fail"){
				$_SESSION['message'] = "- Cannot register vehicle yet for it didn't pass the inspection";
				$this->setDefaults($uname,$vehicletype,$plateno,$model,$year,$motor,$chassis,$color,$laststickeryear,$laststicker,$reference,$certReg,$receiptReg,$ltfrbFranchise,$insurance,$driverID);
				header("Location: ../Add/");
				die();
			}elseif($inspection['referenceNumber'] != $reference){
				$_SESSION['message'] = "- Reference Number didn't match your Plate Number";
				$this->setDefaults($uname,$vehicletype,$plateno,$model,$year,$motor,$chassis,$color,$laststickeryear,$laststicker,$reference,$certReg,$receiptReg,$ltfrbFranchise,$insurance,$driverID);
				header("Location: ../Add/");
				die();
			}
		}*/
		
		if($_SESSION['profileType'] == "ADMIN" || $_SESSION['profileType'] == "OVCCA"){
			if($rm->checkProfile("userName", $uname) > 0){
				$ownerData = mysql_fetch_array($rm->retrieveProfile($uname));
				$owner = $ownerData[0];
			}else{
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION['message'] .= "- Username doesn't exist.";
				$error = 1;
			}
		}else{
			$owner = $_SESSION['profileID'];
		}
		
		if($plateno != ""){
			if($this->checkPlateNumber($plateno) == 0){
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION['message'] .= "- Plate number format is invalid.";
				$error = 1;
			}
		}
		
		//Certification Registration
		if($certReg['tmp_name'] == ""){
			if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
			$_SESSION['message'] .= "- Please select Vehicle's Certificate of Registration file.";
			$error = 1;
		}
		else{
			$fileType = $this->fileType($certReg);
			$filename = $plateno . "_certificationRegistration." . $fileType;
			if(move_uploaded_file( $certReg['tmp_name'], ($target.$filename) )){
				$certReg = $filename;
			}
			else{
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION['message'] .= "- Error in uploading Vehicle's Certificate of Registration file.";
				$error = 1;
			}
		}
		
		//Receipt Registration
		if($receiptReg['tmp_name'] == ""){
			if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
			$_SESSION['message'] .= "- Please select Current Official Receipt of Registration.";
			$error = 1;
		}
		else{
			$fileType = $this->fileType($receiptReg);
			$filename = $plateno . "_receiptRegistration." . $fileType;
			if(move_uploaded_file( $receiptReg['tmp_name'], ($target.$filename) )){
				$receiptReg = $filename;
			}
			else{
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION['message'] .= "- Error in uploading Current Official Receipt of Registration file.";
				$error = 1;
			}
		}
		//Driver's ID
			//$driverID = "";
			if($deed['tmp_name'] == ""){
				//if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				//$_SESSION['message'] .= "- Please select Driver's ID file";
				//$error = 1;
			}
			else{
				$fileType = $this->fileType($deed);
				$filename = $plateno . "_deed." . $fileType;
				if(move_uploaded_file( $deed['tmp_name'], ($target.$filename) )){
					$deed = $filename;
				}
				else{
					if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
					$_SESSION['message'] .= "- Error in uploading Deed of Sale file.";
					$error = 1;
				}
			}
		if($vehicletype == "public"){
			//LTFRB Franchise
			//$ltfrbFranchise = "";
			if($ltfrbFranchise['tmp_name'] == ""){
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION['message'] .= "- Please select LTFRB Franchise.";
				$error = 1;
			}
			else{
				$fileType = $this->fileType($ltfrbFranchise);
				$filename = $plateno . "_ltfrbFranchise." . $fileType;
				if(move_uploaded_file( $ltfrbFranchise['tmp_name'], ($target.$filename) )){
					$ltfrbFranchise = $filename;
				}
				else{
					if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
					$_SESSION['message'] .= "- Error in uploading LTFRB Franchise file.";
					$error = 1;
				}
			}
			
			//Insurance
			//$insurance = "";
			if($insurance['tmp_name'] == ""){
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION['message'] .= "- Please select Insurance file.";
				$error = 1;
			}
			else{
				$fileType = $this->fileType($insurance);
				$filename = $plateno . "_insurance." . $fileType;
				if(move_uploaded_file( $insurance['tmp_name'], ($target.$filename) )){
					$insurance = $filename;
				}
				else{
					if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
					$_SESSION['message'] .= "- Error in uploading LTFRB Insurance file.";
					$error = 1;
				}
			}
		}
		
		if($error == 1){
			$this->setDefaults($uname,$vehicletype,$plateno,$model,$year,$motor,$chassis,$color,$laststickeryear,$laststicker,$reference,$certReg,$receiptReg,$ltfrbFranchise,$insurance,$deed,$inspection);
			header("Location: ../Add");
		}
		else{
			$asc = new NewVehicleController();
			$asc->newVehicle($owner,$uname,$vehicletype,$plateno,$model,$year,$motor,$chassis,$color,$laststickeryear,$laststicker,$reference,$certReg,$receiptReg,$ltfrbFranchise,$insurance,$deed);
					// email schedule inspection date
		$to = $profile['givenName'] . " " . $profile['lastName'] . " <" . $profile['emailAddress'] . ">";
		//$subject = "UPF Vehicle Inspection Schedule";
		$subject = "UPF - Added Vehicle";
		/*$message = ""
			. "Good Day! \r\n"
			. "\r\n"
			. "This email lets you know that your vehicle with a plate number of ".$plateno." was schedule for inspection on ".$inspection."." . "\r\n"
			. "\r\n"
			. "UPF Admin"
			. "";
			*/
		$message = ""
			. "Good Day! \r\n"
			. "\r\n"
			. "This email lets you know that you registered a vehicle with a plate number of ".$plateno."." . "\r\n"
			. "\r\n"
			. "Please visit the site to see whether your vehicle has been approved for verification of documents, once approved and vehicle/s is/are inspected, please bring original copies of documents needed for verification." . "\r\n"
			. "\r\n"
			. "UPF Admin"
			. "";
		$headers = "From: Admin <noreply@upfdatabase.com>";
		
		if(!mail($to, $subject, $message, $headers)){
			$_SESSION['message'] .= "<br><br>Sending email error. <br><br>";
		}
		
		}//there are no errors
	}
	
	function setDefaults($uname,$vehicletype,$plateno,$model,$year,$motor,$chassis,$color,$laststickeryear,$laststicker,$reference,$certReg,$receiptReg,$ltfrbFranchise,$insurance,$deed,$inspection){
		$_SESSION['error'] = 1;
		$_SESSION['vehicletype'] = $vehicletype;
		$_SESSION['addusername'] = $uname;
		$_SESSION['addplateno'] = $plateno;
		$_SESSION['addmodel'] = $model;
		$_SESSION['addyear'] = $year;
		$_SESSION['addmotor'] = $motor;
		$_SESSION['addchassis'] = $chassis;
		$_SESSION['addcolor'] = $color;
		$_SESSION['addlaststickeryear'] = $laststickeryear;
		$_SESSION['addlaststicker'] = $laststicker;
		//$_SESSION['addreference'] = $reference;
		$_SESSION['addinspection'] = $inspection;
		
		$_SESSION['certReg'] = $certReg;
		$_SESSION['receiptReg'] = $receiptReg;
		$_SESSION['ltfrbFranchise'] = $ltfrbFranchise;
		$_SESSION['insurance'] = $insurance;
		$_SESSION['deed'] = $deed;
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
		if($input == "") {
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
	
	function checkPlateNumber($plateno){
		if(preg_match('/^([A-Za-z]{3})\ ([0-9]{3})$/',$plateno)){ // LLL NNN
			return 1;
		}elseif(preg_match('/^([0-9]{4})$/',$plateno)){ // NNNN
			return 1;
		}elseif(preg_match('/^([0-9]{5})$/',$plateno)){ // NNNNN
			return 1;
		}elseif(preg_match('/^([0-9]{1})$/',$plateno)){ // N
			return 1;
		}elseif(preg_match('/^([0-9]{2})$/',$plateno)){ // NN
			return 1;
		}elseif(preg_match('/^([A-Za-z]{2})\ ([0-9]{4})$/',$plateno)){ // LL NNNN
			return 1;
		}elseif(preg_match('/^([A-Za-z]{3})\ ([0-9]{4})$/',$plateno)){ // LLL NNNN
			return 1;
		}elseif(preg_match('/^([0-9]{4})\ ([A-Za-z]{2})$/',$plateno)){ // NNNN LL
			return 1;
		}else{
			return 0;
		}
	}
	
	function checkDateFormat($date)
	{
		if(preg_match('#^([0-9]?[0-9]?[0-9]{2}[- /.](0?[1-9]|1[012])[- /.](0?[1-9]|[12][0-9]|3[01]))*$#', $date))
			return 1;
		return 0;
	}
	
	function requestNewVehicle()
	{
		/*get submitted information*/
		$uname = isset($_POST['username']) ? $_POST['username'] : $_SESSION['username'];
		$vehicletype = $_POST['vehicletype'];
		$plateno = $_POST['plateno'];
		$model = $_POST['model'];
		$year = $_POST['year'];
		$motor = $_POST['motor'];							
		$chassis = $_POST['chassis'];
		$color = $_POST['color'];
		$laststickeryear = $_POST['laststickeryear'];
		$laststicker = $_POST['laststicker'];
		$reference = isset($_POST['reference']) ? $_POST['reference'] : "none";
		//$inspection = $_POST['inspection'];
		$inspection = "0000-00-00";
		
		$certReg = $_FILES['certReg'];
		$receiptReg = $_FILES['receiptReg'];
		$ltfrbFranchise = ($_FILES['ltfrbFranchise']['tmp_name'] == "") ? "" : $_FILES['ltfrbFranchise'];
		$insurance = ($_FILES['insurance']['tmp_name'] == "") ? "" : $_FILES['insurance'];
		$deed = ($_FILES['deed']['tmp_name'] == "") ? "" : $_FILES['deed'];
		
		$this->validateInfo($uname,$vehicletype,$plateno,$model,$year,$motor,$chassis,$color,$laststickeryear,
			$laststicker,$reference,$certReg,$receiptReg,$ltfrbFranchise,$insurance,$deed,$inspection);
	}
	
	function showMessage($flag) {
		if($flag==1) header("Location: ../../Vehicle/Add/?addsuccess=1");
		else header("Location: ../../Vehicle/Add/?addnotsuccess=1");
	}
}

$newvehicleview = new NewVehicleView();
$newvehicleview->requestNewVehicle();

?>