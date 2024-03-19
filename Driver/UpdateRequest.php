<!--
  - File Name: UpdateRequest.php
  - Program Description: Update Request
  - Author: 
  -->
  
<?php
	session_start();
	include "../RegistrationManager.php";
	
	class UpdateRequest
	{
		function requestUpdateRequest()
		{
			$rm = new RegistrationManager(); //instance of RegistrationManager
			
			$id = isset($_GET['id']) ? $_GET['id'] : $this->showMessage(0); // driver profile id
			$notes = isset($_POST['notes']) ? $_POST['notes'] : "";
			
			$success = $rm->requestUpdateDriver($id, $_SESSION['profileID'], $notes);
			$this->showMessage($success);
		}
		
		function showMessage($flag) {
			if($flag==1) header("Location: ../?removesuccess=1");
			else header("Location: ../?removenotsuccess=1");
		}
	}
	
	$ur = new UpdateRequest();
	$ur->requestUpdateRequest();
?>