<!--
  - File Name: Report/index.php
  - Program Description: form for new reports
  -->
<?php
	$root = "../"; // root folder
	$pageTitle = "Report";
	$currentMenu = "report";
	
	session_start();
	
	$isnull = "<p class='fieldError'>*Required field</p>";
	$invalid = "<p class='fieldError'>*Should be a non-negative number</p>";
	$script = "<p class='fieldError'>Illegal input! &ltscript&gt&lt/script&gt</p>";
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
				<h2>U-Patrol UPLB</h2>
				<p>U-Patrol UPLB is a campaign program of the Office of the Vice Chancellor for Community Affairs (OVCCA) that allows UPLB students and staff of the University to be an additional <i>'eyes and ears'</i> of the University and the police.<br /></p>
<p>Any UPLB student or employee may report suspicious activity or violation against the rules, regulations, ordinance, and laws implemented inside the University.<br /></p>
<p><b>PLEASE REPORT VIOLATORS AGAINST</b></p>
<ul id="upatrol1"> <li>TRAFFIC RULES and REGULATIONS
<ul id="upatrol"><li>No illegal parking.</li>
<li>Observe proper loading and unloading zones.</li>
<li>Motorcycle/bicycle drivers must wear helmets.</li>
<li>Counterflowing traffic is prohibited.</li></ul></li><br>
<li>ANTI-LITTERING and WASTE MANAGEMENT
<ul id="upatrol"><li>No illegal dumping of waste.</li>
<li>Segregation of waste must be observed.</li>
<li>Burning of any waste is prohibited.</li></ul></li><br>
<li>NO SMOKING POLICY
<ul id="upatrol"><li>All University buildings shall be smoke-free.</li>
<li>All drivers and passengers are prohibited to smoke inside public utility vehicles.</li></ul></li><br>
<li>ANTI-LOITERING PROGRAM
<ul id="upatrol"><li>Non-UP students are prohibited to loiter in the campus during class hours.</li></ul></li><br>
<li>RESPONSIBLE PET OWNERSHIP
<ul id="upatrol"><li>Dont allow the pet to stray inside the campus.</li>
<li>Clean any mess that the pet may bring.</li></ul></li><br>
<li>SAFETY and SECURITY
<ul id="upatrol"><li>All lights and appliances inside the classroom and offices must be turned off after class and working hours.</li>
<li>Ambulant vendors are not allowed inside the University.</li></ul></li></ul><br>
<br><p>EMAIL OR CALL US</p>
Incident report must be accurate and factual, stating the date, time and place of the incident.<br>
If possible, include pictures or video.<br>
Email us at upatroluplb@gmail.com or call us at 536-3358.<br>
You may also send SMS or MMS to +639176214540.<br>
You may also contact Univer-sity Police Force (UPF) at 536-2243 and 536-2803.
				
				
				<h2>Report Violation</h2>
				
				<form name="info" method="post" action="ReportController.php">
					<table>
						<tr>
							<td><label for="licenseNumber">License Number</label></td>
							<td><input type="text" name="license" id="license" value="<?php echo isset($_SESSION['addlicense']) ? $_SESSION['addlicense'] : ""; ?>"></td>
							<td>
							<?php
						//		if(isset($_SESSION['licenseisnull'])) echo $isnull;
								if(isset($_SESSION['scriptlicense'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="driver">Driver ID</label></td>
							<td><input type="text" name="driver" id="driver" value="<?php echo isset($_SESSION['adddriver']) ? $_SESSION['adddriver'] : ""; ?>"></td>
							<td>
							<?php
								if(isset($_SESSION['driverisnull']))	echo $isnull;
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
								if(isset($_SESSION['violatedateisnull'])) echo $isnull;
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
							<td><label for="reporter">Reporter Name</label></td>
							<td><input type="text" name="reporterName" id="reporterName" value="<?php echo isset($_SESSION['addreporterName']) ? $_SESSION['addreporterName'] : ""; ?>"></td>
							<td>
							<?php
								//if(isset($_SESSION['reporternameisnull'])) echo $isnull;
								if(isset($_SESSION['scriptreportername'])) echo $script;
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
	if(isset($_SESSION['addpenalty'])) unset($_SESSION['addpenalty']);
	if(isset($_SESSION['addreporter'])) unset($_SESSION['addreporter']);
	
	if(isset($_SESSION['scriptlicense'])) unset($_SESSION['scriptlicense']);
	if(isset($_SESSION['scriptdriver'])) unset($_SESSION['scriptdriver']);
	if(isset($_SESSION['scriptviolation'])) unset($_SESSION['scriptviolation']);
	if(isset($_SESSION['scriptviolatedate'])) unset($_SESSION['scriptviolatedate']);
	if(isset($_SESSION['scriptpenalty'])) unset($_SESSION['scriptpenalty']);
	if(isset($_SESSION['scriptreporter'])) unset($_SESSION['scriptreporter']);
	
	if(isset($_SESSION['licenseisnull'])) unset($_SESSION['licenseisnull']);
	if(isset($_SESSION['driverisnull'])) unset($_SESSION['driverisnull']);
	if(isset($_SESSION['platenoisnull'])) unset($_SESSION['platenoisnull']);
	if(isset($_SESSION['violationisnull'])) unset($_SESSION['violationisnull']);
	if(isset($_SESSION['violatedateisnull'])) unset($_SESSION['violatedateisnull']);
	if(isset($_SESSION['penaltyisnull'])) unset($_SESSION['penaltyisnull']);
	if(isset($_SESSION['reporterisnull'])) unset($_SESSION['reporterisnull']);
?>
