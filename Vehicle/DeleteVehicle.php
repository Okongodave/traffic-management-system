<!--
  - File Name: DeleteVehicle.php
  - Program Description: Delete Vehicle
  -->
<?php
session_start();
include "../RegistrationManager.php";

class DeleteVehicle
{
	function requestDeleteVehicle()
	{
		$plateno = isset($_GET['pn']) ? $_GET['pn'] : $this->showMessage(0);

		$rm = new RegistrationManager(); //instance of RegistrationManager
		$rm->newLog("Removed Vehicle: ".$plateno);
		$success = $rm->removeVehicle($plateno);
		
		// remove all violations related to this vehicle
		$rm->removeViolationByVehicle($plateno);
		
		$this->showMessage($success);
	}
	
	function showMessage($flag) {
		if($flag==1){
			$_SESSION['message'] = $plateno." Vehicle deleted";
			header("Location: ../?removesuccess=1");
		}else{
			$_SESSION['message'] = "Error in adding new vehicle.";
			header("Location: ../?removenotsuccess=1");
		}
	}
}
$deletevehicle = new DeleteVehicle();
$deletevehicle->requestDeleteVehicle();
?>