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
	
	if(($_SESSION['Identity'] == 2) || ($_SESSION['Identity'] == 1))
	{
		$_Flight_ID=$_POST['Flight_ID'];
		$_Account = $_SESSION['Account'];
		$_ID = $_SESSION['ID'];
									
		
		$db_host ="dbhome.cs.nctu.edu.tw";
		$db_name ="scsu_cs";
		$db_user ="scsu_cs";
		$db_password ="313";
		$dsn = "mysql:host=$db_host;dbname=$db_name";
		
		$_db = new PDO($dsn,$db_user,$db_password);
		$_sql = "SELECT * FROM `Flight` WHERE `ID` =".$_Flight_ID;
		$_sth=$_db->prepare($_sql);
		$_sth->execute(array());
		$result=$_sth->fetchObject();
		
		
		$db = new PDO($dsn,$db_user,$db_password);
		//$sql = "DELETE FROM `".$_Account."` WHERE `ID`=?" ;
		$sql = "DELETE FROM `comparison_list` WHERE `ID`=? AND `user`=?" ;
		$sth = $db->prepare($sql);
		$sth->execute(array($result->ID,$_Account));
		
		if($_SESSION['Type'] == true){
			header("Location:seaflight_func.php");
		}
		else if ($_SESSION['Compare'] == true){
			header("Location:comparisonlist.php");
		}
		else{
			header("Location:login_func.php");
		}
	}
	else
	{
		echo 'Permission deny. ';
		echo "<a href=\"http://people.cs.nctu.edu.tw/~chenc/login.php\"target=\"_top\">Back. </a>";
	}
	
?>