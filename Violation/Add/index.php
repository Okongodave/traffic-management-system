<!--
  - File Name: Violation/Add/index.php
  - Program Description: form for new violation
  -->
<?php
	$root = "../../"; // root folder
	$pageTitle = "Add Violation";
	$currentMenu = "violation";
	
	include $root."dbconnection.php";
	session_start();
	
	if(!isset($_SESSION['username'])) header("Location: ../../");
	
	$connect = new dbconnection();
	$con = $connect->connectdb();
	
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
			
				<h2>Add Violation</h2>
				
				<!--Form for User Inputs-->
				<form name="info" method="post" action="NewViolationView.php" enctype="multipart/form-data">
					<?php
						if(isset($_GET['addsuccess']))
							echo "<p class='successNotifier'>Violation added.</p><br/>";
						if(isset($_GET['addnotsuccess']))
							echo "<p class='successNotifier'>Invalid violation details.</p><br/>";
					?>
					<table>
						<tr>
							<td><label for="licenseNumber">License Number</label></td>
							<td><input type="text" name="license" id="license" value="<?php echo isset($_SESSION['addlicense']) ? $_SESSION['addlicense'] : ""; ?>"></td>
							<td>
							<?php
								if(isset($_SESSION['licenseisnull'])) echo $isnull;
								if(isset($_SESSION['scriptlicense'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="driver">Driver ID</label></td>
							<td><input type="text" name="driver" id="driver" value="<?php echo isset($_SESSION['adddriver']) ? $_SESSION['adddriver'] : ""; ?>"></td>
							<td>
							<?php
								if(isset($_SESSION['driverisnull'])) echo $isnull;
								if(isset($_SESSION['scriptdriver'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td title="Format: LLL NNN | LL NNNN | NNNN LL | N | NN | NNNN | NNNNN"><label for="plateNo">Plate Number</label></td>
							<td><input type="text" name="plateNo" id="plateNo" value="<?php echo isset($_SESSION['addplateno']) ? $_SESSION['addplateno'] : ""; ?>"></td>
							<td>
							<?php
								if(isset($_SESSION['platenoisnull']))	echo $isnull;
								if(isset($_SESSION['scriptplateno'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="violation">Violation</label></td>
							<td><input type="text" name="violation" id="violation" value="<?php echo isset($_SESSION['addviolation']) ? $_SESSION['addviolation'] : ""; ?>"></td>
							<td>
							<?php
								if(isset($_SESSION['violationisnull']))	echo $isnull;
								if(isset($_SESSION['scriptviolation'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="violationDate">Date Violated (YYYY-MM-DD)</label></td>
							<td><input type="text" name="violationDate" id="violationDate" value="<?php echo isset($_SESSION['addviolatedate']) ? $_SESSION['addviolatedate'] : ""; ?>"></td>
							<td>
							<?php
								if(isset($_SESSION['violatedateisnull']))	echo $isnull;
								if(isset($_SESSION['scriptviolatedate'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="violationDate">Time Violated (24 Hours) (HH:MM:SS)</label></td>
							<td><input type="text" name="violationTime" id="violationTime" value="<?php echo isset($_SESSION['addviolatetime']) ? $_SESSION['addviolatetime'] : ""; ?>"></td>
							<td>
							<?php
								if(isset($_SESSION['violatetimeisnull']))	echo $isnull;
								if(isset($_SESSION['scriptviolatetime'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="violationDate">Location</label></td>
							<td><input type="text" name="violationLocation" id="violationLocation" value="<?php echo isset($_SESSION['addviolatelocation']) ? $_SESSION['addviolatelocation'] : ""; ?>"></td>
							<td>
							<?php
								if(isset($_SESSION['violatelocationisnull']))	echo $isnull;
								if(isset($_SESSION['scriptviolatelocation'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="penalty">Penalty</label></td>
							<td><input type="text" name="penalty" id="penalty" value="<?php echo isset($_SESSION['addpenalty']) ? $_SESSION['addpenalty'] : ""; ?>"></td>
							<td>
							<?php
								if(isset($_SESSION['penaltyisnull']))	echo $isnull;
								if(isset($_SESSION['scriptpenalty'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="reporter">Reporter</label></td>
							<td><input type="text" name="reporter" id="reporter" value="<?php echo isset($_SESSION['addreporter']) ? $_SESSION['addreporter'] : ""; ?>"></td>
							<td>
							<?php
								if(isset($_SESSION['reporterisnull'])) echo $isnull;
								if(isset($_SESSION['scriptreporter'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="reporter">Reporter Contact Number</label></td>
							<td><input type="text" name="reporterContact" id="reporterContact" value="<?php echo isset($_SESSION['addrreporterContact']) ? $_SESSION['addrreporterContact'] : ""; ?>"></td>
							<td>
							<?php
								//if(isset($_SESSION['reportercontactisnull']))	echo $isnull;
								if(isset($_SESSION['scriptreportercontact'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="reporter">Evidence</label></td>
							<td><input type="file" name="evidence" id="evidence" value=""></td>
							<td>
							<?php
								if(isset($_SESSION['evidenceisnull'])) echo $isnull;
								if(isset($_SESSION['scriptevidence'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<p>for video evidence, send it to <a href="mailto:upatroluplb@gmail.com">upatroluplb@gmail.com</a></p>
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
	if(isset($_SESSION['addlicense'])) unset($_SESSION['addlicense']);
	if(isset($_SESSION['adddriver'])) unset($_SESSION['adddriver']);
	if(isset($_SESSION['addplateno'])) unset($_SESSION['addplateno']);
	if(isset($_SESSION['addviolation'])) unset($_SESSION['addviolation']);
	if(isset($_SESSION['addviolatedate'])) unset($_SESSION['addviolatedate']);
	if(isset($_SESSION['addviolatetime'])) unset($_SESSION['addviolatetime']);
	if(isset($_SESSION['addviolatelocation'])) unset($_SESSION['addviolatelocation']);
	if(isset($_SESSION['addpenalty'])) unset($_SESSION['addpenalty']);
	if(isset($_SESSION['addreporter'])) unset($_SESSION['addreporter']);
	
	if(isset($_SESSION['scriptlicense'])) unset($_SESSION['scriptlicense']);
	if(isset($_SESSION['scriptdriver'])) unset($_SESSION['scriptdriver']);
	if(isset($_SESSION['scriptviolation'])) unset($_SESSION['scriptviolation']);
	if(isset($_SESSION['scriptviolatedate'])) unset($_SESSION['scriptviolatedate']);
	if(isset($_SESSION['scriptviolatetime'])) unset($_SESSION['scriptviolatetime']);
	if(isset($_SESSION['scriptviolatelocation'])) unset($_SESSION['scriptviolatelocation']);
	if(isset($_SESSION['scriptpenalty'])) unset($_SESSION['scriptpenalty']);
	if(isset($_SESSION['scriptreporter'])) unset($_SESSION['scriptreporter']);
	
	if(isset($_SESSION['licenseisnull'])) unset($_SESSION['licenseisnull']);
	if(isset($_SESSION['driverisnull'])) unset($_SESSION['driverisnull']);
	if(isset($_SESSION['platenoisnull'])) unset($_SESSION['platenoisnull']);
	if(isset($_SESSION['violationisnull'])) unset($_SESSION['violationisnull']);
	if(isset($_SESSION['violatedateisnull'])) unset($_SESSION['violatedateisnull']);
	if(isset($_SESSION['violatetimeisnull'])) unset($_SESSION['violatetimeisnull']);
	if(isset($_SESSION['violatelocationisnull'])) unset($_SESSION['violatelocationisnull']);
	if(isset($_SESSION['penaltyisnull'])) unset($_SESSION['penaltyisnull']);
	if(isset($_SESSION['reporterisnull'])) unset($_SESSION['reporterisnull']);
?>