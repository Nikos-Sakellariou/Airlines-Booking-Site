<!DOCTYPE html>
  	<!-- Header -->
		<?php
			$page_title="Results";
			include('includes/header.php');
		?>

	<!-- white bg -->
	<section class="tm-white-bg section-padding-bottom">
		<div class="container">
			<div class="row">
				<div class="tm-section-header section-margin-top">
					<div class="col-lg-4 col-md-3 col-sm-3"><hr></div>
					<div class="col-lg-4 col-md-6 col-sm-6"><h2 class="tm-section-title" style="text-transform:none">Αποτελέσματα</h2></div>
					<div class="col-lg-4 col-md-3 col-sm-3"><hr></div>	
				</div>				
			</div>
			
				<!-- Testimonial -->
			<?php
			require_once('mysqli_connect.php');
				if (isset($_POST['submitted'])) {
					$errors = array();
					if (($_POST['departure'])=="" || ($_POST['destination'])=="" || empty($_POST['date1']) || ($_POST['passenger'])=="" || (empty($_POST['trip']))){
						$errors[] = "Ξεχάσατε να επιλέξετε όλα τα πεδία.";
					}else if (empty($_POST['date2']) && $_POST['trip']=="return") {
						$errors[] = "Ξεχάσατε να επιλέξετε όλα τα πεδία.";
					}else {
						$_SESSION['epivates'] = $_POST['passenger'];
						$_SESSION['anaxwrisi'] = $_POST['departure'];
						$_SESSION['proorismos'] = $_POST['destination'];
						$_SESSION['taksidi'] = $_POST['trip'];
						$dat1 = mysqli_real_escape_string($dbc, trim($_POST['date1']));
						$newdate1 = preg_replace('!^([0-9]{2})/([0-9]{2})/([0-9]{4})$!',"$3-$1-$2",$dat1);
						$_SESSION['startdate'] = $newdate1;
						$dat2 = mysqli_real_escape_string($dbc, trim($_POST['date2']));
						$newdate2 = preg_replace('!^([0-9]{2})/([0-9]{2})/([0-9]{4})$!',"$3-$1-$2",$dat2);
						$_SESSION['findate'] = $newdate2;
						if (($_POST['departure'])==($_POST['destination'])){	
							$errors[] = "Το αεροδρόμιο αναχώρησης δεν μπορεί να είναι ίδιο με το αεροδρόμιο προορισμού.";
						}else if ($newdate1<date("Y-m-d")) {
							$errors[] = "H ημερομηνία αναχώρησης δεν μπορεί να είναι προγενέστερη της σημερινής ημερομηνίας.";
						}else if ((($newdate1)>($newdate2)) && $_POST['trip']=="return") {
							$errors[] = "H ημερομηνία αναχώρησης δεν μπορεί να είναι μεταγενέστερη της ημερομηνίας επιστροφής.";
						}else {
							$dep = mysqli_real_escape_string($dbc, trim($_POST['departure']));
							$des = mysqli_real_escape_string($dbc, trim($_POST['destination']));
							$pas = mysqli_real_escape_string($dbc, trim($_POST['passenger']));
							$q = "SELECT I_dep, I_arr FROM itinerary WHERE I_dep='$dep' AND I_arr='$des' AND I_active=1 GROUP BY I_dep, I_arr";
							$r = mysqli_query($dbc, $q);
							$num = mysqli_num_rows($r);
							if ($num > 0) {
								$row = mysqli_fetch_row($r);
								$q2 = "SELECT I_dep, I_arr FROM itinerary WHERE I_dep='$des' AND I_arr='$dep' AND I_active=1 GROUP BY I_dep, I_arr";
								$r2 = mysqli_query($dbc, $q2);
								$num2 = mysqli_num_rows($r2);
								if (($num2 == 0) && ($_POST['trip']=='return')) {
									$errors[] = 'Το δρομολόγιο ' . $des . ' - ' . $dep . ' που επιλέξατε δεν εκτελείται. Ζητούμε συγγνώμη.';
								}
							} else {
								$errors[] = 'Το δρομολόγιο ' . $dep . ' - ' . $des . ' που επιλέξατε δεν εκτελείται. Ζητούμε συγγνώμη.';
							}

						}
					}
				}
				if (!empty($errors)) {
					echo '<h2>&nbsp;&nbsp;Σφάλμα</h2>
					<p class="error">&nbsp;&nbsp;&nbsp;&nbsp;Εντοπίστηκαν τα ακόλουθα σφάλματα:<br>';
					foreach ($errors as $m) {
						echo "&nbsp;&nbsp;&nbsp;&nbsp; - $m <br>\n";
					}
					echo "</p><br><p>&nbsp;&nbsp;&nbsp;&nbsp;Παρακαλώ επανεισάγετε τα στοιχεία σας!</p>\n";
				}
			?>
			<?php if (empty($errors)) { ?>
				<div class="col-lg-12">
					<div class="tm-home-box-4">
					<!-- Tab panes -->
					<div class="tab-content">
					    <div role="tabpanel" class="tab-pane fade in active tm-white-bg" id="flight">
					    	<div class="tm-search-box effect2">
								<form action="seatselect.php" method="post" class="hotel-search-form">
									<div class="tm-form-inner">
										<div class="list-group-item segment-item" style="background-color:#d9edf7">
											<div class="row">
												<div class="col-xs-9 col-md-8 col-lg-9">
													<div class="row">
														<div class="col-xs-9 col-md-8 col-lg-9" style="width:100px; padding-left:30px;">
															<img src="img/plane_go.svg" alt="Plane ob" width="24" height="24">
														</div>
														<div style="width:300px;text-align:left;font-family:serif;font-size:20px;color:#616876;letter-spacing:0.12em;">
															<div>My Airlines</div>
														</div>
													</div>
												</div>
												<div class="pull-right" style="text-align:left;font-family:serif;font-size:16px;color:#616876">
													<img class="align-middle" src="img/bag.svg" alt="Bag not availlable" width="20" height="20">
													&nbsp;Χωρίς Αποσκευή&nbsp;&nbsp;
												</div>
											</div>
										</div>
										<div class="list-group-item segment-item">
											<div class="row">
												<div class="col-xs-9 col-sm-8 col-lg-9">
													<div class="row">
														<div class="col-xs-4 col-lg-offset-1">
															<div style="font-family:sans-serif;font-size:20px;color:#00339a" name="time1dep"><strong>
																<?php
																	$q = "SELECT I_deptime FROM itinerary WHERE I_dep='$dep' AND I_arr='$des' GROUP BY I_dep, I_arr";
																	$r = mysqli_query($dbc, $q);
																	$num = mysqli_num_rows($r);
																	if ($num > 0) {
																		$row1r = mysqli_fetch_row($r);
																		echo $row1r[0];
																		$_SESSION['deptime1'] = $row1r[0];
																	}
																?>
																</strong>
															</div>
															<div><br></div>
															<div style="font-family:sans-serif;font-size:14px;color:#616876"><?php echo $_POST['departure'] ?></div>
														</div>
														<div class="col-xs-4">
															<div style="font-family:sans-serif;font-size:20px;color:#00339a"><strong>
																<?php
																	$q = "SELECT I_arrtime FROM itinerary WHERE I_dep='$dep' AND I_arr='$des' GROUP BY I_dep, I_arr";
																	$r = mysqli_query($dbc, $q);
																	$num = mysqli_num_rows($r);
																	if ($num > 0) {
																		$row2r = mysqli_fetch_row($r);
																		echo $row2r[0];
																		$_SESSION['arrtime1'] = $row2r[0];
																	}
																	$result1 = str_replace(":", "", "$row1r[0]");
																	$result2 = str_replace(":", "", "$row2r[0]");
																?>
																<?php if ((intval($result1)>=1200) and (intval($result1)<=2359) and (intval($result2)>=0000) and (intval($result2)<1200)){ ?>
																	<span data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Μεταμεσονύκτια άφιξη" data-original-title title aria-described-by="popover">
																		<a href="#" title="Μεταμεσονύκτια άφιξη"><img src="img/midnight_arrival.svg" alt="Midnight arrival" width="16" height="16"></a>
																	</span>
																<?php }   ?>
															</strong>
															</div>
															<div><br></div>
															<div style="font-family:sans-serif;font-size:14px;color:#616876"><?php echo $_POST['destination'] ?></div>
														</div>
														<div class="col-xs-4 col-lg-3">
															<div style="font-family:sans-serif;font-size:15px;color:#00aeef;letter-spacing:0.12em;">
																<?php echo preg_replace('!^([0-9]{2})/([0-9]{2})/([0-9]{4})$!',"$2-$1-$3",$_POST['date1']); ?>
															</div>
															<div><br></div>
															<div style="font-family:sans-serif;font-size:14px;color:#616876">
																	Απευθείας πτήση
															</div>
														</div>
													</div>
												</div>
												<div class="col-xs-4 col-lg-3">
													<div style="font-family:sans-serif;font-size:20px;color:deeppink">
														<span data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Seats Available" data-original-title title aria-described-by="popover">
															<a href="#" title="Seats Available"><img src="img/seat.png" alt="Seat" width="40" height="40">
																<?php
																	$q = "select sum(t3.seats) as seats, sum(t3.count) as reserved from
																		(select 0 as seats, count(*) as count from reserve, price, itinerary, plane
																		where R_dep='$newdate1' and R_Prid in
																		(select Pr_id from price where
																		Pr_Iid = (select I_id from itinerary where I_dep='$dep' and I_arr='$des')) and R_Prid=Pr_id and 
																		Pr_Iid=I_id and Pl_id=I_Pid
																		union
																		select Pl_seats, 0 from itinerary, plane where I_dep='$dep' and I_arr='$des' and Pl_id=I_Pid) as t3";
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
																				$remseat1 = $row['seats'] - $row['reserved'];
																				echo $remseat1;
																			}
																			$_SESSION['remseat1']= $remseat1;
																			mysqli_free_result($r);
																		} else {
																			echo "<p>Δεν υπάρχουν διαθέσιμες πτήσεις</p>\n";
																		}
																	}
																?>
															</a>
														</span>
													</div>
													<div class="pull-right" style="font-family:sans-serif;font-size:20px;color:deeppink">
														<?php
															$q = "SELECT Pr_Cost from price where Pr_Iid=(select I_id from itinerary where I_dep='$dep' and I_arr='$des') and Pr_Peid=(select Pe_id from period where '$newdate1' between Pe_startdate and Pe_findate);";
															$r = mysqli_query($dbc, $q);
															$d = "select I_disc from itinerary where I_dep='$dep' and I_arr='$des';";
															$s = mysqli_query($dbc, $d);
															$row1r = mysqli_fetch_row($r);
															$row2r = mysqli_fetch_row($s);
															$double1 = 0;
															$double2 = 0;
															$double3 = 0;
															$double4 = 0;
															if ($pas!=1) {
																echo $pas . ' x ';
															}
															if ($row2r[0] > 0) {
																echo '<del style="color:#333">' . $double = bcadd($row1r[0],'0',2) . " \xE2\x82\xAc" . '</del>&nbsp;';
																echo $double1 = bcadd($row1r[0]*(1-$row2r[0]/100),'0',2) . " \xE2\x82\xAc" . '<br>';	
																echo '<div class="pull-right">-' . $row2r[0] . '%</div>';
															} else {
																echo $double2 = bcadd($row1r[0],'0',2) . " \xE2\x82\xAc";
															}
														?>
													</div>
												</div>
											</div>
										</div>
									
										<?php if (($_POST['trip'])=="return") { ?>
										<div class="list-group-item segment-item" style="background-color:#d9edf7">
											<div class="row">
												<div class="col-xs-9 col-md-8 col-lg-9">
													<div class="row">
														<div class="col-xs-9 col-md-8 col-lg-9" style="width:100px; padding-left:30px">
															<img src="img/plane_ret.svg" alt="Plane ob" width="24" height="24">
														</div>
														<div style="text-align:left;font-family:serif;font-size:20px;color:#616876;letter-spacing:0.12em;">
															<div>My Airlines</div>
														</div>
													</div>
												</div>
												<div class="pull-right" style="text-align:left;font-family:serif;font-size:16px;color:#616876">
													<img class="align-middle" src="img/bag.svg" alt="Bag not availlable" width="20" height="20">
													&nbsp;Χωρίς Αποσκευή&nbsp;&nbsp;
												</div>
											</div>
										</div>
										<div class="list-group-item segment-item">
											<div class="row">
												<div class="col-xs-9 col-sm-8 col-lg-9">
													<div class="row">
														<div class="col-xs-4 col-lg-offset-1">
															<div style="font-family:sans-serif;font-size:20px;color:#00339a"><strong>
																<?php
																	$q = "SELECT I_deptime FROM itinerary WHERE I_dep='$des' AND I_arr='$dep' GROUP BY I_dep, I_arr";
																	$r = mysqli_query($dbc, $q);
																	$num = mysqli_num_rows($r);
																	if ($num > 0) {
																		$row1r = mysqli_fetch_row($r);
																		echo $row1r[0];
																		$_SESSION['deptime2'] = $row1r[0];
																	}
																?>
																</strong>
															</div>
															<div><br></div>
															<div style="font-family:sans-serif;font-size:14px;color:#616876"><?php echo $_POST['destination'] ?></div>
														</div>
														<div class="col-xs-4">
															<div style="font-family:sans-serif;font-size:20px;color:#00339a"><strong>
																<?php
																	$q = "SELECT I_arrtime FROM itinerary WHERE I_dep='$des' AND I_arr='$dep' GROUP BY I_dep, I_arr";
																	$r = mysqli_query($dbc, $q);
																	$num = mysqli_num_rows($r);
																	if ($num > 0) {
																		$row2r = mysqli_fetch_row($r);
																		echo $row2r[0];
																		$_SESSION['arrtime2'] = $row2r[0];
																	}
																	$result1 = str_replace(":", "", "$row1r[0]");
																	$result2 = str_replace(":", "", "$row2r[0]");
																?>
																<?php if ((intval($result1)>=1200) and (intval($result1)<=2359) and (intval($result2)>=0000) and (intval($result2)<1200)){ ?>
																	<span data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Μεταμεσονύκτια άφιξη" data-original-title title aria-described-by="popover">
																		<a href="#" title="Μεταμεσονύκτια άφιξη"><img src="img/midnight_arrival.svg" alt="Midnight arrival" width="16" height="16"></a>
																	</span>
																<?php }   ?>
																</strong>
															</div>
															<div><br></div>
															<div style="font-family:sans-serif;font-size:14px;color:#616876"><?php echo $_POST['departure'] ?></div>
														</div>
														<div class="col-xs-4 col-lg-3">
															<div style="font-family:sans-serif;font-size:15px;color:#00aeef;letter-spacing:0.12em;">
																<?php echo preg_replace('!^([0-9]{2})/([0-9]{2})/([0-9]{4})$!',"$2-$1-$3",$_POST['date2']); ?>
															</div>
															<div><br></div>
															<div style="font-family:sans-serif;font-size:14px;color:#616876">
																	Απευθείας πτήση
															</div>
														</div>
													</div>
												</div>
												<div class="col-xs-4 col-lg-3">
													<div style="font-family:sans-serif;font-size:20px;color:deeppink">
														<span data-placement="top" data-toggle="popover" data-trigger="hover" data-content="Seats Available" data-original-title title aria-described-by="popover">
															<a href="#" title="Seats Available"><img src="img/seat.png" alt="Seat" width="40" height="40">
																<?php
																	$q = "select sum(t3.seats) as seats, sum(t3.count) as reserved from
																		(select 0 as seats, count(*) as count from reserve, price, itinerary, plane
																		where R_dep='$newdate2' and R_Prid in
																		(select Pr_id from price where
																		Pr_Iid = (select I_id from itinerary where I_dep='$des' and I_arr='$dep')) and R_Prid=Pr_id and 
																		Pr_Iid=I_id and Pl_id=I_Pid
																		union
																		select Pl_seats, 0 from itinerary, plane where I_dep='$des' and I_arr='$dep' and Pl_id=I_Pid) as t3";
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
																				$remseat2 = $row['seats'] - $row['reserved'];
																				echo $remseat2;
																			}
																			$_SESSION['remseat2']= $remseat2;
																			mysqli_free_result($r);
																		} else {
																			echo "<p>Δεν υπάρχουν διαθέσιμες πτήσεις</p>\n";
																		}
																	}
																?>
															</a>
														</span>
													</div>
													<div class="pull-right" style="font-family:sans-serif;font-size:20px;color:deeppink">
														<?php
															$q = "SELECT Pr_Cost from price where Pr_Iid=(select I_id from itinerary where I_dep='$dep' and I_arr='$des') and Pr_Peid=(select Pe_id from period where '$newdate2' between Pe_startdate and Pe_findate);";
															$r = mysqli_query($dbc, $q);
															$d = "select I_disc from itinerary where I_dep='$des' and I_arr='$dep';";
															$s = mysqli_query($dbc, $d);
															$row1r = mysqli_fetch_row($r);
															$row2r = mysqli_fetch_row($s);
															if ($pas!=1) {
																echo $pas . ' x ';
															}
															if ($row2r[0] > 0) {
																echo '<del style="color:#333">' . $double = bcadd($row1r[0],'0',2) . " \xE2\x82\xAc" . '</del>&nbsp;';
																echo $double3 = bcadd($row1r[0]*(1-$row2r[0]/100),'0',2) . " \xE2\x82\xAc" . '<br>';	
																echo '<div class="pull-right">-' . $row2r[0] . '%</div>';
															} else {
																echo $double4 = bcadd($row1r[0],'0',2) . " \xE2\x82\xAc";
															}
														?>
													</div>
												</div>
											</div>
										</div>
										<?php }   ?>
										<div class="list-group-item segment-item" style="background-color:deeppink;font-family:sans-serif;font-size:20px;color:#00339a;width:230px;text-align:right;margin-left:820px;border-bottom-left-radius:10px;">
											<?php 
												echo '<b><i>ΣΥΝΟΛΟ : </i></b>' . bcadd(($pas*($double1+$double2+$double3+$double4)),'0',2) . " \xE2\x82\xAc";
											?>
										</div>
									</div>
									</div>									
									<div class="pull-right">
										<?php
										if ($_POST['trip']=='return') {
											if ($remseat2==0 || $remseat1==0 || $remseat1<$_POST['passenger'] || $remseat2<$_POST['passenger']) {
												echo '<br><div style="color:red;margin-right:35px"><i>Δεν υπάρχουν διαθέσιμες θέσεις στο δρομολόγιο που επιλέξατε. Παρακαλώ δοκιμάστε διαφορετικές ημερομηνίες.</i></div>';
											} else {
												echo '
													<button type="submit" name="submit" class="tm-pink-btn">Κράτηση</button>
													<input type="hidden" name="submitted" value="1">';
											}
										} else {
											if ($remseat1==0 || $remseat1<$_POST['passenger']) {
												echo '<br><div style="color:red;margin-right:35px"><i>Δεν υπάρχουν διαθέσιμες θέσεις στο δρομολόγιο που επιλέξατε. Παρακαλώ δοκιμάστε διαφορετικές ημερομηνίες.</i></div>';
											} else {
												echo '
													<button type="submit" name="submit" class="tm-pink-btn">Κράτηση</button>
													<input type="hidden" name="submitted" value="1">';
											}
										}
										?>	
						            </div>
								</form>
							</div>
						</div>							
					</div>
					</div>
				</div>
				
			<?php }   ?>
		</div>
	</section>
	
	<!-- Footer -->
		<?php
			include('includes/footer.html');
		?>