<!--
  - File Name: Violation/index.php
  - Program Description: show violations
  -->
<?php
	$root = "../"; // root folder
	$pageTitle = "Violation";
	$currentMenu = "violation";
	
	//include "../dbconnection.php";
	session_start();
	$_SESSION['printLocation'] = "./Violation/index.php";
	
	if(!isset($_SESSION['username'])) header("Location: ".$root);
	
	include "../RegistrationManager.php";
	$rm = new RegistrationManager();
	
	$connect = new dbconnection();
	$con = $connect->connectdb();
	
	$searchOptions = ""
		. 	"<select class='filter'>"
		.		"<option value='plateNumber'>Plate Number</option>"
		.		"<option value='driverID'>Driver ID</option>"
		.		"<option value='violationDate'>Date</option>"
		.		"<option value='reporter'>Reporter</option>"
		.	"</select>"
		.	"";
?>
<html>
	<?php include $root."head.php"; ?>
	
	<body id="">
		<div id='centerArea'>
			<?php include "../menu.php"; // display menu options ?>
			<div id="content">
				<div id="searchPanel">
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
					<? if ($_SESSION['profileType']!="INVESTIGATION"){?>
					<input type="button" value="Add Violation" onclick="this.form.action='./Add/';submit();" style="float:right;" />
					<?}?>
					<input type="button" value="Print" onclick="this.form.action='./PrintViolation.php';submit();" style="float:right;" />
					<div style="clear:both;"></div>
					<div style=''>
						<?php 
						$profile = $rm->retrieveViolations("approve=1");
						$data = array();
						?>
						<table id="result" width="100%">
							<tr>
								<th class="sortable" onclick="javascript:sortColumns('licenseNumber');">License Number</th>
								<th class="sortable" onclick="javascript:sortColumns('driverID');">Driver ID</th>
								<th class="sortable" onclick="javascript:sortColumns('plateNumber');">Plate Number</th>
								<th class="sortable" onclick="javascript:sortColumns('violation');">Violation</th>
								<th class="sortable" onclick="javascript:sortColumns('violationDate');">Date</th>
								<th class="sortable" onclick="javascript:sortColumns('violationTime');">Time</th>
								<th class="sortable" onclick="javascript:sortColumns('violationLocation');">Location</th>
								<th class="sortable" onclick="javascript:sortColumns('penalty');">Penalty</th>
								<th class="sortable" onclick="javascript:sortColumns('reporter');">Reporter</th>
								<th>Evidence</th>
							<? if ($_SESSION['profileType']!="INVESTIGATION"){?>
								<th>Edit</th>
								<th>Delete</th>
							<? } ?>
							</tr>
							<?php
							$target = "../files/evidence/";
							while($row = mysql_fetch_array($profile))
							{
								array_push($data, $row);
								?>
								<tr>
									<td align="center"><?php echo $row['licenseNumber'] == "" ? "---" : $row['licenseNumber']; ?></td>
									<td align="center"><?php echo $row['driverID'] == "0000" ? "---" : $row['driverID']; ?></td>
									<td><?php echo $row['plateNumber']; ?></td>
									<td>
										<span style="cursor:pointer;" onclick="alert('License Number: <?php echo $row['licenseNumber'];?>\nDriver ID: <?php echo $row['driverID'];?>\nPlate Number: <?php echo $row['plateNumber'];?>\nViolation: <?php echo $row['violation'];?>\nViolate Date: <?php echo $row['violationDate'];?>\nViolation Time: <?php echo $row['violationTime'];?>\nViolation Location: <?php echo $row['violationLocation'];?>\nPenalty: <?php echo $row['penalty'];?>\nReporter: <?php echo $row['reporter'];?>\nReporter Contact No: <?php echo $row['reporterContact'];?>');">
											<?php echo $row['violation']; ?>
										</span>
									</td>
									<td><?php echo $row['violationDate']; ?></td>
									<td><?php echo $row['violationTime']; ?></td>
									<td><?php echo $row['violationLocation']; ?></td>
									<td><?php echo $row['penalty']; ?></td>
									<td>
										<?php 
											echo $row['reporter']; 
											if($row['reporterContact'] != ""){
												echo "<br>(" . $row['reporterContact'] . ")";
											}
										?>
									</td>
									<td align="center">
										<?php if($row['evidence'] != ""){ ?>
											<a href="<?php echo $target.$row['evidence']; ?>" target="_blank"><img src="<?php echo $root."assets/images/icons/search24.png"; ?>" /></a>
										<?php } ?>
									</td><? if ($_SESSION['profileType']!="INVESTIGATION"){?>
									<td align="center"><a title="Edit Violation" href="./Update/?vn=<?php echo $row['violationNumber'];?>"><img src="<?php echo $root."assets/images/icons/edit24.png"; ?>" /></a></td>
									<td align="center"><a title="Delete Violation" href="./DeleteViolation.php/?vn=<?php echo $row['violationNumber']; ?>&pn=<?php echo $row['plateNumber']; ?>&id=<?php echo $row['driverID']; ?>"><img src="<?php echo $root."assets/images/icons/delete24.png"; ?>" /></a></td>
									<? } ?>
								</tr>
								<?php
							}
							$_SESSION['pData'] = $data;
							?>
						</table>
					</div>
					<input type="hidden" id="searchCombine" name="searchCombine" value="" />
					<input type="hidden" id="searchKeyword" name="searchKeyword" value="" />
					<input type="hidden" id="searchFilters" name="searchFilters" value="" />
					<input type="hidden" id="sortColumn" name="sortColumn" value="" />
				</form>
				<br><br>
				<p><strong>Violation Reported by Civilians</strong></p>
				<form name="viewForm" id="viewForm" method="post" action="">
					<input type="button" value="Print" onclick="this.form.action='./PrintViolationCivilian.php';submit();" style="float:right;" />
					<div style="clear:both;"></div>
					<div style=''>
						<?php 
						$profile = $rm->retrieveViolations("approve=0"); 
						$data = array();
						?>
						<table id="result" width="100%">
							<tr>
								<th class="sortable" onclick="javascript:sortColumns('licenseNumber');">License Number</th>
								<th class="sortable" onclick="javascript:sortColumns('driverID');">Driver ID</th>
								<th class="sortable" onclick="javascript:sortColumns('plateNumber');">Plate Number</th>
								<th class="sortable" onclick="javascript:sortColumns('violation');">Violation</th>
								<th class="sortable" onclick="javascript:sortColumns('violationDate');">Date</th>
								<th class="sortable" onclick="javascript:sortColumns('reporter');">Reporter</th>
							<? if ($_SESSION['profileType']!="INVESTIGATION"){?>	
								<th>Approve</th>
								<th>Edit</th>
								<th>Delete</th>
							<? } ?>
							</tr>
							<?php
							while($row = mysql_fetch_array($profile))
							{
								array_push($data, $row);
								?>
								<tr>
									<td align="center"><?php echo $row['licenseNumber'] == "" ? "---" : $row['licenseNumber']; ?></td>
									<td align="center"><?php echo $row['driverID'] == "0000" ? "---" : $row['driverID']; ?></td>
									<td align="center"><?php echo $row['plateNumber'] == "" ? "---" : $row['plateNumber']; ?></td>
									<td><?php echo $row['violation']; ?></td>
									<td><?php echo $row['violationDate']; ?></td>
									<td><?php echo $row['reporter']; ?></td>
								<? if ($_SESSION['profileType']!="INVESTIGATION"){?>
									<td align="center"><a title="Approve Violation" href="./ApproveViolation.php/?vn=<?php echo $row['violationNumber'];?>&pn=<?php echo $row['plateNumber'];?>&id=<?php echo $row['driverID'];?>&ln=<?php echo $row['licenseNumber'];?>"><img src="<?php echo $root."assets/images/icons/check24.png"; ?>" /></a></td>
									<td align="center"><a title="Edit Violation" href="./Update/?vn=<?php echo $row['violationNumber'];?>"><img src="<?php echo $root."assets/images/icons/edit24.png"; ?>" /></a></td>
									<td align="center"><a title="Delete Violation" href="./DeleteViolation.php/?vn=<?php echo $row['violationNumber']; ?>"><img src="<?php echo $root."assets/images/icons/delete24.png"; ?>" /></a></td>
								<? } ?>
								</tr>
								<?php
							}
							$_SESSION['pcData'] = $data;
							?>
						</table>
					</div>
					<input type="hidden" id="searchCombine" name="searchCombine" value="" />
					<input type="hidden" id="searchKeyword" name="searchKeyword" value="" />
					<input type="hidden" id="searchFilters" name="searchFilters" value="" />
					<input type="hidden" id="sortColumn" name="sortColumn" value="" />
				</form>
			</div>
		</div>
	</body>
</html>