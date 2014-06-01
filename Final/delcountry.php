<?php
	session_start();
	$_ID=$_POST['ID'];
	
	$db_host ="dbhome.cs.nctu.edu.tw";
	$db_name ="scsu_cs";
	$db_user ="scsu_cs";
	$db_password ="313";

	$dsn = "mysql:host=$db_host;dbname=$db_name";
	$db = new PDO($dsn,$db_user,$db_password);
	
	$sql = "DELETE FROM `country` WHERE `id`=?" ;
	$sth = $db->prepare($sql);
	$sth->execute(array($_ID));
	
	header("Location:country.php");
?>