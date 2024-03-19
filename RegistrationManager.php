<!--
  - File Name: RegistrationManager.php
  - Program Description: Manipulate Database Queries
  -->
<?php
include "dbconnection.php";	//class that includes functions for database connections
//session_start();
class RegistrationManager
{
	//constructor
	function RegistrationManager(){
	}
	
	/* -- PROFILE ---------------------------------------------------------------------------------------------------- */
	
	function newRegistration($profiletype,$uname,$pword,$lname,$fname,$mname,$contactno,$gender,$civil,$homeadd,$homebrgy,$hometown,$homeprov,
		$offbrgy,$offtown,$offprov,$officeadd,$birthplace,$birthday,$occupation,$email,$cit,$license,$where,$when,$expiry,$picture,$licensepic)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
			
			$query = "
				INSERT INTO 
					table_profile (profileType, userName, password, lastName, givenName, middleName, contactNumber, gender, civilStatus, homeAddress, homeBrgy, homeTown, homeProvince, officeAddress, officeBrgy, officeTown, officeProvince, birthPlace, birthDate, emailAddress, occupation, citizenship, licenseNumber, licenseIssuedLTOBranch, licenseIssuedDate, licenseExpiryDate, picture, licensepic)
					VALUES ('".$profiletype."', '".$uname."', '".$pword."', '".$lname."', '".$fname."', '".$mname."', '".$contactno."', '".$gender."', '".$civil."', '".$homeadd."', '".$homebrgy."', '".$hometown."', '".$homeprov."', '".$officeadd."','".$offbrgy."', '".$offtown."', '".$offprov."', '".$birthplace."', '".$birthday."', '".$email."', '".$occupation."', '".$cit."', '".$license."','".$where."','".$when."','".$expiry."', '".$picture."', '".$licensepic."')
			";
			
			$code = md5($uname);
			$to = $fname." ".$lname." <".$email.">";
			$subject = "UPF Registration";
			$message = ""
				. "Good day " . $fname . "!" . "\r\n"
				. "\r\n"
				. "Thank you for using UPLB Vehicle Traffic Management System!" . "\r\n"
				. "\r\n"
				. "Here's your confirmation link:" . "\r\n"
				. "        localhost/upfdatabase/Registration/Confirm/?id=1&code=" . $code . "\r\n"
				. "\r\n"
				. "Please click the link above to complete your registration." . "\r\n"
				. "\r\n"
				. "UPF";
			$headers = "From: noreply@upfdatabase.com";
			
			if(!mail($to, $subject, $message, $headers)){
				$_SESSION['message'] = "The confirmation email is not sent.<br>Please go to the UPF office and inquire about this situation.";
			}
			$result = mysql_query($query);
			
			//if($profiletype == "PUBLIC" || $profiletype == "OPERATOR" || $profiletype == "DRIVER"){
			if($profiletype == "APPLICANT"){
				$id = mysql_insert_id();
				$this->addDriverID($id);
			}
			
		$connect->closeconnection($con);
		
		if($result > 0) {
			return 1;
		}
		else return 0;
	}
	
	function addDriverID($profileID)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "INSERT INTO table_driverID (profileID) VALUES ('".$profileID."')";
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		if($result > 0) {
			return 1;
		}
		else return 0;
	}
	
	function retrieveProfile($username)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		if($username == null){
			$query = "
				SELECT *, p.profileID AS pid
				FROM table_profile p
				LEFT JOIN table_driverID d ON p.profileID=d.profileID
				WHERE 
					profileType != 'ADMIN' AND
					profileType != 'OVCCA' AND
					profileType != 'CASHIER' AND
					profileType != 'INVESTIGATION' AND
					profileType != 'CASHIER'
			";
			
			// SEARCHING
			$combine = isset($_POST['searchCombine']) ? $_POST['searchCombine'] : "";
			$keyword = isset($_POST['searchKeyword']) ? $_POST['searchKeyword'] : "";
			$filters = isset($_POST['searchFilters']) ? $_POST['searchFilters'] : "";
			
			if($filters != ""){
				$combine = explode(';', $combine);
				$keyword = explode(';', $keyword);
				$filters = explode(';', $filters);
				
				$search = "";
				for($i=0; $i<count($filters); $i++)
				{
					$keyword[$i] = isset($keyword[$i]) ? $keyword[$i] : "";
					$search .= $combine[$i] . " " . $filters[$i] . " LIKE '%" . $keyword[$i] . "%' ";
				}
				
				if($search != "")
					$query .= " AND (" . $search . ")";
			}
		}
		else{
			$query = "
				SELECT *, p.profileID AS pid 
				FROM table_profile p
				LEFT JOIN table_driverID d ON p.profileID=d.profileID
				WHERE userName='$username'";
		}
		
		// SORTING
		$sortCol = (isset($_POST['sortColumn']) && $_POST['sortColumn'] != "") ? $_POST['sortColumn'] : "lastName, givenName, middleName";
		$query .= " ORDER BY ".$sortCol;
		
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		return $result;
	}
	
	function retrieveProfilebyId($id)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "
			SELECT * 
			FROM table_profile p
			LEFT JOIN table_driverID d ON p.profileID=d.profileID
			WHERE p.profileID='$id'
		";
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		return $result;
	}
	
	function retrieveProfilebyLicense($license)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "
			SELECT * 
			FROM table_profile p
			LEFT JOIN table_driverID d ON p.profileID=d.profileID
			WHERE p.licenseNumber='$license'
		";
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		return $result;
	}
	
	function checkLoginDetails($username,$password)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();	
		
		$query = "SELECT * FROM table_profile p	WHERE userName='$username' AND password='$password'";
		
		$result = mysql_query($query);
		
		$row = mysql_fetch_array($result);
		
		$connect->closeconnection($con);
		
		if(isset($row['userName'])){
			return $row;
		}
		else{
			return 0;
		}
	}
	
	function updateProfile($profiletype,$uname,$pword,$lname,$fname,$mname,$contactno,$gender,$civil,$homeadd,$homebrgy,$hometown,$homeprov,
		$offbrgy,$offtown,$offprov,$officeadd,$birthplace,$birthday,$occupation,$email,$cit,$license,$where,$when,$expiry,$picture,$licensepic)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "
			UPDATE
				table_profile
			SET
				password='$pword'
		";
		switch($_SESSION['profileType']){
			//case "OPERATOR":
			//case "PRIVATE":
			//case "PUBLIC":
			case "APPLICANT":
				$query .= "
						,userName='$uname', 
						lastName='$lname', 
						givenName='$fname', 
						middleName='$mname', 
						contactNumber='$contactno',
						homeAddress='$homeadd', 
						homeBrgy='$homebrgy', 
						homeTown='$hometown', 
						homeProvince='$homeprov', 
						officeAddress='$officeadd', 
						officeBrgy='$offbrgy', 
						officeTown='$offtown', 
						officeProvince='$offprov', 
						birthPlace='$birthplace', 
						birthDate='$birthday', 
						gender='$gender', 
						emailAddress='$email', 
						occupation='$occupation', 
						citizenship='$cit', 
						civilStatus='$civil', 
						licenseNumber='$license', 
						licenseIssuedLTOBranch='$where', 
						licenseIssuedDate='$when', 
						licenseExpiryDate='$expiry',
						picture='$picture',
						licensepic='$licensepic'
				";
		}
		$query .= "
			WHERE
				profileID='" . $_SESSION['profileID'] . "'
		";
		
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		if($result > 0) return 1;
		else return 0;
	}
	
	function showProfile($username)
	{
		$profile = $this->retrieveProfile($_SESSION['username']);
		
		/*print the table*/
		$row = mysql_fetch_array($profile, MYSQL_ASSOC);
		echo "Profile information:";
		
		echo "
		<table id='result'>
			<tr>
				<td>".'User Name'."</td>
				<td>".$row['userName']."</td>
			</tr>
		";
			//if($row['profileType'] == "PUBLIC" || $row['profileType'] == "OPERATOR")
			if($row['profileType'] == "APPLICANT")
			{
				if(isset($row['driverID'])){
					echo "
					<tr>
						<td>".'Driver ID Number'."</td>
						<td>".$row['driverID']."</td>
					</tr>
					";
				}else{
					echo "
					<tr>
						<td>".'Driver ID Number'."</td>
						<td><a style='float:right;' href='RenewDriverID.php/?id=".$row['pid']."'><img title='Renew driver ID' src='../assets/images/icons/refresh24.png' /></a></td>
					</tr>
					";
				}
			}
		echo "
			<tr>
				<td>".'Profile Type'."</td>
				<td>".$row['profileType']."</td>
			</tr>
			<tr>
				<td>".'Full Name'."</td>
				<td>".$row['lastName'].',  '.$row['givenName'].'  '.$row['middleName']."</td>
			</tr>
			<tr>
				<td>".'Home Address'."</td>
				<td>".$row['homeAddress'].', '.$row['homeBrgy'].', '.$row['homeTown'].', '.$row['homeProvince']."</td>
			</tr>
			<tr>
				<td>".'Office Address'."</td>
				<td>".$row['officeAddress'].', '.$row['officeBrgy'].', '.$row['officeTown'].', '.$row['officeProvince']."</td>
			</tr>
			<tr>
				<td>".'Birthplace'."</td>
				<td>".$row['birthPlace']."</td>
			</tr>
			<tr>
				<td>".'Birthday'."</td>
				<td>".$row['birthDate']."</td>
			</tr>
			<tr>
				<td>".'Gender'."</td>
				<td>".$row['gender']."</td>
			</tr>
			<tr>
				<td>".'Email Address'."</td>
				<td>".$row['emailAddress']."</td>
			</tr>
			<tr>
				<td>".'Occupation'."</td>
				<td>".$row['occupation']."</td>
			</tr>
			<tr>
				<td>".'Citizenship'."</td>
				<td>".$row['citizenship']."</td>
			</tr>
			<tr>
				<td>".'Civil Status'."</td>
				<td>".$row['civilStatus']."</td>
			</tr>
			<tr>
				<td>".'License Number'."</td>
				<td>".$row['licenseNumber']."</td>
			</tr>			
			<tr>
				<td>".'Where was it issued?'."</td>
				<td>".$row['licenseIssuedLTOBranch']."</td>
			</tr>
			<tr>
				<td>".'When was it issued?'."</td>
				<td>".$row['licenseIssuedDate']."</td>
			</tr>			
			<tr>
				<td>".'Expiry Date'."</td>
				<td>".$row['licenseExpiryDate']."</td>
			</tr>			
			";
		echo "</table> <br />";
	}
	
	function removeProfile($id)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "DELETE FROM table_profile WHERE profileID='$id'";
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		if($result > 0) return 1;
		else return 0;
	}
	
	/* -- VEHICLE ---------------------------------------------------------------------------------------------------- */
	
	function newVehicle($owner,$uname,$vehicletype,$plateno,$model,$year,$motor,$chassis,$color,$laststickeryear,$laststicker,$reference,$certReg,$receiptReg,$ltfrbFranchise,$insurance,$deed)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
	
		$query = " INSERT INTO table_vehicle (plateNumber, vehicleType, owner, model, year, motor, chassis, color, reference, certificationRegistration, receiptRegistration, LTFRBFranchise, insurance, deed)
				VALUES ('".$plateno."', '".$vehicletype."', '".$owner."', '".$model."', '".$year."', '".$motor."', '".$chassis."', '".$color."', '".$reference."', '".$certReg."', '".$receiptReg."', '".$ltfrbFranchise."', '".$insurance."', '".$deed."')
		";
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		if($result > 0) return 1;
		else return 0;
	}
	
	function retrieveVehicle($profileID)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		if($profileID != ""){
			$query = "SELECT * FROM table_vehicle v WHERE owner='$profileID'";
		}elseif($_SESSION['profileType'] == "ADMIN" || $_SESSION['profileType'] == "OVCCA" || $_SESSION['profileType'] == "CASHIER" || $_SESSION['profileType'] == "INVESTIGATION"){
			$query = "
				SELECT 
					v.*,
					p.userName,
					p.lastName,
					p.givenName,
					p.middleName,
						r.result
				FROM
					table_vehicle v
				INNER JOIN
					table_profile p ON v.owner = p.profileID
				LEFT JOIN
					table_reference r ON v.plateNumber = r.plateNumber
			";
		}else{
			$query = "SELECT * FROM table_vehicle v WHERE owner='$profileID'";
		}
		
		// SEARCHING
		$combine = isset($_POST['searchCombine']) ? $_POST['searchCombine'] : "";
		$keyword = isset($_POST['searchKeyword']) ? $_POST['searchKeyword'] : "";
		$filters = isset($_POST['searchFilters']) ? $_POST['searchFilters'] : "";
		
		if($filters != ""){
			$combine = explode(';', $combine);
			$keyword = explode(';', $keyword);
			$filters = explode(';', $filters);
			
			$search = "";
			for($i=0; $i<count($filters); $i++)
			{
				$keyword[$i] = isset($keyword[$i]) ? $keyword[$i] : "";
				$search .= $combine[$i] . " " . $filters[$i] . " LIKE '%" . $keyword[$i] . "%' ";
			}
			
			if($search != "")
				$query .= " WHERE " . $search;
		}
		
		// SORTING
		$sortCol = (isset($_POST['sortColumn']) && $_POST['sortColumn'] != "") != "" ? $_POST['sortColumn'] : "status"; // default sorted column is status
		$query .= "ORDER BY ".$sortCol;
		
		$result = mysql_query($query);
		$connect->closeconnection($con);
		
		return $result;
	}
	
	function updateVehicle($uname,$plateno,$model,$year,$motor,$chassis,$color,$laststickeryear,$laststicker,$certReg,$receiptReg,$ltfrbFranchise,$insurance,$deed)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
			//$query = "UPDATE table_vehicle SET model='$model', year='$year', motor='$motor', chassis='$chassis', color='$color', lastStickerIssuedDate='$laststickeryear', lastStickerNumber='$laststicker', reference='$reference' WHERE plateNumber='$plateno'";
			$query = "
				UPDATE 
					table_vehicle 
				SET 
					model='$model', 
					year='$year', 
					motor='$motor', 
					chassis='$chassis', 
					color='$color', 
					lastStickerIssuedDate='$laststickeryear', 
					lastStickerNumber='$laststicker', 
					certificationRegistration='$certReg',
					receiptRegistration='$receiptReg',
					LTFRBFranchise='$ltfrbFranchise',
					insurance='$insurance',
					deed='$deed'
				WHERE plateNumber='$plateno'";
				//echo $query;die();
			$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		if($result > 0) return 1;
		else return 0;
	}
	
	function showVehicle($profileID)
	{
		$vehicles = $this->retrieveVehicle($profileID);
		
		if(mysql_num_rows($vehicles) == 0)
		{
			echo "There are no current vehicle for this user.";
		}
		else
		{
			$row = mysql_fetch_array($vehicles);
			
			echo "<table id='result' width='100%'>";
				echo "<tr>";
						if($_SESSION['profileType'] == "ADMIN" || $_SESSION['profileType'] == "OVCCA" || $_SESSION['profileType'] == "INVESTIGATION")
							echo "<th>Owner Username</th>";
				echo "
						<th>Plate Number</th>
						<th>Type</th>
						<th>Model</th>
						<th>Year</th>
						<th>Motor</th>
						<th>Chassis</th>
						<th>Color</th>
						<th>Sticker Number</th>
						<th>Sticker Date Issued</th>
						<th>Status</th>
						<th>Edit</th>
						<th>Delete</th>
						<th>Resend</th>
					</tr>
				";
				while($row != null){
					echo "<tr>";
						if($_SESSION['profileType'] == "ADMIN" || $_SESSION['profileType'] == "OVCCA" || $_SESSION['profileType'] == "INVESTIGATION")
							echo "<td>".$row['userName']."</td>";
					echo "
						<td>".$row['plateNumber']."</td>
						<td>".$row['vehicleType']."</td>
						<td>".$row['model']."</td>
						<td>".$row['year']."</td>
						<td>".$row['motor']."</td>
						<td>".$row['chassis']."</td>
						<td>".$row['color']."</td>
						<td>".$row['stickerNumber']."</td>
						<td>".$row['stickerIssuedDate']."</td>
						<td align='center'>";
							if($row['block'] == 1){
								echo "block";
							}elseif($row['status'] == "released"){
								echo $row['status'];
							}elseif($row['paid'] != "0000-00-00"){
								echo "paid";
							}else{
								echo $row['status'].($row['status']=="disapproved" ? ("<br>-<br>".$row['condition']) : "");
							}
					echo"
						</td>
					";
					
						if($row['block'] == 1){
							echo "<td><img title='Vehicle blocked' src='../assets/images/icons/edit24_x.png' /></td>";
							echo "<td><img title='Vehicle blocked' src='../assets/images/icons/delete24_x.png' /></td>";
						}elseif($row['status'] == "approved"){
							echo "<td><img title='Vehicle already approved' src='../assets/images/icons/edit24_x.png' /></td>";
							echo "<td><img title='Vehicle already approved' src='../assets/images/icons/delete24_x.png' /></td>";
						}elseif($row['status'] == "disapproved"){
							echo "<td><a href='../Vehicle/Update/?pn=".$row['plateNumber']."'><img title='Edit Vehicle' src='../assets/images/icons/edit24.png' /></a></td>";
							echo "<td><img title='Cannot delete vehicle' src='../assets/images/icons/delete24_x.png' /></td>";
						}
						elseif($row['paid'] == "0000-00-00"){
							echo "<td><a href='../Vehicle/Update/?pn=".$row['plateNumber']."'><img title='Edit Vehicle' src='../assets/images/icons/edit24.png' /></a></td>";
							echo "<td><a href='../Vehicle/DeleteVehicle.php/?pn=".$row['plateNumber']."'><img title='Delete Vehicle' src='../assets/images/icons/delete24.png' /></a></td>";
						}else{
							echo "<td><img title='Edit Vehicle' src='../assets/images/icons/edit24_x.png' /></td>";
							echo "<td><img title='Delete Vehicle' src='../assets/images/icons/delete24_x.png' /></td>";
						}
						
						if($row['status'] == "disapproved"){
							echo "<td><a href='./VehicleController.php/?task=refresh&pn=".$row['plateNumber']."'><img title='resend application' src='../assets/images/icons/refresh24.png'></a></td>";
						}else{
							echo "<td><img title='no need to resend application' src='../assets/images/icons/refresh24_x.png'></td>";
						}
					echo "</tr>";
					$row = mysql_fetch_array($vehicles);
				}
			echo "</table>";
		}
	}
	
	function removeReferenceNumber($plateno)
	{
		$connect = new dbConnection();
		$con = $connect->connectdb();
		
		$query = "DELETE FROM table_reference WHERE plateNumber='$plateno'";
		$result = mysql_query($query);
		
		$connect->closeConnection($con);
		
		return $result;
	}
	
	function removeVehicle($plateno)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "DELETE FROM table_vehicle WHERE plateNumber='$plateno'";
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		if($result > 0) return 1;
		else return 0;
	}
	
	function removeVehicleByUser($profileID)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "DELETE FROM table_vehicle WHERE owner='$profileID'";
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		if($result > 0) return 1;
		else return 0;
	}
	
	function blockVehicle($plateno, $block)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "UPDATE table_vehicle SET block='$block' WHERE plateNumber='$plateno'";
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		if($result > 0) return 1;
		else return 0;
	}
	
	function resetVehicleViolation($plateno)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "UPDATE table_vehicle SET violation='0' WHERE plateNumber='$plateno'";
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		if($result > 0) return 1;
		else return 0;
	}
	
	function vehicleStatus($status, $message, $plateno)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "UPDATE table_vehicle SET status='$status', `condition`='$message' WHERE plateNumber='$plateno'";
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		if($result > 0) return 1;
		else return 0;
	}
	
	function checkVehicleStatus($plateno)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "SELECT * FROM table_vehicle WHERE plateNumber='".$plateno."'";
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		return mysql_fetch_array($result);
	}
	
	function addStickerNumber($plateno, $stickerno, $stickerdate)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "
			UPDATE
				table_vehicle
			SET
				stickerNumber='".$stickerno."',
				stickerIssuedDate='".$stickerdate."',
				status='released',
				`condition`=''
			WHERE
				plateNumber='".$plateno."'
		";
		//die($query);
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		return $result;
	}
	
	function checkInspectionSchedule($date)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "
			SELECT 
				COUNT(inspection) AS schedule
			FROM 
				table_vehicle
			WHERE 
				inspection = '".$date."'
		";
		
		$result = mysql_query($query);
		$schedule = mysql_fetch_assoc($result);
		
		$connect->closeconnection($con);
		
		return $schedule['schedule'];
	}
	
	/* -- DRIVER ---------------------------------------------------------------------------------------------------- */
	
	function newDriver($operatorID, $username, $lastname, $givenName, $middleName, $age, $civilStatus, $homeAddress, $homeBarangay, $homeTown, $homeProvince, $licenseNumber, $validUntil, $spouseName, $spouseOccupation, $picture, $licensepic)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
			
		$query = "
			INSERT INTO
				table_profile (profileType, lastName, givenName, middleName, age, civilStatus, homeAddress, homeBrgy, homeTown, homeProvince, licenseNumber, licenseExpiryDate, spouseName, spouseOccupation, picture, licensepic)
				VALUES ('DRIVER', '".$lastname."', '".$givenName."', '".$middleName."', '".$age."', '".$civilStatus."', '".$homeAddress."', '".$homeBarangay."', '".$homeTown."', '".$homeProvince."', '".$licenseNumber."', '".$validUntil."', '".$spouseName."', '".$spouseOccupation."', '".$picture."', '".$licensepic."')
		";
		$result = mysql_query($query);
		
		$profileID = mysql_insert_id();
		$query = "
			INSERT INTO
				table_driver
				VALUES ('".$profileID."', '".$operatorID."')
		";
		$result2 = mysql_query($query);
		
		$this->addDriverID($profileID);
		
		$connect->closeconnection($con);
		
		if($result > 0 && $result2 > 0) return 1;
		else return 0;
	}
	
	function retrieveDrivers($operatorNo)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "
			SELECT
				d.*,
				p.*,
				o.userName AS operatorUsername,
				o.lastName AS operatorLastName,
				o.givenName AS operatorGivenName,
				o.middleName AS operatorMiddleName,
				id.driverID AS driverID
			FROM
				table_driver d
			LEFT JOIN
				table_driverID id ON id.profileID = d.driver
			INNER JOIN
				table_profile p ON p.profileID = d.driver
			INNER JOIN
				table_profile o ON o.profileID = d.operator
		";
		
		//if($_SESSION['profileType'] == "OPERATOR" || $_SESSION['profileType'] == "PUBLIC" || $_SESSION['profileType'] == "PRIVATE"){
		if($_SESSION['profileType'] == "APPLICANT" || $operatorNo != ""){
			$query .= " WHERE operator='$operatorNo'";
		}
		
		// SEARCHING
		$combine = isset($_POST['searchCombine']) ? $_POST['searchCombine'] : "";
		$keyword = isset($_POST['searchKeyword']) ? $_POST['searchKeyword'] : "";
		$filters = isset($_POST['searchFilters']) ? $_POST['searchFilters'] : "";
		
		if($filters != ""){
			$combine = explode(';', $combine);
			$keyword = explode(';', $keyword);
			$filters = explode(';', $filters);
			
			$search = "";
			for($i=0; $i<count($filters); $i++)
			{
				$keyword[$i] = isset($keyword[$i]) ? $keyword[$i] : "";
				$search .= $combine[$i] . " " . $filters[$i] . " LIKE '%" . $keyword[$i] . "%' ";
			}
			
			if($search != ""){
				if($_SESSION['profileType'] != "ADMIN"){
					$query .= " AND (" . $search . ")";
				}else{
					$query .= " WHERE (" . $search . ")";
				}
			}
		}
		
		// SORTING
		$sortCol = (isset($_POST['sortColumn']) && $_POST['sortColumn'] != "") ? $_POST['sortColumn'] : "p.lastName, p.givenName";
		$query .= " ORDER BY ".$sortCol;
		
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		return $result;
	}
	
	function retrieveDriver($id)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "
			SELECT
				d.*,
				p.*,
				o.userName AS operatorUsername,
				o.lastName AS operatorLastName,
				o.givenName AS operatorGivenName,
				o.middleName AS operatorMiddleName,
				id.driverID AS driverID
			FROM
				table_driver d
			LEFT JOIN
				table_driverID id ON id.profileID = d.driver
			INNER JOIN
				table_profile p ON p.profileID = d.driver
			INNER JOIN
				table_profile o ON o.profileID = d.operator
			WHERE p.profileID = '$id'
		";
		
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		return $result;
	}
	
	function updateDriver($lastname, $givenName, $middleName, $age, $civilStatus, $homeAddress, $homeBarangay, $homeTown, $homeProvince, $licenseNumber, $validUntil, $spouseName, $spouseOccupation, $picture)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "
			UPDATE
				table_profile 
			SET
				lastName='$lastname', 
				givenName='$givenName', 
				middleName='$middleName', 
				age='$age', 
				civilStatus='$civilStatus', 
				homeAddress='$homeAddress', 
				homeBrgy='$homeBarangay', 
				homeTown='$homeTown', 
				homeProvince='$homeProvince', 
				licenseNumber='$licenseNumber',
				licenseExpiryDate='$validUntil', 
				spouseName='$spouseName', 
				spouseOccupation='$spouseOccupation',
				picture='$picture'
			WHERE
				profileID='".$_SESSION['editdriverprofileid']."'
		";
		
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		if($result > 0) return 1;
		else return 0;
	}
	
	function showDriver($operatorNo)
	{
		$drivers = $this->retrieveDrivers($operatorNo);
		
		/*print the table*/
		$row = mysql_fetch_array($drivers);
		echo $row == null ? "There are no drivers registered yet." : "";
		
		$target = "../files/profile/";
		
		echo "
			<table id='result'>
				<tr>
					<th></th>
					<th>Operator</th>
					<th>Driver ID</th>
					<th>Name</th>
					<th>License Number</th>
					<th></th>
					<th></th>
				</tr>
		";
		while($row != null)
		{
			echo "
				<tr>
					<td><img src='".$target.$row['picture']."' width='100'></td>
					<td>".$row['operatorLastName'].", ".$row['operatorGivenName']." ".$row['operatorMiddleName']."</td>
					<td>".$row['driverID']."</td>
					<td>".$row['lastName'].", ".$row['givenName']." ".$row['middleName']."</td>
					<td>".$row['licenseNumber']."</td>
					<td><a href='../Driver/Update/?id=".$row['profileID']."'><img src='../assets/images/icons/edit24.png'></a></td>
					<td><a href='../Driver/DeleteDriver.php/?id=".$row['profileID']."'><img src='../assets/images/icons/delete24.png'></a></td>
				</tr>
			";
			$row = mysql_fetch_array($drivers);
		}
		echo "</table>";
	}
	
	function requestRemoveDriver($driverPID, $operator)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "INSERT INTO table_request (request, profile, requestor) VALUES ('delete', '".$driverPID."', '".$operator."')";
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		if($result > 0) return 1;
		else return 0;
	}
	
	function requestUpdateDriver($driverPID, $operator, $notes)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "INSERT INTO table_request (request, profile, requestor, notes) VALUES ('edit', '".$driverPID."', '".$operator."', '".$notes."')";
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		if($result > 0) return 1;
		else return 0;
	}
	
	function removeDriver($driverPID)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "DELETE FROM table_driver WHERE driver='$driverPID'";
		$result = mysql_query($query);
		$query = "DELETE FROM table_profile WHERE profileID='$driverPID'";
		$result2 = mysql_query($query);
		
		$connect->closeconnection($con);
		
		if($result > 0 && $result2 > 0) return 1;
		else return 0;
	}
	
	function detachDriver($driverPID)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "DELETE FROM table_driver WHERE driver='$driverPID'";
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		if($result > 0) return 1;
		else return 0;
	}
	
	function attachDriver($driver, $operator)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "INSERT INTO table_driver (driver, operator) VALUES ('".$driver."', '".$operator."')";
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		if($result > 0) return 1;
		else return 0;
	}
	
	/* >>> check if driver exist without operator */
	function checkDriverProfile($license)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "
			SELECT 
				* 
			FROM
				table_profile
			WHERE 
				licenseNumber='$license'
		";
		
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		return $result;
	}
	
	function checkDriverOperator($id)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "
			SELECT 
				* 
			FROM
				table_driver
			WHERE 
				driver='$id'
		";
		
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		return $result;
	}
	
	/* check if driver exists without operator <<< */
	
	/* -- CASHIER ---------------------------------------------------------------------------------------------------- */
	
	function retrieveToPayApplicants()
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "
			SELECT 
				*,
				v.status AS vstatus
			FROM
				table_vehicle v
			INNER JOIN
				table_profile p ON p.profileID = v.owner
			WHERE 
				p.profileType != 'ADMIN' AND
				p.profileType != 'OVCCA' AND
				p.profileType != 'CASHIER'
		";
		
		// SEARCHING
		$combine = isset($_POST['searchCombine']) ? $_POST['searchCombine'] : "";
		$keyword = isset($_POST['searchKeyword']) ? $_POST['searchKeyword'] : "";
		$filters = isset($_POST['searchFilters']) ? $_POST['searchFilters'] : "";
		
		if($filters != ""){
			$combine = explode(';', $combine);
			$keyword = explode(';', $keyword);
			$filters = explode(';', $filters);
			
			$search = "";
			for($i=0; $i<count($filters); $i++)
			{
				$keyword[$i] = isset($keyword[$i]) ? $keyword[$i] : "";
				$search .= $combine[$i] . " " . $filters[$i] . " LIKE '%" . $keyword[$i] . "%' ";
			}
			
			if($search != "")
				$query .= " AND (" . $search . ")";
			
		}
		
		// SORTING
		$sortCol = (isset($_POST['sortColumn']) && $_POST['sortColumn'] != "") != "" ? $_POST['sortColumn'] : "plateNumber";
		$query .= "ORDER BY ".$sortCol;
		
		$result = mysql_query($query);
		$connect->closeconnection($con);
		
		return $result;
	}
	
	function applicantPayment($plateNo)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$date = date("Y-m-d");
		
		$query = "UPDATE table_vehicle SET paid='".$date."' WHERE plateNumber='$plateNo'";
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		if($result > 0) return 1;
		else return 0;
	}
	
	/* -- APPLICANT ---------------------------------------------------------------------------------------------------- */
	
	function blockApplicant($profileID, $block)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "UPDATE table_profile SET block='$block' WHERE profileID='$profileID'";
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		if($result > 0) return 1;
		else return 0;
	}
	
	function updateApplicant($id,$profiletype,$uname,$pword,$lname,$fname,$mname,$contactno,$gender,$civil,$homeadd,$homebrgy,$hometown,$homeprov,
		$offbrgy,$offtown,$offprov,$officeadd,$birthplace,$birthday,$occupation,$email,$cit,$license,$where,$when,$expiry,$picture,$licensepic)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "
			UPDATE
				table_profile
			SET
				password='$pword',
				userName='$uname', 
				lastName='$lname', 
				givenName='$fname', 
				middleName='$mname', 
				contactNumber='$contactno',
				homeAddress='$homeadd', 
				homeBrgy='$homebrgy', 
				homeTown='$hometown', 
				homeProvince='$homeprov', 
				officeAddress='$officeadd', 
				officeBrgy='$offbrgy', 
				officeTown='$offtown', 
				officeProvince='$offprov', 
				birthPlace='$birthplace', 
				birthDate='$birthday', 
				gender='$gender', 
				emailAddress='$email', 
				occupation='$occupation', 
				citizenship='$cit', 
				civilStatus='$civil', 
				licenseNumber='$license', 
				licenseIssuedLTOBranch='$where', 
				licenseIssuedDate='$when', 
				licenseExpiryDate='$expiry',
				picture='$picture',
				licensepic='$licensepic'
			WHERE
				profileID='" . $id . "'
		";
		//die($query);
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		if($result > 0) return 1;
		else return 0;
	}
	
	/* -- VIOLATION ---------------------------------------------------------------------------------------------------- */
	
	function newViolation($license, $driver, $plateno, $violation, $vdate, $vtime, $vlocation, $penalty, $reporter, $reporterContact, $approve, $evidence)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "
			INSERT INTO
				table_violation (licenseNumber, driverID, plateNumber, violation, violationDate, violationTime, violationLocation, penalty, reporter, reporterContact, approve)
			VALUES
				('".$license."', '".$driver."', '".$plateno."', '".$violation."', '".$vdate."', '".$vtime."', '".$vlocation."', '".$penalty."', '".$reporter."', '".$reporterContact."', '".$approve."')
		";
		$result = mysql_query($query);
		
		$id = mysql_insert_id();
		
		if($evidence['name'] == "")
			$evidence = "";
		else{
			//filetype
			if($evidence['type'] != "image/jpeg")
				$filetype = "jpg";
			elseif($evidence['type'] != "image/png")
				$filetype = "png";
			elseif($evidence['type'] != "image/gif")
				$filetype = "gif";
			
			$target = "../../files/evidence/";
			$filename = $target.$id.".".$filetype;
			
			move_uploaded_file($evidence['tmp_name'], $filename);
			
			$evidence = $id.".".$filetype;
		}
		
		if($evidence != ""){
			$query = "UPDATE table_violation SET evidence='$evidence' WHERE violationNumber='$id'";
			mysql_query($query);
		}
		
		$connect->closeconnection($con);
		
		if($result > 0) return 1;
		else return 0;
	}
	
	function increaseVehicleViolation($plateno)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "UPDATE table_vehicle SET violation=violation+1 WHERE plateNumber='".$plateno."'";
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
	}
	
	function decreaseVehicleViolation($plateno)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "UPDATE table_vehicle SET violation=violation-1 WHERE plateNumber='".$plateno."'";
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
	}
	
	function increaseUserViolation($id)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "UPDATE table_profile SET violation=violation+1 WHERE profileID='".$id."'";
		echo $query;
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
	}
	
	function increaseUserViolationViaLicense($license)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "UPDATE table_profile SET violation=violation+1 WHERE licenseNumber='".$license."'";
		echo $query;
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
	}
	
	function decreaseUserViolation($id)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "UPDATE table_profile SET violation=violation-1 WHERE profileID='".$id."'";
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
	}
	
	function retrieveViolations($where)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "SELECT * FROM table_violation";
		
		if($where != ""){
			$query .= " WHERE ".$where;
		}
		
		// SEARCHING
		$combine = isset($_POST['searchCombine']) ? $_POST['searchCombine'] : "";
		$keyword = isset($_POST['searchKeyword']) ? $_POST['searchKeyword'] : "";
		$filters = isset($_POST['searchFilters']) ? $_POST['searchFilters'] : "";
		
		if($filters != ""){
			$combine = explode(';', $combine);
			$keyword = explode(';', $keyword);
			$filters = explode(';', $filters);
			
			$search = "";
			for($i=0; $i<count($filters); $i++)
			{
				$keyword[$i] = isset($keyword[$i]) ? $keyword[$i] : "";
				$search .= $combine[$i] . " " . $filters[$i] . " LIKE '%" . $keyword[$i] . "%' ";
			}
			
			if($search != ""){
				if($where == "")
					$query .= " WHERE " . $search;
				else
					$query .= " AND (" . $search . ")";
			}
		}
		
		// SORTING
		$sortCol = (isset($_POST['sortColumn']) && $_POST['sortColumn'] != "") ? $_POST['sortColumn'] : "violationDate";
		$query .= " ORDER BY ".$sortCol;
		
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		return $result;
	}
	
	function updateViolation($license, $driver, $plateno, $violation, $vdate, $vtime, $vlocation, $penalty, $reporter, $reporterContact, $evidence)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "
			UPDATE
				table_violation
			SET 
				licenseNumber='$license',
				driverID='$driver', 
				plateNumber='$plateno',
				violation='$violation', 
				violationDate='$vdate', 
				violationTime='$vtime', 
				violationLocation='$vlocation', 
				reporter='$reporter', 
				reporterContact='$reporterContact', 
				penalty='$penalty',
				evidence='$evidence'
			WHERE
				violationNumber='".$_SESSION['violationNo']."'
		";
		
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		if($result > 0) return 1;
		else return 0;
	}
	
	function removeViolation($violationno)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "DELETE FROM table_violation WHERE violationNumber='$violationno'";
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		if($result > 0) return 1;
		else return 0;
	}
	
	function removeViolationByVehicle($plateno)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "DELETE FROM table_violation WHERE plateNumber='$plateno'";
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		if($result > 0) return 1;
		else return 0;
	}
	
	function removeViolationByUser($id)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "DELETE FROM table_violation WHERE driverID='$id'";
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		if($result > 0) return 1;
		else return 0;
	}
	
	function approveViolation($violationno)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "UPDATE table_violation SET approve='1' WHERE violationNumber='$violationno'";
		//echo $query;die();
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		if($result > 0) return 1;
		else return 0;
	}
	
	function retrieveOperatorDriverViolation($operator)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "
			SELECT *
			FROM table_driver d
			INNER JOIN table_driverID dd ON dd.profileID=d.driver
			INNER JOIN table_violation v ON v.driverID=dd.driverID
			WHERE operator='$operator' AND approve=1
		";
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		return $result;
	}
	
	/* -- CONFIRMATION ---------------------------------------------------------------------------------------------------- */
	
	function getUsername($username)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "SELECT * FROM table_profile WHERE username='$username'";
		$result = mysql_query($query);
		$count = mysql_num_rows($result);
		$row = mysql_fetch_array($result);
		
		$connect->closeconnection($con);
		
		if($count > 0)
			return 1;
		return $row['emailAddress'];
	}
	
	function checkProfile($column, $data)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "SELECT * FROM table_profile WHERE $column='$data'";
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		return mysql_num_rows($result);
	}
	
	function checkVehicle($column, $data)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "SELECT * FROM table_vehicle WHERE $column='$data'";
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		return mysql_num_rows($result);
	}
	
	function confirmEmail($username)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "UPDATE table_profile SET status='active' WHERE userName='$username'";
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
	}
	
	function checkEmail($email)
	{
		$connect = new dbConnection();
		$con = $connect->connectdb();
		
		$query = "SELECT * FROM table_profile WHERE emailAddress='$email'";
		$result = mysql_query($query);
		$profile = mysql_fetch_array($result);
		
		$connect->closeconnection($con);
		
		return $profile;
	}
	
	function checkDriverId($driverID)
	{
		$connect = new dbConnection();
		$con = $connect->connectdb();
		
		//$query = "SELECT * FROM table_driverID WHERE driverID='$driverID'";
		$query = "
			SELECT
				*
			FROM
				table_driverID d
			INNER JOIN
				table_profile p ON p.profileID = d.profileID
			WHERE 
				driverID='$driverID'
		";
		$result = mysql_query($query);
		$profile = mysql_fetch_array($result);
		
		$connect->closeconnection($con);
		
		return $profile;
	}
	
	/* -- OPTION ---------------------------------------------------------------------------------------------------- */
	
	function setMaxViolation($max)
	{
		$connect = new dbConnection();
		$con = $connect->connectdb();
		
		$query = "UPDATE table_option SET value='$max' WHERE `option`='maxViolation'";
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		return $result;
	}
	
	function setMaxInspection($max)
	{
		$connect = new dbConnection();
		$con = $connect->connectdb();
		
		$query = "UPDATE table_option SET value='$max' WHERE `option`='maxInspection'";
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		return $result;
	}
	
	function retrieveOptions()
	{
		$connect = new dbConnection();
		$con = $connect->connectdb();
		
		$query = "SELECT * FROM table_option";
		$result = mysql_query($query);
		
		$connect->closeConnection($con);
		
		return $result;
	}
	
	/* -- REFERENCE NUMBER ---------------------------------------------------------------------------------------------------- */
	
	function retrieveInspectionResults($where)
	{
		$connect = new dbConnection();
		$con = $connect->connectdb();
		
		$query = "SELECT * FROM table_reference";
		
		if($where != ""){
			$query .= " WHERE " . $where;
		}
		
		// SEARCHING
		$combine = isset($_POST['searchCombine']) ? $_POST['searchCombine'] : "";
		$keyword = isset($_POST['searchKeyword']) ? $_POST['searchKeyword'] : "";
		$filters = isset($_POST['searchFilters']) ? $_POST['searchFilters'] : "";
		
		if($filters != ""){
			$combine = explode(';', $combine);
			$keyword = explode(';', $keyword);
			$filters = explode(';', $filters);
			
			$search = "";
			for($i=0; $i<count($filters); $i++)
			{
				$keyword[$i] = isset($keyword[$i]) ? $keyword[$i] : "";
				$search .= $combine[$i] . " " . $filters[$i] . " LIKE '%" . $keyword[$i] . "%' ";
			}
			
			if($search != ""){
				if($where == "")
					$query .= " WHERE (" . $search . ")";
				else
					$query .= " AND (" . $search . ")";
			}
		}
		
		// SORTING
		$sortCol = (isset($_POST['sortColumn']) && $_POST['sortColumn'] != "") ? $_POST['sortColumn'] : "result, plateNumber";
		$query .= " ORDER BY ".$sortCol;
		
		$result = mysql_query($query);
		
		$connect->closeConnection($con);
		
		return $result;
	}
	
	function checkReferenceNumber($number)
	{
		$connect = new dbConnection();
		$con = $connect->connectdb();
		
		$query = "SELECT * FROM table_reference WHERE referenceNumber='$number'";
		$result = mysql_query($query);
		$count = mysql_num_rows($result);
		
		$connect->closeConnection($con);
		
		if($count > 0)
			return 0;
		return 1;
	}
	
	// Display reference number if plate number already exist
	function checkReferencePlate($plate)
	{
		$connect = new dbConnection();
		$con = $connect->connectdb();
		
		$query = "SELECT * FROM table_reference WHERE plateNumber='$plate'";
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		
		$connect->closeConnection($con);
		
		if($row)
			return $row;
		return 0;
	}
	
	function addReferenceNumber($testresult, $plateno, $refno, $failreason)
	{
		$connect = new dbConnection();
		$con = $connect->connectdb();
		
		$query = "INSERT INTO table_reference (result, plateNumber, referenceNumber, notes) VALUES ('".$testresult."', '".$plateno."', '".$refno."', '".$failreason."')";
		$result = mysql_query($query);
		
		$connect->closeConnection($con);
		
		return $result;
	}
	
	function updateInspection($testresult, $plateno, $refno, $failreason)
	{
		$connect = new dbConnection();
		$con = $connect->connectdb();
		
		//$query = "INSERT INTO table_reference (result, plateNumber, referenceNumber, notes) VALUES ('".$testresult."', '".$plateno."', '".$refno."', '".$failreason."')";
		$query = "
			UPDATE
				table_reference 
			SET
				result='".$testresult."', 
				referenceNumber='".$refno."', 
				notes='".$failreason."'
			WHERE
				plateNumber='".$plateno."'
		";
		//die($query);
		$result = mysql_query($query);
		
		$connect->closeConnection($con);
		
		return $result;
	}
	
	/* -- LOGS ---------------------------------------------------------------------------------------------------- */
	
	function retrieveLogs()
	{
		$connect = new dbConnection();
		$con = $connect->connectdb();
		
		$query = "SELECT * FROM table_log";
		
		// SEARCHING
		$combine = isset($_POST['searchCombine']) ? $_POST['searchCombine'] : "";
		$keyword = isset($_POST['searchKeyword']) ? $_POST['searchKeyword'] : "";
		$filters = isset($_POST['searchFilters']) ? $_POST['searchFilters'] : "";
		
		if($filters != ""){
			$combine = explode(';', $combine);
			$keyword = explode(';', $keyword);
			$filters = explode(';', $filters);
			
			$search = "";
			for($i=0; $i<count($filters); $i++)
			{
				$keyword[$i] = isset($keyword[$i]) ? $keyword[$i] : "";
				$search .= $combine[$i] . " " . $filters[$i] . " LIKE '%" . $keyword[$i] . "%' ";
			}
			
			if($search != "")
				$query .= " WHERE (" . $search . ")";
		}
		
		// SORTING
		$sortCol = (isset($_POST['sortColumn']) && $_POST['sortColumn'] != "") ? $_POST['sortColumn'] : "datetime DESC";
		$query .= " ORDER BY ".$sortCol;
		
		$result = mysql_query($query);
		
		$connect->closeConnection($con);
		
		return $result;
	}
	
	function newLog($change)
	{
		$connect = new dbConnection();
		$con = $connect->connectdb();
		
		$query = "
			INSERT INTO 
				table_log (user, notes)
			VALUES 
				('".$_SESSION['username']."', '".$change."')
		";
		$result = mysql_query($query);
		
		$connect->closeConnection($con);
	}
	
	/* -- REQUEST ---------------------------------------------------------------------------------------------------- */
	function retrieveRequests()
	{
		$connect = new dbConnection();
		$con = $connect->connectdb();
		
		$query = "
			SELECT
				r.id,
				r.request,
				r.notes,
				pp.givenName AS dGivenName,
				pp.middleName AS dMiddleName,
				pp.lastName AS dLastName,
				pr.givenName AS oGivenName,
				pr.middleName AS oMiddleName,
				pr.lastName AS oLastName
			FROM 
				table_request r
			INNER JOIN
				table_profile pp ON pp.profileID = r.profile
			INNER JOIN
				table_profile pr ON pr.profileID = r.requestor
		";
		
		$result = mysql_query($query);
		
		$connect->closeConnection($con);
		
		return $result;
	}
	
	function removeRequest($id)
	{
		$connect = new dbconnection();
		$con = $connect->connectdb();
		
		$query = "DELETE FROM table_request WHERE id='$id'";
		$result = mysql_query($query);
		
		$connect->closeconnection($con);
		
		if($result > 0) return 1;
		else return 0;
	}
}
?>
