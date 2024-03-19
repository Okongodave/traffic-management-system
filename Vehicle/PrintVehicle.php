<?php
session_start();

class PrintVehicle
{
	function requestPrintVehicle()
	{
		$root = "../";
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
		
		$content .= "<p>VEHICLE LIST (" . date("Y-m-d") . ")</p>";
		
		$content .= "
			<table id='result'>
				<tr>
					<th>Owner</th>
					<th>Plate Number</th>
					<th>Vehicle Type</th>
					<th>Model</th>
					<th>Year</th>
					<th>Motor</th>
					<th>Chassis</th>
					<th>Color</th>
					<th>Sticker Number</th>
					<th>Status</th>
					<th>Violations</th>
				</tr>
		";
		
		foreach($data as $row)
		{
		$content .= "
			<tr>
				<td>".$row['lastName'].", ".$row['givenName']." ".$row['middleName']."</td>
				<td>".$row['plateNumber']."</td>
				<td>".$row['vehicleType']."</td>
				<td>".$row['model']."</td>
				<td>".$row['year']."</td>
				<td>".$row['motor']."</td>
				<td>".$row['chassis']."</td>
				<td>".$row['color']."</td>
				<td>".$row['stickerNumber']."</td>
				<td>";
					if($row['status'] == 1)
						$content .= "block";
					elseif($row['status'] == "released")
						$content .= $row['status'];
					elseif($row['paid'] != "0000-00-00")
						$content .= "paid";
					else
						$content .= $row['status'];
		$content .= "
				</td>
				<td>".$row['violation']."</td>
			</tr>
		";
		}
		
		$content .= "
			</table>
		";
		
		$html2pdf = new HTML2PDF('L');
		$html2pdf->WriteHTML($content);
		$html2pdf->Output('Vehicle List '.date("Y-m-d").'.pdf');
		
		exit;
	}
}
$pv = new PrintVehicle();
$pv->requestPrintVehicle();
?>