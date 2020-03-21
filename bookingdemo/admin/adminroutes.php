<!DOCTYPE html>
<!-- Header -->
	<?php
			session_start();
			$page_title='Admin - Error';
			if ($_SESSION) {
				$page_title='Admin - Routes';
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
					<div class="col-lg-6 col-md-6 col-sm-6"><h2 class="tm-section-title" style="text-transform:none;color:#e8bc06">Διαχείριση Δρομολογίων</h2></div>
					<div class="col-lg-3 col-md-3 col-sm-3"><hr></div>	
				</div>				
			</div><br>
			<section class="container tm-home-section-1" id="more">
				<div class="row">
					<div class="col-lg-4 col-md-4 col-sm-6">
						<!-- Nav tabs -->
						<div class="tm-home-box-3">
							<ul class="nav nav-tabs tm-white-bg" role="tablist" id="hotelCarTabs">
								<li role="presentation" class="active" >
									<a href="#add" aria-controls="car" role="tab" data-toggle="tab" style="text-transform:none">Προσθήκη Δρομολογίου</a>
								</li>
								<li role="presentation">
									<a href="#delete" aria-controls="car" role="tab" data-toggle="tab" style="text-transform:none">Διαγραφή Δρομολογίου</a>
								</li>
							</ul>

							<!-- Tab panes -->
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane fade in active tm-white-bg" id="add">
									<div class="tm-search-box effect2">
										<form action="adminroutes.php" method="post" class="hotel-search-form">
											<div class="tm-form-inner">
												<div class="form-group">
													<input type='text' name='departure' class="form-control" placeholder="Insert departure airport"/>
												</div>
												<div class="form-group">
													<input type='text' name='destination' class="form-control" placeholder="Insert destination airport"/>
												</div>
												<div class="form-group">
													<input type='text' name='fligthnum' class="form-control" placeholder="Insert flight number"/>
												</div>
												<div class="form-group">
													<input type='text' name='distance' class="form-control" placeholder="Insert flight distance (mi)"/>
												</div>							           
											</div>							
											<div class="form-group tm-yellow-gradient-bg text-center">
												<button type="submit" name="submit" class="tm-yellow-btn">Add</button>
												<input type="hidden" name="submitted1" value="1">
											</div>  
										</form>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade tm-white-bg" id="delete">
									<div class="tm-search-box effect2">
										<form action="adminroutes.php" method="post" class="hotel-search-form">
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
												<button type="submit" name="submit" class="tm-yellow-btn">Delete</button>
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
							 <?php
								if (isset($_POST['submitted1'])) {
									$errors = array();
									if (empty($_POST['departure']) || empty($_POST['destination'])|| empty($_POST['fligthnum']) || empty($_POST['distance'])) {
										$errors[] = "Ξεχάσατε να επιλέξετε όλα τα πεδία.";
									}else if ($_POST['departure']==$_POST['destination']){
										$errors[] = "Το αεροδρόμιο αναχώρησης δεν μπορεί να είναι ίδιο με το αεροδρόμιο προορισμού.";
									}else if (!(preg_match('/^[A-Z]{2}-[0-9]{3}$/', $_POST['fligthnum']))) {
										$errors[] = "Ο αριθμός πτήσης πρέπει να είναι της μορφής  <b> <i> AB-123</b></i>.";							
									}else if (strval(intval($_POST['distance']))!=$_POST['distance']){
										$errors[] = "Η απόσταση του δρομολογίου πρέπει να είναι ακέραιη τιμή.";
									}else {
										$q = "select I_dep, I_arr,I_num from itinerary group by I_dep, I_arr";
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
													if (($row['I_dep']==$_POST['departure']) && ($row['I_arr']==$_POST['destination'])) {
														$errors[] = 'Το δρομολόγιο ' . $row['I_dep'] . ' - ' . $row['I_arr'] . ' είναι ήδη καταχωρημένο.';
													} else if ($row['I_num']==$_POST['fligthnum']) {
														$errors[] = 'Ο αριθμός πτήσης ' . $row['I_num'] . ' έχει ήδη καταχωρηθεί σε άλλο δρομολόγιο.';
													}
												}
												mysqli_free_result($r);
											} else {
												echo "<p>Δεν υπάρχουν διαθέσιμες πτήσεις</p>\n";
											}
										}
										if (empty($errors)) {
											$q1 = "insert into itinerary (I_dep, I_arr, I_dist, I_num) values ('{$_POST['departure']}', '{$_POST['destination']}','{$_POST['distance']}', '{$_POST['fligthnum']}')";
											$r1 = mysqli_query($dbc, $q1);
											$r2 = mysqli_query($dbc, "select Pe_id from period");
											while ($row2 = mysqli_fetch_array($r2, MYSQLI_BOTH)) {
												$q3 = "insert into price (Pr_Iid, Pr_Cost, Pr_Peid) values ((select I_id from itinerary where I_dep ='{$_POST['departure']}' and I_arr='{$_POST['destination']}'), '0', '{$row2['Pe_id']}')";
												$r3 = mysqli_query($dbc, $q3);
											}
											if ((!$r1) || (!$r3)) {
												echo '<h1>Σφάλμα Συστήματος</h1>
													<p class="error">Δεν μπορέσαμε να σας εξυπηρετήσουμε λόγω
													σφάλματος συστήματος. Ζητούμε συγγνώμη!</p>';
													echo '<p>' . mysqli_error($dbc) . '<br>
													Query: ' . $q1 .  "</p>\n";
											} else {
												echo '<h1 style="min-width:600px;color:#15f509;font-size:24px">Το δρομολόγιο καταχωρήθηκε με επιτυχία</h1>';
											}
										}
									}
									
								}
								if (isset($_POST['submitted2'])) {
									$errors = array();
									if (($_POST['route1'])=="") {
										$errors[] = "Ξεχάσατε να επιλέξετε αεροδρόμιο.";
									}else {
										$q = "update itinerary set I_active='0' where I_id='{$_POST['route1']}'";
										$r = mysqli_query($dbc, $q);
										if (!$r) {
											echo '<h1>Σφάλμα Συστήματος</h1>
												<p class="error">Δεν μπορέσαμε να σας εξυπηρετήσουμε λόγω
												σφάλματος συστήματος. Ζητούμε συγγνώμη!</p>';
												echo '<p>' . mysqli_error($dbc) . '<br>
												Query: ' . $q .  "</p>\n";
										} else {
											echo '<h1 style="min-width:600px;color:#15f509;font-size:24px">Το δρομολόγιο καταργήθηκε με επιτυχία</h1>';
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