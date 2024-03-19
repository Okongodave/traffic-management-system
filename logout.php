<!--
  - File Name: logout.php
  - Program Description: log-out user
  -->
  <?php
session_start();

if(isset($_SESSION['username'])){
	unset($_SESSION['username']);
	session_destroy();
	header("Location: ../UPF_Database/");
}else{
	header("Location: HomePage/");
}
?>