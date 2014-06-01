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
	
	$_Account=$_POST['Account'];
	$_Password=$_POST['Password'];
	$_is_admin=$_POST['is_admin'];
	$_Hash = md5($_Password);
	
	$db_host ="dbhome.cs.nctu.edu.tw";
	$db_name ="scsu_cs";
	$db_user ="scsu_cs";
	$db_password ="313";

	$dsn = "mysql:host=$db_host;dbname=$db_name";
	$db = new PDO($dsn,$db_user,$db_password);
	
	$error=0;
	if($_Account=="")$error=1;
	if($_Password=="")$error=1;
	for($i=0;$i<strlen($_Account);$i++)
	if($_Account[$i]==" ")$error=1;
	for($j=0;$j<strlen($_Password);$j++)
	if($_Password[$j]==" ")$error=1;
	$sql = "SELECT * FROM `User`";
	$sth=$db->prepare($sql);
	$sth->execute();
	while($result=$sth->fetchObject())
	{
		if($result->account==$_Account)$error=1;
	}
	
	if($error==0)
	{
		$sql = "INSERT INTO `User`(account,password,is_admin)"."VALUES( ?, ?, ?)" ;
		$sth = $db->prepare($sql);
		$sth->execute(array($_Account,$_Hash,$_is_admin));
		
		
		$sql = "CREATE TABLE `".$_Account."` (`ID`  int(10) unsigned primary key) " ;
		$sth = $db->prepare($sql);
		$sth->execute(array());
		
		$sql = "alter table`".$_Account."` add primary key (`ID`)" ;
		$sth = $db->prepare($sql);
		$sth->execute(array($_Account,$_Hash,$_is_admin));
		
		$sql = "alter table`".$_Account."` ENGINE = INNODB" ;
		$sth = $db->prepare($sql);
		$sth->execute(array($_Account,$_Hash,$_is_admin));
		
		
		$sql = "alter table`".$_Account."` ADD FOREIGN KEY (  `ID` ) REFERENCES  `scsu_cs`.`Flight` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE" ;
		$sth = $db->prepare($sql);
		$sth->execute(array($_Account,$_Hash,$_is_admin));
	    
		
		
		header("Location:user.php");
	}
	
	}
	else
	{
		echo 'Permission deny. ';
		echo "<a href=\"http://people.cs.nctu.edu.tw/~chenc/login.php\"target=\"_top\">Back. </a>";
	}
	
	
?>