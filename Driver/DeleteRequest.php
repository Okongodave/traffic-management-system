<!--
  - File Name: DeleteRequest.php
  - Program Description: Delete Request
  - Author: 
  -->
  
<?php
	session_start();
	include "../RegistrationManager.php";
	
	class DeleteRequest
	{
		function requestDeleteRequest()
		{
			$rm = new RegistrationManager(); //instance of RegistrationManager
			
			$id = isset($_GET['id']) ? $_GET['id'] : $this->showMessage(0); // driver profile id
			
			$success = $rm->removeRequest($id);
			$this->showMessage($success);
		}
		
		function showMessage($flag) {
			if($flag==1) header("Location: ../?removesuccess=1");
			else header("Location: ../?removenotsuccess=1");
		}
	}
	
	$dr = new DeleteRequest();
	$dr->requestDeleteRequest();
?>