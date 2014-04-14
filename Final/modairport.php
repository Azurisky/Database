<?php
	session_start();
	$_id=$_POST['id'];
	$_Location=$_POST['Location'];
	$_Longitude=$_POST['Longitude'];
	$_Latitude=$_POST['Latitude'];
	
	$db_host ="dbhome.cs.nctu.edu.tw";
	$db_name ="scsu_cs";
	$db_user ="scsu_cs";
	$db_password ="313";

	$dsn = "mysql:host=$db_host;dbname=$db_name";
	$db = new PDO($dsn,$db_user,$db_password);
	
	$sql = "UPDATE `airport` SET `Location`=? , `Longitude`=? , `Latitude`=?  WHERE `id` = ?" ;
	$sth = $db->prepare($sql);
	$sth->execute(array($_Location,$_Longitude,$_Latitude,$_id));
	
	header("Location:airport.php");
?>