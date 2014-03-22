<?php
	session_start();
	$_Account = $_POST['Account'];
	$_Password = $_POST['Password'];
	
	$db_host ="dbhome.cs.nctu.edu.tw";
	$db_name ="scsu_cs";
	$db_user ="scsu_cs";
	$db_password ="313";


function password_hash ($password) {
    return crypt($password, '$5$rounds=5000$'. md5(mcrypt_create_iv(16, 2)) .'$');
}
	
function password_verify ($password, $crypted) {
    return crypt($password, $crypted) == $crypted;
}

$_Hash = md5($_Password);

//echo "<br>$_Password";
//echo "<br>$_Hash";

	
$dsn = "mysql:host=$db_host;dbname=$db_name";
$db = new PDO($dsn,$db_user,$db_password);
	echo "<strike><font size=7 color=red>welcome to sommoner's rift</font> </strike><br>";
	$sql = "SELECT * FROM `User`"."WHERE `account` = ? AND `password` = ?";
	$sth=$db->prepare($sql);
	$sth->execute(array($_Account,$_Hash));
	$result=$sth->fetchObject();
	//echo $result->account;
	//echo "<br>$result->password";
	/*if($result->is_admin == 1)
		$_SESSION['Identity'] = true;
	else
		$_SESSION['Identity'] = false;*/
	
	if(($result->account==$_Account && $result->password == $_Hash && $result->is_admin == 1) || ($_SESSION['Identity'] == true))
		{	
			$_SESSION['Identity'] = true;
			$sql = "SELECT * FROM `Flight`";
			$sth=$db->prepare($sql);
			$sth->execute();
			echo "<table border=\"1\">";
			echo "<form action = \"newflight.php\" >
						<button type = \"submit\">Create New Flight</button>
				  </form>".
				  "<form action = \"modflight.php\" >
						<button type = \"submit\">Modify Flight</button>
				  </form>".
				  "<form action = \"delflight.php\" >
						<button type = \"submit\">Delete Flight</button>
				  </form></table>";
			
			echo "<table border=\"1\">";
			echo "<tr>
						<td>ID</td>
						<td>Flight_number</td>
						<td>Departure</td>
						<td>Destination</td>
						<td>Departure_time</td>
						<td>Arrival_time</td>
				  </tr>";
			while($result=$sth->fetchObject())
				 
				echo 
					"<tr>
							<th>".$result->ID ."</th>
							<th>".$result->Flight_number."</th>
							<th>".$result->Departure."</th>
							<th>".$result->Destination."</th>
							<th>".$result->Departure_time."</th>
							<th>".$result->Arrival_time."</th>
					 </tr>";
			
			
			echo "</table>";
			
			echo "<p><form action = \"login.php\" >
						<button type = \"submit\">Log out</button>
				  </form></p>";
	
		}
	else if(($result->account==$_Account && $result->password == $_Hash && $result->is_admin == 0))
		{
			$sql = "SELECT * FROM `Flight`";
			$sth=$db->prepare($sql);
			$sth->execute();
			echo "<table border=\"1\">";
			echo "<tr>
						<th>ID</th>
						<th>Flight_number</th>
						<th>Departure</th>
						<th>Destination</th>
						<th>Departure_time</th>
						<th>Arrival_time</th>
				  </tr>";
			while($result=$sth->fetchObject())
				 
				echo 
					"<p><tr>
							<th>".$result->ID ."</th>
							<th>".$result->Flight_number."</th>
							<th>".$result->Departure."</th>
							<th>".$result->Destination."</th>
							<th>".$result->Departure_time."</th>
							<th>".$result->Arrival_time."</th>
					 </tr></p>";
			echo "</table>";
				
			echo  "<p><form action = \"login.php\" >
						<button type = \"submit\">Log out</button>
				  </form></p>";
		}
	else
	{
		echo 'Permission deny. ';
		echo "<a href=\"http://people.cs.nctu.edu.tw/~chenc/login.php\"target=\"_new\">Back. </a>";

	}
		

?>