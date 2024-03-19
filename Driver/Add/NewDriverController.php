<!--
  - File Name: NewDriverController.php
  - Program Description: New Driver Form Validation
  -->
<?php
include "../../RegistrationManager.php";

class NewDriverController
{
	//constructor
	function NewDriverController(){}
	
	function newDriver($operatorID, $username, $surname, $givenName, $middleName, $age, $civilStatus, $homeAddress, $homeBarangay, $homeTown, $homeProvince, $licenseNumber, $validUntil, $spouseName, $spouseOccupation, $picture, $licensepic)
	{
		$_SESSION['addusername'] = $username;
		$_SESSION['addsurname'] = $surname;
		$_SESSION['addgivenname'] = $givenName;
		$_SESSION['addmiddlename'] = $middleName;
		$_SESSION['addage'] = $age;
		$_SESSION['addcivilstatus'] = $civilStatus;
		$_SESSION['addhomeaddress'] = $homeAddress;
		$_SESSION['addbarangay'] = $homeBarangay;
		$_SESSION['addhometown'] = $homeTown;
		$_SESSION['addprovince'] = $homeProvince;
		$_SESSION['addlicenseno'] = $licenseNumber;
		$_SESSION['addvaliduntil'] = $validUntil;
		$_SESSION['addspousename'] = $spouseName;
		$_SESSION['addspouseoccup'] = $spouseOccupation;
		
		$username = trim($username);
		$surname = trim(ucwords(strtolower($surname)));
		$givenName = trim(ucwords(strtolower($givenName)));
		$middleName = trim(ucwords(strtolower($middleName)));
		$age = trim($age);
		$civilStatus = trim(ucwords(strtolower($civilStatus)));
		$homeAddress = trim(ucwords(strtolower($homeAddress)));
		$homeBarangay = trim(strtolower($homeBarangay));
		$homeTown = trim(ucwords(strtolower($homeTown)));
		$homeProvince = trim(ucwords(strtolower($homeProvince)));
		$licenseNumber = trim(strtoupper($licenseNumber));
		$validUntil = trim($validUntil);
		$spouseName = trim(ucwords(strtolower($spouseName)));
		$spouseOccupation = trim(ucwords(strtolower($spouseOccupation)));
		
		$driver = new NewDriverView();
		$rm = new RegistrationManager();
		
		$rm->newLog("Added Driver: ".$givenName." ".$middleName." ".$surname);
		$addsuccess = $rm->newDriver($operatorID, $username, $surname, $givenName, $middleName, $age, $civilStatus, $homeAddress, $homeBarangay, $homeTown, $homeProvince, $licenseNumber, $validUntil, $spouseName, $spouseOccupation, $picture, $licensepic);
		
		if($addsuccess == 1){
			if(isset($_SESSION['addusername'])) unset($_SESSION['addusername']);
			unset($_SESSION['addsurname']);
			unset($_SESSION['addgivenname']);
			unset($_SESSION['addmiddlename']);
			unset($_SESSION['addage']);
			unset($_SESSION['addcivilstatus']);
			unset($_SESSION['addhomeaddress']);
			unset($_SESSION['addbarangay']);
			unset($_SESSION['addhometown']);
			unset($_SESSION['addprovince']);
			unset($_SESSION['addlicenseno']);
			unset($_SESSION['addvaliduntil']);
			unset($_SESSION['addspousename']);
			unset($_SESSION['addspouseoccup']);
			
			$driver->showMessage(1);
		}
		else $driver->showMessage(0);
	}
}