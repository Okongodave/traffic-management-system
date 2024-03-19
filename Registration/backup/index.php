<!--
  - File Name: Registration/index.php
  - Program Description: form for new registrations
  -->
<?php
	$root = "../"; // root folder
	$pageTitle = "Registration";
	$currentMenu = "applicant";
	
	session_start();
	//if(!isset($_SESSION['username'])) header("Location: ../");

	$isnull = "<p class='fieldError'>*Required field</p>";
	$invalid = "<p class='fieldError'>*Should be a non-negative number</p>";
	$script = "<p class='fieldError'>Illegal input! &ltscript&gt&lt/script&gt</p>";
?>
<html>
	<?php include $root."head.php"; ?>
	<body id="newReg">
		<div id='centerArea'>
			<?php include $root."menu.php"; // display menu options ?>
			
			<div id="content">
				<!--Form for User Inputs-->
				<form name="info" id="info" method="post" action="NewRegistrationView.php" onsubmit="return showDetails()" enctype="multipart/form-data">
				
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
							echo "<p class='successNotifier'>The registration is successful!</p><br/>";
						if(isset($_GET['addnotsuccess']))
							echo "<p class='successNotifier'>Invalid registration details.</p><br/>";
					?>
					
					<table>
						<tr>
							<th colspan='2'>Enter complete personal information:</th>
						</tr>
						<!--tr>
							<td><label>Owner Type:</label></td>
							<td>
								<input type="radio" <!--?php if(isset($_SESSION['profiletype']) && $_SESSION['profiletype'] == "PRIVATE") echo "checked='checked'"; ?> name="profiletype" id="private" value="PRIVATE" checked="true"/><label for="private">Private</label>
								<input type="radio" <!--?php if(isset($_SESSION['profiletype']) && $_SESSION['profiletype'] == "PUBLIC") echo "checked='checked'"; ?> name="profiletype" id="public" value="PUBLIC"/><label for="public">PUJ</label>
								<input type="radio" <!--?php if(isset($_SESSION['profiletype']) && $_SESSION['profiletype'] == "OPERATOR") echo "checked='checked'"; ?> name="profiletype" id="operator" value="OPERATOR"/><label for="operator">Operator</label>
							</td>
						</tr-->
						<tr>
							<td><label for="uname">User Name:</label></td>
							<td><input type="text" name="uname" id="uname" <?php if(isset($_SESSION['adduname'])) echo "value='".$_SESSION['adduname']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['unameisnull']))	echo $isnull;
								if(isset($_SESSION['scriptuname'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="pword">Password:</label></td>
							<td><input type="password" name="pword" id="pword" ></td>
							<td>
							<?php
								if(isset($_SESSION['pwordisnull']))	echo $isnull;
								if(isset($_SESSION['scriptpword'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="lname">Last Name:</label></td>
							<td><input type="text" name="lname" id="lname" <?php if(isset($_SESSION['addlname'])) echo "value='".$_SESSION['addlname']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['lnameisnull']))	echo $isnull;
								if(isset($_SESSION['scriptlname'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="fname">First Name:</label></td>
							<td><input type="text" name="fname" id="fname" <?php if(isset($_SESSION['addfname'])) echo "value='".$_SESSION['addfname']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['fnameisnull']))	echo $isnull;
								if(isset($_SESSION['scriptfname'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="mname">Middle Name:</label></td>
							<td><input type="text" name="mname" id="mname" <?php if(isset($_SESSION['addmname'])) echo "value='".$_SESSION['addmname']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['mnameisnull']))	echo $isnull;
								if(isset($_SESSION['scriptmname'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label for="mname">Contact Number: (N/A if not applicable)</label></td>
							<td><input type="text" name="contactnumber" id="contactnumber" <?php if(isset($_SESSION['addcontactnumber'])) echo "value='".$_SESSION['addcontactnumber']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['contactnumberisnull']))	echo $isnull;
								if(isset($_SESSION['scriptcontactnumber'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							<td><label>Gender:</label></td>
							<td>
							<select name="gender" id="gender">
								<option value="F" <?php if((isset($_SESSION['addgender'])) && ($_SESSION['addgender']=='F')) echo "selected='selected'";?>>Female</option>
								<option value="M" <?php if((isset($_SESSION['addgender'])) && ($_SESSION['addgender']=='M')) echo "selected='selected'";?>>Male</option>
							</select>
							</td>
							<td></td>
						</tr>
						<tr>
							<td><label>Civil Status:</label></td>
							<td>
							<select name="civil" id="civil">
								<option value="single" <?php if((isset($_SESSION['addcivil'])) && ($_SESSION['addcivil']=='single')) echo "selected='selected'";?>>Single</option>
								<option value="married" <?php if((isset($_SESSION['addcivil'])) && ($_SESSION['addcivil']=='married')) echo "selected='selected'";?>>Married</option>
								<option value="divorced" <?php if((isset($_SESSION['addcivil'])) && ($_SESSION['addcivil']=='divorced')) echo "selected='selected'";?>>Divorced</option>
								<option value="separated" <?php if((isset($_SESSION['addcivil'])) && ($_SESSION['addcivil']=='separated')) echo "selected='selected'";?>>Separated</option>
								<option value="widowed" <?php if((isset($_SESSION['addcivil'])) && ($_SESSION['addcivil']=='widowed')) echo "selected='selected'";?>>Widowed</option>
							</select>
							</td>
							<td></td>
						</tr>
						<tr id="homeadd">
							<td><label for="homeadd">Home Address (Lot/Block/Street Number):</label></td>
							<td><input type="text" name="homeadd" id="homeadd" size="50" <?php if(isset($_SESSION['addhomeadd'])) echo "value='".$_SESSION['addhomeadd']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['homeaddisnull']))	echo $isnull;
								if(isset($_SESSION['scripthomeadd'])) echo $script;
							?>
						</tr>
						<tr>
							</td>
							<td><label for="homebrgy">Home Barangay:</label></td>
							<td><input type="text" name="homebrgy" id="homebrgy" <?php if(isset($_SESSION['addhomebrgy'])) echo "value='".$_SESSION['addhomebrgy']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['homebrgyisnull']))	echo $isnull;
								if(isset($_SESSION['scripthomebrgy'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							</td>
							<td><label for="hometown">Home Town:</label></td>
							<td><input type="text" name="hometown" id="hometown" <?php if(isset($_SESSION['addhometown'])) echo "value='".$_SESSION['addhometown']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['hometownisnull']))	echo $isnull;
								if(isset($_SESSION['scripthometown'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							</td>
							<td><label for="homeprov">Home Province:</label></td>
							<td><input type="text" name="homeprov" id="homeprov" <?php if(isset($_SESSION['addhomeprov'])) echo "value='".$_SESSION['addhomeprov']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['homeprovisnull']))	echo $isnull;
								if(isset($_SESSION['scripthomeprov'])) echo $script;
							?>
							</td>
						</tr>
						
						<tr id="officeadd">
							<td><label for="officeadd">Office Address:</label></td>
							<td><input type="text" name="officeadd" id="officeadd" size="50" <?php if(isset($_SESSION['addofficeadd'])) echo "value='".$_SESSION['addofficeadd']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['officeaddisnull'])) echo $isnull;
								if(isset($_SESSION['scriptofficeadd'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							</td>
							<td><label for="offbrgy">Office Barangay:</label></td>
							<td><input type="text" name="offbrgy" id="offbrgy" <?php if(isset($_SESSION['addoffbrgy'])) echo "value='".$_SESSION['addoffbrgy']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['offbrgyisnull']))	echo $isnull;
								if(isset($_SESSION['scriptoffbrgy'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							</td>
							<td><label for="offtown">Office Town:</label></td>
							<td><input type="text" name="offtown" id="offtown" <?php if(isset($_SESSION['addofftown'])) echo "value='".$_SESSION['addofftown']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['offtownisnull']))	echo $isnull;
								if(isset($_SESSION['scriptofftown'])) echo $script;
							?>
							</td>
						</tr>
						<tr>
							</td>
							<td><label for="offprov">Office Province:</label></td>
							<td><input type="text" name="offprov" id="offprov" <?php if(isset($_SESSION['addoffprov'])) echo "value='".$_SESSION['addoffprov']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['offprovisnull']))	echo $isnull;
								if(isset($_SESSION['scriptoffprov'])) echo $script;
							?>
							</td>
						</tr>
						<tr id="birthplace">
							<td><label for="birthplace">Birthplace:</label></td>
							<td><input type="text" name="birthplace" id="birthplace" <?php if(isset($_SESSION['addbirthplace'])) echo "value='".$_SESSION['addbirthplace']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['birthplaceisnull'])) echo $isnull;
								if(isset($_SESSION['scriptbirthplace'])) echo $script;
							?>
							</td>
						</tr>
						<tr id="birthday">
							<td><label for="birthday">Birthday: (Format: YYYY-MM-DD)</label></td>
							<td><input type="text" name="birthday" id="birthday" <?php if(isset($_SESSION['addbirthday'])) echo "value='".$_SESSION['addbirthday']."'"?>/></td>
							<td>		
							<?php
								if(isset($_SESSION['birthdayisnull'])) echo $isnull;
							?>
							</td>
						</tr>
						<tr id="email">
							<td><label for="email">Email Address: (Format: xxxxxx@xxx.xxx)</label></td>
							<td><input type="text" name="email" id="email" <?php if(isset($_SESSION['addemail'])) echo "value='".$_SESSION['addemail']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['emailisnull']))	echo $isnull;
								if(isset($_SESSION['scriptemail'])) echo $script;
							?>
							</td>
						</tr>
						<tr id="occupation">
							<td><label for="occupation">Present Occupation:</label></td>
							<td><input type="text" name="occupation" id="occupation" <?php if(isset($_SESSION['addoccupation'])) echo "value='".$_SESSION['addoccupation']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['occupationisnull']))	echo $isnull;
								if(isset($_SESSION['scriptoccupation'])) echo $script;
							?>
							</td>
						</tr>
						<tr id="cit">
							<td><label for="cit">Citizenship:</label></td>
							<td><input type="text" name="cit" id="cit" <?php if(isset($_SESSION['addcit'])) echo "value='".$_SESSION['addcit']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['citisnull'])) echo $isnull;
								if(isset($_SESSION['scriptcit'])) echo $script;
							?>
							</td>
						</tr>
						<tr id="license">
							<td><label for="license">Driver's License Number: (Format: LNN-NN-NNNNNN)</label></td>
							<td><input type="text" name="license" id="license" <?php if(isset($_SESSION['addlicense'])) echo "value='".$_SESSION['addlicense']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['licenseisnull'])) echo $isnull;
								if(isset($_SESSION['scriptlicense'])) echo $script;
							?>
							</td>
						</tr>
						<tr id="where">
							<td><label for="where">Where was it issued? (LTO Branch)</label></td>
							<td><select name="where" id="whereIssued">
								<option value="D01" <?php if((isset($_SESSION['addwhere'])) && ($_SESSION['addwhere']=='D01')) echo "selected='selected'";?>>D01 - Batangas Licensing Center</option>
								<option value="D02" <?php if((isset($_SESSION['addwhere'])) && ($_SESSION['addwhere']=='D02')) echo "selected='selected'";?>>D02 - Imus District Office</option>
								<option value="D03" <?php if((isset($_SESSION['addwhere'])) && ($_SESSION['addwhere']=='D03')) echo "selected='selected'";?>>D03 - Boac District Office</option>
								<option value="D04" <?php if((isset($_SESSION['addwhere'])) && ($_SESSION['addwhere']=='D04')) echo "selected='selected'";?>>D04 - Boac District Office</option>
								<option value="D05" <?php if((isset($_SESSION['addwhere'])) && ($_SESSION['addwhere']=='D05')) echo "selected='selected'";?>>D05 - Calapan District Office</option>
								<option value="D06" <?php if((isset($_SESSION['addwhere'])) && ($_SESSION['addwhere']=='D06')) echo "selected='selected'";?>>D06 - Cavite Licensing Center</option>
								<option value="D07" <?php if((isset($_SESSION['addwhere'])) && ($_SESSION['addwhere']=='D07')) echo "selected='selected'";?>>D07 - Gumaca District Office</option>
								<option value="D08" <?php if((isset($_SESSION['addwhere'])) && ($_SESSION['addwhere']=='D08')) echo "selected='selected'";?>>D08 - Lipa District Office</option>
								<option value="D09" <?php if((isset($_SESSION['addwhere'])) && ($_SESSION['addwhere']=='D09')) echo "selected='selected'";?>>D09 - Quezon Licensing Center</option>
								<option value="D10" <?php if((isset($_SESSION['addwhere'])) && ($_SESSION['addwhere']=='D10')) echo "selected='selected'";?>>D10 - Romblon District Office</option>
								<option value="D11" <?php if((isset($_SESSION['addwhere'])) && ($_SESSION['addwhere']=='D11')) echo "selected='selected'";?>>D11 - Palawan District Office</option>
								<option value="D12" <?php if((isset($_SESSION['addwhere'])) && ($_SESSION['addwhere']=='D12')) echo "selected='selected'";?>>D12 - Pila District Office</option>
								<option value="D13" <?php if((isset($_SESSION['addwhere'])) && ($_SESSION['addwhere']=='D13')) echo "selected='selected'";?>>D13 - San Jose District Office</option>
								<option value="D14" <?php if((isset($_SESSION['addwhere'])) && ($_SESSION['addwhere']=='D14')) echo "selected='selected'";?>>D14 - Laguna Licensing Center</option>
								<option value="D16" <?php if((isset($_SESSION['addwhere'])) && ($_SESSION['addwhere']=='D16')) echo "selected='selected'";?>>D16 - Cainta Extension Office</option>
								<option value="D17" <?php if((isset($_SESSION['addwhere'])) && ($_SESSION['addwhere']=='D17')) echo "selected='selected'";?>>D17 - Cavite District Office</option>
								<option value="D18" <?php if((isset($_SESSION['addwhere'])) && ($_SESSION['addwhere']=='D18')) echo "selected='selected'";?>>D18 - Tagaytay Extension Office</option>
								<option value="D19" <?php if((isset($_SESSION['addwhere'])) && ($_SESSION['addwhere']=='D19')) echo "selected='selected'";?>>D19 - Binangonan Extension Office</option>
								<option value="D20" <?php if((isset($_SESSION['addwhere'])) && ($_SESSION['addwhere']=='D20')) echo "selected='selected'";?>>D20 - Taal Extension Office</option>
								<option value="D21" <?php if((isset($_SESSION['addwhere'])) && ($_SESSION['addwhere']=='D21')) echo "selected='selected'";?>>D21 - Santa Rosa DLRC</option>
								<option value="D22" <?php if((isset($_SESSION['addwhere'])) && ($_SESSION['addwhere']=='D22')) echo "selected='selected'";?>>D22 - Calamba District Office</option>
								<option value="D23" <?php if((isset($_SESSION['addwhere'])) && ($_SESSION['addwhere']=='D23')) echo "selected='selected'";?>>D23 - Dasmarinas District Office</option>
								<option value="D24" <?php if((isset($_SESSION['addwhere'])) && ($_SESSION['addwhere']=='D24')) echo "selected='selected'";?>>D24 - E Patrol District Office</option>
								<option value="A++" <?php if((isset($_SESSION['addwhere'])) && ($_SESSION['addwhere']=='A++')) echo "selected='selected'";?>>A++ - Region 1</option>
								<option value="B++" <?php if((isset($_SESSION['addwhere'])) && ($_SESSION['addwhere']=='B++')) echo "selected='selected'";?>>B++ - Region 2</option>
								<option value="C++" <?php if((isset($_SESSION['addwhere'])) && ($_SESSION['addwhere']=='C++')) echo "selected='selected'";?>>C++ - Region 3</option>
								<option value="E++" <?php if((isset($_SESSION['addwhere'])) && ($_SESSION['addwhere']=='E++')) echo "selected='selected'";?>>E++ - Region 5</option>
								<option value="N++" <?php if((isset($_SESSION['addwhere'])) && ($_SESSION['addwhere']=='N++')) echo "selected='selected'";?>>N++ - National Capital Region</option>
								<option value="OTHERS" <?php if((isset($_SESSION['addwhere'])) && ($_SESSION['addwhere']=='OTHERS')) echo "selected='selected'";?>>Others</option>
							</select>
							</td>
						</tr>
						<tr id="when">
							<td><label for="when">When was is issued? (Format: YYYY-MM-DD)</label></td>
							<td><input type="text" name="when" id="when" <?php if(isset($_SESSION['addwhen'])) echo "value='".$_SESSION['addwhen']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['whenisnull'])) echo $isnull;
								if(isset($_SESSION['scriptwhen'])) echo $script;
							?>
							</td>
						</tr>
						<tr id="expiry">
							<td><label for="expiry">Expiry Date: (Format: YYYY-MM-DD)</label></td>
							<td><input type="text" name="expiry" id="expiry" <?php if(isset($_SESSION['addexpiry'])) echo "value='".$_SESSION['addexpiry']."'"?>/></td>
							<td>
							<?php
								if(isset($_SESSION['expiryisnull'])) echo $isnull;
								if(isset($_SESSION['scriptexpiry'])) echo $script;
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
							<td><label for="licensepic">Scanned Image of License:</label></td>
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
					<!--button onclick="javascript:showDetails();">Submit</button-->
					<input type="reset" name="clear" value="Clear"/>
					<br/>
				</form>
			</div>
		</div>
	</body>
</html>
<?php
	unset($_SESSION['error']);
	unset($_SESSION['adduname']);
	unset($_SESSION['addlname']);
	unset($_SESSION['addfname']);
	unset($_SESSION['addmname']);
	unset($_SESSION['addcontactnumber']);
	unset($_SESSION['gender']);
	unset($_SESSION['civil']);
	unset($_SESSION['homeadd']);
	unset($_SESSION['homebrgy']);
	unset($_SESSION['hometown']);
	unset($_SESSION['homeprov']);
	unset($_SESSION['officeadd']);
	unset($_SESSION['offbrgy']);
	unset($_SESSION['offtown']);
	unset($_SESSION['offprov']);
	unset($_SESSION['birthplace']);
	unset($_SESSION['birthday']);
	unset($_SESSION['occupation']);
	unset($_SESSION['email']);
	unset($_SESSION['cit']);
	unset($_SESSION['license']);
	unset($_SESSION['where']);
	unset($_SESSION['when']);
	unset($_SESSION['expiry']);
	
	if(isset($_SESSION['scriptlname'])) unset($_SESSION['scriptlname']);
	if(isset($_SESSION['scriptfname'])) unset($_SESSION['scriptfname']);
	if(isset($_SESSION['scriptmname'])) unset($_SESSION['scriptmname']);
	if(isset($_SESSION['scriptunameisnull'])) unset($_SESSION['$unameisnull']);
	if(isset($_SESSION['scriptpwordisnull'])) unset($_SESSION['$pwordisnull']);	
	if(isset($_SESSION['lnameisnull'])) unset($_SESSION['lnameisnull']);
	if(isset($_SESSION['fnameisnull'])) unset($_SESSION['fnameisnull']);
	if(isset($_SESSION['mnameisnull'])) unset($_SESSION['mnameisnull']);
	if(isset($_SESSION['unameisnull'])) unset($_SESSION['unameisnull']);
	if(isset($_SESSION['pwordisnull'])) unset($_SESSION['pwordisnull']);
	if(isset($_SESSION['contactnumberisnull'])) unset($_SESSION['contactnumberisnull']);
	if(isset($_SESSION['genderisnull'])) unset($_SESSION['genderisnull']);
	if(isset($_SESSION['civilisnull'])) unset($_SESSION['civilisnull']);
	if(isset($_SESSION['homeaddisnull'])) unset($_SESSION['homeaddisnull']);
	if(isset($_SESSION['homebrgyisnull'])) unset($_SESSION['homebrgyisnull']);
	if(isset($_SESSION['hometownisnull'])) unset($_SESSION['hometownisnull']);
	if(isset($_SESSION['homeprovisnull'])) unset($_SESSION['homeprovisnull']);
	if(isset($_SESSION['officeaddisnull'])) unset($_SESSION['officeaddisnull']);
	if(isset($_SESSION['offbrgyisnull'])) unset($_SESSION['offbrgyisnull']);
	if(isset($_SESSION['offtownisnull'])) unset($_SESSION['offtownisnull']);
	if(isset($_SESSION['offprovisnull'])) unset($_SESSION['offprovisnull']);
	if(isset($_SESSION['birthplaceisnull'])) unset($_SESSION['birthplaceisnull']);
	if(isset($_SESSION['birthdayisnull'])) unset($_SESSION['birthdayisnull']);
	if(isset($_SESSION['occupationisnull'])) unset($_SESSION['occupationisnull']);
	if(isset($_SESSION['emailisnull'])) unset($_SESSION['emailisnull']);
	if(isset($_SESSION['citisnull'])) unset($_SESSION['citisnull']);
	if(isset($_SESSION['licenseisnull'])) unset($_SESSION['licenseisnull']);
	if(isset($_SESSION['whereisnull'])) unset($_SESSION['whereisnull']);
	if(isset($_SESSION['whenisnull'])) unset($_SESSION['whenisnull']);
	if(isset($_SESSION['expiryisnull'])) unset($_SESSION['expiryisnull']);
	if(isset($_SESSION['pictureisnull'])) unset($_SESSION['pictureisnull']);
	//if(isset($_SESSION['licensepicisnull'])) unset($_SESSION['licensepicisnull']);	
?>
<script language="javascript" type="text/javascript">
	function showDetails(){
		var message = "PLEASE REVIEW THE FOLLOWING INFORMATION BEFORE SUBMITTING" + "\n\n";
		
		var uname = jQuery("input#uname").val();
		var pword = jQuery("input#pword").val();
		var lname = jQuery("input#lname").val();
		var fname = jQuery("input#fname").val();
		var mname = jQuery("input#mname").val();
		var contactnumber = jQuery("input#contactnumber").val();
		var gender = jQuery("select#gender").val();
		var civil = jQuery("select#civil").val();
		var homeadd = jQuery("input#homeadd").val();
		var homebrgy = jQuery("input#homebrgy").val();
		var hometown = jQuery("input#hometown").val();
		var homeprov = jQuery("input#homeprov").val();
		var birthplace = jQuery("input#birthplace").val();
		var birthday = jQuery("input#birthday").val();
		var email = jQuery("input#email").val();
		var occupation = jQuery("input#occupation").val();
		var cit = jQuery("input#cit").val();
		var license = jQuery("input#license").val();
		var whereIssued = jQuery("select#whereIssued").val();
		var when = jQuery("input#when").val();
		var expiry = jQuery("input#expiry").val();
		
		message += "Username: " + uname + "\n"
			+ "Password: " + pword + "\n"
			+ "Last Name: " + lname + "\n"
			+ "First Name: " + fname + "\n"
			+ "Middle Name: " + mname + "\n"
			+ "Contact Number: " + contactnumber + "\n"
			+ "Gender: " + gender + "\n"
			+ "Civil Status: " + civil + "\n"
			+ "Home Address: " + homeadd + "\n"
			+ "Home Barangay: " + homebrgy + "\n"
			+ "Home Town: " + hometown + "\n"
			+ "Home Province: " + homeprov + "\n"
			+ "Birth Place: " + birthplace + "\n"
			+ "Birthday: " + birthday + "\n"
			+ "Email: " + email + "\n"
			+ "Occupation: " + occupation + "\n"
			+ "License Number: " + license + "\n"
			+ "License Issued Date: " + whereIssued + "\n"
			+ "License Expiry Date: " + when + "\n";
		
		return confirm(message);
	}
</script>