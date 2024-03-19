<!--
  - File Name: Password/PasswordController.php
  - Program Description:
  -->
<?php
	include "../RegistrationManager.php";
	
	class PasswordController
	{
		function requestSendPassword()
		{
			$email = $_POST['email'];
			
			$rm = new RegistrationManager();
			$profile = $rm->checkEmail($email);
			
			if($profile['userName'] != ""){
				$to = $profile['givenName'] . " " . $profile['lastName'] . " <" . $email . ">";
				$subject = "UPLB Vehicle Traffic Management System - Forgot Password";
				$message = ""
					. "Hi " . $profile['givenName'] . "\r\n"
					. "\r\n"
					. "Your password to you UPLB Vehicle Traffic Management System account is : " . $profile['password'] . "\r\n"
					. "\r\n"
					. "UPF Admin"
					. "";
				$headers = "From: Admin <noreply@upfdatabase.com>";
				
				mail($to, $subject, $message, $headers);
				header("Location: ./?success=1");
			}
			else{
				// email doesn't exist
				header("Location: ./?success=0");
			}
		}
	}
	$pc = new PasswordController();
	$pc->requestSendPassword();
?>