<!--
  - File Name: Vehicle/index.php
  - Program Description: form for new vehicle
  -->
<?php
	$root = "../../"; // root folder
	$pageTitle = "Add Vehicle";
	$currentMenu = "vehicle";
	
	include $root."dbconnection.php";
	
	session_start();
	
	if(!isset($_SESSION['username'])) header("Location: ../../");
	
	$connect = new dbconnection();
	$con = $connect->connectdb();
	
	$result = mysql_query("SELECT * FROM table_profile WHERE userName='".$_SESSION['username']."'");
	$row = mysql_fetch_array($result);
	
	$isnull = "<p class='fieldError'>*Required field</p>";
	$invalid = "<p class='fieldError'>*Should be a non-negative number</p>";
	$script = "<p class='fieldError'>Illegal input! &ltscript&gt&lt/script&gt</p>";
?>
<html>
	<?php include $root."head.php"; ?>
	<body id="newReg">
		<div id='centerArea'>
			<?php include "../../menu.php"; // display menu options ?>
			
			<div id="content">
			<h2>Add New Vehicle</h2>
				<!--Form for User Inputs-->
				<form name="info" method="post" onsubmit="return showDetails();" action="NewVehicleView.php" enctype="multipart/form-data" >
				
				
				<?php
					if(isset($_SESSION["message"])) {
						if($_SESSION["message"] != ""){
							echo "<div class='message'>";
								echo $_SESSION["message"];
							echo "</div>";
						}
						unset($_SESSION["message"]);
					}
					
					if(isset($_GET['addsuccess']))
						echo "<p class='removesuccess'>The adding of new vehicle is successful!</p><br/>";
					if(isset($_GET['removenotsuccess']))
						echo "<p class='successNotifier'>Error adding vehicle</p><br/>";
				?>
				<?php
					echo "Add new vehicle for username: ".$_SESSION['username'];
				?>
					
					<table>
						<tr>
							<th colspan='2'>Enter complete information for your vehicle:</th>
						</tr>
						<tr id="vehicleTypeRow">
							<td><label for="vehicleType">Vehicle Type</label></td>
							<td>
								<select name="vehicletype" id="vehicletype" >
									<option value="private" <?php if(isset($_SESSION['vehicletype']) && $_SESSION['vehicletype'] == "private") echo "selected='selected'"; ?>>Private Car</option>
									<option value="public" <?php if(isset($_SESSION['vehicletype']) && $_SESSION['vehicletype'] == "public") echo "selected='selected'"; ?>>PUJ</option>
									<option value="motorcycle" <?php if(isset($_SESSION['vehicletype']) && $_SESSION['vehicletype'] == "motorcycle") echo "selected='selected'"; ?>>Motorcycle</option>
									<option value="commercial" <?php if(isset($_SESSION['vehicletype']) && $_SESSION['vehicletype'] == "commercial") echo "selected='selected'"; ?>>Commercial</option>
								</select>
								<script>
									jQuery(function() {
										jQuery('#vehicletype').change(function(){
											if (jQuery(this).val() == "public") {
												jQuery("[name=model]").val("jeep");
												jQuery("#modelRow").hide();
												jQuery('.publicdocs').show();
											} else if (jQuery(this).val() == "motorcycle") {
												jQuery("[name=model]").val("motorcycle");
												jQuery("#modelRow").hide();
												jQuery('.publicdocs').hide();
											} else if (jQuery(this).val() == "commercial") {
												jQuery("[name=model]").val("commercial");
												jQuery("#modelRow").hide();
												jQuery('.publicdocs').hide();
											} else {
												jQuery("[name=model]").val("");
												jQuery("#modelRow").show();
												jQuery('.publicdocs').hide();
												jQuery('#reference').val("");
											}
										});
									});
								</script>
							</td>
							<td></td>
						</tr>
						<?php if($_SESSION['profileType'] == "ADMIN" || $_SESSION['profileType'] == "OVCCA"){ ?>
							<td><label for="userName">Username</label></td>
							<td><input type="text" name="username" id="username" <?php if(isset($_SESSION['addusername'])) echo "value='".$_SESSION['addusername']."'"?>></td>
							<td>
							<?php
								if(isset($_SESSION['usernameisnull'])) echo $isnull;
								if(isset($_SESSION['scriptusername'])) echo $script;
							?>
							</td>
						<?php } ?>
						<tr>
							<td title="Format: LLL NNN | LL NNNN | NNNN LL | N | NN | NNNN | NNNNN"><label for="plateNo">Plate Number:</label></td>
							<td><input type="text" name="plateno" id="plateno" <?php if(isset($_SESSION['addplateno'])) echo "value='".$_SESSION['addplateno']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['platenoisnull']))	echo $isnull;
								//if(isset($_SESSION['wrongplateno'])) echo "<p class='fieldError'>*Correct form is *** ***</p>";
							?>
							</td>
						</tr>
						<tr id="modelRow">
							<td><label>Model/Type of Vehicle:</label></td>
							<td>
								<select name="model" id="model">
									<option value="audi" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='audi')) echo "selected='selected'";?>>Audi</option>
									<option value="bmw" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='bmw')) echo "selected='selected'";?>>BMW</option>
									<option value="chana" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='chana')) echo "selected='selected'";?>>Chana</option>
									<option value="chery" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='chery')) echo "selected='selected'";?>>Chery</option>
									<option value="chevrolet" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='chevrolet')) echo "selected='selected'";?>>Chevrolet</option>
									<option value="chrysler" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='chrysler')) echo "selected='selected'";?>>Chrysler</option>
									<option value="commercial" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='commercial')) echo "selected='selected'";?>>Commercial</option>
									<option value="dodge" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='dodge')) echo "selected='selected'";?>>Dodge</option>
									<option value="ferrari" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='ferrari')) echo "selected='selected'";?>>Ferrari</option>
									<option value="ford" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='ford')) echo "selected='selected'";?>>Ford</option>
									<option value="foton" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='foton')) echo "selected='selected'";?>>Foton</option>
									<option value="geely" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='geely')) echo "selected='selected'";?>>Geely</option>
									<option value="greatwall" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='greatwall')) echo "selected='selected'";?>>Great Wall</option>
									<option value="honda" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='honda')) echo "selected='selected'";?>>Honda</option>
									<option value="hyundai" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='hyundai')) echo "selected='selected'";?>>Hyundai</option>
									<option value="isuzu" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='isuzu')) echo "selected='selected'";?>>Isuzu</option>
									<option value="jaguar" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='jaguar')) echo "selected='selected'";?>>Jaguar</option>
									<option value="jeep" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='jeep')) echo "selected='selected'";?>>Jeep</option>
									<option value="kia" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='kia')) echo "selected='selected'";?>>Kia</option>
									<option value="lexus" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='lexus')) echo "selected='selected'";?>>Lexus</option>
									<option value="lifan" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='lifan')) echo "selected='selected'";?>>Lifan</option>
									<option value="mazda" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='mazda')) echo "selected='selected'";?>>Mazda</option>
									<option value="mercedesbenz" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='mercedesbenz')) echo "selected='selected'";?>>Mercedes Benz</option>
									<option value="mini" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='mini')) echo "selected='selected'";?>>Mini</option>
									<option value="mitsubishi" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='mitsubishi')) echo "selected='selected'";?>>Mitsubishi</option>
									<option value="motorcycle" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='motorcycle')) echo "selected='selected'";?>>Motorcycle</option>
									<option value="nissan" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='nissan')) echo "selected='selected'";?>>Nissan</option>
									<option value="porsche" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='porsche')) echo "selected='selected'";?>>Porsche</option>
									<option value="ssangyong" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='ssangyong')) echo "selected='selected'";?>>SsangYong</option>
									<option value="subaru" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='subaru')) echo "selected='selected'";?>>Subaru</option>
									<option value="suzuki" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='suzuki')) echo "selected='selected'";?>>Suzuki</option>
									<option value="toyota" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='toyota')) echo "selected='selected'";?>>Toyota</option>
									<option value="volkswagon" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='volkswagon')) echo "selected='selected'";?>>Volkswagon</option>
									<option value="volvo" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='volvo')) echo "selected='selected'";?>>Volvo</option>
									<option value="others" <?php if((isset($_SESSION['addmodel'])) && ($_SESSION['addmodel']=='others')) echo "selected='selected'";?>>Others</option>
								</select>
							</td>
							<td></td>
						</tr>
						<tr id="year">
							<td><label for="year">Year Model:</label></td>
							<td><input type="text" name="year" id="year" <?php if(isset($_SESSION['addyear'])) echo "value='".$_SESSION['addyear']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['yearisnull']))	echo $isnull;
								if(isset($_SESSION['scriptyear'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="motor">Motor Number:</label></td>
							<td><input type="text" name="motor" id="motor" <?php if(isset($_SESSION['addmotor'])) echo "value='".$_SESSION['addmotor']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['motorisnull']))	echo $isnull;
								if(isset($_SESSION['scriptmotor'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="chassis">Chassis Number:</label></td>
							<td><input type="text" name="chassis" id="chassis" <?php if(isset($_SESSION['addchassis'])) echo "value='".$_SESSION['addchassis']."'"?>/></td>
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
							<td><input type="text" name="color" id="color" <?php if(isset($_SESSION['addcolor'])) echo "value='".$_SESSION['addcolor']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['colorisnull']))	echo $isnull;
								if(isset($_SESSION['scriptcolor'])) echo $script;
							?>
							</td>
						</tr>
						
						<tr id="laststicker">
							<td><label for="laststickeryear">Year of Last Sticker (YYYY):</label></td>
							<td><input type="text" name="laststickeryear" id="laststickeryear" <?php if(isset($_SESSION['addlaststickeryear'])) echo "value='".$_SESSION['addlaststickeryear']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['laststickeryearisnull'])) echo $isnull;
								if(isset($_SESSION['scriptlaststickeryear'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="laststicker">Last Sticker Number:</label></td>
							<td><input type="text" name="laststicker" id="laststicker" <?php if(isset($_SESSION['laststicker'])) echo "value='".$_SESSION['laststicker']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['laststickerisnull'])) echo $isnull;
								if(isset($_SESSION['scriptlaststicker'])) echo $script;
							?>
							</td>
						</tr>
						<!--tr id="referenceRow">
							<td><label for="reference">Reference Number:</label></td>
							<td><input type="text" name="reference" id="reference" <!--?php if(isset($_SESSION['addreference'])) echo "value='".$_SESSION['addreference']."'"?>/></td>
							<td>
							<!--?php
								if(isset($_SESSION['referenceisnull']))	echo $isnull;
								if(isset($_SESSION['scriptreference'])) echo $script;
							?>
							</td>
						</tr-->
						<!--tr>
							<td><label for="inspection">Inspection Schedule:</label></td>
							<td><input type="text" name="inspection" id="inspection" <!--?php if(isset($_SESSION['addinspection'])) echo "value='".$_SESSION['addinspection']."'"?>/></td>
							<td>
							<!--?php
								if(isset($_SESSION['inspectionisnull'])) echo $isnull;
								if(isset($_SESSION['scriptinspection'])) echo $script;
							?>
							</td>
						</tr-->
					</table>
					<br>
					Scanned Documents
					<table>
						<tr class="deedofsale">
							<td><label for="">Deed Of Sale: (Optional)</label></td>
							<td><input type="file" name="deed" value=""></td>
							<td>
							<?php
								//if(isset($_SESSION['deedisnull'])) echo $isnull;
								if(isset($_SESSION['scriptdeed'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="">Vehicle's Certificate of Registration</label></td>
							<td><input type="file" name="certReg" value=""></td>
							<td>
							<?php
								if(isset($_SESSION['certregisnull'])) echo $isnull;
								if(isset($_SESSION['scriptcertreg'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="">Current Official Receipt of Registration</label></td>
							<td><input type="file" name="receiptReg" value=""></td>
							<td>
							<?php
								if(isset($_SESSION['receiptregisnull'])) echo $isnull;
								if(isset($_SESSION['scriptreceiptreg'])) echo $script;
							?>
							</td>
						</tr>
						
						<tr class="publicdocs">
							<td><label for="">LTFRB Franchise/Decision</label></td>
							<td><input type="file" name="ltfrbFranchise" value=""></td>
							<td>
							<?php
								if(isset($_SESSION['ltfrbfranchiseisnull'])) echo $isnull;
								if(isset($_SESSION['scriptltfrbfranchise'])) echo $script;
							?>
							</td>
						</tr>
						<tr class="publicdocs">
							<td><label for="">Insurance</label></td>
							<td><input type="file" name="insurance" value=""></td>
							<td>
							<?php
								if(isset($_SESSION['insuranceisnull'])) echo $isnull;
								if(isset($_SESSION['scriptinsurance'])) echo $script;
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
	unset($_SESSION['error']);
	unset($_SESSION['addusername']);
	unset($_SESSION['addplateno']);
	unset($_SESSION['addmodel']);
	unset($_SESSION['addyear']);
	unset($_SESSION['addmotor']);
	unset($_SESSION['addchassis']);
	unset($_SESSION['addcolor']);
	unset($_SESSION['addlaststickeryear']);
	unset($_SESSION['addlaststicker']);
	unset($_SESSION['addinspection']);
	
	if(isset($_SESSION['scriptusername'])) unset($_SESSION['scriptusername']);
	if(isset($_SESSION['scriptplateno'])) unset($_SESSION['scriptplateno']);
	if(isset($_SESSION['scriptcolor'])) unset($_SESSION['scriptcolor']);
	if(isset($_SESSION['usernameisnull'])) unset($_SESSION['usernameisnull']);
	if(isset($_SESSION['platenoisnull'])) unset($_SESSION['platenoisnull']);
	if(isset($_SESSION['yearisnull'])) unset($_SESSION['yearisnull']);
	if(isset($_SESSION['motorisnull'])) unset($_SESSION['motorisnull']);
	if(isset($_SESSION['chassisisnull'])) unset($_SESSION['chassisisnull']);
	if(isset($_SESSION['colorisnull'])) unset($_SESSION['colorisnull']);
	if(isset($_SESSION['laststickeryearisnull'])) unset($_SESSION['laststickeryearisnull']);
	if(isset($_SESSION['laststickerisnull'])) unset($_SESSION['laststickerisnull']);
	if(isset($_SESSION['inspectionisnull'])) unset($_SESSION['inspectionisnull']);
	if(isset($_SESSION['certregisnull'])) unset($_SESSION['certregisnull']);
	if(isset($_SESSION['receiptregisnull'])) unset($_SESSION['receiptregisnull']);
	if(isset($_SESSION['ltfrbfranchiseisnull'])) unset($_SESSION['ltfrbfranchiseisnull']);
	if(isset($_SESSION['insuranceisnull'])) unset($_SESSION['insuranceisnull']);
	if(isset($_SESSION['driveridisnull'])) unset($_SESSION['driveridisnull']);
?>
<script language="javascript" type="text/javascript">
	jQuery(document).ready(function(){
		/*if("<?php echo $_SESSION['profileType']?>" == "PRIVATE"){
			jQuery("#vehicleTypeRow").hide();
		}*/
		
		if (jQuery("#vehicletype").val() == "public") {
			jQuery("[name=model]").val("jeep");
			jQuery("#modelRow").hide();
			jQuery('.publicdocs').show();
		} else if (jQuery(this).val() == "motorcycle") {
			jQuery("[name=model]").val("motorcycle");
			jQuery("#modelRow").hide();
			jQuery('.publicdocs').hide();
		} else if (jQuery(this).val() == "commercial") {
			jQuery("[name=model]").val("commercial");
			jQuery("#modelRow").hide();
			jQuery('.publicdocs').hide();
		} else {
			jQuery('#referenceRow').hide();
			jQuery('.publicdocs').hide();
		}
	});
	
	
	function showDetails(){
		var message = "PLEASE REVIEW INFORMATION BEFORE SUBMITTING" + "\n\n";
		
		var vehicletype = jQuery("select#vehicletype").val();
		if("<?php echo $_SESSION['profileType']?>" != "APPLICANT"){
			var username = jQuery("input#username").val();
		}
		var plateno = jQuery("input#plateno").val();
		var model = jQuery("select#model").val();
		var year = jQuery("input#year").val();
		var motor = jQuery("input#motor").val();
		var chassis = jQuery("input#chassis").val();
		var color = jQuery("input#color").val();
		var laststickeryear = jQuery("input#laststickeryear").val();
		var laststicker = jQuery("input#laststicker").val();
		//var inspection = jQuery("input#inspection").val();
		
		message += "Vehicle Type: " + vehicletype + "\n";
		if("<?php echo $_SESSION['profileType']?>" != "APPLICANT"){
			message +=  "Username: " + username + "\n"
		}
		message += "Plate Number: " + plateno + "\n"
			+ "Model/Type of Vehicle: " + model + "\n"
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