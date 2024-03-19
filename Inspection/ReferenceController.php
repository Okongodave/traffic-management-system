<!--
  - File Name: Inspection/ReferenceController.php
  - Program Description: Email Confirmation
  -->
<?php
	session_start();
	include "../RegistrationManager.php";
	class ReferenceController
	{
		function requestReferenceNumber()
		{
			$rm = new RegistrationManager();
			$_SESSION["message"] = "";
			
			$plateno = strtoupper($_POST['plateno']);
			$testresult = $_POST['testresult'];
			$failselection = $_POST['inspectionDefect'];
			$refno = "0";
			
			if($testresult == "fail"){
				$failreasons = "";
				
				for($i=0; $i<count($failselection); $i++)
				{
					if($failreasons != "") $failreasons .= ";";
					$failreasons .= $failselection[$i];
				}
			
				// fail reasons
				if($_POST['failreason'] == ""){
					$failreason = $failreasons;
				}else{
					if($failreasons != "") $failreasons .= "|";
					$failreason = $failreasons . $_POST['failreason'];
				}
			}else{
				$failreason = "";
			}
			
			if($this->checkPlateNumber($plateno) == 0){
				$_SESSION["message"] = "Plate Number format is invalid.";
				header("Location: ../");
				die();
			}
			
			$ref = $rm->checkReferencePlate($plateno);
			if(is_array($ref)){
				if($ref['referenceNumber'] == ""){
					$_SESSION["message"] = $ref['plateNumber']." failed the inspection due to the following reason/s: <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- ".$ref['notes'];
				}else{
					$_SESSION["message"] = $ref['plateNumber']." already has a reference number.<br>Reference Number: ".$ref['referenceNumber'];
				}
				header("Location: ../");
				die();
			}
			
			/*if($testresult == "pass"){
				$check = 0;
				while($check == 0){
					$refno = rand(100000, 999999);
					$check = $rm->checkReferenceNumber($refno);
				}
			}*/
			
			$success = $rm->addReferenceNumber($testresult, $plateno, $refno, $failreason);
			if($success == 1){
				$_SESSION["message"] = "Inspection result for ".$plateno." added.";
				
				$rm->newLog("Added Inspection: " . $testresult . " " . $plateno);
			}else{
				$_SESSION["message"] = "Error in adding inspection result.";
			}
			header("Location: ./?success=0");
		}
		
		function checkPlateNumber($plateno){
			if(preg_match('/^([A-Za-z]{3})\ ([0-9]{3})$/',$plateno)){ // LLL NNN
				return 1;
			}elseif(preg_match('/^([0-9]{4})$/',$plateno)){ // NNNN
				return 1;
			}elseif(preg_match('/^([0-9]{5})$/',$plateno)){ // NNNNN
				return 1;
			}elseif(preg_match('/^([0-9]{1})$/',$plateno)){ // N
				return 1;
			}elseif(preg_match('/^([0-9]{2})$/',$plateno)){ // NN
				return 1;
			}elseif(preg_match('/^([A-Za-z]{2})\ ([0-9]{4})$/',$plateno)){ // LL NNNN
				return 1;
			}elseif(preg_match('/^([0-9]{4})\ ([A-Za-z]{2})$/',$plateno)){ // NNNN LL
				return 1;
			}else{
				return 0;
			}
		}
		
		function requestDeleteInspection()
		{
			$plateno = isset($_GET['pn']) ? $_GET['pn'] : "";
			if($plateno == ""){
				header("Location: ./");
				die();
			}
			
			$rm = new RegistrationManager();
			$rm->removeReferenceNumber($plateno);
			$_SESSION['message'] = $plateno." deleted.";
			header("Location: ./");
		}
	}
	$rc = new ReferenceController();
	$task = isset($_GET['task']) ? $_GET['task'] : "";
	
	if($task == "add")
		$rc->requestReferenceNumber();
	elseif($task == "delete")
		$rc->requestDeleteInspection();
	else
		header("Location: ../");
?>