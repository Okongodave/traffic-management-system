<!--
  - File Name: EditDriverController.php
  - Program Description: data transformations
  -->
<?php
include "../../RegistrationManager.php";

class EditDriverController
{
	//constructor
	function EditDriverController(){}
	
	function editDriver($surname, $givenName, $middleName, $age, $civilStatus, $homeAddress, $homeBarangay, $homeTown, $homeProvince, $licenseNumber, $validUntil, $spouseName, $spouseOccupation, $picture)
	{
		$_SESSION['editsurname'] = $surname;
		$_SESSION['editgivenname'] = $givenName;
		$_SESSION['editmiddlename'] = $middleName;
		$_SESSION['editage'] = $age;
		$_SESSION['editcivilstatus'] = $civilStatus;
		$_SESSION['edithomeaddress'] = $homeAddress;
		$_SESSION['editbarangay'] = $homeBarangay;
		$_SESSION['edithometown'] = $homeTown;
		$_SESSION['editprovince'] = $homeProvince;
		$_SESSION['editlicenseno'] = $licenseNumber;
		$_SESSION['editvaliduntil'] = $validUntil;
		$_SESSION['editspousename'] = $spouseName;
		$_SESSION['editspouseoccup'] = $spouseOccupation;
		
		$surname = trim($surname);
		$givenName = trim($givenName);
		$middleName = trim($middleName);
		$age = trim($age);
		$civilStatus = trim(strtoupper($civilStatus));
		$homeAddress = trim($homeAddress);
		$homeBarangay = trim($homeBarangay);
		$homeTown = trim($homeTown);
		$homeProvince = trim($homeProvince);
		$licenseNumber = trim(strtoupper($licenseNumber));
		$validUntil = trim($validUntil);
		$spouseName = trim($spouseName);
		$spouseOccupation = trim($spouseOccupation);
		
		$driver = new EditDriverView();
		$rm = new RegistrationManager();
		
		$rm->newLog("Updated Driver: ".$givenName." ".$middleName." ".$surname);
		$editsuccess = $rm->updateDriver($surname, $givenName, $middleName, $age, $civilStatus, $homeAddress, $homeBarangay, $homeTown, $homeProvince, $licenseNumber, $validUntil, $spouseName, $spouseOccupation, $picture);
		
		if($editsuccess == 1){
			unset($_SESSION['editsurname']);
			unset($_SESSION['editsurname']);
			unset($_SESSION['editgivenname']);
			unset($_SESSION['editmiddlename']);
			unset($_SESSION['editage']);
			unset($_SESSION['editcivilstatus']);
			unset($_SESSION['edithomeaddress']);
			unset($_SESSION['editbarangay']);
			unset($_SESSION['edithometown']);
			unset($_SESSION['editprovince']);
			unset($_SESSION['editlicenseno']);
			unset($_SESSION['editvaliduntil']);
			unset($_SESSION['editspousename']);
			unset($_SESSION['editspouseoccup']);
			unset($_SESSION['editpicture']);
			
			$driver->showMessage($licenseNumber, 1);
		}
		else $driver->showMessage($licenseNumber, 0);
	}
}
?>
	