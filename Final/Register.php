<?php
	session_start();
?>

<form action = "Register_func.php" method = "POST">
	<p>Please enter your Account</p>
	<p><input type = "text" name = "Account" placeholder = "Account"></p>
	<p>Please enter your Password:</p>
	<p><input type = "password" name = "Password" placeholder = "Password"></p>
	<button type="submit">Submit</button>
</form>
