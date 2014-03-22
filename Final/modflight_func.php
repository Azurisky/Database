<?php
	session_start();
	
$_ID = $_POST['ID'];
$_flight_number = $_POST['flight number'];
$_departure = $_POST['departure'];
$_destination = $_POST['destination'];
$_departure_time = date($_POST['departure time']); 
$_arrival_time = date($_POST['arrival time']);

$db_host ="dbhome.cs.nctu.edu.tw";
$db_name ="scsu_cs";
$db_user ="scsu_cs";
$db_password ="313";

$dsn = "mysql:host=$db_host;dbname=$db_name";
$db = new PDO($dsn,$db_user,$db_password);

$sql = "UPDATE `Flight` SET `Flight_number`=? AND `Departure`=? AND `Destination`=? AND `Departure_time`=? AND `Arrival_time`=? WHERE `ID` = ?" ;
$sth = $db->prepare($sql);
$sth->execute(array($_flight_number,$_departure,$_destination,$_departure_time,$_arrival_time,$_ID));


?>
<p>The flight has been modified!</p>
<form action = "login_func.php" method = "POST">
	<button type="submit">yeah</button>
</form>


