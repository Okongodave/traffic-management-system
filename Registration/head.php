<head>
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	<meta content="utf-8" http-equiv="encoding">
	<title><?php echo $pageTitle." | UPLB Traffic Management System - "; ?></title>

	<!-- font icons -->
	<link rel="stylesheet" href="<?php echo $root; ?>assets/icons/css/font-awesome.min.css">

	<!-- css -->
	<link rel="stylesheet" type="text/css" href="<?php echo $root; ?>assets/styles/view.css" />
	
	<!-- other styles -->
	<style>
/* 		<?php echo ".".$currentMenu."M"; ?>{
			color: white;
			background-color: black;
		}
	</style> */
	
	<!-- jQuery -->
	<script type="text/javascript" src="<?php echo $root; ?>Script/jquery.min.js" ></script>
	<script type="text/javascript" src="<?php echo $root; ?>Script/jquery.validate.pack.js" ></script>

	<script type="text/javascript">
		var wrong = "false";
		
		$(document).ready(function(){
		
			$("#update_form").validate();
		
			$("#user_registration_form").validate({
				rules: {
					reg_username: {
						required: true,
						minlength: 2,
						remote: "check.php"
					},
					reg_password: {
						required: true,
						minlength: 5
					},
					confirm_password: {
						required: true,
						minlength: 5,
						equalTo: "#reg_password"
					},
					reg_email: {
						required: true,
						email: true,
						remote: "check_email.php"
					},
					agree: "required"
				},
				messages: {
					reg_username: {
						required: "Enter a username",
						minlength: "Username is too short",
						remote: "Username not available"
					},
					reg_password: {
						required: "Provide a password",
						minlength: "Password is too short"
					},
					confirm_password: {
						required: "Provide a password",
						minlength: "Password is too short",
						equalTo: "Doesn't match password"
					},
					reg_email: {
						required: "Enter your email address",
						email: "Not an email address",
						remote: "Email already registered"
					},
					agree: "Please accept our policy"
				}
			});
		});
		
		
		
	</script>
	
	
</head>
