<!--
  - File Name: Registration/Confirm/ConfirmController.php
  - Program Description: Email Confirmation
  -->
<?php
	//session_start();
	include "../../RegistrationManager.php";


	class ConfirmController
	{
		function requestConfirmEmail($username, $codeConfirm)
		{
			$rm = new RegistrationManager();
			$check = $rm->getUsername($username);
			
			$hashUsername = md5($username);
			//echo $hashUsername;
			
			if($check == 1){
				if($hashUsername == $codeConfirm){
					//echo "email confirmation successful";
					
					$rm->confirmEmail($username);
					return 1;
					
				}else{
					//echo "wrong confirmation link";
					return 0;
				}
			}else{
				//echo "your account doesn't exist";
				return 0;
			}
		}
		
		function sendEmail($username)
		{
			$rm = new RegistrationManager();
			$profile = mysql_fetch_array($rm->retrieveProfile($username));
			
			$code = md5($username);
			$to = $profile['givenName']." ".$profile['lastName']." <".$profile['emailAddress'].">";
			$subject = "UPLB Vehicle Traffic Management System Registration";
			$message = ""
				. "Good day " . $profile['givenName'] . "!" . "\r\n"
				. "\r\n"
				. "Thank you for using UPLB Vehicle Traffic Management System!" . "\r\n"
				. "\r\n"
				. "Here's your confirmation link:" . "\r\n"
				. "        localhost/UPF_Database/Registration/Confirm/?id=1&code=" . $code . "\r\n"
				. "\r\n"
				. "Please click the link above to complete your registration." . "\r\n"
				. "\r\n"
				. "UPF Admin";
			$headers = "From: noreply@upfdatabase.com";
			
			//if(mail($to, $subject, $message, $headers))
			if(true){
				$_SESSION['message'] = "Email confirmation sent";
				header("Location: ../");
			}
			else{
				$_SESSION['message'] = "Error in sending email confirmation.";
				header("Location: ../");
			}
		}
	}
	$confirmcontroller = new ConfirmController();

	$task = isset($_GET['task']) ? $_GET['task'] : "";

	if($task == "send"){
		$username = isset($_GET['us']) ? $_GET['us'] : "";
		$confirmcontroller->sendEmail($username);
	}
?>