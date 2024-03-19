<!--
  - File Name: Driver/Add/index.php
  - Program Description: form for new driver
  -->
<?php
	$root = "../../"; // root folder
	$pageTitle = "Add Driver";
	$currentMenu = "driver";
	
	session_start();
	
	include "../../dbconnection.php";
	
	if(!isset($_SESSION['username'])) header("Location: ../../");
	
	$connect = new dbconnection();
	$con = $connect->connectdb();
	
	$isnull = "<p class='fieldError'>*Required field.</p>";
	$invalid = "<p class='fieldError'>*Should be a non-negative number.</p>";
	$script = "<p class='fieldError'>Illegal input! &ltscript&gt&lt/script&gt</p>";
?>
<html>
	<?php include $root."head.php"; ?>
	
	<body id="newReg">
		<div id='centerArea'>
			<?php include "../../menu.php"; // display menu options ?>
			
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
			
				<h2>Add New Driver</h2>
				
				<!--Form for User Inputs-->
				<form name="info" method="post" onsubmit="return showDetails();" action="NewDriverView.php" enctype="multipart/form-data">
					<?php
						if(isset($_GET['addsuccess']))
							echo "<p class='successNotifier'>The adding of new driver is successful!</p><br/>";
						if(isset($_GET['addnotsuccess']))
							echo "<p class='successNotifier'>Invalid driver details.</p><br/>";
					?>
					<?php
						if(($_SESSION['profileType'] != "ADMIN") || ($_SESSION['profileType'] != "OVCCA")){
							echo "Add new driver for operator: ".$_SESSION['username'];
						}
					?>
					
					<table>
						<?php if($_SESSION['profileType'] == "ADMIN" || $_SESSION['profileType'] == "OVCCA"){ ?>
							<tr>
								<td>Operator Username</td>
								<td><input type="text" name="username" id="username" value="<?php echo isset($_SESSION['addusername']) ? $_SESSION['addusername'] : ""; ?>"></td>
								<td>
								<?php
									if(isset($_SESSION['usernameisnull'])) echo $isnull;
									if(isset($_SESSION['scriptsurname'])) echo $script;
								?>
								</td>
							</tr>
						<?php } ?>
						<tr>
							<td><label for="surname">Surname</label></td>
							<td><input type="text" name="surname" id="surname" value="<?php echo isset($_SESSION['addsurname']) ? $_SESSION['addsurname'] : ""; ?>"></td>
							<td>
							<?php
								if(isset($_SESSION['surnameisnull'])) echo $isnull;
								if(isset($_SESSION['scriptsurname'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="givenName">Given Name</label></td>
							<td><input type="text" name="givenName" id="givenName" value="<?php echo isset($_SESSION['addgivenname']) ? $_SESSION['addgivenname'] : ""; ?>"></td>
							<td>
							<?php
								if(isset($_SESSION['givennameisnull'])) echo $isnull;
								if(isset($_SESSION['scriptgivenname'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="middleName">Middle Name</label></td>
							<td><input type="text" name="middleName" id="middleName" value="<?php echo isset($_SESSION['addmiddlename']) ? $_SESSION['addmiddlename'] : ""; ?>"></td>
							<td>
							<?php
								if(isset($_SESSION['middlenameisnull'])) echo $isnull;
								if(isset($_SESSION['scriptmiddlename'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="age">Age</label></td>
							<td><input type="text" name="age" id="age" value="<?php echo isset($_SESSION['addage']) ? $_SESSION['addage'] : ""; ?>"></td>
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
									<option value="single" <?php if((isset($_SESSION['addcivilstatus'])) && ($_SESSION['addcivilstatus']=='single')) echo "selected='selected'";?>>Single</option>
									<option value="married" <?php if((isset($_SESSION['addcivilstatus'])) && ($_SESSION['addcivilstatus']=='married')) echo "selected='selected'";?>>Married</option>
									<option value="divorced" <?php if((isset($_SESSION['addcivilstatus'])) && ($_SESSION['addcivilstatus']=='divorced')) echo "selected='selected'";?>>Divorced</option>
									<option value="separated" <?php if((isset($_SESSION['addcivilstatus'])) && ($_SESSION['addcivilstatus']=='separated')) echo "selected='selected'";?>>Separated</option>
									<option value="widowed" <?php if((isset($_SESSION['addcivilstatus'])) && ($_SESSION['addcivilstatus']=='widowed')) echo "selected='selected'";?>>Widowed</option>
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
							<td><input type="text" name="homeAddress" id="homeAddress" value="<?php echo isset($_SESSION['addhomeaddress']) ? $_SESSION['addhomeaddress'] : ""; ?>"></td>
							<td>
							<?php
								if(isset($_SESSION['homeaddressisnull'])) echo $isnull;
								if(isset($_SESSION['scripthomeaddress'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="homeBarangay">Home Barangay</label></td>
							<td><input type="text" name="homeBarangay" id="homeBarangay" value="<?php echo isset($_SESSION['addbarangay']) ? $_SESSION['addbarangay'] : ""; ?>"></td>
							<td>
							<?php
								if(isset($_SESSION['barangayisnull'])) echo $isnull;
								if(isset($_SESSION['scriptbarangay'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="homeTown">Home Town</label></td>
							<td><input type="text" name="homeTown" id="homeTown" value="<?php echo isset($_SESSION['addhometown']) ? $_SESSION['addhometown'] : ""; ?>"></td>
							<td>
							<?php
								if(isset($_SESSION['hometownisnull'])) echo $isnull;
								if(isset($_SESSION['scripthometown'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="homeProvince">Province</label></td>
							<td><input type="text" name="homeProvince" id="homeProvince" value="<?php echo isset($_SESSION['addprovince']) ? $_SESSION['addprovince'] : ""; ?>"></td>
							<td>
							<?php
								if(isset($_SESSION['provinceisnull'])) echo $isnull;
								if(isset($_SESSION['scriptprovince'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="licenseNumber">License Number</label></td>
							<td><input type="text" name="licenseNumber" id="licenseNumber" value="<?php echo isset($_SESSION['addlicenseno']) ? $_SESSION['addlicenseno'] : ""; ?>"></td>
							<td>
							<?php
								if(isset($_SESSION['licensenoisnull'])) echo $isnull;
								if(isset($_SESSION['scriptlicenseno'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="validUntil">License Expiry Date (YYYY-MM-DD)</label></td>
							<td><input type="text" name="validUntil" id="validUntil" value="<?php echo isset($_SESSION['addvaliduntil']) ? $_SESSION['addvaliduntil'] : ""; ?>"></td>
							<td>
							<?php
								if(isset($_SESSION['validuntilisnull'])) echo $isnull;
								if(isset($_SESSION['scriptvaliduntil'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="spouseName">Spouse Name</label></td>
							<td><input type="text" name="spouseName" id="spouseName" value="<?php echo isset($_SESSION['addspousename']) ? $_SESSION['addspousename'] : ""; ?>"></td>
							<td>
							<?php
								if(isset($_SESSION['spousenameisnull'])) echo $isnull;
								if(isset($_SESSION['scriptspousename'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="spouseOccupation">Spouse Occupation</label></td>
							<td><input type="text" name="spouseOccupation" id="spouseOccupation" value="<?php echo isset($_SESSION['addspouseoccup']) ? $_SESSION['addspouseoccup'] : ""; ?>"></td>
							<td>
							<?php
								if(isset($_SESSION['spouseoccupisnull'])) echo $isnull;
								if(isset($_SESSION['scriptspouseoccup'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="picture">2x2 Picture</label></td>
							<td><input type="file" name="picture" id="picture" value=""></td>
							<td>
							<?php
								if(isset($_SESSION['pictureisnull'])) echo $isnull;
								if(isset($_SESSION['scriptpicture'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="licensepic">Scanned image of License:</label></td>
							<td><input type="file" name="licensepic" id="licensepic" value=""></td>
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
					<input type="reset" name="clear" value="Clear"/>
					<br/>
				</form>
			</div>
		</div>
	</body>
</html>
<?php
	$connect->closeconnection($con);
	
	unset($_SESSION['addsurname']);
	unset($_SESSION['addgivenname']);
	unset($_SESSION['addmiddlename']);
	unset($_SESSION['addage']);
	unset($_SESSION['addcivilstatus']);
	unset($_SESSION['addhomeaddress']);
	unset($_SESSION['addbarangay']);
	unset($_SESSION['addhometown']);
	unset($_SESSION['addprovince']);
	unset($_SESSION['addlicenseno']);
	unset($_SESSION['addvaliduntil']);
	unset($_SESSION['addspousename']);
	unset($_SESSION['addspouseoccup']);
	if(isset($_SESSION['addusername'])) unset($_SESSION['addusername']);
	
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
	
	if(isset($_SESSION['usernameisnull'])) unset($_SESSION['usernameisnull']);
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
	if(isset($_SESSION['pictureisnull'])) unset($_SESSION['pictureisnull']);
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