<!--
  - File Name: Log/index.php
  - Program Description: display for change logs
  -->
<?php
	$root = "../"; // root folder
	$pageTitle = "Logs";
	$currentMenu = "log";
	
	session_start();
	
	include "../RegistrationManager.php";
	$rm = new RegistrationManager();
	
	$searchOptions = ""
		.	"<select class='filter'>"
		.		"<option value='user'>User</option>"
		.		"<option value='notes'>Notes</option>"
		.		"<option value='datetime'>Date Time (YYYY-MM-DD)</option>"
		.	"</select>";
?>
<html>
	<?php include $root."head.php"; ?>
	
	<body id="">
		<div id='centerArea'>
			<?php include $root."menu.php"; // display menu options ?>
			
			<div id="content">
				<?php 
				$logs = $rm->retrieveLogs(); 
				$data = array();
				?>
				
				<div id="searchPanel">
					<form action="javascript:getFilters()" method="post">
						<div id="searchFilter">
							<div>
								<input class="keyword" name="keyword" type="text" value="" />
								<?php echo $searchOptions; ?>
							</div>
						</div>
						<div class="searchButton">
							<input type="button" value="Add Filter" onclick="javascript:addFilter()" />
							<input type="button" value="Search" onclick="javascript:getFilters()" />
						</div>
					</form>
				</div>
				
				<form name="viewForm" id="viewForm" method="post" action="">
					<input type="button" value="Print" onclick="this.form.action='./PrintLog.php';submit();" style="float: right;"/>
					<table id="result" width="800">
						<tr>
							<th class="sortable" onclick="javascript:sortColumns('user');">User</th>
							<th class="sortable" onclick="javascript:sortColumns('notes');">Changes</th>
							<th class="sortable" onclick="javascript:sortColumns('datetime DESC');">Date Time</th>
						</tr>
						<?php
						while($row = mysql_fetch_array($logs))
						{
						array_push($data, $row);
						?>
							<tr>
								<td><?php echo $row['user']; ?></td>
								<td><?php echo $row['notes']; ?></td>
								<td><?php echo $row['datetime']; ?></td>
							</tr>
						<?php
						}
						$_SESSION['pData'] = $data;
						?>
					</table>
					<input type="hidden" id="searchCombine" name="searchCombine" value="" />
					<input type="hidden" id="searchKeyword" name="searchKeyword" value="" />
					<input type="hidden" id="searchFilters" name="searchFilters" value="" />
					<input type="hidden" id="sortColumn" name="sortColumn" value="" />
				</form>
			</div>
		</div>
	</body>
</html>