<!--
  - File Name: DeleteDriver.php
  - Program Description: Delete 
  -->
<?php
session_start();
include "../RegistrationManager.php";

class DeleteDriver
{
	function requestDeleteDriver()
	{
		$driverPID = isset($_GET['id']) ? $_GET['id'] : $this->showMessage(0); // driver profile id

		$rm = new RegistrationManager(); //instance of RegistrationManager
		
		$driver = mysql_fetch_array($rm->retrieveDriver($driverPID));
		
		if($_SESSION['profileType'] == "APPLICANT"){
			$rm->newLog("Request to Remove Driver: ".$driver['givenName']." ".$driver['middleName']." ".$driver['lastName']);
			
			$success = $rm->requestRemoveDriver($driverPID, $_SESSION['profileID']);
			$_SESSION['message'] = "Driver Remove Request Saved";
		}else{
			$rm->newLog("Remove Driver: ".$driver['givenName']." ".$driver['middleName']." ".$driver['lastName']);
			
			$success = $rm->detachDriver($driverPID);
			$_SESSION['message'] = "Driver Removed";
		}
		
		$this->showMessage($success);
	}
	
	function showMessage($flag) {
		if($flag==1) header("Location: ../?removesuccess=1");
		else header("Location: ../?removenotsuccess=1");
	}
}
$deletevehicle = new DeleteDriver();
$deletevehicle->requestDeleteDriver();
?>