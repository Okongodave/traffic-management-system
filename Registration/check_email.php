<?php
include("dbConnector.php");
$connector = new DbConnector();

$emailAddress = $_GET['reg_email'];

$emailAddress = trim(strtolower($emailAddress));
$emailAddress = mysql_escape_string($emailAddress);

$query = "SELECT emailAddress FROM table_profile WHERE emailAddress = '$emailAddress' LIMIT 1";
$result = $connector->query($query);
$num = mysql_num_rows($result);

if($num){ //exists
  echo 'false';
}else {
  echo 'true';
}




mysql_close();

?>