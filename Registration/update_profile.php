<?php
$url = "/UPF_Database/Registration/";  //Registration folder URL
$root = "../"; // root folder

include "../dbconnection.php";

$connect = new dbconnection();
$con = $connect->connectdb();
session_start();
if(!isset($_SESSION['username'])){
	header("Location: ".$root."");
}

//query string
$sql = "UPDATE table_profile SET
profileType = 'APPLICANT',
licenseNumber='".$_POST['license']."',
licenseIssuedLTOBranch='".$_POST['whereIssued']."',
licenseIssuedDate='".$_POST['when']."',
licenseExpiryDate='".$_POST['expiry']."',
contactNumber='".$_POST['contactnumber']."',
lastName='".$_POST['lname']."',
givenName='".$_POST['fname']."',
middleName='".$_POST['mname']."',
birthDate='".$_POST['birthday']."',
birthPlace='".$_POST['birthplace']."',
gender='".$_POST['gender']."',
civilStatus='".$_POST['civil']."',
citizenship='".$_POST['cit']."',
occupation='".$_POST['occupation']."',
homeAddress='".$_POST['homeadd']."',
homeBrgy='".$_POST['homebrgy']."',
homeTown='".$_POST['hometown']."',
homeProvince='".$_POST['homeprov']."',
officeAddress='".$_POST['officeadd']."',
officeBrgy='".$_POST['offbrgy']."',
officeTown='".$_POST['offtown']."',
officeProvince='".$_POST['offprov']."',
picture='".$_POST['picture']."'
WHERE userName = '".$_SESSION['username']."'";

//execute query or die
if (!mysql_query($sql,$con)){
die('Query 1 Error: ' . mysql_error());
}
else header("Location: ".$root."logout.php");

?>