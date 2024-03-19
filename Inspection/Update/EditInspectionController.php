<!--
  - File Name: Inspection/EditInspectionController.php
  - Program Description: 
  -->
<?php
	session_start();
	include "../../RegistrationManager.php";
	class EditInspectionController
	{
		function validateInfo($result, $plateno, $refno, $notes)
		{
			$rm = new RegistrationManager();
			
			/*if($result == "fail" && $notes == ""){
				$this->setDefaults($result, $plateno, $refno, $notes);
				$_SESSION['message'] = "please indicate notes";
				header("Location: ./?pn=".$plateno);
				die();
			}*/
			
			$failselection = $_POST['inspectionDefect'];
			
			$failreasons = "";
			for($i=0; $i<count($failselection); $i++)
			{
				if($failreasons != "") $failreasons .= ";";
				$failreasons .= $failselection[$i];
			}
			
			if($result == "pass"){
				$check = 0;
				while($check == 0){
					$refno = rand(100000, 999999);
					$check = $rm->checkReferenceNumber($refno);
				}
				$notes = "";
			}
			
			// notes
			if($_POST['failreason'] == ""){
				$notes = $failreasons;
			}else{
				if($failreasons != "") $failreasons .= "|";
				$notes = $failreasons . $_POST['failreason'];
			}
			
			$rm->updateInspection($result, $plateno, $refno, $notes);
			$rm->newLog("Update Inspection: " . $testresult . " " . $plateno);
			$_SESSION['message'] = $plateno." updated.";
			header("Location: ../");
		}
		
		function setDefaults($result, $plateno, $refno, $notes)
		{
			$_SESSION['result'] = $result;
			$_SESSION['plateNumber'] = $plateno;
			$_SESSION['referenceNumber'] = $refno;
			$_SESSION['notes'] = $notes;
		}
		
		function requestEditInspection()
		{
			$result = $_POST['testresult'];
			$plateno = $_POST['plateno'];
			$refno = ""; //$_POST[''];
			$notes = $_POST['failreason'];
			
			$this->validateInfo($result, $plateno, $refno, $notes);
		}
	}
	$controller = new EditInspectionController();
	$controller->requestEditInspection();
?>