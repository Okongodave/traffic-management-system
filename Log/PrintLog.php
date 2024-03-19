<?php
session_start();

class PrintPayment
{
	function requestPrintPayment()
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
		
		$content .= "<p>LOG LIST (" . date("Y-m-d") . ")</p>";
		
		$content .= "
			<table id='result'>
				<tr>
					<th>User</th>
					<th>Changes</th>
					<th>Date Time</th>
				</tr>
		";
		
		foreach($data as $row)
		{
		$content .= "
			<tr>
				<td>".$row['user']."</td>
				<td>".$row['notes']."</td>
				<td>".$row['datetime']."</td>
			</tr>
		";
		}
		
		$content .= "
			</table>
		";
		
		$html2pdf = new HTML2PDF('L');
		$html2pdf->WriteHTML($content);
		$html2pdf->Output('Log List '.date("Y-m-d").'.pdf');
		
		exit;
	}
}
$pv = new PrintPayment();
$pv->requestPrintPayment();
?>