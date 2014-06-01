<?php
	session_start();
	$_Departure = $_POST['Departure'];
	$_Destination = $_POST['Destination'];
	$_Max = $_POST['Max_transfer_time'];
	$_Order = $_POST['Order'];
	$_Info = $_POST['Info'];
	
	$db_host ="dbhome.cs.nctu.edu.tw";
	$db_name ="scsu_cs";
	$db_user ="scsu_cs";
	$db_password ="313";
	$dsn = "mysql:host=$db_host;dbname=$db_name";
	$db = new PDO($dsn,$db_user,$db_password);
	
	
	echo $_Departure;
	echo $_Destination;
	echo $_Max;
	echo $_Order;
	echo $_Info;
	if($_Order == "" || $_Info == ""){
		echo "<p>Input error!</p>
				<form action = \"login_func.php\" method = \"POST\">
					<button type=\"submit\">back</button>
				</form>";
	}
	else
	{	
		$sql = "
				select 
	case type 
		when 0 then First_Arrival_time
		when 1 then Second_Arrival_time
		when 2 then Third_Arrival_time
		else NULL
	end as Final_Arrival_Time, 
	case type
		when 0 then 0
		when 1 then timediff(Second_Departure_time, First_Arrival_Time)
		when 2 then addtime(timediff(Second_Departure_time, First_Arrival_Time), timediff(Third_Departure_time, Second_Arrival_time))
		else NULL
	end as Total_Transfer_Time, 
	case type
		when 0 then First_Price
		when 1 then ((First_Price + Second_Price) * 0.9)
		when 2 then ((First_Price + Second_Price + Third_Price) * 0.8)
		else NULL
	end as Total_Price, 
	timediff(convert_tz(First_Arrival_Time, (select timezone from airport where Location = First_Destination), (select timezone from airport where Location = First_Departure)), First_Departure_time) as First_flight_time,
	case type
		when 1 then timediff(convert_tz(Second_Arrival_time, (select timezone from airport where Location = Second_Destination), (select timezone from airport where Location = Second_Departure)), Second_Departure_time)
		when 2 then timediff(convert_tz(Second_Arrival_time, (select timezone from airport where Location = Second_Destination), (select timezone from airport where Location = Second_Departure)), Second_Departure_time)
		else NULL
	end as Second_flight_time, 
	case type 
		when 2 then timediff(convert_tz(Third_Arrival_time, (select timezone from airport where Location = Third_Destination), (select timezone from airport where Location = Third_Departure)), Third_Departure_time)
		else NULL
	end as Third_flight_time,
	case type
		when 0 then timediff(convert_tz(First_Arrival_Time, (select timezone from airport where Location = First_Destination), (select timezone from airport where Location = First_Departure)), First_Departure_time)
		when 1 then addtime(timediff(convert_tz(First_Arrival_Time, (select timezone from airport where Location = First_Destination), (select timezone from airport where Location = First_Departure)), First_Departure_time), timediff(convert_tz(Second_Arrival_time, (select timezone from airport where Location = Second_Destination), (select timezone from airport where Location = Second_Departure)), Second_Departure_time))
		when 2 then addtime(timediff(convert_tz(Third_Arrival_time, (select timezone from airport where Location = Third_Destination), (select timezone from airport where Location = Third_Departure)), Third_Departure_time), addtime(timediff(convert_tz(First_Arrival_Time, (select timezone from airport where Location = First_Destination), (select timezone from airport where Location = First_Departure)), First_Departure_time), timediff(convert_tz(Second_Arrival_time, (select timezone from airport where Location = Second_Destination), (select timezone from airport where Location = Second_Departure)), Second_Departure_time)))
		else NULL
	end as Total_flight_time,
	two.*
from
(
	select 
		case 
			when Second_ID is NULL then 0
			when t.ID is NULL then 1
			else 2
		end as type,
		one.*,
		t.ID as Third_ID,
		t.Flight_number as Third_Number,
		t.Departure as Third_Departure,
		t.Destination as Third_Destination,
		t.Departure_time as Third_Departure_time,
		t.Arrival_time as Third_Arrival_time,
		t.Price as Third_Price
	from 
	(
		select 
			f.ID as First_ID,
			f.Flight_number as First_Number,
			f.Departure as First_Departure,
			f.Destination as First_Destination,
			f.Departure_time as First_Departure_time,
			f.Arrival_time as First_Arrival_time,
			f.Price as First_Price,
			s.ID as Second_ID,
			s.Flight_number as Second_Number,
			s.Departure as Second_Departure,
			s.Destination as Second_Destination,
			s.Departure_time as Second_Departure_time,
			s.Arrival_time as Second_Arrival_time,
			s.Price as Second_Price
		from 
			Flight as f join (
				select * from Flight union 
				select
					NULL as ID,
					NULL as Flight_number,
					NULL as Departure,
					NULL as Destination,
					NULL as Departure_time,
					NULL as Arrival_time,
					NULL as Price
			) AS s
		on (f.Destination = s.Departure AND f.Arrival_time + interval 2 hour <= s.Departure_time)
			or s.ID is null
	) as one
	join(
		select * from Flight union 
		select
			NULL as ID,
			NULL as Flight_number,
			NULL as Departure,
			NULL as Destination,
			NULL as Departure_time,
			NULL as Arrival_time,
			NULL as Price
	) as t 
	on (Second_Destination = t.Departure and Second_Arrival_time + interval 2 hour <= t.Departure_time) 
		or t.ID is null
	where
		First_Departure = ? and 
		case 
			when Second_ID is NULL then First_Destination
			when t.ID is NULL then Second_Destination
			else t.Destination
		end = ?
) as two

where type <= ? and 
	case type
		when 2 then First_Departure != Second_Destination
		else true
	end	

Order by ".$_Order." ".$_Info;
	
	
	
	
		//$sql = "SELECT * FROM `Flight`"."WHERE `".$_Type."` = ? ORDER BY  `".$_Type_o."` ".$_Info_o;			
		//$sql = "SELECT * FROM `Flight` ORDER BY  `".$_Type."` ".$_Info;
		//$sql = "SELECT * FROM `Flight`"."WHERE `Departure` = ?";
		$sth = $db->prepare($sql);
		$sth->execute(array($_Departure, $_Destination, $_Max));
		

		
		

echo "<table border=\"1\">";
		echo "<tr>
					<td>Result</td>
					<td>Flight_number</td>
					<td>Departure Airport</td>
					<td>Destination Airprot</td>
					<td>Departure_time</td>
					<td>Arrival_time</td>
					<td>Flight Time</td>
					<td>Total Flight time</td>
					<td>Transfer TIme</td>
					<td>Price</td>
			  </tr>";
$c=0;			  
while($result=$sth->fetchObject()){
			$c++;
			if($result->type==0)
			{
				echo "<tr>
						<th>".$c."</th>
						<th>".$result->First_Number."</th>
						<th>".$result->First_Departure."</th>
						<th>".$result->First_Destination."</th>
						<th>".$result->First_Departure_time."</th>
						<th>".$result->First_Arrival_time."</th>
						<th>".$result->First_flight_time."</th>
						<th>".$result->Total_flight_time."</th>
						<th>".$result->Total_Transfer_Time."</th>
						<th>".$result->Total_Price."</th>
			          </tr>";
			}
			else if($result->type==1)
			{
				echo "<tr>
						<th rowspan=\"2\">".$c."</th>
						<th>".$result->First_Number."</th>
						<th>".$result->First_Departure."</th>
						<th>".$result->First_Destination."</th>
						<th>".$result->First_Departure_time."</th>
						<th>".$result->First_Arrival_time."</th>
						<th>".$result->First_flight_time."</th>
						<th rowspan=\"2\">".$result->Total_flight_time."</th>
						<th rowspan=\"2\">".$result->Total_Transfer_Time."</th>
						<th rowspan=\"2\">".$result->Total_Price."</th>
			          </tr>";
				echo "<tr>
						<th>".$result->Second_Number."</th>
						<th>".$result->Second_Departure."</th>
						<th>".$result->Second_Destination."</th>
						<th>".$result->Second_Departure_time."</th>
						<th>".$result->Second_Arrival_time."</th>
						<th>".$result->Second_flight_time."</th>
			          </tr>";
			}
			else if($result->type==2)
			{
				echo "<tr>
						<th rowspan=\"3\">".$c."</th>
						<th>".$result->First_Number."</th>
						<th>".$result->First_Departure."</th>
						<th>".$result->First_Destination."</th>
						<th>".$result->First_Departure_time."</th>
						<th>".$result->First_Arrival_time."</th>
						<th>".$result->First_flight_time."</th>
						<th rowspan=\"3\">".$result->Total_flight_time."</th>
						<th rowspan=\"3\">".$result->Total_Transfer_Time."</th>
						<th rowspan=\"3\">".$result->Total_Price."</th>
			          </tr>";
				echo "<tr>
						<th>".$result->Second_Number."</th>
						<th>".$result->Second_Departure."</th>
						<th>".$result->Second_Destination."</th>
						<th>".$result->Second_Departure_time."</th>
						<th>".$result->Second_Arrival_time."</th>
						<th>".$result->Second_flight_time."</th>
			          </tr>";
				echo "<tr>
						<th>".$result->Third_Number."</th>
						<th>".$result->Third_Departure."</th>
						<th>".$result->Third_Destination."</th>
						<th>".$result->Third_Departure_time."</th>
						<th>".$result->Third_Arrival_time."</th>
						<th>".$result->Third_flight_time."</th>
			          </tr>";
			}
			
			
	}		
	echo "</table>";		
			
			
		echo "<form action = \"seaflight.php\" method = \"POST\">
				<button type=\"submit\">End search</button>
			 </form>";
	}



?>



