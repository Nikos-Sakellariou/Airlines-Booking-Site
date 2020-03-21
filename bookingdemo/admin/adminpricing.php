<!DOCTYPE html>
<!-- Header -->
	<?php
			session_start();
			$page_title='Admin - Error';
			if ($_SESSION) {
				$page_title='Admin - Pricing';
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
					<div class="col-lg-6 col-md-6 col-sm-6"><h2 class="tm-section-title" style="text-transform:none;color:#e8bc06">Τιμολόγηση</h2></div>
					<div class="col-lg-3 col-md-3 col-sm-3"><hr></div>	
				</div>				
			</div><br>
			<section class="container tm-home-section-1" id="more">
				<div class="row">
					<div class="col-lg-4 col-md-4 col-sm-6">
						<!-- Nav tabs -->
						<div class="tm-home-box-3">
							<ul class="nav nav-tabs tm-white-bg" role="tablist" id="hotelCarTabs">
								<li role="presentation" class="active">
									<a href="#cost" aria-controls="car" role="tab" data-toggle="tab" style="text-transform:none">Καθορισμός Τιμών</a>
								</li>
								<li role="presentation">
									<a href="#discount" aria-controls="car" role="tab" data-toggle="tab" style="text-transform:none">Παροχή Εκπτώσεων</a>
								</li>
							</ul>

							<!-- Tab panes -->
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane fade in active tm-white-bg" id="cost">
									<div class="tm-search-box effect2">
										<form action="adminpricing.php" method="post" class="hotel-search-form">
											<div class="tm-form-inner">
												<div class="form-group">
													 <select class="form-control" name="route">
														<option value="">-- Select Route -- </option>
														<?php
															require_once('../mysqli_connect.php');
															$q = "SELECT I_id,I_dep, I_arr FROM itinerary where I_active=1";
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
													<select class="form-control" name="season">
														<option value="">-- Select Season -- </option>
														<?php
															require_once('../mysqli_connect.php');
															$q = "SELECT distinct Pe_type FROM period";
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
																		echo '<option value="' . $row['Pe_type'] . '">' . $row['Pe_type'] . ' season</option>';
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
												<button type="submit" name="submit" class="tm-yellow-btn">Check Price</button>
												<input type="hidden" name="submitted1" value="1">
											</div>  
										</form>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade tm-white-bg" id="discount">
									<div class="tm-search-box effect2">
										<form action="adminpricing.php" method="post" class="hotel-search-form">
											<div class="tm-form-inner">
												<div class="form-group">
													 <select class="form-control" name="route1">
														<option value="">-- Select Route -- </option>
														<?php
															require_once('../mysqli_connect.php');
															$q = "SELECT I_id,I_dep, I_arr FROM itinerary where I_active=1 group by I_dep, I_arr";
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
											</div>							
											<div class="form-group tm-yellow-gradient-bg text-center">
												<button type="submit" name="submit" class="tm-yellow-btn">Check Discount</button>
												<input type="hidden" name="submitted2" value="1">
											</div>  
										</form>
									</div>
								</div>								
							</div>
						</div>								
					</div> 
					
					<div class="col-lg-8 col-md-8 col-sm-10">
						<div class="tm-home-box-1 tm-home-box-1-center" style="margin-left:90px;margin-right:20px">
							<?php if (isset($_POST['submitted1']) || isset($_POST['submitted2'])) { ?>
								<div class="col-lg-8 col-md-8 col-sm-10">
									<div class="tm-home-box-1 tm-home-box-1-center" style="margin-left:0px;margin-right:20px">
										<?php 
										if (isset($_POST['submitted1']) && ((($_POST['route'])=="" || ($_POST['season'])==""))) { 
											$errors = array();
											$errors[] = "Ξεχάσατε να επιλέξετε όλα τα πεδία.";
										} else if (isset($_POST['submitted2']) && (($_POST['route1'])=="")) {
											$errors = array();
											$errors[] = "Ξεχάσατε να επιλέξετε όλα τα πεδία.";
										}
										
										if (!empty($errors)) {
											echo '<p class="error" style="min-width:600px">&nbsp;&nbsp;&nbsp;&nbsp;Προσοχή!<br>';
											foreach ($errors as $m) {
												echo "&nbsp;&nbsp;&nbsp;&nbsp; - $m <br>\n";
											}
											echo '</p><br><p style="color:#e8bc06">&nbsp;&nbsp;&nbsp;&nbsp;Παρακαλώ επανεισάγετε εκ νέου τα στοιχεία.</p>';
										}
										?>
										<?php if (empty($errors)) { ?>
										<div class="tab-content">
											<div role="tabpanel" class="tab-pane fade in active tm-white-bg" id="costchange">
												<div class="tm-search-box effect2">
													<form action="adminpricing.php" method="post" class="hotel-search-form">
														<div class="tm-form-inner">	
															<div class="form-group" style="color:#0207E0;font-family:serif;font-size:16px">
																 <?php
																	if (isset($_POST['submitted1'])) {
																		$errors = array();
																		if (($_POST['route'])=="" || ($_POST['season'])=="") {
																			$errors[] = "Ξεχάσατε να επιλέξετε όλα τα πεδία.";
																		}else {
																			$ItinID = mysqli_real_escape_string($dbc, trim($_POST['route']));
																			$_SESSION['ItID'] = $ItinID;
																			$q1 = "SELECT I_dep, I_arr FROM itinerary where I_active=1 and I_id='$ItinID'";
																			$r1 = mysqli_query($dbc, $q1);
																			while ($row = mysqli_fetch_array($r1, MYSQLI_BOTH)) {
																				echo "Δρομολόγιο:&nbsp;&nbsp;{$row['I_dep']} - {$row['I_arr']}";
																			}
																			$season = mysqli_real_escape_string($dbc, trim($_POST['season']));
																			$_SESSION['season'] = $season;
																			$q2 = "select distinct Pr_Cost from price where Pr_Iid='$ItinID' and Pr_Peid in (select Pe_id from period where Pe_type='$season')";
																			$r2 = mysqli_query($dbc, $q2);
																			echo "<div class='form-group'><br>Περίοδος:&nbsp;&nbsp;&nbsp;$season season</div>";
																			while ($row2 = mysqli_fetch_array($r2, MYSQLI_BOTH)) {
																				echo "<div class='form-group'>Τιμή:&nbsp;&nbsp;&nbsp;{$row2['Pr_Cost']} \xE2\x82\xAc</div>";
																			}
																			if (!$r2){
																				echo '<h1>Σφάλμα Συστήματος</h1>
																					<p class="error">Δεν μπορέσαμε να σας εξυπηρετήσουμε λόγω
																					σφάλματος συστήματος. Ζητούμε συγγνώμη!</p>';
																					echo '<p>' . mysqli_error($dbc) . '<br>
																					Query: ' . $q2 .  "</p>\n";
																			}
																		}
																	}
																?>
																<?php
																	if (isset($_POST['submitted2'])) {
																		$errors = array();
																		if (($_POST['route1'])=="") {
																			$errors[] = "Ξεχάσατε να επιλέξετε πεδίο.";
																		}else {
																			$ItinID = mysqli_real_escape_string($dbc, trim($_POST['route1']));
																			$_SESSION['ItID'] = $ItinID;
																			$q1 = "SELECT I_disc, I_dep, I_arr FROM itinerary where I_active=1 and I_id='$ItinID'";
																			$r1 = mysqli_query($dbc, $q1);
																			while ($row = mysqli_fetch_array($r1, MYSQLI_BOTH)) {
																				echo "Δρομολόγιο:&nbsp;&nbsp;{$row['I_dep']} - {$row['I_arr']}";
																				echo "<div class='form-group'><br>Καταχωρημένη έκπτωση:&nbsp;&nbsp;&nbsp;-{$row['I_disc']} %</div>";
																			}
																			if (!$r1){
																				echo '<h1>Σφάλμα Συστήματος</h1>
																					<p class="error">Δεν μπορέσαμε να σας εξυπηρετήσουμε λόγω
																					σφάλματος συστήματος. Ζητούμε συγγνώμη!</p>';
																					echo '<p>' . mysqli_error($dbc) . '<br>
																					Query: ' . $q2 .  "</p>\n";
																			}
																		}
																	}
																?>
															</div>
															<div class="form-group">
																<input type='text' name='<?php	if (isset($_POST['submitted2'])) { echo 'discount';} else if (isset($_POST['submitted1'])) { echo 'price';} ?>' class="form-control" placeholder="<?php	if (isset($_POST['submitted2'])) { echo 'Insert new discount';} else if (isset($_POST['submitted1'])) { echo 'Insert new price';} ?>"/>
															</div>												
														</div>							
														<div class="form-group tm-yellow-gradient-bg text-center">
															<button type="submit" name="submit" class="tm-yellow-btn"><?php	if (isset($_POST['submitted2'])) { echo 'Change Discount';} else if (isset($_POST['submitted1'])) { echo 'Change Price';} ?></button>
															<input type="hidden" name="<?php if (isset($_POST['submitted2'])) { echo 'submitted4';} else if (isset($_POST['submitted1'])) { echo 'submitted3';} ?>" value="1">
														</div>  
													</form>
												</div>
											</div>								
										</div>
										<?php } ?>
										
									</div>								
								</div>		
							<?php } ?>
							<?php if (isset($_POST['submitted3']) || isset($_POST['submitted4'])) { ?>
								<div class="col-lg-8 col-md-8 col-sm-10">
									<div class="tm-home-box-1 tm-home-box-1-center" style="margin-left:0px;margin-right:20px">
										<?php 
										if (isset($_POST['submitted3'])) { 
											if (($_POST['price'])=="") { 
											$errors = array();
											$errors[] = "Ξεχάσατε να επιλέξετε όλα τα πεδία.";
											}else if (strval(intval($_POST['price']))!=$_POST['price']) {
												$errors[] = "Παρακαλώ εισάγετε μία έγκυρη, ακέραιη τιμή.";
											}else {
												$season = $_SESSION['season'];
												$ItinID = $_SESSION['ItID'];
												$q3 = "update price set Pr_Cost={$_POST['price']} where Pr_Iid='$ItinID' and Pr_Peid in (select Pe_id from period where Pe_type='$season')";
												$r3 = mysqli_query($dbc, $q3);
												if (!$r3){
													echo '<h1>Σφάλμα Συστήματος</h1>
														<p class="error">Δεν μπορέσαμε να σας εξυπηρετήσουμε λόγω
														σφάλματος συστήματος. Ζητούμε συγγνώμη!</p>';
														echo '<p>' . mysqli_error($dbc) . '<br>
														Query: ' . $q2 .  "</p>\n";
												} else {
													echo "<h1 style='min-width:600px;color:#15f509;font-size:24px'>H τιμή του δρομολογίου άλλαξε με επιτυχία σε {$_POST['price']} \xE2\x82\xAc.</h1>";
												}
												
											}
										}
										if (isset($_POST['submitted4'])) {
											if (($_POST['discount'])=="") {
											$errors = array();
											$errors[] = "Ξεχάσατε να επιλέξετε όλα τα πεδία.";
											}else if ((strval(intval($_POST['discount']))!=$_POST['discount']) || ((intval($_POST['discount']))>=100)) {
												$errors[] = "Παρακαλώ εισάγετε μία έγκυρη, ακέραιη έκπτωση.";
											}else {
												$season = $_SESSION['season'];
												$ItinID = $_SESSION['ItID'];
												$q3 = "update itinerary set I_disc={$_POST['discount']} where I_id='$ItinID'";
												$r3 = mysqli_query($dbc, $q3);
												if (!$r3){
													echo '<h1>Σφάλμα Συστήματος</h1>
														<p class="error">Δεν μπορέσαμε να σας εξυπηρετήσουμε λόγω
														σφάλματος συστήματος. Ζητούμε συγγνώμη!</p>';
														echo '<p>' . mysqli_error($dbc) . '<br>
														Query: ' . $q2 .  "</p>\n";
												} else {
													echo "<h1 style='min-width:600px;color:#15f509;font-size:24px'>Καταχωρήθηκε με επιτυχία έκπτωση {$_POST['discount']} % στο δρομολόγιο.</h1>";
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
							<?php } ?>
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
