<!--
  - File Name: ApproveViolation.php
  - Program Description: Approve Violation
  -->
<?php
session_start();
include "../RegistrationManager.php";

class ApproveViolation
{
	function requestApproveViolation()
	{
		$violationno = isset($_GET['vn']) ? $_GET['vn'] : $this->showMessage(0);
		$licenseno = isset($_GET['ln']) ? $_GET['pn'] : "";
		$plateno = isset($_GET['pn']) ? $_GET['pn'] : "";
		$driverID = isset($_GET['id']) ? $_GET['id'] : "0000";

		$rm = new RegistrationManager(); //instance of RegistrationManager
		$success = $rm->approveViolation($violationno);
		
		// increase violation number
		if($licenseno != "") // no driver id, yes license number
			$rm->increaseUserViolationViaLicense($licenseno);
		else // no license number, yes driver id
			if($plateno != "0000") $rm->increaseUserViolation($id);
			
		if($plateno != "") $rm->increaseVehicleViolation($plateno);
		
		$this->showMessage($success);
	}
	
	function showMessage($flag) {
		if($flag==1) header("Location: ../../Violation/?removesuccess=1");
		else header("Location: ../../Violation/?removenotsuccess=1");
	}
}
$av = new ApproveViolation();
$av->requestApproveViolation();
?>