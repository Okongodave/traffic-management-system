<!--
  - File Name: Password/index.php
  - Program Description: form for new registrations
  -->
<?php
	$root = "../"; // root folder
	$pageTitle = "Forgot Password";
	$currentMenu = "";
	
	session_start();
?>
<html>
	<?php include $root."head.php"; ?>
	
	<body id="">
		<div id='centerArea'>
			<?php include $root."menu.php"; // display menu options ?>
			
			<div id="content">
				<?php
					if(isset($_GET['success']))
					{
						$success = $_GET['success'];
						
						if($success == 1)
						{
							echo "Your password is sent to your email.";
						}
						else
						{
							echo "That email address doesn't exist.";
							echo "<br>";
							echo "<a href='../'>Go back to LOG IN page.</a>";
						}
					}
					
						?>
						<form action="PasswordController.php" method="post" name="passwordForm">
							Enter email:
							<input type="text" name="email" id="email" />
							<input type="submit" value="Submit" name="submit" />
						</form>
						<?php
					
				?>
			</div>
		</div>
	</body>
</html>