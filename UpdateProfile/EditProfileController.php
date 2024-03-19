<!--
 - File Name: EditProfileController.php
 - Program Description: data transformations
-->
<?php
include "../RegistrationManager.php";
class EditProfileController
{
	//constructor
	function EditProfileController(){
	}
	
	function editProfile($profiletype,$uname,$pword,$lname,$fname,$mname,$contactno,$gender,$civil,$homeadd,$homebrgy,$hometown,$homeprov,
		$offbrgy,$offtown,$offprov,$officeadd,$birthplace,$birthday,$occupation,$email,$cit,$license,$where,$when,$expiry,$picture,$licensepic)
	{
		/*transform each information to uppercase letters,
		remove white spaces before and after,
		and look for characters which can harm the program*/
		$search = array("<",">");
		$replace = array("bawal1","bawal2");
		
		$lname = str_replace($search,$replace,trim(strtoupper($lname)));
		$fname = str_replace($search,$replace,trim(strtoupper($fname)));
		$mname = str_replace($search,$replace,trim(strtoupper($mname)));
		$gender = trim(strtoupper($gender));
		$civil = trim(strtoupper($civil));
		$homeadd = trim(strtoupper($homeadd));
		$homebrgy = trim(strtoupper($homebrgy));
		$hometown = trim(strtoupper($hometown));
		$homeprov = trim(strtoupper($homeprov));
		$officeadd = trim(strtoupper($officeadd));
		$offbrgy = trim(strtoupper($offbrgy));
		$offtown = trim(strtoupper($offtown));
		$offprov = trim(strtoupper($offprov));
		$birthplace = trim(strtoupper($birthplace));
		$occupation = trim(strtoupper($occupation));
		$cit = trim(strtoupper($cit));
		$license = trim(strtoupper($license));
		$where = trim(strtoupper($where));
		
		
		$editprofileview = new EditProfileView(); //instance of EditProfileView
		$update = new RegistrationManager(); //instance of RegistrationManager
		$editsuccess = $update->updateProfile($profiletype,$uname,$pword,$lname,$fname,$mname,$contactno,$gender,$civil,$homeadd,$homebrgy,$hometown,$homeprov,
			$offbrgy,$offtown,$offprov,$officeadd,$birthplace,$birthday,$occupation,$email,$cit,$license,$where,$when,$expiry,$picture,$licensepic);
		$update->newLog("Updated Applicant: ".$uname);
		$editprofileview->showMessage($editsuccess);
	}
}
?>