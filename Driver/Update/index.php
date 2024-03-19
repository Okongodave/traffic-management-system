<!--
 - File Name: Driver/Update.php
 - Program Description: form for editing driver information
 -->
<?php
	$root = "../../"; // root folder
	$pageTitle = "Update Driver";
	$currentMenu = "driver";
	
	session_start();
	include $root . "dbconnection.php";
	
	if(!isset($_SESSION['username']))header("Location: ".$root);
	
	$connect = new dbconnection();
	$con = $connect->connectdb();
	
	$_SESSION['driverProfileID'] = $driverProfileID = isset($_GET['id']) ? $_GET['id'] : "";
	
	if(isset($_SESSION['error'])){
		
	}else{
		$query = "
			SELECT
				*
			FROM
				table_driver d
			INNER JOIN
				table_profile p ON p.profileID = d.driver
			WHERE
				p.profileID='$driverProfileID'
		";
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		
		$_SESSION['editdriverprofileid'] = $driverProfileID;
		$_SESSION['editlastname'] = $row['lastName'];
		$_SESSION['editgivenname'] = $row['givenName'];
		$_SESSION['editmiddlename'] = $row['middleName'];
		$_SESSION['editage'] = $row['age'];
		$_SESSION['editcivilstatus'] = $row['civilStatus'];
		$_SESSION['edithomeaddress'] = $row['homeAddress'];
		$_SESSION['edithomebarangay'] = $row['homeBrgy'];
		$_SESSION['edithometown'] = $row['homeTown'];
		$_SESSION['edithomeprovince'] = $row['homeProvince'];
		$_SESSION['editlicenseno'] = $row['licenseNumber'];
		$_SESSION['editlicenseexpirydate'] = $row['licenseExpiryDate'];
		$_SESSION['editspousename'] = $row['spouseName'];
		$_SESSION['editspouseoccupation'] = $row['spouseOccupation'];
		$_SESSION['editpicture'] = $row['picture'];
		$_SESSION['editlicensepic'] = $row['licensepic'];
	}
	
	$isnull = "<p class='fieldError'>*Required field</p>";
	$invalid = "<p class='fieldError'>*Should be a non-negative number</p>";
	$script = "<p class='fieldError'>Illegal input! &ltscript&gt&lt/script&gt</p>";
?>

<html>
	<?php include $root."head.php"; ?>

	<body>
		<div id='centerArea'>
			<?php include $root."menu.php"; // display menu options ?>

			<div id='content' style='top:0'>
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
				
				<h2>Driver Editor</h2>
				
				<?php
					if(isset($_GET['editsuccess']))
						echo "<p class='successNotifier'>Updating driver information is successful!</p><br/>";
					if(isset($_GET['editnotsuccess']))
						echo "<p class='successNotifier'>Invalid driver details.</p><br/>";
				?>
				<?php
				echo "<table><tr><td>Profile Image</td><td>Scanned License</td></tr>";
				echo "<tr><td><img src='".$root."files/profile/".$_SESSION['editpicture']."' width='100'></td><td><img <img src='".$root."files/license/".$_SESSION['editlicensepic']."' width='100'></td></tr></table>";
				?>
				<?php
					//echo "Edit information for driver with license number: ".$licenseNo;
				?>
				
				<!-- Form for Driver Editing-->
				<form name="editDriverForm" method="post" onsubmit="return showDetails();" action="EditDriverView.php" enctype="multipart/form-data">
					<table>
						<tr>
							<td><label for="surname">Surname</label></td>
							<td><input type="text" name="surname" id="surname" value="<?php echo isset($_SESSION['editlastname']) ? $_SESSION['editlastname'] : "";?>"></td>
							<td>
							<?php
								if(isset($_SESSION['surnameisnull'])) echo $isnull;
								if(isset($_SESSION['scriptsurname'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="givenName">Given Name</label></td>
							<td><input type="text" name="givenName" id="givenName" value="<?php echo isset($_SESSION['editgivenname']) ? $_SESSION['editgivenname'] : "";?>"></td>
							<td>
							<?php
								if(isset($_SESSION['givennameisnull'])) echo $isnull;
								if(isset($_SESSION['scriptgivenname'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="middleName">Middle Name</label></td>
							<td><input type="text" name="middleName" id="middleName" value="<?php echo isset($_SESSION['editmiddlename']) ? $_SESSION['editmiddlename'] : "";?>"></td>
							<td>
							<?php
								if(isset($_SESSION['middlenameisnull'])) echo $isnull;
								if(isset($_SESSION['scriptmiddlename'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="age">Age</label></td>
							<td><input type="text" name="age" id="age" value="<?php echo isset($_SESSION['editage']) ? $_SESSION['editage'] : "";?>"></td>
							<td>
							<?php
								if(isset($_SESSION['ageisnull'])) echo $isnull;
								if(isset($_SESSION['scriptage'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="civilStatus">Civil Status</label></td>
							<td>
								<select id="civilStatus" name="civilStatus">
									<option value="single" <?php if((isset($_SESSION['editcivilstatus'])) && ($_SESSION['editcivilstatus']=='SINGLE')) echo "selected='selected'";?>>Single</option>
									<option value="married" <?php if((isset($_SESSION['editcivilstatus'])) && ($_SESSION['editcivilstatus']=='MARRIED')) echo "selected='selected'";?>>Married</option>
									<option value="divorced" <?php if((isset($_SESSION['editcivilstatus'])) && ($_SESSION['editcivilstatus']=='DIVORCED')) echo "selected='selected'";?>>Divorced</option>
									<option value="separated" <?php if((isset($_SESSION['editcivilstatus'])) && ($_SESSION['editcivilstatus']=='SEPARATED')) echo "selected='selected'";?>>Separated</option>
									<option value="widowed" <?php if((isset($_SESSION['editcivilstatus'])) && ($_SESSION['editcivilstatus']=='WIDOWED')) echo "selected='selected'";?>>Widowed</option>
								</select>
							</td>
							<td>
							<?php
								if(isset($_SESSION['civilstatusisnull'])) echo $isnull;
								if(isset($_SESSION['scriptcivilstatus'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="homeAddress">Home Address</label></td>
							<td><input type="text" name="homeAddress" id="homeAddress" value="<?php echo isset($_SESSION['edithomeaddress']) ? $_SESSION['edithomeaddress'] : "";?>"></td>
							<td>
							<?php
								if(isset($_SESSION['homeaddressisnull'])) echo $isnull;
								if(isset($_SESSION['scripthomeaddress'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="homeBarangay">Home Barangay</label></td>
							<td><input type="text" name="homeBarangay" id="homeBarangay" value="<?php echo isset($_SESSION['edithomebarangay']) ? $_SESSION['edithomebarangay'] : "";?>"></td>
							<td>
							<?php
								if(isset($_SESSION['barangayisnull'])) echo $isnull;
								if(isset($_SESSION['scriptbarangay'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="homeTown">Home Town</label></td>
							<td><input type="text" name="homeTown" id="homeTown" value="<?php echo isset($_SESSION['edithometown']) ? $_SESSION['edithometown'] : "";?>"></td>
							<td>
							<?php
								if(isset($_SESSION['hometownisnull'])) echo $isnull;
								if(isset($_SESSION['scripthometown'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="homeProvince">Province</label></td>
							<td><input type="text" name="homeProvince" id="homeProvince" value="<?php echo isset($_SESSION['edithomeprovince']) ? $_SESSION['edithomeprovince'] : "";?>"></td>
							<td>
							<?php
								if(isset($_SESSION['provinceisnull'])) echo $isnull;
								if(isset($_SESSION['scriptprovince'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="licenseNumber">License Number</label></td>
							<td><input type="text" name="licenseNumber" id="licenseNumber" value="<?php echo isset($_SESSION['editlicenseno']) ? $_SESSION['editlicenseno'] : "";?>"></td>
							<td>
							<?php
								if(isset($_SESSION['licensenoisnull'])) echo $isnull;
								if(isset($_SESSION['scriptlicenseno'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="validUntil">Valid Until (YYYY-MM-DD)</label></td>
							<td><input type="text" name="validUntil" id="validUntil" value="<?php echo isset($_SESSION['editlicenseexpirydate']) ? $_SESSION['editlicenseexpirydate'] : "";?>"></td>
							<td>
							<?php
								if(isset($_SESSION['validuntilisnull'])) echo $isnull;
								if(isset($_SESSION['scriptvaliduntil'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="spouseName">Spouse Name</label></td>
							<td><input type="text" name="spouseName" id="spouseName" value="<?php echo isset($_SESSION['editspousename']) ? $_SESSION['editspousename'] : "";?>"></td>
							<td>
							<?php
								if(isset($_SESSION['spousenameisnull'])) echo $isnull;
								if(isset($_SESSION['scriptspousename'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="spouseOccupation">Spouse Occupation</label></td>
							<td><input type="text" name="spouseOccupation" id="spouseOccupation" value="<?php echo isset($_SESSION['editspouseoccupation']) ? $_SESSION['editspouseoccupation'] : "";?>"></td>
							<td>
							<?php
								if(isset($_SESSION['spouseoccupisnull'])) echo $isnull;
								if(isset($_SESSION['scriptspouseoccup'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="picture">2x2 Picture</label></td>
							<td>
								<?php
									echo "<input type='hidden' name='pictureVal' value='".$_SESSION['editpicture']."'>";
									echo "<input type='file' name='picture' id='picture' value='' disabled='disabled'>";
									echo "&nbsp;&nbsp;&nbsp;";
									echo "<input type='checkbox' name='pictureCheck' id='pictureCheck' value='1'>update file?";
								?>
								<script>
									jQuery("#pictureCheck").change(function(){
										if(jQuery("#pictureCheck").attr("checked")){
											jQuery("#picture").prop('disabled', false);
										}else{
											jQuery("#picture").prop('disabled', true);
										}
									});
								</script>
							</td>
							<td>
							<?php
								if(isset($_SESSION['pictureisnull'])) echo $isnull;
								if(isset($_SESSION['scriptpicture'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="licensepic">Scanned image of license:</label></td>
							<td>
								<?php
									echo "<input type='hidden' name='licensepicVal' value='".$_SESSION['editlicensepic']."'>";
									echo "<input type='file' name='licensepic' id='licensepic' value='' disabled='disabled'>";
									echo "&nbsp;&nbsp;&nbsp;";
									echo "<input type='checkbox' name='licensepicCheck' id='licensepicCheck' value='1'>update file?";
								?>
								<script>
									jQuery("#licensepicCheck").change(function(){
										if(jQuery("#licensepicCheck").attr("checked")){
											jQuery("#licensepic").prop('disabled', false);
										}else{
											jQuery("#licensepic").prop('disabled', true);
										}
									});
								</script>
							</td>
							<td>
							<?php
								if(isset($_SESSION['licensepicisnull'])) echo $isnull;
								if(isset($_SESSION['scriptlicensepic'])) echo $script;
							?>
							</td>
						</tr>
					</table>
					<br />
					<input type="submit" name="submit" value="Submit"/>
					<br/>
				</form>
			</div>
		</div>
	</body>
</html>
<?php
	$connect->closeconnection($con);
	
	if(isset($_SESSION['error'])) unset($_SESSION['error']);
	
	unset($_SESSION['editsurname']);
	unset($_SESSION['editgivenname']);
	unset($_SESSION['editmiddlename']);
	unset($_SESSION['editage']);
	unset($_SESSION['editcivilstatus']);
	unset($_SESSION['edithomeaddress']);
	unset($_SESSION['editbarangay']);
	unset($_SESSION['edithometown']);
	unset($_SESSION['editprovince']);
	unset($_SESSION['editlicenseno']);
	unset($_SESSION['editvaliduntil']);
	unset($_SESSION['editspousename']);
	unset($_SESSION['editspouseoccup']);
	
	if(isset($_SESSION['scriptsurname'])) unset($_SESSION['scriptsurname']);
	if(isset($_SESSION['scriptgivenname'])) unset($_SESSION['scriptgivenname']);
	if(isset($_SESSION['scriptmiddlename'])) unset($_SESSION['scriptmiddlename']);
	if(isset($_SESSION['scriptage'])) unset($_SESSION['scriptage']);
	if(isset($_SESSION['scriptcivilstatus'])) unset($_SESSION['scriptcivilstatus']);
	if(isset($_SESSION['scripthomeaddress'])) unset($_SESSION['scripthomeaddress']);
	if(isset($_SESSION['scriptbarangay'])) unset($_SESSION['scriptbarangay']);
	if(isset($_SESSION['scripthometown'])) unset($_SESSION['scripthometown']);
	if(isset($_SESSION['scriptprovince'])) unset($_SESSION['scriptprovince']);
	if(isset($_SESSION['scriptlicenseno'])) unset($_SESSION['scriptlicenseno']);
	if(isset($_SESSION['scriptvaliduntil'])) unset($_SESSION['scriptvaliduntil']);
	if(isset($_SESSION['scriptspousename'])) unset($_SESSION['scriptspousename']);
	if(isset($_SESSION['scriptspouseoccup'])) unset($_SESSION['scriptspouseoccup']);
	
	if(isset($_SESSION['surnameisnull'])) unset($_SESSION['surnameisnull']);
	if(isset($_SESSION['givennameisnull'])) unset($_SESSION['givennameisnull']);
	if(isset($_SESSION['middlenameisnull'])) unset($_SESSION['middlenameisnull']);
	if(isset($_SESSION['ageisnull'])) unset($_SESSION['ageisnull']);
	if(isset($_SESSION['civilstatusisnull'])) unset($_SESSION['civilstatusisnull']);
	if(isset($_SESSION['homeaddressisnull'])) unset($_SESSION['homeaddressisnull']);
	if(isset($_SESSION['barangayisnull'])) unset($_SESSION['barangayisnull']);
	if(isset($_SESSION['hometownisnull'])) unset($_SESSION['hometownisnull']);
	if(isset($_SESSION['provinceisnull'])) unset($_SESSION['provinceisnull']);
	if(isset($_SESSION['licensenoisnull'])) unset($_SESSION['licensenoisnull']);
	if(isset($_SESSION['validuntilisnull'])) unset($_SESSION['validuntilisnull']);
	if(isset($_SESSION['spousenameisnull'])) unset($_SESSION['spousenameisnull']);
	if(isset($_SESSION['spouseoccupisnull'])) unset($_SESSION['spouseoccupisnull']);
?>
<script language="javascript" type="text/javascript">
	function showDetails(){
		var message = "PLEASE REVIEW INFORMATION BEFORE SUBMITTING" + "\n\n";
		
		var username = jQuery("input#username").val();
		var surname = jQuery("input#surname").val();
		var givenName = jQuery("input#givenName").val();
		var middleName = jQuery("input#middleName").val();
		var age = jQuery("input#age").val();
		var civilStatus = jQuery("select#civilStatus").val();
		var homeAddress = jQuery("input#homeAddress").val();
		var homeBarangay = jQuery("input#homeBarangay").val();
		var homeTown = jQuery("input#homeTown").val();
		var homeProvince = jQuery("input#homeProvince").val();
		var licenseNumber = jQuery("input#licenseNumber").val();
		var validUntil = jQuery("input#validUntil").val();
		var spouseName = jQuery("input#spouseName").val();
		var spouseOccupation = jQuery("input#spouseOccupation").val();
		
		message += "Username: " + username + "\n"
			+ "Surname: " + surname + "\n"
			+ "given Name: " + givenName + "\n"
			+ "Middle Name: " + middleName + "\n"
			+ "Age: " + age + "\n"
			+ "Civil Status: " + civilStatus + "\n"
			+ "Home Address: " + homeAddress + "\n"
			+ "Home Barangay: " + homeBarangay + "\n"
			+ "Home Town: " + homeTown + "\n"
			+ "Home Province: " + homeProvince + "\n"
			+ "License Number: " + licenseNumber + "\n"
			+ "License Expiry Date: " + validUntil + "\n"
			+ "Spouse Name: " + spouseName + "\n";
			+ "Spouse Occupation: " + spouseOccupation + "\n";
		
		return confirm(message);
	}
</script>