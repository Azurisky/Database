<?php
	session_start();
?>


<form action = "delflight_func.php" method = "POST">
	<p>Please enter the ID of flight you want to delete:</p>
	<p><input type="text" name="ID" placeholder = "ID"></p>
	<button type="submit">OK</button>
</form>
