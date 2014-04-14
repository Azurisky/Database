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
		
		
		$sql = "SELECT * FROM `airport`";
				$sth=$db->prepare($sql);
				$sth->execute();
				
		echo "<table border=\"1\">";
				echo "<tr>
							<td>#</td>
							<td>Location</td>
							<td>Longitude</td>
							<td>Latitude</td>
					  </tr>";
				while($result=$sth->fetchObject())
					 {
						echo 
						"<tr>
								<th>".$result->id ."</th>
								<th>".$result->Location."</th>
								<th>".$result->Longitude."</th>
								<th>".$result->Latitude."</th>";
						echo 
						"<th>"."<form action = \"delairport.php\" method=\"POST\" >
										<button name = \"ID\" value =\"".$result->id."\">delete</button>
								</form>" ."</th>";
						
								
						echo"</tr>";
					 }
					
				
				
				echo "</table>";
				echo "<form action = \"newairport.php\" method = \"POST\">
						<p>new airport</p>
						<p>Location<input type=\"text\" name=\"Location\"></p>
						<p>Longitude<input type=\"text\" name=\"Longitude\"></p>
						<p>Latitude<input type=\"text\" name=\"Latitude\"></p>
						<p><button type=\"submit\">submit</button></p>
					  </form>";
				
				
				
				
				echo "<form action = \"modairport.php\" method = \"POST\">
						<p>modify airport</p>
						<p>ID<input type=\"text\" name=\"id\"></p>
						<p>Location<input type=\"text\" name=\"Location\"></p>
						<p>Longitude<input type=\"text\" name=\"Longitude\"></p>
						<p>Latitude<input type=\"text\" name=\"Latitude\"></p>
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