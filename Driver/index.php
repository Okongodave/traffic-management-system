<!--
  - File Name: Driver/index.php
  - Program Description: drivers view page
  -->
<?php
	$root = "../"; // root folder
	$pageTitle = "Driver";
	$currentMenu = "driver";
	
	session_start();
	
	if(!isset($_SESSION['username'])) header("Location: ../");
	
	include "../RegistrationManager.php";
	$rm = new RegistrationManager();
	
	$searchOptions = ""
		.	"<select class='filter'>"
		.		"<optgroup label='Driver'>"
		.			"<option value='p.licenseNumber'>License Number</option>"
		.			"<option value='p.lastName'>Last Name</option>"
		.			"<option value='p.givenName'>Given Name</option>"
		.			"<option value='p.middleName'>Middle Name</option>"
		.			"<option value='p.age'>Age</option>"
		.			"<option value='p.civilStatus'>Civil Status</option>"
		.			"<option value='p.homeAddress'>Home Address</option>"
		.			"<option value='p.homeBrgy'>Home Barangay</option>"
		.			"<option value='p.homeTown'>Home Town</option>"
		.			"<option value='p.homeProvince'>Home Province</option>"
		.			"<option value='p.spouseName'>Spouse</option>"
		.		"</optgroup>"
		.		"<optgroup label='Operator'>"
		.			"<option value='o.userName'>Username</option>"
		.			"<option value='o.lastName'>Last Name</option>"
		.			"<option value='o.givenName'>Given Name</option>"
		.			"<option value='o.middleName'>Middle Name</option>"
		.		"</optgroup>"
		.	"</select>";
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
							echo "<div class='message'>";
								echo $_SESSION['message'];
							echo "</div>";
						}
						unset($_SESSION['message']);
					}
				?>
				
				<div id="searchPanel">
					<form action="javascript:getFilters()" method="post">
						<div id="searchFilter">
							<div>
								<input class="keyword" name="keyword" type="text" value="" />
								<?php echo $searchOptions; ?>
							</div>
						</div>
						<div class="searchButton">
							<input type="button" value="Add Filter" onclick="javascript:addFilter()" />
							<input type="button" value="Search" onclick="javascript:getFilters()" />
						</div>
					</form>
				</div>
				<form name="viewForm" id="viewForm" method="post" action="">
					<div style=''>
						<? if ($_SESSION['profileType']!="INVESTIGATION"){?>
							<input type="button" value="Add Driver" onclick="this.form.action='./Add/';submit();" style="float: right;"/>
						<? } ?>
						<input type="button" value="Print" onclick="this.form.action='./PrintDriver.php';submit();" style="float: right;"/>
						<div style="clear:both;"></div>
						<?php
							if($_SESSION['profileType'] == "APPLICANT") $profileID = $_SESSION['profileID'];
							else $profileID = "";
							
							$drivers = $rm->retrieveDrivers($profileID); 
							$data = array();
							$target = "../files/profile/";
							$row = mysqli_fetch_assoc($drivers);
							if($row != null)
							{
								echo "
									<table id='result' width='100%'>
										<tr>
											<th></th>
											<th class='sortable' onclick='javascript:sortColumns(\"o.lastName, o.givenName, o.middleName\");'>Operator</th>
											<th class='sortable' onclick='javascript:sortColumns(\"driverID\");'>Driver ID</th>
											<th class='sortable' onclick='javascript:sortColumns(\"p.lastName, p.givenName, p.middleName\");'>Name</th>
											<th class='sortable' onclick='javascript:sortColumns(\"p.licenseNumber\");'>License Number</th>
											";?>
											<? if ($_SESSION['profileType']!="INVESTIGATION"){
											echo "<th></th>";
											echo "<th></th>";
											 } 
									echo "	</tr>
								";
							}
							while($row != null)
							{
								array_push($data, $row);
								echo "
									<tr>
										<td><img src='".$target.$row['picture']."' width='100'></td>
										<td>".$row['operatorLastName'].", ".$row['operatorGivenName']." ".$row['operatorMiddleName']."</td>
										<td align='center'>
								";
											if($row['block'] == 1){
												echo "<img title='Cannot Renew Driver ID. User is blocked' src='".$root."assets/images/icons/refresh24_x.png' />";
											}elseif($row['driverID'] == ""){
												echo "<a href='RenewDriverID.php/?id=".$row['profileID']."'><img title='Renew Driver ID' src='".$root."assets/images/icons/refresh24.png' /></a>";
											}else{
												echo "<span style='cursor:pointer;' onclick='alert(\"DRIVER INFO:\\n\\nOperator: ".$row['operatorLastName'].", ".$row['operatorGivenName']." ".$row['operatorMiddleName']."\\nDriver Name: ".$row['lastName'].", ".$row['givenName']." ".$row['middleName']."\\nAge: ".$row['age']."\\nCivil Status: ".ucwords(strtolower($row['civilStatus']))."\\nHome Address: ".$row['homeAddress']."\\nHome Barangay: ".$row['homeBrgy']."\\nHome Town: ".$row['homeTown']."\\nProvince: ".$row['homeProvince']."\\nLicense Number: ".$row['licenseNumber']."\\nLicense Expiry Date: ".$row['licenseExpiryDate']."\\nSpouse Name: ".$row['spouseName']."\\nSpouse Occupation: ".$row['spouseOccupation']."\")'>".$row['driverID']."</span>";
											}
								echo "
										</td>
										<td>".$row['lastName'].", ".$row['givenName']." ".$row['middleName']."</td>
										<td>".$row['licenseNumber']."</td>
								";
									if ($_SESSION['profileType']!="INVESTIGATION"){
								
										if($_SESSION['profileType'] == "APPLICANT"){
											if($row['block'] == 0){
												echo "<td align='center'><span style='cursor:pointer;' onclick='javascript:updateRequest(".$row['profileID'].")'><img src='".$root."assets/images/icons/edit24.png'></span></td>";
												echo "<td align='center'><a href='../Driver/DeleteDriver.php/?id=".$row['profileID']."'><img src='".$root."assets/images/icons/delete24.png'></a></td>";
											}else{
												echo "<td align='center'><img title='Cannot edit. Driver is blocked.' src='".$root."assets/images/icons/edit24_x.png'></td>";
												echo "<td align='center'><img title='Cannot delete. Driver is blocked.' src='".$root."assets/images/icons/delete24_x.png'></td>";
											}
										}else{
											if($row['block'] == 0){
												echo "<td align='center'><a href='../Driver/Update/?id=".$row['profileID']."'><img src='".$root."assets/images/icons/edit24.png'></a></td>";
												echo "<td align='center'><a href='../Driver/DeleteDriver.php/?id=".$row['profileID']."'><img src='".$root."assets/images/icons/delete24.png'></a></td>";
											}else{
												echo "<td align='center'><img title='Cannot edit. Driver is blocked.' src='".$root."assets/images/icons/edit24_x.png'></td>";
												echo "<td align='center'><img title='Cannot delete. Driver is blocked.' src='".$root."assets/images/icons/delete24_x.png'></td>";
											}
										}
									}
								echo "
									</tr>
								";
								$row = mysqli_fetch_array($drivers, MYSQLI_ASSOC);
							}
							$_SESSION['pData'] = $data;
							echo "</table>";
						?>
						<script language="javascript">
							function updateRequest(id)
							{
								var message = prompt("List the new values to update");
								
								jQuery("#notes").val(message);
								
								document.getElementById("viewForm").action="../Driver/UpdateRequest.php/?id="+id;
								
								jQuery("#viewForm").submit();
							}
						</script>
					</div>
					<input type="hidden" id="searchCombine" name="searchCombine" value="" />
					<input type="hidden" id="searchKeyword" name="searchKeyword" value="" />
					<input type="hidden" id="searchFilters" name="searchFilters" value="" />
					<input type="hidden" id="sortColumn" name="sortColumn" value="" />
					<input type="hidden" id="notes" name="notes" value="" />
				</form>
				
				<?php
				if($_SESSION['profileType'] == "APPLICANT"){ // driver violations
				?>
					<form action="" method="post">
						<?php 
						$violations = $rm->retrieveOperatorDriverViolation($_SESSION['profileID']); 
						$row = mysqli_fetch_assoc($violations);
						if($row != null)
						{
						?>
							<br><br>
							<p><strong>Driver Violations</strong></p>
							
							<table id="result">
								<tr>
									<th>Driver ID</th>
									<th>Plate Number</th>
									<th>Violation</th>
									<th>Date</th>
									<th>Penalty</th>
								</tr>
						<?php 
						}
						
							while($row != null)
							{
								?>
								<tr>
									<td><?php echo $row['driverID']; ?></td>
									<td><?php echo $row['plateNumber']; ?></td>
									<td><?php echo $row['violation']; ?></td>
									<td><?php echo $row['violationDate']; ?></td>
									<td><?php echo $row['penalty']; ?></td>
								</tr>
								<?php
								$row = mysqli_fetch_assoc($violations);
							}
						
						
						if($row != null)
						{
						?>
							</table>
						<?php
						}
						?>
					</form>
				<?php
				}else{
				?>
					<form name="viewRequest" id="viewRequest" action="UpdateRequest.php" method="post">
						<?php
						$requests = $rm->retrieveRequests();
						$row = mysqli_fetch_assoc($requests);
						
						if($row != null)
						{
						?>
							<br><br>
							<p><strong>Requests</strong></p>
							
							<table id="result">
								<tr>
									<th>Request</th>
									<th>Notes</th>
									<th></th>
								</tr>
						<?php
						}
						
						while($row != null)
						{
							?>
							<tr>
								<td>
									<?php
									if($row['request'] == "delete")
									{
										echo "Request: Delete Driver" . "<br>";
										echo "Operator: " . $row['oLastName'] . ", " . $row['oGivenName'] . " " . $row['oMiddleName'] . "<br>";
										echo "Driver: " . $row['dLastName'] . ", " . $row['dGivenName'] . " " . $row['dMiddleName'];
									}
									elseif($row['request'] == "edit")
									{
										echo "Request: Update Driver" . "<br>";
										echo "Operator: " . $row['oLastName'] . ", " . $row['oGivenName'] . " " . $row['oMiddleName'] . "<br>";
										echo "Driver: " . $row['dLastName'] . ", " . $row['dGivenName'] . " " . $row['dMiddleName'];
									}
									?>
								</td>
								<td><?php echo $row['notes']; ?></td>
								<td><a title="remove request" href="./DeleteRequest.php/?id=<?php echo $row['id']; ?>"><img src="<?php echo $root."assets/images/icons/delete24.png"; ?>"></a></td>
							</tr>
							<?php
							$row = mysqli_fetch_assoc($requests);

						}
						
						if($row != null)
						{
						?>
							</table>
						<?php
						}
						?>
					</form>
				<?php
				}
				?>
			</div>
		</div>
	</body>
</html>