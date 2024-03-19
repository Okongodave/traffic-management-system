<!--
  - File Name: Inspection/Update/index.php
  - Program Description: form for inspection results
  -->
<?php
	$root = "../../"; // root folder
	$pageTitle = "Inspection";
	$currentMenu = "inspection";
	
	session_start();
	
	include $root."RegistrationManager.php";
	$rm = new RegistrationManager();
	
	$plateno = isset($_GET['pn']) ? $_GET['pn'] : "";
	
	if($plateno == ""){
		header("Location: ./");
		die();
	}
	
	$where = "plateNumber='".$plateno."'";
	$inspection = mysql_fetch_array($rm->retrieveInspectionResults($where));
	
	$_SESSION['result'] = $inspection['result'];
	$_SESSION['plateNumber'] = $inspection['plateNumber'];
	$_SESSION['referenceNumber'] = $inspection['referenceNumber'];
	$_SESSION['notes'] = $inspection['notes'];
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
				
				<form action="EditInspectionController.php" method="post" name="updateRefForm">
					<table>
						<tr>
							<td>Inspection</td>
							<td>
								<input type="radio" onclick="javascript:displayFailBox(this);" <?php if($_SESSION['result'] == "fail") echo "checked=checked";?> class="testresult" name="testresult" id="pass" value="pass" checked="true"/><label for="private">Pass</label>
								<input type="radio" onclick="javascript:displayFailBox(this);" <?php if($_SESSION['result'] == "fail") echo "checked=checked";?> class="testresult" name="testresult" id="fail" value="fail"/><label for="public">Fail</label>
								<script>
									function displayFailBox(el){
										if(jQuery(el).val() == "fail"){
											jQuery("#failRow").show();
										}else{
											jQuery("#failRow").hide();
											jQuery("#failreason").val("");
										}
									}
									jQuery("input:radio[name=testresult]").click(function() {
										var value = jQuery(this).val();
									});
								</script>
							</td>
						</tr>
						<tr>
							<td title="Format: LLL NNN | LL NNNN | NNNN LL | N | NN | NNNN | NNNNN">Plate Number</td>
							<td><input type="text" name="plateno" readonly value="<?php echo $_SESSION['plateNumber']; ?>" /></td>
						</tr>
						<tr id="failRow" style="display:none;">
							<td valign="top">Reason for failing</td>
							<td>
								<?php
									$fails = explode(';', $_SESSION['notes']);
									//echo "<pre>"; print_r($fails); echo "</pre>";
									
									$temp = $fails[count($fails)-1];
									if(strpos($temp, "|") !== false){
										$temp = explode("|", $temp);
										$fails[count($fails)-1] = $temp[0];
										$_SESSION['notes'] = $temp[1];
									}
									else
										$_SESSION['notes'] = "";
								?>
								<input <?php echo in_array("defective head light", $fails) ? "checked='checked'" : ""; ?> type="checkbox" value="defective head light" name="inspectionDefect[]" /> defective head light<br />
								<input <?php echo in_array("defective tail light", $fails) ? "checked='checked'" : ""; ?> type="checkbox" value="defective tail light" name="inspectionDefect[]" /> defective tail light<br />
								<input <?php echo in_array("defective break light", $fails) ? "checked='checked'" : ""; ?> type="checkbox" value="defective break light" name="inspectionDefect[]" /> defective brake light<br />
								<input <?php echo in_array("defective signal light", $fails) ? "checked='checked'" : ""; ?> type="checkbox" value="defective signal light" name="inspectionDefect[]" /> defective signal light<br />
								<input <?php echo in_array("unreadable plate number", $fails) ? "checked='checked'" : ""; ?> type="checkbox" value="unreadable plate number" name="inspectionDefect[]" /> unreadable plate number<br />
								<input <?php echo in_array("no trash can", $fails) ? "checked='checked'" : ""; ?> type="checkbox" value="no trash can" name="inspectionDefect[]" /> no trash can<br />
								<input <?php echo in_array("no seat belt", $fails) ? "checked='checked'" : ""; ?> type="checkbox" value="no seat belt" name="inspectionDefect[]" /> no seat  belt<br />
								<input <?php echo in_array("smoke belcher", $fails) ? "checked='checked'" : ""; ?> type="checkbox" value="smoke belcher" name="inspectionDefect[]" /> smoke belcher<br />
								Other reasons:<br />
								<textarea name="failreason" id="failreason"><?php echo $_SESSION['notes']; ?></textarea>
							</td>
						</tr>
					</table>
					<input type="hidden" name="result" value="<?php echo $_SESSION['result']; ?>">
					<input type="submit" value="Submit" name="submit" />
				</form>
			</div>
		</div>
	</body>
</html>
<script>
	jQuery(document).ready(function(){
		if(jQuery("[name=result]").val() == "fail"){
			jQuery("#failRow").show();
		}else{
			jQuery("#failRow").hide();
			jQuery("#failreason").val("");
		}
	});
</script>