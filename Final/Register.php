<?php
	session_start();
?>

<form action = "Register_func.php" method = "POST">
	<p>Please enter your Account</p>
	<p><input type = "text" name = "Account" placeholder = "Account"></p>
	<p>Please enter your Password:</p>
	<p><input type = "password" name = "Password" placeholder = "Password"></p>
	<p>Do you want to be administrator? If you want, enter 1, or just enter 0. </p>
	<p><input type = "text" name = "Is_admin" placeholder = "Want to be a admin? "></p>
	<button type="submit">Submit</button>
</form>
