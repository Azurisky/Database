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
	
	if($_SESSION['Identity'] == true)
	{
		$db_host ="dbhome.cs.nctu.edu.tw";
		$db_name ="scsu_cs";
		$db_user ="scsu_cs";
		$db_password ="313";
		$dsn = "mysql:host=$db_host;dbname=$db_name";
		$db = new PDO($dsn,$db_user,$db_password);
		
		
		$sql = "SELECT * FROM `User`";
				$sth=$db->prepare($sql);
				$sth->execute();
				
		echo "<table border=\"1\">";
				echo "<tr>
							<td>#</td>
							<td>account</td>
							<td>Identity</td>
							<td>Delete</td>
							<td>Upgrade</td>
					  </tr>";
				while($result=$sth->fetchObject())
					 {
						echo 
						"<tr>
								<th>".$result->id ."</th>
								<th>".$result->account."</th>
								<th>".$result->is_admin."</th>";
						echo "<th>"."<form action = \"deluser.php\" method=\"POST\" >
															<button name = \"Account\" value =\"".$result->account."\">delete</button>
														 </form>" ."</th>";
						if(!$result->is_admin)
						echo "<th>"."<form action = \"levelup.php\" method=\"POST\" >
															<button name = \"ID\" value =\"".$result->id."\">Level Up !!</button>
														 </form>" ."</th>";
						else
						echo "<th></th>";
						
								
						echo"</tr>";
					 }
				echo "</table>"; 
				echo "<form action = \"newuser.php\" method = \"POST\">
						  <p>new user</p>
						  <p>Account<input type=\"text\" name=\"Account\"></p>
						  <p>Password<input type=\"text\" name=\"Password\"></p>
						  <p><input type=\"radio\" name=\"is_admin\" value=\"0\" checked>user<input type=\"radio\" name=\"is_admin\" value=\"1\">admin</p>
						  <p><button type=\"submit\">submit</button></p>
					  </form>";
				
				
				
				echo  "<p><form action = \"login_func.php\" >
							<button type = \"submit\">Back</button>
					  </form></p>";
	}
	else
	{
		echo 'Permission deny. ';
		echo "<a href=\"http://people.cs.nctu.edu.tw/~chenc/login.php\"target=\"_top\">Back. </a>";
	}
?>
			
			
			