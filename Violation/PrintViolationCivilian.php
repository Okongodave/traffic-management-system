<?php
session_start();

class PrintViolation
{
	function requestPrintViolation()
	{
		$root = "../";
		$data = $_SESSION['pcData'];
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
		
		$content .= "<p>CIVILIAN VIOLATION LIST (" . date("Y-m-d") . ")</p>";
		
		$content .= "
			<table id='result'>
				<tr>
					<th>License Number</th>
					<th>Driver ID</th>
					<th>Plate Number</th>
					<th>Violation</th>
					<th>Date</th>
					<th>Penalty</th>
					<th>Reporter</th>
				</tr>
		";
		
		foreach($data as $row)
		{
		$content .= "
				<tr>
					<td>".$row['licenseNumber']."</td>
					<td>".$row['driverID']."</td>
					<td>".$row['plateNumber']."</td>
					<td>".$row['violation']."</td>
					<td>".$row['violationDate']."</td>
					<td>".$row['penalty']."</td>
					<td>".$row['reporter']."</td>
				</tr>
		";
		}
		
		$content .= "
			</table>
		";
		
		$html2pdf = new HTML2PDF('L');
		$html2pdf->WriteHTML($content);
		$html2pdf->Output('Civilian Violation List '.date("Y-m-d").'.pdf');
		
		exit;
	}
}
$pv = new PrintViolation();
$pv->requestPrintViolation();
?>