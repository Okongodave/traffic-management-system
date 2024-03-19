<?php
include("dbConnector.php");
$connector = new DbConnector();

$username = $_GET['reg_username'];
$username = trim(strtolower($username));
$username = mysql_escape_string($username);

$query = "SELECT userName FROM table_profile WHERE userName = '$username' LIMIT 1";
$result = $connector->query($query);
$num = mysql_num_rows($result);


if($num){ //exists
  echo 'false';
}else {
  echo 'true';
}


mysql_close();

?>