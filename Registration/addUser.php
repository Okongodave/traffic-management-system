<?php

$url = "/UPF_Database/Registration/";  //Registration folder URL
$root = "../"; // root folder

include "../dbconnection.php";

$connect = new dbconnection();
$con = $connect->connectdb();
$username = $_POST['reg_username'];
$password = $_POST['reg_password'];
$email = $_POST['reg_email'];

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

// phpinfo();

echo "username: ".$username."<br />password: ".$password."<br />";

// generate verification code
$verificationCode = generateRandomString();

//query string
$sql = "INSERT INTO table_profile (userName, password, emailAddress, verification_code) VALUES ('".$username."', '".$password."' ,'".$email."', '".$verificationCode."')";

//execute query or die
if (!mysql_query($sql,$con)){
die('Query 1 Error: ' . mysql_error());
}


// SEND email for verification
/*
$subject = "Thank you for registering at the UPLB Traffic Management System!";
$message = "test message";
$message = wordwrap($message, 70);
$from = "yo_ayco@yahoo.com";
mail($email,$subject,$message,"From: $from\n") or die('Mail Error');
*/



echo "<a href='".$url."verify_code.php?code=".$verificationCode."&username=".$username."'>".$verificationCode."</a>";

// REDIRECT //not working
// header("Location: ".$root."?status=emailsent");

?>