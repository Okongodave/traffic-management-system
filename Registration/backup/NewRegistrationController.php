<!--
  - File Name: NewRegistrationController.php
  - Program Description: data transformations
  -->
<?php
include "../RegistrationManager.php";

class NewRegistrationController
{
	//constructor
	function NewRegistrationController(){
	}
	
	function newRegistration($profiletype,$uname,$pword,$lname,$fname,$mname,$contactno,$gender,$civil,$homeadd,$homebrgy,$hometown,$homeprov,
		$offbrgy,$offtown,$offprov,$officeadd,$birthplace,$birthday,$occupation,$email,$cit,$license,$where,$when,$expiry,$picture,$licensepic)
	{
			$_SESSION['addprofiletype'] = $profiletype;
			$_SESSION['adduname'] = $uname;
			$_SESSION['addpword'] = $pword;
			$_SESSION['addlname'] = $lname;
			$_SESSION['addfname'] = $fname;
			$_SESSION['addmname'] = $mname;
			$_SESSION['addcontactnumber'] = $contactno;
			
			$_SESSION['addgender'] = $gender;
			$_SESSION['addcivil'] = $civil;
			$_SESSION['addhomeadd'] = $homeadd;
			$_SESSION['addhomebrgy'] = $homebrgy;
			$_SESSION['addhometown'] = $hometown;
			$_SESSION['addhomeprov'] = $homeprov;
			$_SESSION['addofficeadd'] = $officeadd;
			$_SESSION['addoffbrgy'] = $offbrgy;
			$_SESSION['addofftown'] = $offtown;
			$_SESSION['addoffprov'] = $offprov;
			$_SESSION['addbirthplace'] = $birthplace;
			
			$_SESSION['addoccupation'] = $occupation;
			$_SESSION['addemail'] = $email;
			$_SESSION['addcit'] = $cit;
			$_SESSION['addlicense'] = $license;
			$_SESSION['addwhere'] = $where;
			$_SESSION['addwhen'] = $when;
			$_SESSION['addexpiry'] = $expiry;	
			$_SESSION['addbirthday'] = $birthday;
		
		/*$lname = str_replace($search,$replace,trim(strtoupper($lname)));
		$fname = str_replace($search,$replace,trim(strtoupper($fname)));
		$mname = str_replace($search,$replace,trim(strtoupper($mname)));*/
		$lname = trim(ucwords(strtolower($lname)));
		$fname = trim(ucwords(strtolower($fname)));
		$mname = trim(ucwords(strtolower($mname)));
		$gender = trim(ucwords(strtolower($gender)));
		$civil = trim(ucwords(strtolower($civil)));
		$homeadd = trim(ucwords(strtolower($homeadd)));
		$homebrgy = trim(ucwords(strtolower($homebrgy)));
		$hometown = trim(ucwords(strtolower($hometown)));
		$homeprov = trim(ucwords(strtolower($homeprov)));
		$officeadd = trim(ucwords(strtolower($officeadd)));
		$offbrgy = trim(ucwords(strtolower($offbrgy)));
		$offtown = trim(ucwords(strtolower($offtown)));
		$offprov = trim(ucwords(strtolower($offprov)));
		$birthplace = trim(ucwords(strtolower($birthplace)));
		$occupation = trim(ucwords(strtolower($occupation)));
		$cit = trim(ucwords(strtolower($cit)));
		$license = trim(strtoupper($license));
		$where = trim(ucwords(strtolower($where)));
		
		$registration = new NewRegistrationView(); //instance of NewRegistrationView
		$sm = new RegistrationManager(); //instance of RegistrationManager
		$addsuccess = $sm->newRegistration($profiletype,$uname,$pword,$lname,$fname,$mname,$contactno,$gender,$civil,$homeadd,$homebrgy,$hometown,$homeprov,
			$offbrgy,$offtown,$offprov,$officeadd,$birthplace,$birthday,$occupation,$email,$cit,$license,$where,$when,$expiry,$picture,$licensepic);
		
		$sm->newLog("Add Applicant: ".$uname);
		
		if($addsuccess==1){  //successful add registration
		
			unset($_SESSION['adduname']);
			unset($_SESSION['adddriverid']);
			unset($_SESSION['addpword']);
			unset($_SESSION['addlname']);
			unset($_SESSION['addfname']);
			unset($_SESSION['addmname']);
			
			unset($_SESSION['addgender']);
			unset($_SESSION['addcivil']);
			unset($_SESSION['addhomeadd']);
			unset($_SESSION['addhomebrgy']);
			unset($_SESSION['addhometown']);
			unset($_SESSION['addhomeprov']);
			unset($_SESSION['addofficeadd']);
			unset($_SESSION['addoffbrgy']);
			unset($_SESSION['addofftown']);
			unset($_SESSION['addoffprov']);
			unset($_SESSION['addbirthplace']);
			unset($_SESSION['addbirthday']);
			
			unset($_SESSION['addoccupation']);
			unset($_SESSION['addemail']);
			unset($_SESSION['addcit']);
			unset($_SESSION['addlicense']);
			unset($_SESSION['addwhere']);
			unset($_SESSION['addwhen']);
			unset($_SESSION['addexpiry']);
			
			$registration->showMessage(1);
		}
		else $registration->showMessage(0); //unsuccessful add registration
	}
}
?>