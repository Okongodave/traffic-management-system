<!--
  - File Name: BlockDriver.php
  - Program Description: 
  -->
<?php
session_start();
include "../RegistrationManager.php";

class BlockDriver
{
	function requestBlockDriver()
	{
		$profileID = isset($_GET['id']) ? $_GET['id'] : header("Location: ../");
		$block = isset($_GET['b']) ? $_GET['b'] : header("Location: ../");
		
		$rm = new RegistrationManager(); //instance of RegistrationManager
		$success = $rm->blockApplicant($profileID, $block);
		
		if($success == 1)
			$_SESSION['message'] = "Driver ".($block == 1 ? "blocked" : "unblocked");
		else
			$_SESSION['message'] = "There is an error in ".($block == 1 ? "blocking" : "unblocking")." the driver";
		
		header("Location: ../");
	}
	
	/*function showMessage($flag) {
		if($flag == 1) 
			$_SESSION['message'] = "applicant blocked";
		else
			$_SESSION['message'] = "applicant unblocked";
		
		header("Location: ../");
	}*/
}
$bd = new BlockDriver();
$bd->requestBlockDriver();
?>