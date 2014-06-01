<?php
	session_start();
	$_id=$_POST['id'];
	$_abbreviation=$_POST['abbreviation'];
	$_fullname=$_POST['fullname'];
	
	
	$db_host ="dbhome.cs.nctu.edu.tw";
	$db_name ="scsu_cs";
	$db_user ="scsu_cs";
	$db_password ="313";

	$dsn = "mysql:host=$db_host;dbname=$db_name";
	$db = new PDO($dsn,$db_user,$db_password);
	
	$sql = "UPDATE `country` SET `abbreviation`=? , `fullname`=?   WHERE `id` = ?" ;
	$sth = $db->prepare($sql);
	$sth->execute(array($_abbreviation,$_fullname,$_id));
	
	header("Location:country.php");
?>