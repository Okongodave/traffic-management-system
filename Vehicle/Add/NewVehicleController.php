<!--
  - File Name: NewVehicleController.php
  - Program Description: data transformations
  -->
<?php
include "../../RegistrationManager.php";

class NewVehicleController
{
	//constructor
	function NewVehicleController(){
	}
	
	function newVehicle($owner,$uname,$vehicletype,$plateno,$model,$year,$motor,$chassis,$color,$laststickeryear,$laststicker,$reference,$certReg,$receiptReg,$ltfrbFranchise,$insurance,$deed)
	{
		$_SESSION['addusername'] = $uname;
		$_SESSION['vehicletype'] = $vehicletype;
		$_SESSION['addplateno'] = $plateno;
		$_SESSION['addmodel'] = $model;
		$_SESSION['addyear'] = $year;
		$_SESSION['addmotor'] = $motor;
		$_SESSION['addchassis'] = $chassis;
		$_SESSION['addcolor'] = $color;
		$_SESSION['addlaststickeryear'] = $laststickeryear;
		$_SESSION['addlaststicker'] = $laststicker;
		$_SESSION['addreference'] = $reference;

		$plateno = trim(strtoupper($plateno));
		$vehicletype = strtoupper($vehicletype);
		$model = trim(strtoupper($model));
		$motor = trim(strtoupper($motor));
		$chassis = trim(strtoupper($chassis));
		$color = trim(strtoupper($color));
		$reference = trim(strtoupper($reference));
		
		$vehicle = new NewVehicleView();
		$rm = new RegistrationManager();
		$addsuccess = $rm->newVehicle($owner,$uname,$vehicletype,$plateno,$model,$year,$motor,$chassis,$color,$laststickeryear,$laststicker,$reference,$certReg,$receiptReg,$ltfrbFranchise,$insurance,$deed);
		$rm->newLog("Added Vehicle: ".$plateno);
		//$rm->removeReferenceNumber($plateno);
		
		if($addsuccess==1){  //successful add registration
				unset($_SESSION['addplateno']);
				unset($_SESSION['vehicletype']);
				unset($_SESSION['addmodel']);
				unset($_SESSION['addyear']);
				unset($_SESSION['addmotor']);
				unset($_SESSION['addchassis']);
				unset($_SESSION['addcolor']);
				unset($_SESSION['addlaststickeryear']);
				unset($_SESSION['addlaststicker']);
				unset($_SESSION['addreference']);
						
			$vehicle->showMessage(1);
		}
		else $vehicle->showMessage(0); //unsuccessful add registration
	}
}
?>