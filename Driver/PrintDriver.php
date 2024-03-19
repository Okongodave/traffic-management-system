<?php
session_start();

class PrintDriver
{
	function requestPrintDriver()
	{
		$root = "../";
		$target = $root."files/profile/";
		$data = $_SESSION['pData'];
		$content = "";
		
		include $root."assets/library/html2pdf/html2pdf.class.php";
		
		$content .= "
			<style>
				th{
					text-align: center;
					background-color: #e6e6fa;
					color:#014421;
					border: 1px solid black;
				}
				
				td{
					color:#7b1113;
				}

				#result, #result td{
					border: 1px solid black;
					border-collapse: collapse;
					padding: 10px;
				}
			</style>
		";
		
		$content .= "<p>DRIVER LIST (" . date("Y-m-d") . ")</p>";
		
		$content .= "
			<table id='result'>
				<tr>
					<th></th>
					<th>Operator</th>
					<th>License Number</th>
					<th>Driver ID</th>
					<th>Name</th>
					<th>Age</th>
					<th>Birth Date</th>
					<th>Civil Status</th>
				</tr>
		";
		
		foreach($data as $row)
		{
		$content .= "
				<tr>
					<td><img src='".$target.$row['picture']."' style='width:XXXmm'></td>
					<td>".$row['operatorLastName'].", ".$row['operatorGivenName']." ".$row['operatorMiddleName']."</td>
					<td>".$row['licenseNumber']."</td>
					<td>".$row['driverID']."</td>
					<td>".$row['lastName'].", ".$row['givenName']." ".$row['middleName']."</td>
					<td>".$row['age']."</td>
					<td>".$row['birthDate']."</td>
					<td>".$row['civilStatus']."</td>
				</tr>
		";
		}
		
		$content .= "
			</table>
		";
		
		$html2pdf = new HTML2PDF('L');
		$html2pdf->WriteHTML($content);
		$html2pdf->Output('Driver List '.date("Y-m-d").'.pdf');
		
		exit;
	}
}
$pd = new PrintDriver();
$pd->requestPrintDriver();
?>