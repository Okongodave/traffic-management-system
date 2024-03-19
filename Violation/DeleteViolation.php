<!--
  - File Name: DeleteViolation.php
  - Program Description: Delete Violation
  -->
<?php
session_start();
include "../RegistrationManager.php";

class DeleteViolation
{
	function requestDeleteViolation()
	{
		$rm = new RegistrationManager();
		
		$violationno = isset($_GET['vn']) ? $_GET['vn'] : $this->showMessage(0);
		$plateno = isset($_GET['pn']) ? $_GET['pn'] : "";
		$driverID = isset($_GET['id']) ? $_GET['id'] : "0000";
		
		$driverData = $rm->checkDriverId($driverID);
		$id = $driverData['profileID'];
		
		$success = $rm->removeViolation($violationno);
		
		if($plateno != "") $rm->decreaseVehicleViolation($plateno);
		if($id != "0000") $rm->decreaseUserViolation($id);
		
		$this->showMessage($success);
	}
	
	function showMessage($flag) {
		if($flag==1) header("Location: ../../Violation/?removesuccess=1");
		else header("Location: ../../Violation/?removenotsuccess=1");
	}
}
$deletevehicle = new DeleteViolation();
$deletevehicle->requestDeleteViolation();
?>