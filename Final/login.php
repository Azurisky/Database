<?php 
	session_start();
	unset($_SESSION['Identity']);
	unset($_SESSION['Account']);
	unset($_SESSION['ID']);
	unset($_SESSION['Password']);
?>


<form action = "login_func.php" method = "POST">
	<p>Please enter your account name:</p>
	<p><input type = "text" name = "Account" placeholder = "Account"></p>
	<p>And password:</p>
	<p><input type = "password" name = "Password" placeholder = "Password"></p>
	<button type = "submit">Log in</button>
</form>


<form action = "Register.php" >
	<button type = "submit">Register</button>
</form>


<form action = "seaflight.php" >
	<button type = "submit">Search Flight Ticket</button>
</form>
