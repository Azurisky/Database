<?php
	session_start();
	unset($_SESSION['Type']);
	unset($_SESSION['Info']);
	unset($_SESSION['Compare']);
	
	if(($_SESSION['Identity'] == true)){
		$_Account = $_SESSION['Account'];
		$_Hash = $_SESSION['Password'];
	}
	
	else{
		$_Account = $_POST['Account'];
		$_Password = $_POST['Password'];
		$_Hash = md5($_Password);
	}
	if($_POST['Type'] == ""){
		$_Type = "ID";
		$_Info = "ASC";
	}
	else{
		$_Type = $_POST['Type'];
		$_Info = $_POST['Info'];
	}
	echo "<strike><font size=7 color=red>welcome to sommoner's rift</font> </strike><br>";
	
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
	
	//echo $result->account;
	//echo "<br>$result->password";
	/*if($result->is_admin == 1)
		$_SESSION['Identity'] = true;
	else
		$_SESSION['Identity'] = false;*/
	
	if($_SESSION['Identity'] == 2)
		{	
			
			$_SESSION['Account'] = $_Account;
			$_SESSION['ID'] = $result->ID;
			$_SESSION['Password'] = $result->password;
			$_SESSION['Identity'] = 2;
			$sql = "SELECT * FROM `Flight` ORDER BY  `".$_Type."` ".$_Info;
			$sth=$db->prepare($sql);
			$sth->execute();
			echo "<p>Admin_by_session</p>";
			echo "<table border=\"1\">";
			echo "<form action = \"newflight.php\" >
						<button type = \"submit\">Create New Flight</button>
				  </form>".
				  "<form action = \"modflight.php\" >
						<button type = \"submit\">Modify Flight</button>
				  </form>".
				  "<form action = \"delflight.php\" >
						<button type = \"submit\">Delete Flight</button>
				  </form>
				  <form action = \"seaflight.php\" >
						<button type = \"submit\">Search Flight Ticket</button>
				  </form>
				  </table>";
				  
		
	
				  
			
			echo "<table border=\"1\">";
			echo "<tr>
						<td>ID</td>
						<td>Flight_number</td>
						<td>Departure</td>
						<td>Destination</td>
						<td>Departure_time</td>
						<td>Arrival_time</td>
						<td>Price</td>
						<td>Favorite</td>
						<td></td>
				  </tr>";
			while($result=$sth->fetchObject())
				 
				 {
					echo 
					"<tr>
							<th>".$result->ID ."</th>
							<th>".$result->Flight_number."</th>
							<th>".$result->Departure."</th>
							<th>".$result->Destination."</th>
							<th>".$result->Departure_time."</th>
							<th>".$result->Arrival_time."</th>
							<th>".$result->Price."</th>";
					$in_list=0;
				
					$_db = new PDO($dsn,$db_user,$db_password);
					$_sql = "SELECT * FROM `comparison_list` where `user`=".$_Account ;
					$_sth=$_db->prepare($_sql);
					$_sth->execute(array());
					
					while($_result=$_sth->fetchObject())
					{
						if($_result->ID==$result->ID)$in_list=1;
					}
					if($in_list==1)
					{

						echo "<th>O</th>
							  <th><form action = \"delfromlist.php\" method=\"POST\" >
									 <button name = \"Flight_ID\" value =\"".$result->ID."\" type=\"submit\">Delete</button>
								  </form></th>";
						 
					}
					if($in_list==0)
					{
						echo"<th>X</th>
							 <th><form action = \"addtolist.php\" method=\"POST\" >
									<button name = \"Flight_ID\" value =\"".$result->ID."\">Add</button>
							     </form></th>";
					}
					echo "</tr>";
					
				 }
				
				
			
			
			echo "</table>";
			echo "<table border=\"1\">";
			echo  "<form action = \"user.php\" >
						<button type = \"submit\">userlist</button>
				  </form>";
			echo  "<form action = \"airport.php\" >
						<button type = \"submit\">airportlist</button>
				  </form>
				  <form action = \"comparisonlist.php\" >
						<button type = \"submit\">ComparisonList</button>
				  </form>";
			echo  "<form action = \"country.php\" >
						<button type = \"submit\">CountryList</button>
				  </form></table>";
			echo "<p><form action = \"login.php\" >
						<button type = \"submit\">Log out</button>
				  </form></p>";
			
	
		}
	else if($_SESSION['Identity'] == 1) 
	{	
			
			$_SESSION['Identity'] = 1;
			$_SESSION['Account'] = $_Account;
			$_SESSION['ID'] = $result->ID;
			$_SESSION['Password'] = $result->password;
			$sql = "SELECT * FROM `Flight` ORDER BY  `".$_Type."` ".$_Info;
			$sth=$db->prepare($sql);
			$sth->execute();
			echo "<p>User_by_session</p>";
			echo "<table border=\"1\">";
			echo "<form action = \"seaflight.php\" >
						<button type = \"submit\">Search Flight Ticket</button>
				  </form>
				  </table>";
				
	
			
			echo "<table border=\"1\">";
			echo "<tr>
						<td>ID</td>
						<td>Flight_number</td>
						<td>Departure</td>
						<td>Destination</td>
						<td>Departure_time</td>
						<td>Arrival_time</td>
						<td>Price</td>
						<td>Favorite</td>
						<td></td>
				  </tr>";
			while($result=$sth->fetchObject())
				 
				 {
					echo 
					"<tr>
							<th>".$result->ID ."</th>
							<th>".$result->Flight_number."</th>
							<th>".$result->Departure."</th>
							<th>".$result->Destination."</th>
							<th>".$result->Departure_time."</th>
							<th>".$result->Arrival_time."</th>
							<th>".$result->Price."</th>";
					$in_list=0;
				
					$_db = new PDO($dsn,$db_user,$db_password);
					$_sql = "SELECT * FROM `".$_Account."`";
					$_sth=$_db->prepare($_sql);
					$_sth->execute(array());
					
					while($_result=$_sth->fetchObject())
					{
						if($_result->ID==$result->ID)$in_list=1;
					}
					if($in_list==1)
					{

						echo "<th>O</th>
							  <th><form action = \"delfromlist.php\" method=\"POST\" >
									 <button name = \"Flight_ID\" value =\"".$result->ID."\" type=\"submit\">Delete</button>
								  </form></th>";
						 
					}
					if($in_list==0)
					{
						echo"<th>X</th>
							 <th><form action = \"addtolist.php\" method=\"POST\" >
									<button name = \"Flight_ID\" value =\"".$result->ID."\">Add</button>
							     </form></th>";
					}
					echo "</tr>";
					
				 }
			echo "</table>";
				
			echo  "<p><form action = \"login.php\" >
						<button type = \"submit\">Log out</button>
				  </form></p>";
			
		
		}
	else if($result->account==$_Account && $result->password == $_Hash && $result->is_admin == 1)
	{	
			
			$_SESSION['Account'] = $_Account;
			$_SESSION['ID'] = $result->ID;
			$_SESSION['Password'] = $result->password;
			$_SESSION['Identity'] = 2;
			$sql = "SELECT * FROM `Flight` ORDER BY  `".$_Type."` ".$_Info;
			$sth=$db->prepare($sql);
			$sth->execute();
			echo "<p>Admin_by_log</p>";
			echo "<table border=\"1\">";
			echo "<form action = \"newflight.php\" >
						<button type = \"submit\">Create New Flight</button>
				  </form>".
				  "<form action = \"modflight.php\" >
						<button type = \"submit\">Modify Flight</button>
				  </form>".
				  "<form action = \"delflight.php\" >
						<button type = \"submit\">Delete Flight</button>
				  </form>
				  <form action = \"seaflight.php\" >
						<button type = \"submit\">Search Flight Ticket</button>
				  </form>
				  </table>";
				
			echo "<table border=\"1\">";
			echo "<form action = \"login_func.php\" method = \"POST\">
				 Order by:
				  <select name = \"Type\">
					<option value = \"ID\">ID</option>
					<option value = \"Flight_number\">Flight number</option>
					<option value = \"Departure\">Departure</option>
					<option value = \"Destination\">Destination</option>
					<option value = \"Departure_time\">Departure_time</option>
					<option value = \"Arrival_time\">Arrival_time</option>
					<option value = \"Price\">Price</option>
				  </select>"."
					Please choose a way to order:
					<input type=\"radio\" name=\"Info\" value=\"ASC\" checked>Ascending order
					<input type=\"radio\" name=\"Info\" value=\"DESC \">Descending order
					<button type=\"submit\">submit</button>
				</form></table>";
				 
				 
				  
			
			echo "<table border=\"1\">";
			echo "<tr>
						<td>ID</td>
						<td>Flight_number</td>
						<td>Departure</td>
						<td>Destination</td>
						<td>Departure_time</td>
						<td>Arrival_time</td>
						<td>Price</td>
						<td>Favorite</td>
						<td></td>
				  </tr>";
			while($result=$sth->fetchObject())
				 
				 {
					echo 
					"<tr>
							<th>".$result->ID ."</th>
							<th>".$result->Flight_number."</th>
							<th>".$result->Departure."</th>
							<th>".$result->Destination."</th>
							<th>".$result->Departure_time."</th>
							<th>".$result->Arrival_time."</th>
							<th>".$result->Price."</th>";
					$in_list=0;
				
					$_db = new PDO($dsn,$db_user,$db_password);
					$_sql = "SELECT * FROM `".$_Account."`";
					$_sth=$_db->prepare($_sql);
					$_sth->execute(array());
					
					while($_result=$_sth->fetchObject())
					{
						if($_result->ID==$result->ID)$in_list=1;
					}
					if($in_list==1)
					{

						echo "<th>O</th>
							  <th><form action = \"delfromlist.php\" method=\"POST\" >
									 <button name = \"Flight_ID\" value =\"".$result->ID."\" type=\"submit\">Delete</button>
								  </form></th>";
						 
					}
					if($in_list==0)
					{
						echo"<th>X</th>
							 <th><form action = \"addtolist.php\" method=\"POST\" >
									<button name = \"Flight_ID\" value =\"".$result->ID."\">Add</button>
							     </form></th>";
					}
					echo "</tr>";
					
				 }
				
				
			
			
			echo "</table>";
			echo "<table border=\"1\">";
			echo  "<form action = \"user.php\" >
						<button type = \"submit\">userlist</button>
				  </form>";
			echo  "<form action = \"airport.php\" >
						<button type = \"submit\">airportlist</button>
				  </form>
				  <form action = \"comparisonlist.php\" >
						<button type = \"submit\">ComparisonList</button>
				  </form>";
			echo  "<form action = \"country.php\" >
						<button type = \"submit\">CountryList</button>
				  </form></table>";
			echo "<p><form action = \"login.php\" >
						<button type = \"submit\">Log out</button>
				  </form></p>";
			
	
		}
	else if(($result->account==$_Account && $result->password == $_Hash && $result->is_admin == 0))
		{
			
			$_SESSION['Identity'] = 1;
			$_SESSION['Account'] = $_Account;
			$_SESSION['ID'] = $result->ID;
			$_SESSION['Password'] = $result->password;
			$sql = "SELECT * FROM `Flight` ORDER BY  `".$_Type."` ".$_Info;
			$sth=$db->prepare($sql);
			$sth->execute();
			echo "<p>User_by_log</p>";
			echo "<table border=\"1\">";
			echo "<form action = \"seaflight.php\" >
						<button type = \"submit\">Search Flight Ticket</button>
				  </form>
				  </table>";
			
			echo "<table border=\"1\">";
			echo "<tr>
						<td>ID</td>
						<td>Flight_number</td>
						<td>Departure</td>
						<td>Destination</td>
						<td>Departure_time</td>
						<td>Arrival_time</td>
						<td>Price</td>
						<td>Favorite</td>
						<td></td>
				  </tr>";
			while($result=$sth->fetchObject())
				 
				 {
					echo 
					"<tr>
							<th>".$result->ID ."</th>
							<th>".$result->Flight_number."</th>
							<th>".$result->Departure."</th>
							<th>".$result->Destination."</th>
							<th>".$result->Departure_time."</th>
							<th>".$result->Arrival_time."</th>
							<th>".$result->Price."</th>";
					$in_list=0;
				
					$_db = new PDO($dsn,$db_user,$db_password);
					$_sql = "SELECT * FROM `".$_Account."`";
					$_sth=$_db->prepare($_sql);
					$_sth->execute(array());
					
					while($_result=$_sth->fetchObject())
					{
						if($_result->ID==$result->ID)$in_list=1;
					}
					if($in_list==1)
					{

						echo "<th>O</th>
							  <th><form action = \"delfromlist.php\" method=\"POST\" >
									 <button name = \"Flight_ID\" value =\"".$result->ID."\" type=\"submit\">Delete</button>
								  </form></th>";
						 
					}
					if($in_list==0)
					{
						echo"<th>X</th>
							 <th><form action = \"addtolist.php\" method=\"POST\" >
									<button name = \"Flight_ID\" value =\"".$result->ID."\">Add</button>
							     </form></th>";
					}
					echo "</tr>";
					
				 }
			echo "</table>";
				
			echo  "<p><form action = \"login.php\" >
						<button type = \"submit\">Log out</button>
				  </form></p>";
			
		
		}
	else
	{
		echo 'Permission deny. ';
		echo "<a href=\"http://people.cs.nctu.edu.tw/~chenc/login.php\"target=\"_top\">Back. </a>";

	}
		

?>