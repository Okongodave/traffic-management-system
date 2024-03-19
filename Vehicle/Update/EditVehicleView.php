<!--
  - File Name: /Vehicle/Update/EditVehicleView.php
  - Program Description: Edit Vehicle Form Validation
  -->
<?php
session_start();
include "EditVehicleController.php";
class EditVehicleView
{
	function validateInfo($uname, $vehicletype, $plateno, $model, $year, $motor, $chassis, $color, $stickerdate, $stickerno, $certReg, $receiptReg, $ltfrbFranchise, $insurance, $deed, $certRegVal, $receiptRegVal, $ltfrbFranchiseVal, $insuranceVal, $deedVal){
	
		$error = 0;
		$error = 0;
		$target = "../../files/"; 
		$_SESSION['message'] = "";
		
		$error = $this->scriptError($color, "scriptcolor", $error);
		
		$error = $this->inputIsNull($plateno, "platenoisnull", $error);
		$error = $this->inputIsNull($motor, "motorisnull", $error);
		$error = $this->inputIsNull($chassis, "chassisisnull", $error);
		$error = $this->inputIsNull($color, "colorisnull", $error);
		//$error = $this->inputIsNull($stickerdate, "laststickeryearisnull", $error);
		//$error = $this->inputIsNull($stickerno, "laststickerisnull", $error);
		
		if($plateno != ""){
			if($this->checkPlateNumber($plateno) == 0){
				$_SESSION['message'] = "- Plate number format is invalid.";
				$error = 1;
			}
		}
		
		//Certification Registration
		if(is_array($certReg)){
			if($certReg['tmp_name'] == ""){
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION['message'] .= "- Please select Vehicle's Certificate of Registration file";
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
					$_SESSION['message'] .= "- Error in uploading Vehicle's Certificate of Registration file";
					$error = 1;
				}
			}
		}
		
		//Receipt Registration
		if(is_array($receiptReg)){
			if($receiptReg['tmp_name'] == ""){
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION['message'] .= "- Please select Current Official Receipt of Registration";
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
					$_SESSION['message'] .= "- Error in uploading Current Official Receipt of Registration file";
					$error = 1;
				}
			}
		}
		
		if($vehicletype == "PUBLIC"){
			//LTFRB Franchise
			if(is_array($ltfrbFranchise)){
				if($ltfrbFranchise['tmp_name'] == ""){
					if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
					$_SESSION['message'] .= "- Please select LTFRB Franchise";
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
						$_SESSION['message'] .= "- Error in uploading LTFRB Franchise file";
						$error = 1;
					}
				}
			}
			
			//Insurance
			if(is_array($insurance)){
				if($insurance['tmp_name'] == ""){
					if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
					$_SESSION['message'] .= "- Please select Insurance file";
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
						$_SESSION['message'] .= "- Error in uploading LTFRB Insurance file";
						$error = 1;
					}
				}
			}
			
			//Driver's ID
			if(is_array($deed)){
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
						$_SESSION['message'] .= "- Error in uploading Deed of Sale file";
						$error = 1;
					}
				}
			}
		}
		
		if($error == 1){
			$_SESSION['editerror'] = 1;
			$_SESSION['editplateno'] = $plateno;
			$_SESSION['editmodel'] = $model;
			$_SESSION['edityear'] = $year;
			$_SESSION['editmotor'] = $motor;
			$_SESSION['editchassis'] = $chassis;
			$_SESSION['editcolor'] = $color;
			$_SESSION['editstickerno'] = $stickerno;
			$_SESSION['editstickerdate'] = $stickerdate;
			
				header("Location: ../../Vehicle/Update/?pn=".$plateno);//there are errors present
		}
		else{
			$asc = new EditVehicleController();
			$asc->editVehicle($uname,$plateno,$model,$year,$motor,$chassis,$color,$stickerdate,$stickerno,$certReg,$receiptReg,$ltfrbFranchise,$insurance,$deed);
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
	
	function fileType($file)
	{
		if($certReg['type'] != "image/jpeg")
			return "jpg";
		elseif($certReg['type'] != "image/png")
			return "png";
		elseif($certReg['type'] != "image/gif")
			return "gif";
	}
	
	function checkPlateNumber($plateno){
		if(preg_match('/^([A-Za-z]{3})\ ([0-9]{3})$/',$plateno)){ // LLL-NNN
			return 1;
		}elseif(preg_match('/^([0-9]{4})$/',$plateno)){ // NNNN
			return 1;
		}elseif(preg_match('/^([0-9]{5})$/',$plateno)){ // NNNNN
			return 1;
		}elseif(preg_match('/^([0-9]{1})$/',$plateno)){ // N
			return 1;
		}elseif(preg_match('/^([0-9]{2})$/',$plateno)){ // NN
			return 1;
		}elseif(preg_match('/^([A-Za-z]{2})\ ([0-9]{4})$/',$plateno)){ // LL-NNNN
			return 1;
		}elseif(preg_match('/^([A-Za-z]{3})\ ([0-9]{4})$/',$plateno)){ // LLL-NNNN
			return 1;
		}elseif(preg_match('/^([0-9]{4})\ ([A-Za-z]{2})$/',$plateno)){ // NNNN-LL
			return 1;
		}else{
			return 0;
		}
	}
	
	function requestEditVehicle(){
		/*get submitted information*/
		
		$uname = $_SESSION['username'];
		$vehicletype = $_POST['vehicletype'];
		$plateno = $_POST['plateno'];
		$model = $_POST['model'];
		$year = $_POST['year'];
		$motor = $_POST['motor'];
		$chassis = $_POST['chassis'];
		$color = $_POST['color'];
		$stickerdate = $_POST['laststickeryear'];
		$stickerno = $_POST['laststicker'];
		
		//Certification Registration
		$certRegVal = "";
		if(isset($_POST['certRegCheck'])){
			$certReg = $_FILES['certReg'];
			$certRegVal = $_POST['certRegVal'];
		}else{
			$certRegVal = $certReg = $_POST['certRegVal'];
		}
		
		//Receipt Registration
		$receiptRegVal = "";
		if(isset($_POST['receiptRegCheck'])){
			$receiptReg = $_FILES['receiptReg'];
			$certRegVal = $_POST['certRegVal'];
		}else{
			$certRegVal = $receiptReg = $_POST['certRegVal'];
		}
		
		//LTFRB Franchise
		$ltfrbFranchiseVal = "";
		if(isset($_POST['ltfrbFranchiseCheck'])){
			$ltfrbFranchise = $_FILES['ltfrbFranchise'];
			$ltfrbFranchiseVal = $_POST['ltfrbFranchiseVal'];
		}else{
			$ltfrbFranchiseVal = $ltfrbFranchise = $_POST['ltfrbFranchiseVal'];
		}
		
		//Insurance
		$ltfrbFranchiseVal = "";
		if(isset($_POST['insuranceCheck'])){
			$insurance = $_FILES['insurance'];
			$insuranceVal = $_POST['insuranceVal'];
		}else{
			$insuranceVal = $insurance = $_POST['insuranceVal'];
		}
		
		//Deed's
		$deedVal = "";
		if(isset($_POST['deedCheck'])){
			$deed = $_FILES['deed'];
			$deedVal = $_POST['deedVal'];
		}else{
			$deedVal = $deed = $_POST['deedVal'];
		}
		$this->validateInfo($uname, $vehicletype, $plateno, $model, $year, $motor, $chassis, $color, $stickerdate, $stickerno, $certReg, $receiptReg, $ltfrbFranchise, $insurance, $deed, $certRegVal, $receiptRegVal, $ltfrbFranchiseVal, $insuranceVal, $deedVal);
	}
	
	function showMessage($plateno, $flag) {
		if($flag==1) header("Location: ../../Vehicle/Update/?pn=".$plateno."&editsuccess=1");
		else header("Location: ../../Vehicle/Update/?pn=".$plateno."&editnotsuccess=1");
	}
}

$editvehicleview = new EditVehicleView(); //instance of EditVehicleView
$editvehicleview->requestEditVehicle();
?>