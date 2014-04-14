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
	
	if($result == NULL){
		$_SESSION['Identity'] = 0;
	}
	
	if(($_SESSION['Identity'] == 2) || ($_SESSION['Identity'] == 1))
	{
		$_Flight_ID=$_POST['Flight_ID'];
		$_Account = $_SESSION['Account'];
		$_ID = $_SESSION['ID'];
		
		//echo  $_Account.$_id.$_flight_number.$_Departure.$_Destination.$_Departure_time.$_Arrival_time.$_Price;
		/*echo  $_SESSION['Account'];
		echo  $_SESSION['ID'];
		echo  $_Account;
		echo  $_ID;*/
		
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
		
		
		//echo $result->ID.$result->Flight_number.$result->Departure.$result->Destination.$result->Departure_time;
		
		
		
		$db = new PDO($dsn,$db_user,$db_password);
		$sql = "INSERT INTO `".$_Account."`(ID,Flight_number,Departure,Destination,Departure_time,Arrival_time,Price)"."VALUES( ?, ?, ?, ?, ?, ?, ?)" ;
		$sth = $db->prepare($sql);
		$sth->execute(array($result->ID,$result->Flight_number,$result->Departure,$result->Destination,$result->Departure_time,$result->Arrival_time,$result->Price));
		
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