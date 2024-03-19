<!--
  - File Name: BlockVehicle.php
  - Program Description: 
  -->
<?php
session_start();
include "../RegistrationManager.php";

class BlockVehicle
{
	function requestBlockVehicle()
	{
		//die();
		$plateno = isset($_GET['pn']) ? $_GET['pn'] : header("Location: ../Vehicle");
		$block = isset($_GET['b']) ? $_GET['b'] : header("Location: ../Vehicle");

		$rm = new RegistrationManager(); //instance of RegistrationManager
		
		if($block == 1) $rm->newLog("Block Vehicle: ".$plateno);
		else $rm->newLog("Unblock Vehicle: ".$plateno);
		
		$success = $rm->blockVehicle($plateno, $block);
		$rm->resetVehicleViolation($plateno);
		
		if($success == 1)
			$_SESSION['message'] = "Vehicle ".($block == 1 ? "blocked." : "unblocked.");
		else
			$_SESSION['message'] = "Error in ".($block == 1 ? "blocking" : "unblocking")." vehicle";
		
		header("Location: ../");
	}
	
	/*function showMessage($flag) {
		if($flag == 1) 
			$_SESSION['message'] = "vehicle blocked";
		else
			$_SESSION['message'] = "vehicle unblocked";
		
		header("Location: ../");
	}*/
}
$blockvehicle = new BlockVehicle();
$blockvehicle->requestBlockVehicle();
?>