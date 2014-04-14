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
		$_Account = $_SESSION['Account'];
		$_ID = $_SESSION['ID'];
	
		if($_POST['Type_o'] == ""){
			$_Type_o = "ID";
			$_Info_o = "ASC";
		}
		else{
			$_Type_o = $_POST['Type_o'];
			$_Info_o = $_POST['Info_o'];
		}
		
		if($_POST['Type'] == ""){
			$_Type = $_SESSION['Type'];
			$_Info = $_SESSION['Info'];
		}
		else{
			$_Type = $_POST['Type'];
			$_Info = $_POST['Info'];
			$_SESSION['Type'] = $_POST['Type'];
			$_SESSION['Info'] = $_POST['Info'];
		}
		
		$_SESSION['Compare'] = true;
		
		$db_host ="dbhome.cs.nctu.edu.tw";
		$db_name ="scsu_cs";
		$db_user ="scsu_cs";
		$db_password ="313";
		$dsn = "mysql:host=$db_host;dbname=$db_name";
		$db = new PDO($dsn,$db_user,$db_password);
		
		$sql = "SELECT * FROM `".$_Account."` ORDER BY  `".$_Type_o."` ".$_Info_o;
		$sth=$db->prepare($sql);
		$sth->execute(array());
		
		
		echo "<form action = \"comparisonlist.php\" method = \"POST\">
				 Order by:
				  <select name = \"Type_o\">
					<option value = \"ID\">ID</option>
					<option value = \"Flight_number\">Flight number</option>
					<option value = \"Departure\">Departure</option>
					<option value = \"Destination\">Destination</option>
					<option value = \"Departure_time\">Departure_time</option>
					<option value = \"Arrival_time\">Arrival_time</option>
					<option value = \"Price\">Price</option>
				  </select>"."
					Please choose a way to order:
					<input type=\"radio\" name=\"Info_o\" value=\"ASC\" checked>Ascending order
					<input type=\"radio\" name=\"Info_o\" value=\"DESC \">Descending order
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
			echo "<form action = \"login_func.php\" method=\"POST\" >
					<button name = \"back\"  type=\"submit\">Back</button>
			  </form>";
	}
	
	else
	{
		echo 'Permission deny. ';
		echo "<a href=\"http://people.cs.nctu.edu.tw/~chenc/login.php\"target=\"_top\">Back. </a>";
	}