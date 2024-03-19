<!--
  - File Name: NewVehicleController.php
  - Program Description: data transformations
  -->
<?php
include "../../RegistrationManager.php";

class EditVehicleController
{
	//constructor
	function EditVehicleController(){}
	
	function editVehicle($uname,$plateno,$model,$year,$motor,$chassis,$color,$stickerdate,$stickerno,$certReg,$receiptReg,$ltfrbFranchise,$insurance,$deed)
	{
		$_SESSION['editplateno'] = $plateno;
		$_SESSION['editmodel'] = $model;
		$_SESSION['edityear'] = $year;
		$_SESSION['editmotor'] = $motor;
		$_SESSION['editchassis'] = $chassis;
		$_SESSION['editcolor'] = $color;
		$_SESSION['editstickerdate'] = $stickerdate;
		$_SESSION['editstickerno'] = $stickerno;
		
		/*transform each information to uppercase letters,
		remove white spaces before and after,*/
		
		$plateno = trim(strtoupper($plateno));
		$model = trim(strtoupper($model));
		$motor = trim(strtoupper($motor));
		$chassis = trim(strtoupper($chassis));
		$color = trim(strtoupper($color));
		
		$vehicle = new EditVehicleView(); //instance of EditVehicleView
		$rm = new RegistrationManager(); //instance of RegistrationManager
		$editsuccess = $rm->updateVehicle($uname,$plateno,$model,$year,$motor,$chassis,$color,$stickerdate,$stickerno,$certReg,$receiptReg,$ltfrbFranchise,$insurance,$deed);
		$rm->newLog("Updated Vehicle: ".$plateno);
		
		if($editsuccess==1){  //successful edit vehicle
			unset($_SESSION['editplateno']);
			unset($_SESSION['editmodel']);
			unset($_SESSION['edityear']);
			unset($_SESSION['editmotor']);
			unset($_SESSION['editchassis']);
			unset($_SESSION['editcolor']);
			unset($_SESSION['editlaststickeryear']);
			unset($_SESSION['editlaststicker']);
			
			$_SESSION['message'] = "";
			$vehicle->showMessage($plateno, 1);
		}
		else{
			$_SESSION['message'] = "";
			$vehicle->showMessage($plateno, 0); //unsuccessful edit vehicle
		}
	}
}
?>