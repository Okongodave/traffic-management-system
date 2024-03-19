<?php

$url = "/UPF_Database/Registration/";  //Registration folder URL
$root = "../"; // root folder

include "../dbconnection.php";
$connect = new dbconnection();
$con = $connect->connectdb();

$get_code = $_GET['code'];
$username = $_GET['username'];

$sql = "SELECT verification_code FROM table_profile WHERE userName ='".$username."'";
$result = mysql_query($sql, $con) or die('Error: '.mysql_error());
$rows = mysql_fetch_array($result);
$db_code = $rows['verification_code'];

if($get_code == $db_code){// if get_code is same as code in db_code, start session, then prompt success
	$sql = "UPDATE table_profile SET status = 'active' WHERE userName ='".$username."'"; // set status to active
	mysql_query($sql, $con) or die('Error: '.mysql_error());
	session_start();
	
	//set session variables
	$_SESSION['username'] = $username;
	
	
	header("Location: verification_success.php?code=".$get_code."");
}else{
	header("Location: ".$root."");
}



?>