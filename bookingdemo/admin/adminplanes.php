<!DOCTYPE html>
<!-- Header -->
	<?php
			session_start();
			$page_title='Admin - Error';
			if ($_SESSION) {
				$page_title='Admin - Planes';
			}
			session_write_close();
			include('../includes/adminheader.php');
	?>
	

	
<!-- white bg -->
	<section class="section-padding-bottom" style="min-height:750px"><?php if ($_SESSION) { ?>
		<div class="container">
			<div class="row">
				<div class="tm-section-header section-margin-top">
					<div class="col-lg-3 col-md-3 col-sm-3"><hr></div>
					<div class="col-lg-6 col-md-6 col-sm-6"><h2 class="tm-section-title" style="text-transform:none;color:#e8bc06">Διαχείριση Αεροσκαφών</h2></div>
					<div class="col-lg-3 col-md-3 col-sm-3"><hr></div>	
				</div>				
			</div><br>
			<section class="container tm-home-section-1" id="more">
				<div class="row">
					<div class="col-lg-4 col-md-4 col-sm-6">
						<!-- Nav tabs -->
						<div class="tm-home-box-3">
							<ul class="nav nav-tabs tm-white-bg" role="tablist" id="hotelCarTabs">
								<li role="presentation" class="active" style="width:33.3%">
									<a href="#assign" aria-controls="car" role="tab" data-toggle="tab" style="text-transform:none">Ανάθεση σε γραμμή</a>
								</li>
								<li role="presentation" style="width:33.3%">
									<a href="#add" aria-controls="car" role="tab" data-toggle="tab" style="text-transform:none">Προσθήκη Αεροσκάφους</a>
								</li>
								<li role="presentation" style="width:33.4%">
									<a href="#delete" aria-controls="car" role="tab" data-toggle="tab" style="text-transform:none">Διαγραφή Αεροσκάφους</a>
								</li>
							</ul>

							<!-- Tab panes -->
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane fade in active tm-white-bg" id="assign">
									<div class="tm-search-box effect2">
										<form action="adminplanes.php" method="post" class="hotel-search-form">
											<div class="tm-form-inner">
												<div class="form-group">
													 <select class="form-control" name="route">
														<option value="">-- Select Route -- </option>
														<?php
															require_once('../mysqli_connect.php');
															$q = "SELECT I_id,I_dep, I_arr FROM itinerary group by I_dep, I_arr";
															$r = mysqli_query($dbc, $q);
															if (!$r) {
																echo '<h1>Σφάλμα Συστήματος</h1>
																	<p class="error">Δεν μπορέσαμε να σας εξυπηρετήσουμε λόγω
																	σφάλματος συστήματος. Ζητούμε συγγνώμη!</p>';
																	echo '<p>' . mysqli_error($dbc) . '<br>
																	Query: ' . $q . "</p>\n";
															} else {
																$num = mysqli_num_rows($r);
																if ($num > 0) {
																	while ($row = mysqli_fetch_array($r, MYSQLI_BOTH)) {
																		echo '<option value="' . $row['I_id'] . '">' . $row['I_dep'] . ' - ' . $row['I_arr'] . '</option>';
																	}
																	mysqli_free_result($r);
																} else {
																	echo "<p>Δεν υπάρχουν διαθέσιμες πτήσεις</p>\n";
																}
															}
														?>
													</select> 
												</div>					
												<div class="form-group">	
													<select class="form-control" name="plane">
														<option value="">-- Select Plane -- </option>
														<?php
															require_once('../mysqli_connect.php');
															$q = "SELECT Pl_type FROM plane";
															$r = mysqli_query($dbc, $q);
															if (!$r) {
																echo '<h1>Σφάλμα Συστήματος</h1>
																	<p class="error">Δεν μπορέσαμε να σας εξυπηρετήσουμε λόγω
																	σφάλματος συστήματος. Ζητούμε συγγνώμη!</p>';
																	echo '<p>' . mysqli_error($dbc) . '<br>
																	Query: ' . $q . "</p>\n";
															} else {
																$num = mysqli_num_rows($r);
																if ($num > 0) {
																	while ($row = mysqli_fetch_array($r, MYSQLI_BOTH)) {
																		echo '<option value="' . $row['Pl_type'] . '">' . $row['Pl_type'] . '</option>';
																	}
																	mysqli_free_result($r);
																} else {
																	echo "<p>Δεν υπάρχουν διαθέσιμες πτήσεις</p>\n";
																}
															}
														?>
													</select> 
												</div>
												<div class="form-group">
													<div class='input-group' name='departuretime'>
														<div>Departure Time</div>
														<select  name="h1">
														<option value="">hh</option>
														<?php 
															for($hours=0; $hours<24; $hours++) { // the interval for hours is '1'
																	echo '<option>'.str_pad($hours,2,'0',STR_PAD_LEFT).'</option>';
															}
														?>
														</select>
														<select  name="m1">
														<option value="">mm</option>
														<?php
															for($mins=0; $mins<60; $mins+=1) { // the interval for mins is '30'
																echo '<option>'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
															}
														?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<div class='input-group' name='arrivaltime'>
														<div>Arrival Time</div>
														<select  name="h2">
														<option value="">hh</option>
														<?php 
															for($hours=0; $hours<24; $hours++) { // the interval for hours is '1'
																	echo '<option>'.str_pad($hours,2,'0',STR_PAD_LEFT).'</option>';
															}
														?>
														</select>
														<select  name="m2">
														<option value="">mm</option>
														<?php
															for($mins=0; $mins<60; $mins+=1) { // the interval for mins is '30'
																echo '<option>'.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
															}
														?>
														</select>
													</div>
												</div>
											</div>							
											<div class="form-group tm-yellow-gradient-bg text-center">
												<button type="submit" name="submit" class="tm-yellow-btn">Assign</button>
												<input type="hidden" name="submitted1" value="1">
											</div>  
										</form>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade tm-white-bg" id="add">
									<div class="tm-search-box effect2">
										<form action="adminplanes.php" method="post" class="hotel-search-form">
											<div class="tm-form-inner">
												<div class="form-group">
													<input type='text' name='type' class="form-control" placeholder="Insert aircraft type"/>
												</div>
												<div class="form-group">
													<input type='text' name='seats' class="form-control" placeholder="Insert aircraft max seats"/>
												</div>
												<div class="form-group">
													<input type='text' name='distance' class="form-control" placeholder="Insert aircraft max distance (mi)"/>
												</div>							           
											</div>							
											<div class="form-group tm-yellow-gradient-bg text-center">
												<button type="submit" name="submit" class="tm-yellow-btn">Add</button>
												<input type="hidden" name="submitted2" value="1">
											</div>  
										</form>
									</div>
								</div>
								
								<div role="tabpanel" class="tab-pane fade tm-white-bg" id="delete">
									<div class="tm-search-box effect2">
										<form action="adminplanes.php" method="post" class="hotel-search-form">
											<div class="tm-form-inner">
												<div class="form-group">	
													<select class="form-control" name="plane1">
														<option value="">-- Select Plane -- </option>
														<?php
															require_once('../mysqli_connect.php');
															$q = "SELECT Pl_id, Pl_type FROM plane where Pl_active=1";
															$r = mysqli_query($dbc, $q);
															if (!$r) {
																echo '<h1>Σφάλμα Συστήματος</h1>
																	<p class="error">Δεν μπορέσαμε να σας εξυπηρετήσουμε λόγω
																	σφάλματος συστήματος. Ζητούμε συγγνώμη!</p>';
																	echo '<p>' . mysqli_error($dbc) . '<br>
																	Query: ' . $q . "</p>\n";
															} else {
																$num = mysqli_num_rows($r);
																if ($num > 0) {
																	while ($row = mysqli_fetch_array($r, MYSQLI_BOTH)) {
																		echo '<option value="' . $row['Pl_id'] . '">' . $row['Pl_type'] . '</option>';
																	}
																	mysqli_free_result($r);
																} else {
																	echo "<p>Δεν υπάρχουν διαθέσιμες πτήσεις</p>\n";
																}
															}
														?>
													</select> 
												</div>					           
											</div>									
											<div class="form-group tm-yellow-gradient-bg text-center">
												<button type="submit" name="submit" class="tm-yellow-btn">Delete</button>
												<input type="hidden" name="submitted3" value="1">
											</div>  
										</form>
									</div>
								</div>
								
							</div>
						</div>								
					</div> 
					
					<div class="col-lg-8 col-md-8 col-sm-10">
						<div class="tm-home-box-1 tm-home-box-1-center" style="margin-left:90px;margin-right:20px">
							<?php
								if (isset($_POST['submitted1'])) {
									$errors = array();
									if (($_POST['route'])=="" || ($_POST['plane'])=="" || ($_POST['h1'])=="" || ($_POST['m1'])=="" || ($_POST['h2'])=="" || ($_POST['m2'])=="") {
										$errors[] = "Ξεχάσατε να επιλέξετε όλα τα πεδία.";
									}else {
										$h1 = intval(mysqli_real_escape_string($dbc, trim($_POST['h1'])));
										$h2 = intval(mysqli_real_escape_string($dbc, trim($_POST['h2'])));
										$m1 = intval(mysqli_real_escape_string($dbc, trim($_POST['m1'])));
										$m2 = intval(mysqli_real_escape_string($dbc, trim($_POST['m2'])));
										if ((($h1>$h2) &&  (!($h1>=12 && $h1<=23 && $h2<12 && $h2>=0))) || (($h1==$h2) && ($m1>=$m2))) {
											$errors[] = "H ώρα αναχώρησης δεν μπορεί να είναι μεταγενέστερη της ώρας επιστροφής.";
										}else {
											$ItinID = mysqli_real_escape_string($dbc, trim($_POST['route']));
											$q1 = "SELECT I_dep, I_arr FROM itinerary where I_id='$ItinID'";
											$r1 = mysqli_query($dbc, $q1);
											while ($row = mysqli_fetch_array($r1, MYSQLI_BOTH)) {
												$route = $row['I_dep'] . ' - ' . $row['I_arr'];
											}
											$pla = mysqli_real_escape_string($dbc, trim($_POST['plane']));
											$q2 = "update itinerary set I_Pid=(select Pl_id from plane where Pl_type='$pla') where I_id='$ItinID'";
											$q3 = "update itinerary set I_deptime='{$_POST['h1']}:{$_POST['m1']}' where I_id='$ItinID'";
											$q4 = "update itinerary set I_arrtime='{$_POST['h2']}:{$_POST['m2']}' where I_id='$ItinID'";
											$q5 = "update itinerary set I_active='1' where I_id='$ItinID'";
											$r2 = mysqli_query($dbc, $q2);
											$r3 = mysqli_query($dbc, $q3);
											$r4 = mysqli_query($dbc, $q4);
											$r5 = mysqli_query($dbc, $q5);
											if ((!$r2) || (!$r3) || (!$r4) || (!$r5)) {
												echo '<h1>Σφάλμα Συστήματος</h1>
													<p class="error">Δεν μπορέσαμε να σας εξυπηρετήσουμε λόγω
													σφάλματος συστήματος. Ζητούμε συγγνώμη!</p>';
													echo '<p>' . mysqli_error($dbc) . '<br>
													Query: ' . $q2 . $q3 .  $q4 .  "</p>\n";
											} else {
												echo '<h1 style="min-width:600px;color:#15f509;font-size:24px">H ανάθεση πραγματοποιήθηκε με επιτυχία</h1><br><p style="min-width:600px;color:#00cae4;font-size:20px">Το δρομολόγιο: <b><i>&nbsp;' . $route . '</i></b><br> θα εκτελείται πλέον από το αεροσκάφος <b><i>&nbsp;' .$pla . '</i></b><br> με ώρα Αναχώρησης την <b><i>&nbsp;' . $_POST['h1'] . ':' . $_POST['m1'] . '</i></b><br> και ώρα Άφιξης την <b><i>&nbsp;' . $_POST['h2'] . ':' . $_POST['m2'] . '</i></b></p>';
											}
										}
									}
								}
								if (isset($_POST['submitted2'])) {
									$errors = array();
									$seat = mysqli_real_escape_string($dbc, trim($_POST['seats']));
									if (($_POST['type'])=="" || ($_POST['seats'])=="" || ($_POST['distance'])=="") {
										$errors[] = "Ξεχάσατε να συμπληρώσετε όλα τα πεδία.";
									}else if ((strval(intval($_POST['seats']))!=$_POST['seats']) || ($_POST['seats']%6!=0)){
										$errors[] = "Ο μέγιστος αριθμός καθισμάτων του αεροσκάφους πρέπει να είναι ακέραιο πολλαπλάσιο του 6.";
									}else if (strval(intval($_POST['distance']))!=$_POST['distance']){
										$errors[] = "Ο μέγιστος αριθμός μιλίων που μπορεί να διανύσει το αεροσκάφος πρέπει να είναι ακέραιος.";
									}else {
										$q = "insert into plane (Pl_type, Pl_seats, Pl_dist) values ('{$_POST['type']}', {$_POST['seats']}, {$_POST['distance']})";
										$r = mysqli_query($dbc, $q);
										if (!$r) {
											echo '<h1>Σφάλμα Συστήματος</h1>
												<p class="error">Δεν μπορέσαμε να σας εξυπηρετήσουμε λόγω
												σφάλματος συστήματος. Ζητούμε συγγνώμη!</p>';
												echo '<p>' . mysqli_error($dbc) . '<br>
												Query: ' . $q .  "</p>\n";
										} else {
											echo '<h1 style="min-width:600px;color:#15f509;font-size:24px">H προσθήκη του αεροσκάφους πραγματοποιήθηκε με επιτυχία</h1>';
										}
									}
									
								}
								if (isset($_POST['submitted3'])) {
									$errors = array();
									if (($_POST['plane1'])=="") {
										$errors[] = "Ξεχάσατε να επιλέξετε αεροσκάφος.";
									}else {
										$id = mysqli_real_escape_string($dbc, trim($_POST['plane1']));
										$q = "update plane set Pl_active='0' where Pl_id='$id'";
										$r = mysqli_query($dbc, $q);
										if (!$r) {
											echo '<h1>Σφάλμα Συστήματος</h1>
												<p class="error">Δεν μπορέσαμε να σας εξυπηρετήσουμε λόγω
												σφάλματος συστήματος. Ζητούμε συγγνώμη!</p>';
												echo '<p>' . mysqli_error($dbc) . '<br>
												Query: ' . $q .  "</p>\n";
										} else {
											echo '<h1 style="min-width:600px;color:#15f509;font-size:24px">H απόσυρση του αεροσκάφους πραγματοποιήθηκε με επιτυχία</h1>';
										}
									}
									
								}
								if (!empty($errors)) {
									echo '<p class="error" style="min-width:600px">&nbsp;&nbsp;&nbsp;&nbsp;Προσοχή!<br>';
									foreach ($errors as $m) {
										echo "&nbsp;&nbsp;&nbsp;&nbsp; - $m <br>\n";
									}
									echo '</p><br><p style="color:#e8bc06">&nbsp;&nbsp;&nbsp;&nbsp;Παρακαλώ επανεισάγετε εκ νέου τα στοιχεία.</p>';
								}
							?>			
						</div>				
					</div>
					
				</div>
			</section>
		</div>
	<?php } ?></section>

	
	<!-- Footer -->
		<?php
			include('../includes/adminfooter.html');
		?>	