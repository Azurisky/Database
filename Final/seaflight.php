<?php
	session_start();
	$db_host ="dbhome.cs.nctu.edu.tw";
	$db_name ="scsu_cs";
	$db_user ="scsu_cs";
	$db_password ="313";
	$dsn = "mysql:host=$db_host;dbname=$db_name";
	$db = new PDO($dsn,$db_user,$db_password);
?>


<form action = "seaflight_func.php" method = "POST">
	<table border="1">
	<p>Please enter the departure:<p>
	<select name = "Departure">
	<?php
	$sql = "SELECT `fullname`, `abbreviation` FROM country ORDER BY `fullname`";
	$countries = $db->prepare($sql);
	$countries->execute();
	while($country = $countries->fetchObject())
	{
	?>
		<optgroup label="<?= $country->fullname ?>">
		<?php
		$sql = "SELECT `fullname`, `Location` FROM airport WHERE country = ?";
		$airports = $db->prepare($sql);
		$airports->execute(array($country->abbreviation));
		while($airport=$airports->fetchObject())
		{
		?>
			<option value="<?= $airport->Location ?>"> <?= $airport->fullname ?> </option>
		<?php
		}
	}
	?>
	</select>
	
	<p>Please enter the destination:<p>
	<select name = "Destination">
	<?php
	$sql = "SELECT `fullname`, `abbreviation` FROM country ORDER BY `fullname`";
	$countries = $db->prepare($sql);
	$countries->execute();
	while($country = $countries->fetchObject())
	{
	?>
		<optgroup label="<?= $country->fullname ?>">
		<?php
		$sql = "SELECT `fullname`, `Location` FROM airport WHERE country = ?";
		$airports = $db->prepare($sql);
		$airports->execute(array($country->abbreviation));
		while($airport=$airports->fetchObject())
		{
		?>
			<option value="<?= $airport->Location ?>"> <?= $airport->fullname ?> </option>
		<?php
		}
	}
	?>
	</select>
	
	<p>Please enter the max transfer time you can accept:<p>
	<select name = "Max_transfer_time">
		<option value = "0">0</option>
		<option value = "1">1</option>
		<option value = "2">2</option>
	</select>
	
	<p>Order by:<p>
		<select name = "Order">
			<option value = "First_Departure_time">Departure_time</option>
			<option value = "Final_Arrival_Time">Arrival_time</option>
			<option value = "Total_Price">Price</option>
		</select>
	<p>Please choose a way to order:<p>
		<input type="radio" name="Info" value="ASC" checked>Ascending order
		<input type="radio" name="Info" value="DESC">Descending order
	<p>
	<button type="submit">submit</button>
</form></table>


<form action = "login.php" >
	<button type = "submit">Back</button>
</form>
