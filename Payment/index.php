<!--
  - File Name: 
  - Program Description: 
  -->
<?php
	$root = "../"; // root folder
	$pageTitle = "Payment";
	$currentMenu = "payment";
	
	//include "../dbconnection.php";
	session_start();
	
	if(!isset($_SESSION['username'])) header("Location: ".$root);
	
	include "../RegistrationManager.php";
	$rm = new RegistrationManager();
	
	$connect = new dbconnection();
	$con = $connect->connectdb();
	
	$searchOptions = ""
		.	"<select class='filter'>"
		.		"<optgroup label='Vehicle'>"
		.			"<option value='plateNumber'>Plate Number</option>"
		.			"<option value='color'>Color</option>"
		.			"<option value='stickerNumber'>Sticker Number</option>"
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
	
	<body id="">
		<div id='centerArea'>
			<?php include $root."menu.php"; // display menu options ?>
			<div id="content">
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
					<input type="button" value="Print" onclick="this.form.action='./PrintPayment.php';submit();" style="float: right;"/>
					<div style=''>
						<?php
						$profile = $rm->retrieveToPayApplicants();
						$data = array();
						
						if($profile == "")
						{
							echo "There are no vehicle/s that needs to pay.";
						}
						else
						{
							?>
							<table id="result" width="800">
								<tr>
									<th class="sortable" onclick="javascript:sortColumns('plateNumber');">Plate Number</th>
									<th class="sortable" onclick="javascript:sortColumns('lastName, givenName, middleName');">Owner</th>
									<th class="sortable" onclick="javascript:sortColumns('paid');">Paid</th>
								</tr>
								<?php
									while($row = mysql_fetch_array($profile))
									{
										array_push($data, $row);
										?>
										<tr>
											<td><?php echo $row['plateNumber']; ?></td>
											<td><?php echo $row['lastName'] . ", " . $row['givenName'] . " " . $row['middleName']; ?></td>
											<td align="center">
												<?php if($row['vstatus'] == "pending"){ ?>
													<img title="needed approval first" src="<?php echo $root."assets/images/icons/add24_x.png"; ?>" />
												<?php }elseif($row['vstatus'] == "disapproved"){ ?>
													<img title="vehicle disapproved" src="<?php echo $root."assets/images/icons/add24_x.png"; ?>" />
												<?php }elseif($row['paid'] == '0000-00-00'){ ?>
													<a title="pay vehicle registration" href="./PaymentController.php/?pn=<?php echo $row['plateNumber']; ?>"><img src="<?php echo $root."assets/images/icons/add24.png"; ?>" /></a>
												<?php }else{ ?>
													<?php echo $row['paid']; ?>
												<?php } ?>
											</td>
										</tr>
										<?php
									}
									$_SESSION['pData'] = $data;
								?>
							</table>
							<?php
						}
						?>
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