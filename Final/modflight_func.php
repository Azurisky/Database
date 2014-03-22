<?php
	session_start();
	
$_ID = $_POST['ID'];
$_flight_number = $_POST['flight_number'];
$_departure = $_POST['departure'];
$_destination = $_POST['destination'];
$_departure_time = date($_POST['departure_time']); 
$_arrival_time = date($_POST['arrival_time']);

$db_host ="dbhome.cs.nctu.edu.tw";
$db_name ="scsu_cs";
$db_user ="scsu_cs";
$db_password ="313";

$dsn = "mysql:host=$db_host;dbname=$db_name";
$db = new PDO($dsn,$db_user,$db_password);

if($_ID==""||$_flight_number==""||$_departure==""||$_destination==""||$_departure_time==""||$_arrival_time=="")
echo "<p>Input error!</p>
		<form action = \"login_func.php\" method = \"POST\">
			<button type=\"submit\">back</button>
		</form>";
else
{
	$sql = "UPDATE `Flight` SET `Flight_number`=? , `Departure`=? , `Destination`=? , `Departure_time`=? , `Arrival_time`=? WHERE `ID` = ?" ;
	$sth = $db->prepare($sql);
	$sth->execute(array($_flight_number,$_departure,$_destination,$_departure_time,$_arrival_time,$_ID));
	echo"<p>The flight has been modified!</p>
		<form action = \"login_func.php\" method = \"POST\">
			<button type=\"submit\">yeah</button>
		</form>";
	}

?>



