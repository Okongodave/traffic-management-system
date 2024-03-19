<html>
<?php
$root = "../"; // root folder
$pageTitle = "Email Verified!";
include "head.php";
session_start();
if(!isset($_SESSION['username'])){
	header("Location: ".$root."");
}
?>
<body id="newReg">

	<div id='centerArea'>
		<?php include $root."menu.php";?>
		<div id="loginDiv">
		</div>
		<div id="welcome">
			<h1>Congratulations <?echo $_SESSION['username']?>!</h1>
			<p>Your email address is now verified! Please complete your profile.</p>
			<a href="profile_form.php">Complete your Profile</a><br />
		</div>
	</div>
	<div id='about'>
		&nbsp;<br />&copy; 2013 by University of the Philippines Los Ba&ntilde;os.<br />All Rights Reserved.
	</div>
</body>
</html>