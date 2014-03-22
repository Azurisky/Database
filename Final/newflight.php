<?php
	session_start();
?>

<form action = "newflight_func.php" method = "POST">
	<p>Please enter new flight no. :</p>
	<p><input type="text" name="flight_number"></p>
	<p>Please enter new departure:</p>
	<p><input type="text" name="departure"></p>
	<p>Please enter new destination: </p>
	<p><input type="text" name="destination"></p>
	<p>Please enter new departure time(YYYY-MM-DD hh:mm:ss): </p>
	<p><input type="text" name="departure_time"></p>
	<p>Please enter new arrival time(YYYY-MM-DD hh:mm:ss): </p>
	<p><input type="text" name="arrival_time"></p>
	<button type="submit">submit</button>
</form>