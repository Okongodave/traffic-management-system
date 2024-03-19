<!--
  - File Name: Payment/PaymentController.php
  - Program Description: payments transaction
  -->
<?php
	session_start();
	include "../RegistrationManager.php";
	
	class PaymentController
	{
		//constructor
		function PaymentController(){}
		
		function requestPayment()
		{
			$plateNo = isset($_GET['pn']) ? $_GET['pn'] : $this->showMessage(0);
			
			$rm = new RegistrationManager();
			$rm->newLog("Sticker Payment: ".$plateNo);
			$success = $rm->applicantPayment($plateNo);
			
			$this->showMessage($success);
		}
		
		function showMessage($flag)
		{
			if($flag==1) header("Location: ../?removesuccess=1");
			else header("Location: ../?removenotsuccess=1");
		}
	}
	
	$pc = new PaymentController();
	$pc->requestPayment();
?>