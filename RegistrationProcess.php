<?/*

RegistrationProcess

*/

	$root = "./";
	$pageTitle = "Registration Process";
	
	session_start();
	if(!isset($_SESSION['username'])) header("Location: ../");
?>

<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
	<?php include $root."head.php"; ?>
	<body>
		<div id='centerArea'>
			<?php include $root."menu.php";?>
			<div id="content"><br>
				<b>The Registration Process:</b><br><br>
				<ul>
				<li style="color:black;">	A.	You can either register online first or get your vehicle inspected at the UPF Office.<br>
						<ul style="color:black;"><li id="regPro">	During registration, please make sure that the information that you put are all valid and up to date.<br></li>
												<li id="regPro">	Once a vehicle is approved under your name, you can no longer edit your profile for security reasons.<br></li></ul></li><br>
				<li style="color:black;">	B.	Once registered, please confirm your account by clicking the activation code sent to your email.<br></li><br>
				<li style="color:black;">	C.	If your account is already confirmed through email, you may start to register your vehicle/s in the <b>Vehicle</b> Tab.<br>
						<ul style="color:black;"><li id="regPro">	Please upload necessary files to speed up your application process.<br></li>
												<li id="regPro">	You may view the status of your application in your Home Page or in your Vehicle Tab.<br></li>
												<li id="regPro">	If the status of the vehicle is changed to "<i>approved</i>", please bring the original copies to the UPF office of the documents that you have uploaded for verification purposes.<br></li>
												<li id="regPro">	Once the documents are verified, you may now proceed to the UPF Cashier to pay the necessary fees.<br></li>
												<li id="regPro">	After paying, the status of your vehicle will be changed to "<i>paid</i>", you may now proceed to the Releasing Section to get your new sticker.<br></li>
												<li id="regPro">	When the sticker is released to you, the status of your application will then be changed to "<i>released</i>" with your new sticker number in it.<br></li>
						</ul>
				</li>
				<li style="color:black;">	D.	You may add new driver/s for your vehicle/s in the <b>Driver</b> Tab, just click on the <i>Add Driver</i> button.<br>
						<ul style="color:black;"><li id="regPro">	Fill out all the necessary information.<br></li>
												<li id="regPro">	Upload all files needed before you can have the new Driver's ID from the UPF Office.<br></li>
				
						</ul>
				</li>
				</ul><br></div>
		</div>
	</body>
</html>