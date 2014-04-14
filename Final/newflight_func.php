<?php
	session_start();


$_flight_number = $_POST['flight_number'];
$_departure = $_POST['departure'];
$_destination = $_POST['destination'];
$_departure_time = date($_POST['departure_time']); 
$_arrival_time = date($_POST['arrival_time']);
$_price=$_POST['price'];

$db_host ="dbhome.cs.nctu.edu.tw";
$db_name ="scsu_cs";
$db_user ="scsu_cs";
$db_password ="313";

$dsn = "mysql:host=$db_host;dbname=$db_name";
$db = new PDO($dsn,$db_user,$db_password);

$_db = new PDO($dsn,$db_user,$db_password);
$_sql = "SELECT * FROM `airport` WHERE `Location` = '".$_departure."'";
$_sth=$_db->prepare($_sql);
$_sth->execute(array());
$result=$_sth->fetchObject();	

	
$__db = new PDO($dsn,$db_user,$db_password);
$__sql = "SELECT * FROM `airport` WHERE `Location` = '".$_destination."'";
$__sth=$_db->prepare($__sql);
$__sth->execute(array());
$_result=$__sth->fetchObject();
	


if($_flight_number==""||$_departure==""||$_destination==""||$_departure_time==""||$_arrival_time==""||$_price=="")
echo "<p>Input error!</p>
		<form action = \"login_func.php\" method = \"POST\">
			<button type=\"submit\">back</button>
		</form>";



		
else if(($result->Location==$_departure)&&($_result->Location==$_destination))
{
	$sql = "INSERT INTO `Flight`(Flight_number,Departure,Destination,Departure_time,Arrival_time,Price)"."VALUES( ?, ?, ?, ?, ?, ?)" ;
	$sth = $db->prepare($sql);
	$sth->execute(array($_flight_number,$_departure,$_destination,$_departure_time,$_arrival_time,$_price));
	echo"<p>The flight has been added!!</p>
		<form action = \"login_func.php\" method = \"POST\">
			<button type=\"submit\">yeah</button>
		</form>";
	}

else {
	echo "<p>No Such Airport!</p>
		<form action = \"login_func.php\" method = \"POST\">
			<button type=\"submit\">back</button>
		</form>";
	

}


?>



