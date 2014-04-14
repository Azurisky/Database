<?php
	session_start();
	
	if(($_SESSION['Identity'] == true)){
		$_Account = $_SESSION['Account'];
		$_Hash = $_SESSION['Password'];
	}
	
	$db_host ="dbhome.cs.nctu.edu.tw";
	$db_name ="scsu_cs";
	$db_user ="scsu_cs";
	$db_password ="313";
	$dsn = "mysql:host=$db_host;dbname=$db_name";
	$db = new PDO($dsn,$db_user,$db_password);
	$sql = "SELECT * FROM `User`"."WHERE `account` = ? AND `password` = ?";
	$sth=$db->prepare($sql);
	$sth->execute(array($_Account,$_Hash));
	$result=$sth->fetchObject();
	
	if($result == ''){
		$_SESSION['Identity'] = 0;
	}
	
	if($_SESSION['Identity'] == true)
	{	
		echo 
		"<form action = \"newflight_func.php\" method = \"POST\">
			<p>Please enter new flight no. :</p>
			<p><input type=\"text\" name=\"flight_number\"></p>
			<p>Please enter new departure:</p>
			<p><input type=\"text\" name=\"departure\"></p>
			<p>Please enter new destination: </p>
			<p><input type=\"text\" name=\"destination\"></p>
			<p>Please enter new departure time(YYYY-MM-DD hh:mm:ss): </p>
			<p><input type=\"text\" name=\"departure_time\"></p>
			<p>Please enter new arrival time(YYYY-MM-DD hh:mm:ss): </p>
			<p><input type=\"text\" name=\"arrival_time\"></p>
			<p>Please enter the price: </p>
			<p><input type=\"text\" name=\"price\"></p>
			<button type=\"submit\">submit</button>
		</form>";
	}
	else
	{
		echo 'Permission deny. ';
		echo "<a href=\"http://people.cs.nctu.edu.tw/~chenc/login.php\"target=\"_top\">Back. </a>";
	}
?>
