<form name="loginForm" method="post" action="<?echo $root;?>LoginView.php" id="loginForm">
					<input type="text" name="username" id="username">
					<br/><input type="password" name="password" id="password">
					<br/>
					<?php if(isset($_SESSION['invalidlogin'])) echo "<p class='fieldError'>Invalid username or password.</p>";else echo "<br/>";?>
					<input type="submit" name="submit" value="Login">
					<br />
					<br />
					<a href="<?echo $root?>Registration\user_registration.php"><h3>Want to register?</h3></a>
					<!--a href="./Password/"><h3>Forgot<br />Password?</h3></a-->
</form>