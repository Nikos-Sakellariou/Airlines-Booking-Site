<!DOCTYPE html>
<!-- Header -->
	<?php
			session_start();
			$page_title='Admin - Error';
			if ($_SESSION) {
				$page_title='Admin - Customers';
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
					<div class="col-lg-6 col-md-6 col-sm-6"><h2 class="tm-section-title" style="text-transform:none;color:#e8bc06">Στοιχεία Επιβατών</h2></div>
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
									<a href="#flight" aria-controls="car" role="tab" data-toggle="tab" style="text-transform:none">Αναζήτηση Επιβατών σε Πτήση</a>
								</li>
								<li role="presentation">
									<a href="#passenger" aria-controls="car" role="tab" data-toggle="tab" style="text-transform:none">Αναζήτηση Στοιχείων Πελάτη</a>
								</li>
							</ul>

							<!-- Tab panes -->
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane fade in active tm-white-bg" id="flight">
									<div class="tm-search-box effect2">
										<form action="admincustomers.php" method="post" class="hotel-search-form">
											<div class="tm-form-inner">
												<div><br><br><br><br><br>
												</div>
												<div class="form-group">
													 <select class="form-control" name="route">
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
												<div class="form-group">
													<div class='input-group date' id='datetimepicker1'>
														<input type='text' class="form-control" placeholder="Date of Flight" name="date"/>
														<span class="input-group-addon">
															<span class="fa fa-calendar"></span>
														</span>
													</div>
												</div>
											</div>							
											<div class="form-group tm-yellow-gradient-bg text-center">
												<button type="submit" name="submit" class="tm-yellow-btn">Search Flight</button>
												<input type="hidden" name="submitted1" value="1">
											</div>  
										</form>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane fade tm-white-bg" id="passenger">
									<div class="tm-search-box effect2">
										<form action="admincustomers.php" method="post" class="hotel-search-form">
											<div class="tm-form-inner">
												<div class="form-group" style="font-family:serif;font-size:20px">
													<input type='radio' style="width:30px" name='choose' value="eticket">&nbsp;E-ticket</input>
												</div>
												<div class="form-group" style="font-family:serif;font-size:20px">
													<input type='radio' style="width:30px" name='choose' value="adt">&nbsp;Α.Δ.Τ.</input>
												</div>
												<div class="form-group" style="font-family:serif;font-size:20px">
													<input type='radio'  style="width:30px" name='choose' value="lname">&nbsp;Επώνυμο</input>
												</div>
												<div class="form-group">
													<input type='text' name='entry' class="form-control" placeholder="Insert value"/>
												</div>
											</div>							
											<div class="form-group tm-yellow-gradient-bg text-center">
												<button type="submit" name="submit" class="tm-yellow-btn">Search Customer</button>
												<input type="hidden" name="submitted2" value="1">
											</div>  
										</form>
									</div>
								</div>								
							</div>
						</div>								
					</div> 
					
					<div class="col-lg-8 col-md-8 col-sm-10">
						<div class="tm-form-inner" style="padding-top:0px">
						<?php 
							$errors = array();
							if (isset($_POST['submitted1'])) {
										if (empty($_POST['route']) || empty($_POST['date'])) {
											$errors[] = "Ξεχάσατε να επιλέξετε όλα τα πεδία.";
										} else {
											$date = mysqli_real_escape_string($dbc, trim($_POST['date']));
											$newdate = preg_replace('!^([0-9]{2})/([0-9]{2})/([0-9]{4})$!',"$3-$1-$2",$date);
											$q = "select I_dep, I_arr, R_dep, I_num, I_deptime, I_arrtime, C_Fname, C_Lname, C_Trdoc, C_Bdate from (select * from reserve where R_Prid in (select Pr_id from price where Pr_Iid='{$_POST['route']}') and R_dep='$newdate') as t1 left join price on Pr_id=t1.R_Prid left join itinerary on Pr_Iid=I_id left join customer on C_id=t1.R_Cid;";
											$r = mysqli_query($dbc, $q);
											$num = mysqli_num_rows($r);
											if ($num > 0) {
												$i=0;
												while ($row = mysqli_fetch_array($r, MYSQLI_BOTH)) {
												if ($i==0) {
												$newdate = preg_replace('!^([0-9]{2})/([0-9]{2})/([0-9]{4})$!',"$2-$1-$3",$date);
												echo '
												<div class="list-group-item segment-item" style="background-color:#d9edf7">
													<div class="row">
														<div class="col-xs-9 col-md-8 col-lg-9">
															<div class="row">
																<div class="col-xs-9 col-md-8 col-lg-9" style="width:100px; padding-left:30px;">
																	<img src="../img/plane_go.svg" alt="Plane ob" width="24" height="24">
																</div>
																<div style="width:300px;text-align:left;font-family:serif;font-size:20px;color:#616876;letter-spacing:0.12em;">
																	<div>My Airlines</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="list-group-item segment-item">
													<div class="row">
														<div class="col-xs-9 col-sm-8 col-lg-9">
															<div class="row">
																<div class="col-xs-4 col-lg-offset-1">
																	<div style="font-family:sans-serif;font-size:20px;color:#00339a" name="timedep"><strong>
																		' . $row['I_deptime'] . '
																		</strong>
																	</div>
																	<div><br></div>
																	<div style="font-family:sans-serif;font-size:14px;color:#616876">' . $row['I_dep'] . '</div>
																</div>
																<div class="col-xs-4">
																	<div style="font-family:sans-serif;font-size:20px;color:#00339a"><strong>
																		' . $row['I_arrtime'] . '
																		</strong>
																	</div>
																	<div><br></div>
																	<div style="font-family:sans-serif;font-size:14px;color:#616876">' . $row['I_arr'] . '</div>
																</div>
																<div class="col-xs-4 col-lg-3">
																	<div style="font-family:sans-serif;font-size:15px;color:#00aeef;letter-spacing:0.12em;">
																		' . $newdate . '
																	</div>
																	<div><br></div>
																	<div style="font-family:sans-serif;font-size:14px;color:#616876">
																		Αρ. πτήσης<br>
																		' . $row['I_num'] . '
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div>
												</div>
												<div class="list-group-item segment-item" style="background-color:#d9edf7;font-family:serif;font-size:20px;color:#616876;letter-spacing:0.12em;width:230px;text-align:center;margin-top:20px;border-color:black;border-top-left-radius:5px;border-top-right-radius:5px">
													<b>Επιβάτες</b>
												</div>
												<div class="list-group-item segment-item" style="border-color:black;background-color:rgba(255, 255, 255, 0)">
													<div class="row">
														<div class="col-xs-9 col-sm-8 col-lg-9">
															<div class="row" style="font-family:sans-serif;font-size:16px;color:red;width:600px">
																<strong>
																<div class="col-xs-6" style="width:250px">
																	<div>
																		A/A &nbsp;&nbsp;&nbsp;Ονοματεπώνυμο 
																		
																	</div>
																</div>
																<div class="col-xs-4" style="width:160px">
																	<div>
																		Αρ. Ταυτότητας
																	</div>
																</div>
																<div class="col-xs-4" style="width:180px">
																	<div>
																		Ημ/νία Γέννησης
																	</div>
																</div>
																</strong>
															</div>
														</div>
													</div>
												</div>';
												}
												$newdate = preg_replace('!^([0-9]{4})-([0-9]{2})-([0-9]{2})$!',"$3-$2-$1",$row['C_Bdate']);
												echo '
												<div class="list-group-item segment-item" style="border-color:black;background-color:rgba(255, 255, 255, 0)">
													<div class="row">
														<div class="col-xs-9 col-sm-8 col-lg-9">
															<div class="row" style="font-family:sans-serif;font-size:16px;color:#00bcd4;width:600px">
																<div class="col-xs-6" style="width:270px">
																	<div>
																		&nbsp;&nbsp;' . ($i+1) . '.&nbsp;&nbsp; ' . $row['C_Fname'] . ' ' . $row['C_Lname'] . '
																	</div>
																</div>
																<div class="col-xs-4" style="width:140px">
																	<div>
																		' . $row['C_Trdoc'] . '
																	</div>
																</div>
																<div class="col-xs-4" style="width:140px">
																	<div>
																		' . $newdate . '
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>';
												$i++;
												}
											}else {
												echo "<p style='color:red'><b><i>Δεν υπάρχουν καταχωρημένοι επιβάτες στη συγκεκριμένη πτήση.</i></b></p>\n";
											}
										}
							} else if (isset($_POST['submitted2'])) {
								if (empty($_POST['choose']) || empty($_POST['entry'])) {
									$errors[] = "Ξεχάσατε να επιλέξετε όλα τα πεδία.";
								} else if ($_POST['choose']=='eticket') {
									$q = "select * from (select * from reserve where R_etick='{$_POST['entry']}') as t1 left join customer on t1.R_Cid=customer.C_id left join price on Pr_id=t1.R_Prid left join itinerary on I_id=Pr_Iid";
									$r = mysqli_query($dbc, $q);
									if (!$r) {
										echo '<h1>Σφάλμα Συστήματος</h1>
										<p class="error">Δεν μπορέσαμε να σας εξυπηρετήσουμε λόγω
										σφάλματος συστήματος. Ζητούμε συγγνώμη!</p>';
										echo '<p>' . mysqli_error($dbc) . '<br>
										Query: ' . $q .  "</p>\n";
									} else {
										$num = mysqli_num_rows($r);
										if ($num > 0) {
											while ($row = mysqli_fetch_array($r, MYSQLI_BOTH)) {
											$newdate = preg_replace('!^([0-9]{4})-([0-9]{2})-([0-9]{2})$!',"$3-$2-$1",$row['C_Bdate']);
											echo '
											<div class="list-group-item segment-item" style="border-color:black;background-color:rgba(255, 255, 255, 0)">
												<div class="row">
													<div class="col-xs-9 col-sm-8 col-lg-9">
														<div class="row" style="font-family:sans-serif;font-size:16px;color:red;width:600px">
															<strong>
															<div class="col-xs-6" style="width:250px">
																<div>
																	&nbsp;&nbsp;&nbsp;Ονοματεπώνυμο
																</div>
															</div>
															<div class="col-xs-4" style="width:160px">
																<div>
																	Αρ. Ταυτότητας
																</div>
															</div>
															<div class="col-xs-4" style="width:180px">
																<div>
																	Ημ/νία Γέννησης
																</div>
															</div>
															</strong>
														</div>
													</div>
												</div>
											</div>
											<div class="list-group-item segment-item" style="border-color:black;background-color:rgba(255, 255, 255, 0)">
												<div class="row">
													<div class="col-xs-9 col-sm-8 col-lg-9">
														<div class="row" style="font-family:sans-serif;font-size:16px;color:#00bcd4;width:600px">
															<div class="col-xs-6" style="width:270px">
																<div>
																	&nbsp;&nbsp;&nbsp;&nbsp; ' . $row['C_Fname'] . ' ' . $row['C_Lname'] . '
																</div>
															</div>
															<div class="col-xs-4" style="width:140px">
																<div>
																	' . $row['C_Trdoc'] . '
																</div>
															</div>
															<div class="col-xs-4" style="width:140px">
																<div>
																	' . $newdate . '
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>';
											$newdate = preg_replace('!^([0-9]{4})-([0-9]{2})-([0-9]{2})$!',"$3-$2-$1",$row['R_dep']);
											echo '
											<div class="list-group-item segment-item" style="background-color:#d9edf7;margin-top:20px">
												<div class="row">
													<div class="col-xs-9 col-md-8 col-lg-9">
														<div class="row">
															<div class="col-xs-9 col-md-8 col-lg-9" style="width:100px; padding-left:30px;">
																<img src="../img/plane_go.svg" alt="Plane ob" width="24" height="24">
															</div>
															<div style="width:300px;text-align:left;font-family:serif;font-size:20px;color:#616876;letter-spacing:0.12em;">
																<div>My Airlines</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="list-group-item segment-item">
												<div class="row">
													<div class="col-xs-9 col-sm-8 col-lg-9">
														<div class="row" style="width:650px">
															<div class="col-xs-3" style="margin-left:10px;width:150px">
																<div style="font-family:sans-serif;font-size:20px;color:#00339a" name="timedep"><strong>
																	' . $row['I_deptime'] . '
																	</strong>
																</div>
																<div><br></div>
																<div style="font-family:sans-serif;font-size:14px;color:#616876">' . $row['I_dep'] . '</div>
															</div>
															<div class="col-xs-3" style="width:150px">
																<div style="font-family:sans-serif;font-size:20px;color:#00339a"><strong>
																	' . $row['I_arrtime'] . '
																	</strong>
																</div>
																<div><br></div>
																<div style="font-family:sans-serif;font-size:14px;color:#616876">' . $row['I_arr'] . '</div>
															</div>
															<div class="col-xs-3" style="width:150px">
																<div style="font-family:sans-serif;font-size:15px;color:#00aeef;letter-spacing:0.12em;">
																	' . $newdate . '
																</div>
																<div><br></div>
																<div style="font-family:sans-serif;font-size:14px;color:#616876">
																	Αρ. πτήσης<br>
																	' . $row['I_num'] . '
																</div>
															</div>
															<div class="col-xs-3" style="width:150px;font-family:fantasy;font-size:14px;color:#616876"><i>
																<div><br></div>
																<div>
																	Seat Nr.&nbsp;&nbsp;&nbsp;
																	' . $row['R_seat'] . '
																</div>
																<div>
																	E-Ticket:
																	' . $row['R_etick'] . '
																</div>
																<div>
																	Price:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																	' . $row['Pr_Cost'] .  " \xE2\x82\xAc" . '
																</div></i>
															</div>
														</div>
													</div>
												</div>
											</div>';
											}
										} else {
											echo "<p style='color:red'><b><i>Δεν υπάρχουν καταχωρημένοι πελάτες με βάση το e-ticket που δηλώσατε.</i></b></p>\n";
										}
									}
								} else if ($_POST['choose']=='adt') {
									echo '
									<div class="list-group-item segment-item" style="border-color:black;background-color:rgba(255, 255, 255, 0)">
										<div class="row">
											<div class="col-xs-9 col-sm-8 col-lg-9">
												<div class="row" style="font-family:sans-serif;font-size:16px;color:red;width:600px">
													<strong>
													<div class="col-xs-6" style="width:250px">
														<div>
															&nbsp;&nbsp;&nbsp;Ονοματεπώνυμο
														</div>
													</div>
													<div class="col-xs-4" style="width:160px">
														<div>
															Αρ. Ταυτότητας
														</div>
													</div>
													<div class="col-xs-4" style="width:180px">
														<div>
															Ημ/νία Γέννησης
														</div>
													</div>
													</strong>
												</div>
											</div>
										</div>
									</div>';
									$q = "select * from (select * from customer where C_Trdoc='{$_POST['entry']}') as t1 left join reserve on R_Cid=t1.C_id left join price on Pr_id=R_Prid left join itinerary on I_id=Pr_Iid";
									$r = mysqli_query($dbc, $q);
									if (!$r) {
										echo '<h1>Σφάλμα Συστήματος</h1>
										<p class="error">Δεν μπορέσαμε να σας εξυπηρετήσουμε λόγω
										σφάλματος συστήματος. Ζητούμε συγγνώμη!</p>';
										echo '<p>' . mysqli_error($dbc) . '<br>
										Query: ' . $q .  "</p>\n";
									} else {
										$num = mysqli_num_rows($r);
										if ($num > 0) {
											$i=0;
											while ($row = mysqli_fetch_array($r, MYSQLI_BOTH)) {
											$newdate = preg_replace('!^([0-9]{4})-([0-9]{2})-([0-9]{2})$!',"$3-$2-$1",$row['C_Bdate']);
											if ($i==0) {
												echo '
												<div class="list-group-item segment-item" style="border-color:black;background-color:rgba(255, 255, 255, 0)">
													<div class="row">
														<div class="col-xs-9 col-sm-8 col-lg-9">
															<div class="row" style="font-family:sans-serif;font-size:16px;color:#00bcd4;width:600px">
																<div class="col-xs-6" style="width:270px">
																	<div>
																		&nbsp;&nbsp;&nbsp;&nbsp; ' . $row['C_Fname'] . ' ' . $row['C_Lname'] . '
																	</div>
																</div>
																<div class="col-xs-4" style="width:140px">
																	<div>
																		' . $row['C_Trdoc'] . '
																	</div>
																</div>
																<div class="col-xs-4" style="width:140px">
																	<div>
																		' . $newdate . '
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>';
											}
											$i++;
											$newdate = preg_replace('!^([0-9]{4})-([0-9]{2})-([0-9]{2})$!',"$3-$2-$1",$row['R_dep']);
											echo '
											<div class="list-group-item segment-item" style="background-color:#d9edf7;margin-top:20px">
												<div class="row">
													<div class="col-xs-9 col-md-8 col-lg-9">
														<div class="row">
															<div class="col-xs-9 col-md-8 col-lg-9" style="width:100px; padding-left:30px;">
																<img src="../img/plane_go.svg" alt="Plane ob" width="24" height="24">
															</div>
															<div style="width:300px;text-align:left;font-family:serif;font-size:20px;color:#616876;letter-spacing:0.12em;">
																<div>My Airlines</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="list-group-item segment-item">
												<div class="row">
													<div class="col-xs-9 col-sm-8 col-lg-9">
														<div class="row" style="width:650px">
															<div class="col-xs-3" style="margin-left:10px;width:150px">
																<div style="font-family:sans-serif;font-size:20px;color:#00339a" name="timedep"><strong>
																	' . $row['I_deptime'] . '
																	</strong>
																</div>
																<div><br></div>
																<div style="font-family:sans-serif;font-size:14px;color:#616876">' . $row['I_dep'] . '</div>
															</div>
															<div class="col-xs-3" style="width:150px">
																<div style="font-family:sans-serif;font-size:20px;color:#00339a"><strong>
																	' . $row['I_arrtime'] . '
																	</strong>
																</div>
																<div><br></div>
																<div style="font-family:sans-serif;font-size:14px;color:#616876">' . $row['I_arr'] . '</div>
															</div>
															<div class="col-xs-3" style="width:150px">
																<div style="font-family:sans-serif;font-size:15px;color:#00aeef;letter-spacing:0.12em;">
																	' . $newdate . '
																</div>
																<div><br></div>
																<div style="font-family:sans-serif;font-size:14px;color:#616876">
																	Αρ. πτήσης<br>
																	' . $row['I_num'] . '
																</div>
															</div>
															<div class="col-xs-3" style="width:150px;font-family:fantasy;font-size:14px;color:#616876"><i>
																<div><br></div>
																<div>
																	Seat Nr.&nbsp;&nbsp;&nbsp;
																	' . $row['R_seat'] . '
																</div>
																<div>
																	E-Ticket:
																	' . $row['R_etick'] . '
																</div>
																<div>
																	Price:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																	' . $row['Pr_Cost'] .  " \xE2\x82\xAc" . '
																</div></i>
															</div>
														</div>
													</div>
												</div>
											</div>';
											}
										} else {
											echo "<p style='color:red'><b><i>Δεν υπάρχουν καταχωρημένοι πελάτες με βάση τον Α.Δ.Τ. που δηλώσατε.</i></b></p>\n";
										}
									}
								} else if ($_POST['choose']=='lname') {
									$q = "select * from (select * from customer where C_Lname like '{$_POST['entry']}') as t1 left join reserve on R_Cid=t1.C_id left join price on Pr_id=R_Prid left join itinerary on I_id=Pr_Iid order by C_Trdoc";
									$r = mysqli_query($dbc, $q);
									$num = mysqli_num_rows($r);
									if ($num > 0) {
										$i=0;
										$j=1;
										while ($row = mysqli_fetch_array($r, MYSQLI_BOTH)) {
										$newdate = preg_replace('!^([0-9]{4})-([0-9]{2})-([0-9]{2})$!',"$3-$2-$1",$row['C_Bdate']);
										$doc[$j]=$row['C_Trdoc'];
										if ($i==0) {
											echo '
											<div class="list-group-item segment-item" style="border-color:black;background-color:rgba(255, 255, 255, 0)">
												<div class="row">
													<div class="col-xs-9 col-sm-8 col-lg-9">
														<div class="row" style="font-family:sans-serif;font-size:16px;color:red;width:600px">
															<strong>
															<div class="col-xs-6" style="width:250px">
																<div>
																	&nbsp;&nbsp;&nbsp;Ονοματεπώνυμο
																</div>
															</div>
															<div class="col-xs-4" style="width:160px">
																<div>
																	Αρ. Ταυτότητας
																</div>
															</div>
															<div class="col-xs-4" style="width:180px">
																<div>
																	Ημ/νία Γέννησης
																</div>
															</div>
															</strong>
														</div>
													</div>
												</div>
											</div>
											<div class="list-group-item segment-item" style="border-color:black;background-color:rgba(255, 255, 255, 0)">
												<div class="row">
													<div class="col-xs-9 col-sm-8 col-lg-9">
														<div class="row" style="font-family:sans-serif;font-size:16px;color:#00bcd4;width:600px">
															<div class="col-xs-6" style="width:270px">
																<div>
																	&nbsp;&nbsp;&nbsp;&nbsp; ' . $row['C_Fname'] . ' ' . $row['C_Lname'] . '
																</div>
															</div>
															<div class="col-xs-4" style="width:140px">
																<div>
																	' . $doc[$j]. '
																</div>
															</div>
															<div class="col-xs-4" style="width:140px">
																<div>
																	' . $newdate . '
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>';
										}
										if ($j>1) {
											if ($doc[($j-1)]==$doc[($j)]) {
												$i++;
											} else {
												$i=0;
											}
										} else {
											$i++;
										}
										$newdate = preg_replace('!^([0-9]{4})-([0-9]{2})-([0-9]{2})$!',"$3-$2-$1",$row['R_dep']);
										echo '
										<div class="list-group-item segment-item" style="background-color:#d9edf7;margin-top:20px">
											<div class="row">
												<div class="col-xs-9 col-md-8 col-lg-9">
													<div class="row">
														<div class="col-xs-9 col-md-8 col-lg-9" style="width:100px; padding-left:30px;">
															<img src="../img/plane_go.svg" alt="Plane ob" width="24" height="24">
														</div>
														<div style="width:300px;text-align:left;font-family:serif;font-size:20px;color:#616876;letter-spacing:0.12em;">
															<div>My Airlines</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="list-group-item segment-item" style="margin-bottom:25px">
											<div class="row">
												<div class="col-xs-9 col-sm-8 col-lg-9">
													<div class="row" style="width:650px">
														<div class="col-xs-3" style="margin-left:10px;width:150px">
															<div style="font-family:sans-serif;font-size:20px;color:#00339a" name="timedep"><strong>
																' . $row['I_deptime'] . '
																</strong>
															</div>
															<div><br></div>
															<div style="font-family:sans-serif;font-size:14px;color:#616876">' . $row['I_dep'] . '</div>
														</div>
														<div class="col-xs-3" style="width:150px">
															<div style="font-family:sans-serif;font-size:20px;color:#00339a"><strong>
																' . $row['I_arrtime'] . '
																</strong>
															</div>
															<div><br></div>
															<div style="font-family:sans-serif;font-size:14px;color:#616876">' . $row['I_arr'] . '</div>
														</div>
														<div class="col-xs-3" style="width:150px">
															<div style="font-family:sans-serif;font-size:15px;color:#00aeef;letter-spacing:0.12em;">
																' . $newdate . '
															</div>
															<div><br></div>
															<div style="font-family:sans-serif;font-size:14px;color:#616876">
																Αρ. πτήσης<br>
																' . $row['I_num'] . '
															</div>
														</div>
														<div class="col-xs-3" style="width:150px;font-family:fantasy;font-size:14px;color:#616876"><i>
																<div><br></div>
																<div>
																	Seat Nr.&nbsp;&nbsp;&nbsp;
																	' . $row['R_seat'] . '
																</div>
																<div>
																	E-Ticket:
																	' . $row['R_etick'] . '
																</div>
																<div>
																	Price:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																	' . $row['Pr_Cost'] .  " \xE2\x82\xAc" . '
																</div></i>
															</div>
													</div>
												</div>
											</div>
										</div>';
										$j++;
										}
									} else {
										echo "<p style='color:red'><b><i>Δεν υπάρχουν καταχωρημένοι πελάτες με βάση το επώνυμο που δηλώσατε.</i></b></p>\n";
									}
								}
							} 
							if (!empty($errors)) {
								echo '
								<p class="error">&nbsp;&nbsp;&nbsp;&nbsp;Εντοπίστηκαν τα ακόλουθα σφάλματα:<br>';
								foreach ($errors as $m) {
									echo "&nbsp;&nbsp;&nbsp;&nbsp; - $m <br>\n";
								}
								echo "</p><br><p>&nbsp;&nbsp;&nbsp;&nbsp;Παρακαλώ επανεισάγετε τα στοιχεία σας!</p>\n";
							}
						?>
					</div>
				</div>
			</section>
		</div>
	<?php } ?></section>

	
	<!-- Footer -->
		<?php
			include('../includes/adminfooter.html');
		?>	