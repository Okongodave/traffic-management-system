<!--
  - File Name: Password/index.php
  - Program Description: form for new registrations
  -->
<?php
	$root = "../"; // root folder
	$pageTitle = "Option";
	$currentMenu = "option";
	
	session_start();
	
	include "../RegistrationManager.php";
	
	$rm = new RegistrationManager();
	$options = $rm->retrieveOptions();
?>
<html>
	<?php include $root."head.php"; ?>
	
	<body id="">
		<div id='centerArea'>
			<?php include $root."menu.php"; // display menu options ?>
			
			<div id="content">
				<?php
					if(isset($_SESSION["message"])) {
						if($_SESSION["message"] != ""){
							echo "<div class='message'>";
								echo $_SESSION["message"];
							echo "</div>";
						}
						unset($_SESSION["message"]);
					}
				?>
				
				<form action="OptionController.php/?task=mv" method="post">
					Max number of violations
					<?php $row = mysql_fetch_array($options) ?>
					<input type="text" name="maxviolation" id="maxviolation" value="<?php echo $row['value']; ?>" />
					<input type="submit" name="submit" value="Submit" />
				</form>
				
				<!--hr>
				
				<form action="OptionController.php/?task=mi" method="post">
					Max number of inpections per day
					<?php $row = mysql_fetch_array($options) ?>
					<input type="text" name="maxinspection" id="maxinspection" value="<?php echo $row['value']; ?>" />
					<input type="submit" name="submit" value="Submit" />
				</form-->
				
				<hr>
				
				<form action="../reset.php" method="post" onsubmit="return confirm('Reset all vehicle information?')">
					Reset All Vehicle Info:
					<input type="submit" value="Reset" />
				</form>
			</div>
		</div>
	</body>
</html>