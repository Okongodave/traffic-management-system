<!--
  - File Name: Registration/Confirm/index.php
  - Program Description: Email Confirmation
  -->
<?php
	$root = "../../"; // root folder
	$pageTitle = "Confirmation";
	$currentMenu = "homepage";
	
	session_start();
	//if(isset($_SESSION['username'])) header("Location: ".$root); //if logged in, redirect to homepage. no need to reconfirm
	
	//include $root."RegistrationManager.php";
	//$rm = new RegistrationManager();
	
	include "ConfirmController.php";
	$cc = new ConfirmController();
?>
<html>
	<?php include $root."head.php"; ?>
	
	<body id='searchProfile'>
		<div id='centerArea'>
			<?php include $root."menu.php"; // display menu options ?>
			
			<div id="content">
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
				
				<?php
					$username = isset($_GET['us']) ? $_GET['us'] : "";
					$codeConfirm = isset($_GET['code']) ? $_GET['code'] : "";
					
					if($username != "" || $codeConfirm != ""){
					
						// Please remove this code during the real demo
						echo "<div style='border:1px solid #000'>";
						echo "Note: Displaying the code is for debugging purposes only";
						echo "<br>";
						echo "code: ".md5($username);
						echo "</div>";
						echo "<br>";
						
						$result = $cc->requestConfirmEmail($username, $codeConfirm);
						if($result == 1)
							echo "Email confirmation successful.";
						else{
							echo "Error in confirmation link.";
							echo "<br>";
							echo "<a href='./ConfirmController.php/?task=send&us=".$username."'>Re-send confirmation email</a>";
						}
					}
					else{
						echo "Error in confirmation link.";
					}
				?>
			</div>
		</div>
	</body>
</html>