<!DOCTYPE html>
  	<!-- Header -->
		<?php
			$page_title='My Airlines - Home';
			include('includes/header.php');
		?>
	
	<!-- Banner -->
		<?php
			include('includes/banner.html');
		?>

<body class="tm-gray-bg">
	<!-- gray bg -->	
	<section class="container tm-home-section-1" style="min-height:550px" id="more">
		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-6">
				<!-- Nav tabs -->
				<div class="tm-home-box-1">
					<ul class="nav nav-tabs tm-white-bg" role="tablist" id="hotelCarTabs">
					    <li role="presentation" class="active">
					    	<a href="#flight" aria-controls="hotel" role="tab" data-toggle="tab">Search a Flight</a>
					    </li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content">
					    <div role="tabpanel" class="tab-pane fade in active tm-white-bg" id="flight">
					    	<div class="tm-search-box effect2">
								<form action="results.php" method="post" class="hotel-search-form">
									<div class="tm-form-inner">
										<div class="form-group">
											<input style="width:20px" type = 'Radio' onclick="javascript:yesnoCheck();" name ='trip' id="go" value= 'go'>Απλή Μετάβαση</input>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input style="width:20px" type = 'Radio' onclick="javascript:yesnoCheck();" name ='trip' id="return" value= 'return'>Επιστροφή</input>
										</div>
										<div class="form-group">
							            	 <select class="form-control" name="departure">
												<option value="">-- Select Departure -- </option>
												<?php
													require_once('mysqli_connect.php');
													$q = "SELECT distinct I_dep FROM itinerary where I_active=1 order by I_dep";
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
																echo '<option value="' . $row['I_dep'] . '">' . $row['I_dep'] . '</option>';
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
							            	 <select  class="form-control" name="destination">
												<option value="">-- Select Destination -- </option>';										 
												<?php
													$q = "SELECT distinct I_arr FROM itinerary where I_active=1 order by I_arr";
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
																echo '<option value="' . $row['I_arr'] . '">' . $row['I_arr'] . '</option>';
															}
															mysqli_free_result($r);
														} else {
															echo "<p>Δεν υπάρχουν διαθέσιμες πτήσεις για το αεροδρόμιο αναχώρησης που έχετε επιλέξει.</p>\n";
														}
													}
												?>
											</select> 
							          	</div>
							          	<div class="form-group">
							                <div class='input-group date' id='datetimepicker1'>
							                    <input type='text' class="form-control" placeholder="Date of Departure" name="date1"/>
							                    <span class="input-group-addon">
							                        <span class="fa fa-calendar"></span>
							                    </span>
							                </div>
							            </div>
							          	<div class="form-group">
							                <div class='input-group date' id='datetimepicker2'>
							                    <input type='text' class="form-control" placeholder="Date of Return" name="date2"/>
							                    <span class="input-group-addon">
							                        <span class="fa fa-calendar"></span>
							                    </span>
							                </div>
							            </div>
							            <div class="form-group margin-bottom-0">
							                <select class="form-control" name="passenger">
							            	 	<option value="">-- Passengers -- </option>
							            	 	<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
											</select> 
							            </div>
									</div>							
						            <div class="form-group tm-yellow-gradient-bg text-center">
						            	<button type="submit" name="submit" class="tm-yellow-btn">Search Now</button>
										<input type="hidden" name="submitted" value="1">
						            </div>  
								</form>
							</div>
					    </div>			    
					</div>
				</div>								
			</div>
			<div class="col-lg-4 col-md-4 col-sm-6">
				<div class="tm-home-box-1 tm-home-box-1-2 tm-home-box-1-center">
					<img src="img/index-01.jpg" alt="image" class="img-responsive">
					<a href="#">
						<div class="tm-green-gradient-bg tm-city-price-container">
							<span>Αθηνα</span>
							<?php
								$q = "SELECT min(Pr_Cost) from price where Pr_Iid in (select I_id from itinerary where I_arr='Αθήνα' and I_active=1) and Pr_Cost!=0";
								$r = mysqli_query($dbc, $q);
								$num = mysqli_num_rows($r);
								if ($num > 0) {
									$row = mysqli_fetch_row($r);
									echo '<span>απο ' . $row[0] . ' €</span>';
								}
							?>
						</div>	
					</a>			
				</div>				
			</div>
			<div class="col-lg-4 col-md-4 col-sm-6">
				<div class="tm-home-box-1 tm-home-box-1-2 tm-home-box-1-right">
					<img src="img/index-02.jpg" alt="image" class="img-responsive">
					<a href="#">
						<div class="tm-red-gradient-bg tm-city-price-container">
							<span>Θεσσαλονικη</span>
							<?php
								$q = "SELECT min(Pr_Cost) from price where Pr_Iid in (select I_id from itinerary where I_arr = 'Θεσσαλονίκη' and I_active=1) and Pr_Cost!=0";
								$r = mysqli_query($dbc, $q);
								$num = mysqli_num_rows($r);
								if ($num > 0) {
									$row = mysqli_fetch_row($r);
									echo '<span>απο ' . $row[0] . ' €</span>';
								}
							?>
						</div>	
					</a>					
				</div>				
			</div>
		</div>
	</section>
	
	<!-- Footer -->
		<?php
			include('includes/footer.html');
		?>