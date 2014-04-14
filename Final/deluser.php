<?php
	session_start();
	$_Account=$_POST['Account'];
	
	$db_host ="dbhome.cs.nctu.edu.tw";
	$db_name ="scsu_cs";
	$db_user ="scsu_cs";
	$db_password ="313";

	$dsn = "mysql:host=$db_host;dbname=$db_name";
	$db = new PDO($dsn,$db_user,$db_password);
	
	$sql = "DELETE FROM `User` WHERE `Account`=?" ;
	$sth = $db->prepare($sql);
	$sth->execute(array($_Account));
	
	$sql = "DROP TABLE `".$_Account."`" ;
	$sth = $db->prepare($sql);
	$sth->execute(array());
	
	header("Location:user.php");
?>