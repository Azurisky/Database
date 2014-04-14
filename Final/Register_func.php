<?php
	session_start();

$_ID = $_POST['ID'];
$_Account = $_POST['Account'];
$_Password = $_POST['Password'];


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
	$sql = "INSERT INTO `User`(account,password,is_admin)"."VALUES(?,?,?)" ;
	$sth = $db->prepare($sql);
	$sth->execute(array( $_Account, $_Hash, 0));

	echo "Congrats!!! You can try to log in now. ";
	echo "<a href=\"http://people.cs.nctu.edu.tw/~chenc/login.php\"target=\"_new\">Back. </a>";
}
else
{
	echo "Input error!!!";
	echo "<a href=\"http://people.cs.nctu.edu.tw/~chenc/login.php\"target=\"_new\">Back. </a>";
}

?>