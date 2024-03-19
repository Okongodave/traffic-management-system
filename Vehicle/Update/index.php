<!--
 - File Name: Vehicle/Update.php
 - Program Description: form for editing vehicle information
 -->
<?php
	$root = "../../"; // root folder
	$pageTitle = "Update Vehicle";
	$currentMenu = "vehicle";

	include $root."dbconnection.php";
	session_start();
	
	if(!isset($_SESSION['username']))header("Location: ".$root);
	
	$connect = new dbconnection();
	$con = $connect->connectdb();
	
	$uname = $_SESSION['username'];
	$_SESSION['plateNo'] = $plateNo = isset($_GET['pn']) ? $_GET['pn'] : "";
	
	if(isset($_SESSION['editerror'])){
		/*$plateno = $_SESSION['editplateno'];
		$model = $_POST['editmodel'];
		$year = $_POST['edityear'];
		$motor = $_POST['editmotor'];
		$chassis = $_POST['editchassis'];
		$color = $_POST['editcolor'];
		$stickerdate = $_POST['editstickerdate'];
		$stickerno = $_POST['editstickerno'];
		$reference = $_POST['editreference'];*/
	}else{
		$result = mysql_query("SELECT * FROM table_vehicle WHERE plateNumber='$plateNo'");
		$row = mysql_fetch_array($result);
		
		$_SESSION['editvehicletype'] = trim($row['vehicleType']);
		$_SESSION['editplateno'] = $row['plateNumber'];
		$_SESSION['editmodel'] = strtolower($row['model']);
		$_SESSION['edityear'] = $row['year'];
		$_SESSION['editmotor'] = $row['motor'];
		$_SESSION['editchassis'] = $row['chassis'];
		$_SESSION['editcolor'] = $row['color'];
		$_SESSION['editstickerno'] = $row['stickerNumber'];
		$_SESSION['editstickerdate'] = $row['stickerIssuedDate'];
		$_SESSION['editreference'] = $row['reference'];
		$_SESSION['certReg'] = $row['certificationRegistration'];
		$_SESSION['receiptReg'] = $row['receiptRegistration'];
		$_SESSION['ltfrbFranchise'] = $row['LTFRBFranchise'];
		$_SESSION['insurance'] = $row['insurance'];
		$_SESSION['driverID'] = $row['driverID'];
		$_SESSION['certReg'] = $row['certificationRegistration'];
		$_SESSION['receiptReg'] = $row['receiptRegistration'];
		$_SESSION['ltfrbFranchise'] = $row['LTFRBFranchise'];
		$_SESSION['insurance'] = $row['insurance'];
		$_SESSION['deed'] = $row['deed'];
	}
	
	
	$isnull = "<p class='fieldError'>*Required field</p>";
	$invalid = "<p class='fieldError'>*Should be a non-negative number</p>";
	$script = "<p class='fieldError'>Illegal input! &ltscript&gt&lt/script&gt</p>";
?>

<html>
	<?php include $root."head.php"; ?>

	<body>
		<div id='centerArea'>
			<?php include "../../menu.php"; // display menu options ?>

			<div id='content' style='top:0'>
				<h2>Vehicle Editor</h2>
				
				<?php
					if(isset($_SESSION["message"])) {
						if($_SESSION["message"] != ""){
							echo "<div class='message'>";
								echo $_SESSION["message"];
							echo "</div>";
						}
						unset($_SESSION["message"]);
					}
					
					if(isset($_GET['editsuccess']))
						echo "<p class='successNotifier'>Updating vehicle information is successful!</p><br/>";
					if(isset($_GET['editnotsuccess']))
						echo "<p class='successNotifier'>Invalid vehicle details.</p><br/>";
				?>
				
				<?php
					echo "Edit information for vehicle with plate number: ".$plateNo;
				?>
				
				<!-- Form for Vehicle Editing-->
				<form name="editVehicleForm" method="post" onsubmit="return showDetails();" action="EditVehicleView.php" enctype="multipart/form-data">
					<table>
						<tr>
							<th colspan='2'>Modify information for your vehicle:</th>
						</tr>
						<!--tr>
							<td><label for="plateNo">Plate Number:</label></td>
							<td><input type="text" name="plateno" id="plateno" <?php if(isset($_SESSION['editplateno'])) echo "value='".$_SESSION['editplateno']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['platenoisnull']))	echo $isnull;
								//if(isset($_SESSION['wrongplateno'])) echo "<p class='fieldError'>*Correct form is *** ***</p>";
							?>
							</td>
						</tr-->
						<tr>
							<td><label>Model/Type of Vehicle:</label></td>
							<td>
								<select name="model" id="model">
									<option value="audi" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='audi')) echo "selected='selected'";?>>Audi</option>
									<option value="bmw" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='bmw')) echo "selected='selected'";?>>BMW</option>
									<option value="chana" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='chana')) echo "selected='selected'";?>>Chana</option>
									<option value="chery" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='chery')) echo "selected='selected'";?>>Chery</option>
									<option value="chevrolet" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='chevrolet')) echo "selected='selected'";?>>Chevrolet</option>
									<option value="chrysler" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='chrysler')) echo "selected='selected'";?>>Chrysler</option>
									<option value="commercial" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='commercial')) echo "selected='selected'";?>>Commercial</option>
									<option value="dodge" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='dodge')) echo "selected='selected'";?>>Dodge</option>
									<option value="ferrari" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='ferrari')) echo "selected='selected'";?>>Ferrari</option>
									<option value="ford" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='ford')) echo "selected='selected'";?>>Ford</option>
									<option value="foton" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='foton')) echo "selected='selected'";?>>Foton</option>
									<option value="geely" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='geely')) echo "selected='selected'";?>>Geely</option>
									<option value="greatwall" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='greatwall')) echo "selected='selected'";?>>Great Wall</option>
									<option value="honda" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='honda')) echo "selected='selected'";?>>Honda</option>
									<option value="hyundai" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='hyundai')) echo "selected='selected'";?>>Hyundai</option>
									<option value="isuzu" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='isuzu')) echo "selected='selected'";?>>Isuzu</option>
									<option value="jaguar" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='jaguar')) echo "selected='selected'";?>>Jaguar</option>
									<option value="jeep" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='jeep')) echo "selected='selected'";?>>Jeep</option>
									<option value="kia" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='kia')) echo "selected='selected'";?>>Kia</option>
									<option value="lexus" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='lexus')) echo "selected='selected'";?>>Lexus</option>
									<option value="lifan" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='lifan')) echo "selected='selected'";?>>Lifan</option>
									<option value="mazda" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='mazda')) echo "selected='selected'";?>>Mazda</option>
									<option value="mercedesbenz" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='mercedesbenz')) echo "selected='selected'";?>>Mercedes Benz</option>
									<option value="mini" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='mini')) echo "selected='selected'";?>>Mini</option>
									<option value="mitsubishi" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='mitsubishi')) echo "selected='selected'";?>>Mitsubishi</option>
									<option value="motorcycle" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='motorcycle')) echo "selected='selected'";?>>Motorcycle</option>
									<option value="nissan" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='nissan')) echo "selected='selected'";?>>Nissan</option>
									<option value="porsche" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='porsche')) echo "selected='selected'";?>>Porsche</option>
									<option value="ssangyong" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='ssangyong')) echo "selected='selected'";?>>SsangYong</option>
									<option value="subaru" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='subaru')) echo "selected='selected'";?>>Subaru</option>
									<option value="suzuki" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='suzuki')) echo "selected='selected'";?>>Suzuki</option>
									<option value="toyota" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='toyota')) echo "selected='selected'";?>>Toyota</option>
									<option value="volkswagon" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='volkswagon')) echo "selected='selected'";?>>Volkswagon</option>
									<option value="volvo" <?php if((isset($_SESSION['editmodel'])) && ($_SESSION['editmodel']=='volvo')) echo "selected='selected'";?>>Volvo</option>
								</select>
							</td>
							<td></td>
						</tr>
						<tr id="year">
							<td><label for="year">Year Model:</label></td>
							<td><input type="text" name="year" id="year" <?php if(isset($_SESSION['edityear'])) echo "value='".$_SESSION['edityear']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['yearisnull']))	echo $isnull;
								if(isset($_SESSION['scriptyear'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="motor">Motor Number:</label></td>
							<td><input type="text" name="motor" id="motor" <?php if(isset($_SESSION['editmotor'])) echo "value='".$_SESSION['editmotor']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['motorisnull']))	echo $isnull;
								if(isset($_SESSION['scriptmotor'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="chassis">Chassis Number:</label></td>
							<td><input type="text" name="chassis" id="chassis" <?php if(isset($_SESSION['editchassis'])) echo "value='".$_SESSION['editchassis']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['chassisisnull']))	echo $isnull;
								if(isset($_SESSION['scriptchassis'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							</td>
							<td><label for="color">Color:</label></td>
							<td><input type="text" name="color" id="color" <?php if(isset($_SESSION['editcolor'])) echo "value='".$_SESSION['editcolor']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['colorisnull']))	echo $isnull;
								if(isset($_SESSION['scriptcolor'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="laststicker">Last Sticker Number:</label></td>
							<td><input type="text" name="laststicker" id="laststicker" <?php if(isset($_SESSION['editstickerno'])) echo "value='".$_SESSION['editstickerno']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['laststickerisnull']))	echo $isnull;
								if(isset($_SESSION['scriptlaststicker'])) echo $script;
							?>
							</td>
						</tr>
						<tr id="laststicker">
							<td><label for="laststickeryear">Year of Last Sticker (YYYY):</label></td>
							<td><input type="text" name="laststickeryear" id="laststickeryear" <?php if(isset($_SESSION['editstickerdate'])) echo "value='".$_SESSION['editstickerdate']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['laststickeryearisnull'])) echo $isnull;
								if(isset($_SESSION['scriptlaststickeryear'])) echo $script;
							?>
							</td>
						</tr>
					</table>
					<br>
					Scanned Documents
					<table>
						<tr>
							<td><label for="">Deed of Sale: (Optional)</label></td>
							<td>
								<?php
									
										echo "<input type='hidden' name='deedVal' value='".$_SESSION['deed']."'>";
										echo "<input type='file' name='deed' id='deed' value='' disabled='disabled'>";
										echo "&nbsp;&nbsp;&nbsp;";
										echo "<input type='checkbox' name='deedCheck' id='deedCheck' value='1'>update file?";
									
								?>
								<script>
									jQuery("#deedCheck").change(function(){
										if(jQuery("#deedCheck").attr("checked")){
											jQuery("#deed").prop('disabled', false);
										}else{
											jQuery("#deed").prop('disabled', true);
										}
									});
								</script>
							</td>
							<td>
							<?php
								//if(isset($_SESSION['deedisnull'])) echo $isnull;
								if(isset($_SESSION['scriptdeed'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="">Vehicle's Certificate of Registration</label></td>
							<td>
								<?php
										echo "<input type='hidden' name='certRegVal' value='".$_SESSION['certReg']."'>";
										echo "<input type='file' name='certReg' id='certReg' value='' disabled='disabled'>";
										echo "&nbsp;&nbsp;&nbsp;";
										echo "<input type='checkbox' name='certRegCheck' id='certRegCheck' value='1'>update file?";
									
								?>
								<script>
									jQuery("#certRegCheck").change(function(){
										if(jQuery("#certRegCheck").attr("checked")){
											jQuery("#certReg").prop('disabled', false);
										}else{
											jQuery("#certReg").prop('disabled', true);
										}
									});
								</script>
							</td>
							<td>
							<?php
								if(isset($_SESSION['certregisnull'])) echo $isnull;
								if(isset($_SESSION['scriptcertreg'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="">Current Official Receipt of Registration</label></td>
							<td>
								<?php
										echo "<input type='hidden' name='receiptRegVal' value='".$_SESSION['receiptReg']."'>";
										echo "<input type='file' name='receiptReg' id='receiptReg' value='' disabled='disabled'>";
										echo "&nbsp;&nbsp;&nbsp;";
										echo "<input type='checkbox' name='receiptRegCheck' id='receiptRegCheck' value='1'>update file?";
									
								?>
								<script>
									jQuery("#receiptRegCheck").change(function(){
										if(jQuery("#receiptRegCheck").attr("checked")){
											jQuery("#receiptReg").prop('disabled', false);
										}else{
											jQuery("#receiptReg").prop('disabled', true);
										}
									});
								</script>
							</td>
							<td>
							<?php
								if(isset($_SESSION['receiptregisnull'])) echo $isnull;
								if(isset($_SESSION['scriptreceiptreg'])) echo $script;
							?>
							</td>
						</tr>
						<tr class="publicdocs">
							<td><label for="">LTFRB Franchise/Decision</label></td>
							<td>
								<?php
										echo "<input type='hidden' name='ltfrbFranchiseVal' value='".$_SESSION['ltfrbFranchise']."'>";
										echo "<input type='file' name='ltfrbFranchise' id='ltfrbFranchise' value='' disabled='disabled'>";
										echo "&nbsp;&nbsp;&nbsp;";
										echo "<input type='checkbox' name='ltfrbFranchiseCheck' id='ltfrbFranchiseCheck' value='1'>update file?";
								
								?>
								<script>
									jQuery("#ltfrbFranchiseCheck").change(function(){
										if(jQuery("#ltfrbFranchiseCheck").attr("checked")){
											jQuery("#ltfrbFranchise").prop('disabled', false);
										}else{
											jQuery("#ltfrbFranchise").prop('disabled', true);
										}
									});
								</script>
							</td>
							<td>
							<?php
								if(isset($_SESSION['ltfrbfranchiseisnull'])) echo $isnull;
								if(isset($_SESSION['scriptltfrbfranchise'])) echo $script;
							?>
							</td>
						</tr>
						<tr class="publicdocs">
							<td><label for="">Insurance</label></td>
							<td>
								<?php
										echo "<input type='hidden' name='insuranceVal' value='".$_SESSION['insurance']."'>";
										echo "<input type='file' name='insurance' id='insurance' value='' disabled='disabled'>";
										echo "&nbsp;&nbsp;&nbsp;";
										echo "<input type='checkbox' name='insuranceCheck' id='insuranceCheck' value='1'>update file?";
								
								?>
								<script>
									jQuery("#insuranceCheck").change(function(){
										if(jQuery("#insuranceCheck").attr("checked")){
											jQuery("#insurance").prop('disabled', false);
										}else{
											jQuery("#insurance").prop('disabled', true);
										}
									});
								</script>
							</td>
							<td>
							<?php
								if(isset($_SESSION['insuranceisnull'])) echo $isnull;
								if(isset($_SESSION['scriptinsurance'])) echo $script;
							?>
							</td>
						</tr>
						
					</table>
					<br />
					<input type="hidden" name="vehicletype" <?php if(isset($_SESSION['editvehicletype'])) echo "value='".$_SESSION['editvehicletype']."'"?> id="vehicletype">
					<input type="hidden" name="plateno" <?php if(isset($_SESSION['editplateno'])) echo "value='".$_SESSION['editplateno']."'"?>>
					<input type="submit" name="submit" value="Submit"/>
					<br/>
				</form>
			</div>
		</div>
	</body>
</html>
<?php
	$connect->closeconnection($con);
	
	unset($_SESSION['editerror']);
	unset($_SESSION['editplateno']);
	unset($_SESSION['editmodel']);
	unset($_SESSION['edityear']);
	unset($_SESSION['editmotor']);
	unset($_SESSION['editchassis']);
	unset($_SESSION['editcolor']);
	unset($_SESSION['editstickerno']);
	unset($_SESSION['editstickerdate']);
	
	if(isset($_SESSION['scriptplateno'])) unset($_SESSION['scriptplateno']);
	if(isset($_SESSION['scriptcolor'])) unset($_SESSION['scriptcolor']);
	if(isset($_SESSION['platenoisnull'])) unset($_SESSION['platenoisnull']);
	if(isset($_SESSION['yearisnull'])) unset($_SESSION['yearisnull']);
	if(isset($_SESSION['motorisnull'])) unset($_SESSION['motorisnull']);
	if(isset($_SESSION['chassisisnull'])) unset($_SESSION['chassisisnull']);
	if(isset($_SESSION['colorisnull'])) unset($_SESSION['colorisnull']);
	if(isset($_SESSION['laststickeryearisnull'])) unset($_SESSION['laststickeryearisnull']);
	if(isset($_SESSION['laststickerisnull'])) unset($_SESSION['laststickerisnull']);
?>
<script language="javascript" type="text/javascript">
	jQuery(document).ready(function(){
		if (jQuery("#vehicletype").val() == "PUBLIC") {
			jQuery('.publicdocs').show();
		} else {
			jQuery('.publicdocs').hide()
		}
	});
	
	function showDetails(){
		var message = "PLEASE REVIEW INFORMATION BEFORE SUBMITTING" + "\n\n";
		
		//var vehicletype = jQuery("select#vehicletype").val();
		//var username = jQuery("input#username").val();
		//var plateno = jQuery("input#plateno").val();
		var model = jQuery("select#model").val();
		var year = jQuery("input#year").val();
		var motor = jQuery("input#motor").val();
		var chassis = jQuery("input#chassis").val();
		var color = jQuery("input#color").val();
		var laststickeryear = jQuery("input#laststickeryear").val();
		var laststicker = jQuery("input#laststicker").val();
		//var inspection = jQuery("input#inspection").val();
		
		message += "Model/Type of Vehicle: " + model + "\n"
			+ "Year Model: " + year + "\n"
			+ "Motor Number: " + motor + "\n"
			+ "Chassis Number: " + chassis + "\n"
			+ "Color: " + color + "\n"
			+ "Year of Last Sticker: " + laststickeryear + "\n"
			+ "Last Sticker Number: " + laststicker + "\n";
			//+ "Inspection Schedule: " + inspection + "\n";
		
		return confirm(message);
	}
</script>
</script>