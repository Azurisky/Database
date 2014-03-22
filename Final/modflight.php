<?php
	session_start();
?>

<form action = "modflight_func.php" method = "POST">
	<p>Please enter the ID of flight want to modify:</p>
	<p><input type="text" name="ID"></p>
	<p>Please enter new flight no. :</p>
	<p><input type="text" name="flight number"></p>
	<p>Please enter new departure:</p>
	<p><input type="text" name="departure"></p>
	<p>Please enter new destination: </p>
	<p><input type="text" name="destination"></p>
	<p>Please enter new departure time(YYYY-MM-DD hh:mm:ss): </p>
	<p><input type="text" name="departure time"></p>
	<p>Please enter new arrival time(YYYY-MM-DD hh:mm:ss): </p>
	<p><input type="text" name="arrival time"></p>
	<button type="submit">submit</button>
</form>