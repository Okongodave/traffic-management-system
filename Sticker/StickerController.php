<!--
  - File Name: Inspection/StickerController.php
  - Program Description:
  -->
<?php
	session_start();
	include "../RegistrationManager.php";
	class StickerController
	{
		function requestStickerNumber()
		{
			$rm = new RegistrationManager();
			$_SESSION["message"] = "";
			$error = 0;
			
			$plateno = trim(strtoupper($_POST['plateno']));
			$stickerno = trim(strtoupper($_POST['stickerno']));
			$stickerdate = trim($_POST['stickerdate']);
			
			// check sticker number
			if($rm->checkVehicle("stickerNumber", $stickerno) > 0){
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION["message"] .= "Sticker Number already exists.";
				$this->setDefaults($plateno, $stickerno, $stickerdate);
				$error = 1;
			}
			
			if($plateno == ""){ // plate number empty
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION["message"] .= "Plate Number is empty.";
				$this->setDefaults($plateno, $stickerno, $stickerdate);
				$error = 1;
			}elseif($this->checkPlateNumber($plateno) == 0){ // check plate number format
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION["message"] .= "Plate Number format is invalid.";
				$this->setDefaults($plateno, $stickerno, $stickerdate);
				$error = 1;
			}elseif($rm->checkVehicle("plateNumber", $plateno) == 0){ // check if plate number is already registered
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION["message"] .= "Plate Number isn't on the registered vehicle list.";
				$this->setDefaults($plateno, $stickerno, $stickerdate);
				$error = 1;
			}
			
			$temp = $rm->checkVehicleStatus($plateno);
			if($stickerno == ""){ // sticker number empty
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION["message"] .= "Sticker Number is empty.";
				$this->setDefaults($plateno, $stickerno, $stickerdate);
				$error = 1;
			}elseif($temp['status'] == "released"){ // vehicle already have sticker
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION["message"] .= "Vehicle already has a sticker.";
				$this->setDefaults($plateno, $stickerno, $stickerdate);
				$error = 1;
			}elseif(!is_numeric($stickerno)){ // check if sticker number is compose of numbers (only)
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION["message"] .= "Sticker Number must be composed of numbers.";
				$this->setDefaults($plateno, $stickerno, $stickerdate);
				$error = 1;
			}elseif(strlen($stickerno) != 4){ // check if sticker number is compose of four characters
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION["message"] .= "Sticker Number must be four numbers.";
				$this->setDefaults($plateno, $stickerno, $stickerdate);
				$error = 1;
			}
			
			// check date format
			if($stickerdate == ""){
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION["message"] .= "Sticker Issued Date is empty.";
				$this->setDefaults($plateno, $stickerno, $stickerdate);
				$error = 1;
			}
			elseif($this->checkDateFormat($stickerdate) == 0){
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION["message"] .= "Sticker Issued Date format is invalid.";
				$this->setDefaults($plateno, $stickerno, $stickerdate);
				$error = 1;
			}
			if($this->checkMoreThanCurrentDate($stickerdate)){
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION['message'] .= "Sticker Release Date is later than the current date";
				$error = 1;
			}
			
			// check if vehicle is already paid
			$vehicle = $rm->checkVehicleStatus($plateno);
			if($vehicle['paid'] == "0000-00-00"){
				if($_SESSION['message'] != "") $_SESSION['message'] .= "<br>";
				$_SESSION["message"] .= "Sticker is not yet paid or the vehicle is not yet approved.";
				$this->setDefaults($plateno, $stickerno, $stickerdate);
				$error = 1;
			}
			
			if($error == 1){
				$this->setDefaults($plateno, $stickerno, $stickerdate);
			}else{
				$this->setDefaults($plateno, $stickerno, $stickerdate);
				$rm->addStickerNumber($plateno, $stickerno, $stickerdate);
				$rm->newLog("Vehicle Sticker Release: ".$plateno);
				$_SESSION['message'] = "Vehicle Sticker Number added!";
			}
			header("Location: ./");
		}
		
		function setDefaults($plateno, $stickerno, $stickerdate){
			$_SESSION['plateno'] = $plateno;
			$_SESSION['stickerno'] = $stickerno;
			$_SESSION['stickerdate'] = $stickerdate;
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
		
		function checkMoreThanCurrentDate($date)
		{
			$date = strtotime($date);
			$current = strtotime(date("Y-m-d"));
			
			if($date > $current)
				return 1;
			return 0;
		}
	}
	$sc = new StickerController();
	$sc->requestStickerNumber();
?>