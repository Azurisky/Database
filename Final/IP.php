
<?php
	$ip = $_SERVER['REMOTE_ADDR'];

	echo "Your IP:".$ip;
	
	$detail = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));

	echo $detail->country;
	//echo $detail->city;
	//echo $detail->org;
	//echo $detail->loc;
	
	echo "<table border=\"1\">";
			echo "<tr>
						<td>IP</td>
						<td>Country</td>
						<td>City</td>
						<td>Org</td>
						<td>Loc</td>
				  </tr>";
			echo 
				"<tr>
						<th>".$ip ."</th>
						<th>".$detail->country."</th>
						<th>".$detail->city."</th>
						<th>".$detail->org."</th>
						<th>".$detail->loc."</th>
				</tr>";			
	echo "</table>";
?>