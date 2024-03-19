<!--
  - File Name: Registration/index.php
  - Program Description: form for new registrations
  -->
<?php
	$root = "../"; // root folder
	$pageTitle = "Update Profile";
	$currentMenu = "applicant";
	
	session_start();
	if(!isset($_SESSION['username'])) header("Location: ".$root."");
?>
<html>
	<?php include "head.php"; ?>
	<body id="newReg">
		<div id='centerArea'>
			<?php include $root."menu.php"; // display menu options ?>
			
			<div id="content">
				<!--Form for User Inputs-->
				<h1>Complete Your Profile</h1>
				<p>Username: <?echo $_SESSION['username']?><br /></p>
				<form name="update_form" id="update_form" method="post" action="update_profile.php" onsubmit="return showDetails()" enctype="multipart/form-data">
					<table>
						<!--tr>
							<td><label>Owner Type:</label></td>
							<td>
								<input type="radio" <!--?php if(isset($_SESSION['profiletype']) && $_SESSION['profiletype'] == "PRIVATE") echo "checked='checked'"; ?> name="profiletype" id="private" value="PRIVATE" checked="true"/><label for="private">Private</label>
								<input type="radio" <!--?php if(isset($_SESSION['profiletype']) && $_SESSION['profiletype'] == "PUBLIC") echo "checked='checked'"; ?> name="profiletype" id="public" value="PUBLIC"/><label for="public">PUJ</label>
								<input type="radio" <!--?php if(isset($_SESSION['profiletype']) && $_SESSION['profiletype'] == "OPERATOR") echo "checked='checked'"; ?> name="profiletype" id="operator" value="OPERATOR"/><label for="operator">Operator</label>
							</td>
						</tr-->
						<tr>
							<td><label for="lname">Last Name:</label></td>
							<td><input type="text" name="lname" id="lname" class="required" /></td>
						</tr>
						<tr>
							<td><label for="fname">First Name:</label></td>
							<td><input type="text" name="fname" id="fname" class="required" /></td>
						</tr>
						<tr>
							<td><label for="mname">Middle Name:</label></td>
							<td><input type="text" name="mname" id="mname" class="required" /></td>
						</tr>
						<tr>
							<td><label for="mname">Contact Number: (N/A if not applicable)</label></td>
							<td><input type="text" name="contactnumber" id="contactnumber" class="required" /></td>
						</tr>
						<tr>
							<td><label>Gender:</label></td>
							<td>
							<select name="gender" id="gender" class="required">
								<option value="F">Female</option>
								<option value="M">Male</option>
							</select>
							</td>
						</tr>
						<tr>
							<td><label>Civil Status:</label></td>
							<td>
							<select name="civil" id="civil" class="required">
								<option value="single">Single</option>
								<option value="married">Married</option>
								<option value="divorced">Divorced</option>
								<option value="separated">Separated</option>
								<option value="widowed">Widowed</option>
							</select>
							</td>
						</tr>
						<tr id="homeadd">
							<td><label for="homeadd">Home Address (Lot/Block/Street Number):</label></td>
							<td><input type="text" name="homeadd" id="homeadd" size="50" class="required" /></td>
						</tr>
						<tr>
							</td>
							<td><label for="homebrgy">Home Barangay:</label></td>
							<td><input type="text" name="homebrgy" id="homebrgy" class="required" /></td>
						</tr>
						<tr>
							</td>
							<td><label for="hometown">Home Town:</label></td>
							<td><input type="text" name="hometown" id="hometown" class="required" /></td>
						</tr>
						<tr>
							</td>
							<td><label for="homeprov">Home Province:</label></td>
							<td><input type="text" name="homeprov" id="homeprov" class="required" /></td>
						</tr>
						
						<tr id="officeadd">
							<td><label for="officeadd">Office Address:</label></td>
							<td><input type="text" name="officeadd" id="officeadd" size="50" class="required" /></td>
						</tr>
						<tr>
							<td><label for="offbrgy">Office Barangay:</label></td>
							<td><input type="text" name="offbrgy" id="offbrgy" class="required" /></td>
						</tr>
						<tr>
							<td><label for="offtown">Office Town:</label></td>
							<td><input type="text" name="offtown" id="offtown" class="required" /></td>
						</tr>
						<tr>
							<td><label for="offprov">Office Province:</label></td>
							<td><input type="text" name="offprov" id="offprov" class="required" /></td>
						</tr>
						<tr id="birthplace">
							<td><label for="birthplace">Birthplace:</label></td>
							<td><input type="text" name="birthplace" id="birthplace" class="required" /></td>
						</tr>
						<tr id="birthday">
							<td><label for="birthday">Birthday: (Format: YYYY-MM-DD)</label></td>
							<td><input type="text" name="birthday" id="birthday" class="required" /></td>
						</tr>
						<tr id="occupation">
							<td><label for="occupation">Present Occupation:</label></td>
							<td><input type="text" name="occupation" id="occupation" class="required" /></td>
						</tr>
						<tr id="cit">
							<td><label for="cit">Citizenship:</label></td>
							<td><input type="text" name="cit" id="cit" class="required" /></td>
						</tr>
						<tr id="license">
							<td><label for="license">Driver's License Number: (Format: LNN-NN-NNNNNN)</label></td>
							<td><input type="text" name="license" id="license" class="required" /></td>
						</tr>
						<tr id="where">
							<td><label for="whereIssued">Where was it issued? (LTO Branch)</label></td>
							<td><select name="whereIssued" id="whereIssued" class="required">
								<option value="D01">D01 - Batangas Licensing Center</option>
								<option value="D02">D02 - Imus District Office</option>
								<option value="D03">D03 - Boac District Office</option>
								<option value="D04">D04 - Boac District Office</option>
								<option value="D05">D05 - Calapan District Office</option>
								<option value="D06">D06 - Cavite Licensing Center</option>
								<option value="D07">D07 - Gumaca District Office</option>
								<option value="D08">D08 - Lipa District Office</option>
								<option value="D09">D09 - Quezon Licensing Center</option>
								<option value="D10">D10 - Romblon District Office</option>
								<option value="D11">D11 - Palawan District Office</option>
								<option value="D12">D12 - Pila District Office</option>
								<option value="D13">D13 - San Jose District Office</option>
								<option value="D14">D14 - Laguna Licensing Center</option>
								<option value="D16">D16 - Cainta Extension Office</option>
								<option value="D17">D17 - Cavite District Office</option>
								<option value="D18">D18 - Tagaytay Extension Office</option>
								<option value="D19">D19 - Binangonan Extension Office</option>
								<option value="D20">D20 - Taal Extension Office</option>
								<option value="D21">D21 - Santa Rosa DLRC</option>
								<option value="D22">D22 - Calamba District Office</option>
								<option value="D23">D23 - Dasmarinas District Office</option>
								<option value="D24">D24 - E Patrol District Office</option>
								<option value="A++">A++ - Region 1</option>
								<option value="B++">B++ - Region 2</option>
								<option value="C++">C++ - Region 3</option>
								<option value="E++">E++ - Region 5</option>
								<option value="N++">N++ - National Capital Region</option>
								<option value="OTHERS">Others</option>
							</select>
							</td>
						</tr>
						<tr id="when">
							<td><label for="when">When was is issued? (Format: YYYY-MM-DD)</label></td>
							<td><input type="text" name="when" id="when" class="required" /></td>
						</tr>
						<tr id="expiry">
							<td><label for="expiry">Expiry Date: (Format: YYYY-MM-DD)</label></td>
							<td><input type="text" name="expiry" id="expiry" class="required" /></td>
						</tr>
						<tr>
							<td><label for="picture">2x2 Picture</label></td>
							<td><input type="file" name="picture" id="picture"></td>
						</tr>
						<tr>
							<td><label for="licensepic">Scanned Image of License:</label></td>
							<td><input type="file" name="licensepic" id="licensepic"></td>
						</tr>
					</table>
					<br />
					<input type="submit" name="submit" value="Submit"/>
					<!--button onclick="javascript:showDetails();">Submit</button-->
					<br/>
				</form>
			</div>
		</div>
	</body>
</html>
<script language="javascript" type="text/javascript">
	function showDetails(){
		var message = "PLEASE REVIEW THE FOLLOWING INFORMATION BEFORE SUBMITTING" + "\n\n";
		
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
		var occupation = jQuery("input#occupation").val();
		var cit = jQuery("input#cit").val();
		var license = jQuery("input#license").val();
		var whereIssued = jQuery("select#whereIssued").val();
		var when = jQuery("input#when").val();
		var expiry = jQuery("input#expiry").val();
		
		message += "Last Name: " + lname + "\n"
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
			+ "Occupation: " + occupation + "\n"
			+ "License Number: " + license + "\n"
			+ "License Issued Date: " + whereIssued + "\n"
			+ "License Expiry Date: " + when + "\n";
		
		return confirm(message);
	}
</script>