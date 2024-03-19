<!--
  - File Name: Sticker/index.php
  - Program Description: form to add sticker number
  -->
<?php
	$root = "../"; // root folder
	$pageTitle = "Sticker";
	$currentMenu = "sticker";
	
	include $root."dbconnection.php";
	
	session_start();
	
	if(!isset($_SESSION['username'])) header("Location: ".$root);
	
	$connect = new dbconnection();
	$con = $connect->connectdb();
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
				
				<form action="StickerController.php" method="post" name="stickerForm" id="stickerForm">
					<table>
						<tr>
							<td title="Format: LLL NNN | LL NNNN | NNNN LL | N | NN | NNNN | NNNNN">Plate Number</td>
							<td><input type="text" name="plateno" value="<?php if(isset($_SESSION['plateno'])) echo $_SESSION['plateno']?>" /></td>
						</tr>
						<tr>
							<td>Sticker Number: (4 Digits only)</td>
							<td><input type="text" name="stickerno" value="<?php if(isset($_SESSION['stickerno'])) echo $_SESSION['stickerno']?>" /></td>
						</tr>
						<tr>
							<td>Date Issued (YYYY-MM-DD)</td>
							<td><input type="text" name="stickerdate" value="<?php if(isset($_SESSION['stickerdate'])) echo $_SESSION['stickerdate']?>" /></td>
						</tr>
					</table>
					<input type="submit" name="submit" value="Submit" />
				</form>
			</div>
		</div>
	</body>
</html>
<?php
	if(isset($_SESSION['plateno'])) unset($_SESSION['plateno']);
	if(isset($_SESSION['stickerno'])) unset($_SESSION['stickerno']);
	if(isset($_SESSION['stickerdate'])) unset($_SESSION['stickerdate']);
?>