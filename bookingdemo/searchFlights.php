<?php 
$page_title = 'AirHarhal | Αναζήτηση Πτήσης';
include ('includes/header.php');
?>
	
	<div id="content">
	<h1>Καλως ορίσατε στη Μηχανή Αναζήτησης Πτήσεων</h1>
	</div>
	
	<div id="form">
	<form action="bookFlight.php" method="post">
		
		<legend><b>Κάντε την επιλογή σας</b></legend>
		
		<script type="text/javascript">
			function yesnoCheck() {
			if (document.getElementById('one-way-input').checked) 
			{
				document.getElementById('date_to').style.visibility = 'hidden';
			}
			else document.getElementById('date_to').style.visibility = 'visible';
			if (document.getElementById('is-return-input').checked) 
			{
				document.getElementById('date_to').style.visibility = 'visible';
			}
			
			}
		</script>
		
		<p>
		<input type="radio" onclick="javascript:yesnoCheck();" name="trip_type" id="one-way-input" value="one_way" />Απλή μετάβαση                
		<span style="display:inline-block; width: 40px;"></span>
		<input type="radio" onclick="javascript:yesnoCheck();" name="trip_type" id="is-return-input" value="is_return"/>Με επιστροφή
		</p>
		<p>		
		Από<span style="display:inline-block; width: 33px;"></span><select id="place_from" name="place_f">
																	<option value="test"></option>
																	<?php 
																		require_once('dbConnect.php');
																		$query = mysqli_query($dbc, "SELECT distinct D_Name FROM destinations");
																		while($row = mysqli_fetch_assoc($query)){$rfrom = $row["D_Name"];
																		echo '<option value="'.$rfrom.'">'.$rfrom.'</option>';}
																	?>
																	</select>
		</p>		
		<p>
		Προς<span style="display:inline-block; width: 27px;"></span><select id="place_to" name="place_t">
																	<option value="test"></option>
																	<?php 
																		require_once('dbConnect.php');
																		$query = mysqli_query($dbc, "SELECT distinct D_Name FROM destinations");
																		while($row = mysqli_fetch_assoc($query)){$rto = $row["D_Name"];
																		echo '<option value="'.$rto.'">'.$rto.'</option>';}
																	?>
																	</select>
		</p>
				
		<div id="date_from">
		<p>
		Αναχώρηση<span style="display:inline-block; width: 5px;"></span><input type="date" name="date_f">
		</p>
		</div>
		<div id="date_to">
		<p>
		Επιστροφή<span style="display:inline-block; width: 13px;"></span><input type="date" name="date_t">
		</p>
		</div>
		<br>
		<p style="vertical-align:top; float:right">
		<input type="button" name="back" value="Επιστροφή" onClick="history.go(-1);return true;">
		<span style="display:inline-block; width: 5px;"></span>
		<input type="submit" name="submit" value="Αναζήτηση">
		</p>
		<input type="hidden" name="submitted" value="1">
		</fieldset>
	<br><br>					
	</form>
	</div>
	
	<div id ="empty">
	</div>
	<div id ="empty">
	</div>
	<div id ="empty">
	</div>
	<div id ="empty">
	</div>
	<div id ="empty">
	</div>
	<div id ="empty">
	</div>
	<div id ="empty">
	</div>
	
<?php 
include ('includes/footer.html');
?> 