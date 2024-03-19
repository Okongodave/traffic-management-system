<!--
  - File Name: Inspection/index.php
  - Program Description: form for inspection results
  -->
<?php
	$root = "../"; // root folder
	$pageTitle = "Inspection";
	$currentMenu = "inspection";
	
	session_start();
	
	include "../RegistrationManager.php";
	
	$searchOptions = ""
		.	"<select class='filter'>"
		.		"<option value='plateNumber'>Plate Number</option>"
		.		"<option value='referenceNumber'>Reference Number</option>"
		.	"</select>";
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
			
				<form action="ReferenceController.php/?task=add" method="post" name="refForm">
					<table>
						<tr>
							<td>Inspection</td>
							<td>
								<input type="radio" onclick="javascript:displayFailBox(this);" class="testresult" name="testresult" id="pass" value="pass" checked="true"/><label for="private">Pass</label>
								<input type="radio" onclick="javascript:displayFailBox(this);" class="testresult" name="testresult" id="fail" value="fail"/><label for="public">Fail</label>
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
							<td><input type="text" name="plateno" value="" /></td>
						</tr>
						<tr id="failRow" style="display:none;">
							<td valign="top">Reason for failing</td>
							<td>
								<input type="checkbox" value="defective head light" name="inspectionDefect[]" /> defective head light<br />
								<input type="checkbox" value="defective tail light" name="inspectionDefect[]" /> defective tail light<br />
								<input type="checkbox" value="defective break light" name="inspectionDefect[]" /> defective brake light<br />
								<input type="checkbox" value="defective signal light" name="inspectionDefect[]" /> defective signal light<br />
								<input type="checkbox" value="unreadable plate number" name="inspectionDefect[]" /> unreadable plate number<br />
								<input type="checkbox" value="no trash can" name="inspectionDefect[]" /> no trash can<br />
								<input type="checkbox" value="no seat belt" name="inspectionDefect[]" /> no seat  belt<br />
								<input type="checkbox" value="smoke belcher" name="inspectionDefect[]" /> smoke belcher<br />
								Other reasons:<br />
								<textarea name="failreason" id="failreason"></textarea>
							</td>
						</tr>
					</table>
					<input type="submit" value="Submit" name="submit" />
				</form>
				<hr />
				<div id="searchPanel">
					<form action="javascript:getFilters()" method="post">
						<div id="searchFilter">
							<div>
								<input class="keyword" name="keyword" type="text" value="" />
								<select class="filter">
									<option value="plateNumber">Plate Number</option>
									<option value="referenceNumber">Reference Number</option>
								</select>
							</div>
						</div>
						<div class="searchButton">
							<input type="button" value="Add Filter" onclick="javascript:addFilter()" />
							<input type="button" value="Search" onclick="javascript:getFilters()" />
						</div>
					</form>
				</div>
				<?php
					$rm = new RegistrationManager();
					$inspections = $rm->retrieveInspectionResults("");
					$data = array();
				?>
				<form name="viewForm" id="viewForm" method="post" action="">
					<input type="button" value="Print" onclick="this.form.action='./PrintInspection.php';submit();" style="float: right;"/>
					<table id="result" width="700">
						<tr>
							<th class="sortable" onclick="javascript:sortColumns('result');">Result</th>
							<th class="sortable" onclick="javascript:sortColumns('plateNumber');">Plate Number</th>
							<th class="sortable" onclick="javascript:sortColumns('notes');">Notes</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>
					<?php
						while($row = mysql_fetch_array($inspections))
						{ 
							array_push($data, $row);
							?>
							<tr>
								<td align="center"><img title="<?php echo "Inspection ".$row['result'] == "pass" ? "passed." : "failed."; ?>" src="<?php echo $root."assets/images/icons/".($row['result'] == "pass" ? "check24" : "delete24").".png" ; ?>" /></td>
								<td><?php echo $row['plateNumber']; ?></td>
								<td><?php echo str_replace("|", ";", $row['notes']); ?></td>
								<td align="center">
									<?php if($row['result'] == "pass"){ ?>
										<img title="Vehicle already passed the inspection. No need to edit it." src="<?php echo $root."assets/images/icons/edit24_x.png"; ?>">
									<?php }else{ ?>
										<a href="./Update/?pn=<?php echo $row['plateNumber']; ?>"><img title="Edit vehicle inspection result" src="<?php echo $root."assets/images/icons/edit24.png"; ?>"></a>
									<?php } ?>
								</td>
								<td align="center">
									<a href="./ReferenceController.php/?task=delete&pn=<?php echo $row['plateNumber']; ?>"><img src="<?php echo $root."assets/images/icons/delete24.png"; ?>"></a>
								</td>
							</tr>
							<?php
						}
						$_SESSION['pData'] = $data;
					?>
					</table>
					<input type="hidden" id="searchCombine" name="searchCombine" value="" />
					<input type="hidden" id="searchKeyword" name="searchKeyword" value="" />
					<input type="hidden" id="searchFilters" name="searchFilters" value="" />
					<input type="hidden" id="sortColumn" name="sortColumn" value="" />
				</form>
			</div>
		</div>
	</body>
</html>
