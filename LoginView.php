<!--
  - File Name: LoginView.php
  - Program Description: validate login
  -->
  <?php
include "RegistrationManager.php";
session_start();
//if(!isset($_SESSION['username'])) header("Location: ../");
//else header("Location: HomePage/");
class LoginView
{
	function requestLogin(){
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		$loginview2 = new LoginView();
		$loginview2->validateInfo($username,$password);
	}
	
	function validateInfo($username,$password){
	
		$retrieve = new RegistrationManager();
		$profile = $retrieve->checkLoginDetails($username,$password);
		
		$_SESSION['message'] = "";
	
		if($profile == 0){
			$_SESSION['invalidlogin'] = 1;
			header("Location: ../upfdtabase/");
		}else{ // correct login details
			if($profile['status'] == "confirmation"){
				//die('confirmation');
				$_SESSION['message'] = "Your account is inactive.<br> Please click the confirmation link on your email.";
				
				unset($_SESSION['username']);
				//session_destroy();
				
				header("Location: ../upfdatabase/");
			}
			elseif($profile['block'] == 1){
				$_SESSION['message'] = "Your account is blocked.<br>Please go to the UPF Office.";
				
				unset($_SESSION['username']);
				header("Location: ../upfdatabase/");
			}
			else{
				$_SESSION['username'] = $username;
				$_SESSION['profileType'] = strtoupper($profile['profileType']);
				$_SESSION['profileStatus'] = strtoupper($profile['status']);
				$_SESSION['profileID'] = $profile['profileID'];
				$_SESSION['driverID'] = strtoupper($profile['driverID']);
				
				header("Location: HomePage/");
			}
		}
	}
}

$loginview = new LoginView();
$loginview->requestLogin();
?>
