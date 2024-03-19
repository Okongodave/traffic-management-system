<?php
	session_start();
	//include "dbconnection.php";
	include "RegistrationManager.php";
	
	$connect = new dbconnection();
	$con = $connect->connectdb();
	
	$query = "
		UPDATE
			table_vehicle
		SET
			stickerNumber='',
			stickerIssuedDate='0000-00-00',
			reference='0',
			paid='0000-00-00',
			status='pending',
			`condition`='',
			certificationRegistration='',
			receiptRegistration='',
			LTFRBFranchise='',
			insurance='',
			deed=''
	";
	//echo $query;
	$res = mysql_query($query);
	
	/*
	$query = "DELETE FROM table_driverID";
	mysql_query($query);
	
	$query = "ALTER TABLE table_driverID AUTO_INCREMENT = 0000";
	mysql_query($query);
	*/
	
	$connect->closeconnection($con);
	
	if($res>0){
	$rm = new RegistrationManager();
	$rm->newLog("Reset All Vehicle Information.");
	
	$_SESSION['message'] = "All vehicle information has been reset.";
	header("Location: ./Option/");
	}
	else{
	$_SESSION['message'] = "Unsuccessful reset.";
	header("Location: ./Option/");
	}
?>