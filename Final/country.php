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
		
		
		$sql = "SELECT * FROM `country`";
				$sth=$db->prepare($sql);
				$sth->execute();
				
		echo "<table border=\"1\">";
				echo "<tr>
							<td>#</td>
							<td>abbreviation</td>
							<td>fullname</td>
							
					  </tr>";
				while($result=$sth->fetchObject())
					 {
						echo 
						"<tr>
								<th>".$result->id ."</th>
								<th>".$result->abbreviation."</th>
								<th>".$result->fullname."</th>";
						echo 
						"<th>"."<form action = \"delcountry.php\" method=\"POST\" >
										<button name = \"ID\" value =\"".$result->id."\">delete</button>
								</form>" ."</th>";
						
								
						echo"</tr>";
					 }
					
				
				
				echo "</table>";
				echo "<form action = \"newcountry.php\" method = \"POST\">
						<p>new country</p>
						<p>abbreviation<input type=\"text\" name=\"abbreviation\"></p>
						<p>fullname<input type=\"text\" name=\"fullname\"></p>
						<p><button type=\"submit\">submit</button></p>
					  </form>";
				
				
				
				
				echo "<form action = \"modcountry.php\" method = \"POST\">
						<p>modify country</p>
						<p>ID<input type=\"text\" name=\"id\"></p>
						<p>abbreviation<input type=\"text\" name=\"abbreviation\"></p>
						<p>fullname<input type=\"text\" name=\"fullname\"></p>
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