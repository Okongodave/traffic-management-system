<!--
  - File Name: /HomePage/DeleteProfile.php
  - Program Description: Delete Vehicle
  -->
<?php
session_start();
include "../RegistrationManager.php";

class DeleteProfile
{
	function requestDeleteProfile()
	{
		$rm = new RegistrationManager(); //instance of RegistrationManager
		$psuccess = $rm->removeProfile($_SESSION['username']);
		$vsuccess = $rm->removeVehicleByUser($_SESSION['profileID']);
		
		header("Location: ../logout.php");
	}
	
	function showMessage($flag) {
		if($flag==1) header("Location: ../?removesuccess=1");
		else header("Location: ../?removenotsuccess=1");
	}
}
$deletevehicle = new DeleteProfile();
$deletevehicle->requestDeleteProfile();
?>