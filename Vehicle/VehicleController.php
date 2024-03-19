<!--
  - File Name: VehicleController.php
  - Program Description: 
  -->
<?php
	session_start();
	include "../RegistrationManager.php";

	class VehicleController
	{
		function requestDeleteVehicle()
		{
			$plateno = isset($_GET['pn']) ? $_GET['pn'] : $this->showMessage(0);

			$rm = new RegistrationManager(); //instance of RegistrationManager
			$success = $rm->removeVehicle($plateno);
			
			$this->showMessage($success);
			if($flag==1) header("Location: ../?removesuccess=1");
			else header("Location: ../?removenotsuccess=1");
		}
		
		function requestBlockVehicle()
		{
			$plateno = isset($_GET['pn']) ? $_GET['pn'] : header("Location: ../");
			$block = isset($_GET['b']) ? $_GET['b'] : header("Location: ../");

			$rm = new RegistrationManager(); //instance of RegistrationManager
			$success = $rm->blockVehicle($plateno, $block);
			
			if($success == 1) $_SESSION['message'] = "Vehicle " . ($block == 1 ? "blocked" : "unblocked");
			else $_SESSION['message'] = "Error in blocking/unblocking vehicle.";
			
			header("Location: ../");
		}
		
		function requestApproveVehicle()
		{
			$rm = new RegistrationManager(); //instance of RegistrationManager
			
			$status = isset($_GET['s']) ? $_GET['s'] : header("Location: ../");
			$message = $_POST['disapprovedNote'];
			$plateno = isset($_GET['pn']) ? $_GET['pn'] : header("Location: ../");
			
			// change log
			if($status == 1) $rm->newLog("Approved Vehicle: ".$plateno);
			else $rm->newLog("Disapproved Vehicle: ".$plateno);
			
			if($status == 1) $status = "approved";
			else $status = "disapproved";
			
			$success = $rm->vehicleStatus($status, $message, $plateno);
			
			$rm->removeReferenceNumber($plateno); // remove data on table_reference
			
			if($success == 1) 
				$_SESSION['message'] = "vehicle " . $status;
			else
				$_SESSION['message'] = "Error in changing vehicle status.";
			
			header("Location: ../");
		}
		
		function requestVehicleApplication()
		{
			$plateno = isset($_GET['pn']) ? $_GET['pn'] : header("Location: ../");
			
			$rm = new RegistrationManager(); //instance of RegistrationManager
			$success = $rm->vehicleStatus("pending", "", $plateno);
			
			if($success == 1) 
				$_SESSION['message'] = "Applicantion resent.";
			else
				$_SESSION['message'] = "Error in resending vehicle application.";
			
			header("Location: ../");
		}
	}
	$vc = new VehicleController();
	
	$task = isset($_GET['task']) ? $_GET['task'] : "";
	if($task == "delete")
		$vc->requestDeleteVehicle();
	elseif($task == "block")
		$vc->requestBlockVehicle();
	elseif($task == "status")
		$vc->requestApproveVehicle();
	elseif($task == "refresh")
		$vc->requestVehicleApplication();
	else
		header("Location: ../");
?>