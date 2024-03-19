<html>
<?php
$root = "../"; // root folder
$pageTitle = "Register";
include "head.php";
?>

<body id="newReg">

	<div id='centerArea'>
	<?php include $root."menu.php";?>
			<div id="loginDiv">
				<?php
					if(isset($_SESSION['message'])){
						if($_SESSION['message'] != ""){
							echo "<div>";
								echo $_SESSION['message'];
							echo "</div>";
						}
						unset($_SESSION['message']);
					}
				?>
			
				<?include "../loginform.php"?>
			</div>
			<div id="welcome">
		<h1>USER REGISTRATION</h1>
		
		<form id="user_registration_form" name="user_registration_form" action="addUser.php" method="post">
		<table id="registration_table">
			<tr><td class="form_label_column">Email:</td><td><input id="reg_email" name="reg_email" />
				<img id="tick2" src="../images/tick.png" width="16" height="16"/>
				<img id="cross2" src="../images/cross.png" width="16" height="16"/></td></tr>
			<tr><td class="form_label_column">Username:</td><td><input id="reg_username" name="reg_username" />
				<img id="tick" src="../images/tick.png" width="16" height="16"/>
				<img id="cross" src="../images/cross.png" width="16" height="16"/></td></tr>
			<tr><td class="form_label_column">Password:</td><td><input type="password" id="reg_password" name="reg_password" /></td></tr>
			<tr><td class="form_label_column">Confirm password:</td><td><input type="password" id="confirm_password" name="confirm_password" /></td></tr>
			<tr><td class="form_label_column">Agree to our <a href="policy.php" target="_blank">policy</a>:</td><td><input type="checkbox" class="checkbox" id="agree" name="agree" /></td></tr>
			<tr><td class="form_label_column">&nbsp;</td><td><br /><input type="submit" value="Submit" id="submit1" name="smethod" /></td></tr>
			</table>
		</form>
	</div>
	</div>
	<div id='about'>&nbsp;<br />&copy; 2013 by University of the Philippines Los Ba&ntilde;os.<br />All Rights Reserved.
	</div>
</body>
</html>