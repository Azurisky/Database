<?php
	session_start();
?>

<form action = "seaflight_func.php" method = "POST">
	<p>Please enter the flight no you want to search:</p>
	<p><input type="text" name="flight_number"></p>
	<p>Please enter the departure you want to search:</p>
	<p><input type="text" name="departure"></p>
	<p>Please enter the destination you want to search: </p>
	<p><input type="text" name="destination"></p>
	<button type="submit">submit</button>
</form>