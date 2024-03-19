<!--
  - File Name: Vehicle/index.php
  - Program Description: home page
  -->
<?php
	$root = "../"; // root folder
	$pageTitle = "Vehicle";
	$currentMenu = "vehicle";
	
	session_start();
	if(!isset($_SESSION['username'])) header("Location: ../");
	include "../RegistrationManager.php";
	
	$rm = new RegistrationManager();
	
	$searchOptions = ""
		.	"<select class='filter'>"
		.		"<optgroup label='Vehicle'>"
		.			"<option value='vehicleType'>Vehicle Type</option>"
		.			"<option value='plateNumber'>Plate Number</option>"
		.			"<option value='stickerNumber'>Sticker Number</option>"
		.			"<option value='model'>Model of Vehicle</option>"
		.			"<option value='year'>Year Model</option>"
		.			"<option value='motor'>Motor</option>"
		.			"<option value='chassis'>Chassis</option>"
		.			"<option value='color'>Color</option>"
		.		"</optgroup>"
		.		"<optgroup label='Owner'>"
		.			"<option value='lastName'>Last Name</option>"
		.			"<option value='givenName'>Given Name</option>"
		.			"<option value='userName'>Username</option>"
		.			"<option value='emailAddress'>Email Address</option>"
		.			"<option value='homeAddress'>Home Address</option>"
		.			"<option value='homeBrgy'>Home Barangay</option>"
		.			"<option value='homeTown'>Home Town</option>"
		.			"<option value='homeProvince'>Home Province</option>"
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
				
				<?php if($_SESSION['profileType'] == "ADMIN" || $_SESSION['profileType'] == "OVCCA" || $_SESSION['profileType']== "INVESTIGATION"){ ?>
					<div id="searchPanel">
						<form action="javascript:getFilters()" id="searchForm" name="searchForm" method="post">
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
				<?php } ?>
				<form name="viewForm" id="viewForm" method="post" action="">
					<? if($_SESSION['profileType'] != "INVESTIGATION"){ ?>
					<input type="button" value="Add Vehicle" onclick="this.form.action='./Add/';submit();" style="float: right;"/>
					<? } ?>
					<input type="button" value="Print" onclick="this.form.action='./PrintVehicle.php';submit();" style="float: right;"/>
					<div style="clear:both;"></div>
					<div style=''>
						<?php
							if($_SESSION['profileType'] == "ADMIN" || $_SESSION['profileType'] == "OVCCA" || $_SESSION['profileType'] == "CASHIER" || $_SESSION['profileType'] == "INVESTIGATION")
							{
								$vehicles = $rm->retrieveVehicle("");
								$data = array();
								
								if($vehicles == "")
								{
									echo "There are no registered vehicles.";
								}
								else
								{
									$row = mysql_fetch_array($vehicles, MYSQL_ASSOC);
									?>
									<table id="result" width="100%">
										<tr>
											<th class="sortable" onclick="javascript:sortColumns('lastName');">Owner</th>
											<th class="sortable" onclick="javascript:sortColumns('plateNumber');">Plate Number</th>
											<th class="sortable" onclick="javascript:sortColumns('status');">Status</th>
											<!--th class="sortable" onclick="javascript:sortColumns('violation');">Violation</th-->
											<th>Documents</th>
											<?php if($_SESSION['profileType'] != "INVESTIGATION"){ ?>
											<th>Approve / Disapprove</th>
											<th>Delete</th>
											<th>Edit</th>
											<th class="sortable" onclick="javascript:sortColumns('block');">Block</th>
											<? } ?>
										</tr>
										<?php
										while($row != null)
										{
											array_push($data, $row);
											?>
											<tr>
												<td><?php echo $row['lastName'] . ", " . $row['givenName'] . " " . $row['middleName']; ?></td>
												<td>
													<span style="cursor:pointer;" onclick="alert('VEHICLE INFO:\n\nVehicle Type: <?php echo ucwords(strtolower($row['vehicleType'])); ?>\nOwner: <?php echo ucwords(strtolower($row['lastName'])).', '.ucwords(strtolower($row['givenName'])).' '.ucwords(strtolower($row['middleName']));?>\nPlate Number: <?php echo $row['plateNumber'];?>\nModel/Type of Vehicle: <?php echo ucwords(strtolower($row['model']));?>\nYear Model: <?php echo $row['year'];?>\nMotor Number: <?php echo $row['motor'];?>\nChassis Number: <?php echo $row['chassis'];?>\nColor: <?php echo $row['color'];?>\nYear of Last Sticker: <?php echo $row['lastStickerIssuedDate'];?>\nLast Sticker Number: <?php echo $row['lastStickerNumber'];?>');">
														<?php echo $row['plateNumber']; ?>
													</span>
												</td>
												<td align="center">
													<?php
														if($row['status'] == "released"){
															echo $row['status']."<br>(".$row['stickerNumber'].")";
														}elseif($row['paid'] != "0000-00-00"){
															echo "paid";
														}else{
															echo $row['status'].($row['status']=="disapproved" ? ("<br>(".$row['condition']).")" : "");
														}
													?>
												</td>
												<!--td align="center"><!--?php echo $row['violation']; ?></td-->
												<td>
													<?php
														if($row['certificationRegistration'] != "") echo "<a title='Certificate of Registration' target='_blank' href='".$root."files"."/".$row['certificationRegistration']."'>CR</a>" . ",";
														if($row['receiptRegistration'] != "") echo "<a title='Official Receipt of Registration' target='_blank' href='".$root."files"."/".$row['receiptRegistration']."'>OR</a>" . ",";
														if($row['LTFRBFranchise'] != "") echo "<a title='LTFRB Franchise' target='_blank' href='".$root."files"."/".$row['LTFRBFranchise']."'>LR</a>" . ",";
														if($row['insurance'] != "") echo "<a title='Insurance' target='_blank' href='".$root."files"."/".$row['insurance']."'>IN</a>" . ",";
														if($row['deed'] != "") echo "<a title='Deed of Sale' target='_blank' href='".$root."files"."/".$row['deed']."'>DS</a>";
													?>
												</td>
												<?php if($_SESSION['profileType'] != "INVESTIGATION"){ ?>
												<td align="center"> 
													<?php if($row['block'] == 1){ ?>
														
													<?php }elseif($row['status'] == "approved" || $row['status'] == "released" || $row['status'] == "disapproved"){ ?>
														
													<?php }elseif($row['result'] == "fail"){?>
														<img title="vehicle inspection failed" src="<?php echo $root."assets/images/icons/check24_x.png"; ?>">
														<img title="vehicle inspection failed" src="<?php echo $root."assets/images/icons/delete24_x.png"; ?>">
													<?php }elseif($row['result'] == "pass"){?>
														<a href="javascript:statusMessage(1, '<?php echo $row['plateNumber']; ?>');"><img title="Approved vehicle application" src="<?php echo $root."assets/images/icons/check24.png"; ?>"></a>
														<a href="javascript:statusMessage(0, '<?php echo $row['plateNumber']; ?>');"><img title="Disapproved vehicle application" src="<?php echo $root."assets/images/icons/delete24.png"; ?>"></a>
													<?php }else{ ?>
														<img title="vehicle not inspected yet" src="<?php echo $root."assets/images/icons/check24_x.png"; ?>">
														<img title="vehicle not inspected yet" src="<?php echo $root."assets/images/icons/delete24_x.png"; ?>">
													<?php } ?>
												</td>
												<td>
													<?php
														if($_SESSION['profileType'] == "ADMIN" || $_SESSION['profileType'] == "OVCCA"){
															echo "<a href='./DeleteVehicle.php/?pn=".$row['plateNumber']."'><img title='Delete vehicle.' src='".$root."assets/images/icons/delete24.png'></a>";
														}elseif($row['block'] == 1){
															echo "<img title='Vehicle is blocked.' src='".$root."assets/images/icons/delete24_x.png'>";
														}elseif($row['status'] == "approved" || $row['status'] == "released"){
															echo "<img title='Vehicle is already approved.' src='".$root."assets/images/icons/delete24_x.png'>";
														}else{
															echo "<a href='./DeleteVehicle.php/?pn=".$row['plateNumber']."'><img title='Delete vehicle.' src='".$root."assets/images/icons/delete24.png'></a>";
														}
													?>
												</td>
												
												<td>
													<?php
														if($row['block'] == 1){
															//echo "<img title='vehicle is blocked' src='".$root."assets/images/icons/edit24_x.png'>";
														}elseif($row['status'] == "approved" || $row['status'] == "released"){
															//echo "<img title='vehicle already approved' src='".$root."assets/images/icons/edit24_x.png'>";
														}else{
															echo "<a href='./Update/?pn=".$row['plateNumber']."'><img title='Edit vehicle.' src='".$root."assets/images/icons/edit24.png'></a>";
														}
													?>
												</td>
												<td>
													<?php 
														if($row['block'] == 0){
															echo "<a href='BlockVehicle.php/?pn=".$row['plateNumber']."&b=1'><img title='Click to block vehicle.' src='".$root."assets/images/icons/unlock24.png'>";
														}else{
															echo "<a href='BlockVehicle.php/?pn=".$row['plateNumber']."&b=0'><img title='Click to unblock vehicle.' src='".$root."assets/images/icons/lock24.png'>";
														}
													?>
												</td>
												<? } ?>
											</tr>
											<?php
											$row = mysql_fetch_array($vehicles, MYSQL_ASSOC);
										}
										?>
									</table>
									<?php
								}
								$_SESSION['pData'] = $data;
							}else{
								$rm->showVehicle($_SESSION['profileID']); 
							}
						?>
					</div>
					<input type="hidden" name="disapprovedNote" id="disapprovedNote" value="" />
					<input type="hidden" id="searchCombine" name="searchCombine" value="" />
					<input type="hidden" id="searchKeyword" name="searchKeyword" value="" />
					<input type="hidden" id="searchFilters" name="searchFilters" value="" />
					<input type="hidden" id="sortColumn" name="sortColumn" value="" />
				</form>
			</div>
		</div>
	</body>
</html>

<?php
	if(isset($_SESSION['searchnull'])) unset($_SESSION['searchnull']);
	if(isset($_SESSION['message'])) unset($_SESSION['message']);
?>
<script>
	function statusMessage(status, plateno){
		var message = "";
		if(status == 0){
			var message = prompt("Reason for disapproved application:");
			
			if(message == ""){
				alert("Please indicate why it's disapproved:");
				statusMessage(status, plateno)
			}
			else if(!message){
				// do nothing
			}
			else{
				document.getElementById("disapprovedNote").value = message;
				
				document.getElementById("viewForm").action = "./VehicleController.php/?task=status&s="+status+"&pn="+plateno;
				document.getElementById("viewForm").submit();
			}
		}
		else{
			document.getElementById("viewForm").action = "./VehicleController.php/?task=status&s="+status+"&pn="+plateno;
			document.getElementById("viewForm").submit();
		}
	}
</script>