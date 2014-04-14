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
	
	if($_SESSION['Identity'] == true){
	
	$_Location=$_POST['Location'];
	$_Longitude=$_POST['Longitude'];
	$_Latitude=$_POST['Latitude'];
	
	$db_host ="dbhome.cs.nctu.edu.tw";
	$db_name ="scsu_cs";
	$db_user ="scsu_cs";
	$db_password ="313";

	$dsn = "mysql:host=$db_host;dbname=$db_name";
	$db = new PDO($dsn,$db_user,$db_password);
	
	$sql = "INSERT INTO `airport`(Location,Longitude,Latitude)"."VALUES( ?, ?, ?)" ;
	$sth = $db->prepare($sql);
	$sth->execute(array($_Location,$_Longitude,$_Latitude));
	
	header("Location:airport.php");
	
	}
	else
	{
		echo 'Permission deny. ';
		echo "<a href=\"http://people.cs.nctu.edu.tw/~chenc/login.php\"target=\"_top\">Back. </a>";
	}
?>