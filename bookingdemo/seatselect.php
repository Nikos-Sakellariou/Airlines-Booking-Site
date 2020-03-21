<!DOCTYPE html>
  	<!-- Header -->
		<?php
			$page_title="Select Seat";
			include('includes/header.php');
		?>

	<!-- white bg -->
	<section class="tm-white-bg section-padding-bottom">
		<div class="container">
			<div class="row">
				<div class="tm-section-header section-margin-top">
					<div class="col-lg-4 col-md-3 col-sm-3"><hr></div>
					<div class="col-lg-4 col-md-6 col-sm-6"><h2 class="tm-section-title" style="text-transform:none">Κράτηση Θέσης</h2></div>
					<div class="col-lg-4 col-md-3 col-sm-3"><hr></div>	
				</div>				
			</div>
			<form action="done.php" method="post">
			<div class="row">
				<?php 
					require_once('mysqli_connect.php');
					$dep = $_SESSION['anaxwrisi'];
					$des = $_SESSION['proorismos'];
					$pas = $_SESSION['epivates'];
					$date1 = $_SESSION['startdate'];
					$q = "SELECT Pl_seats FROM plane WHERE Pl_id = (select I_Pid from itinerary where I_dep='$dep' AND I_arr='$des' AND I_active=1)";
					$r = mysqli_query($dbc, $q);
					$num = mysqli_num_rows($r);
					if ($num > 0) {
						$row = mysqli_fetch_row($r);
						$maxseats = $row[0];
					}
					$q1 = "select R_seat from reserve, price, itinerary, plane
															where R_dep='$date1' and R_Prid in
															(select Pr_id from price where
															Pr_Iid = (select I_id from itinerary where I_dep='$dep' and I_arr='$des')) and R_Prid=Pr_id and 
															Pr_Iid=I_id and Pl_id=I_Pid";
					$r1 = mysqli_query($dbc, $q1);
					$ret=0;
					$s = 1;
					if (!$r1) {
						echo '<h1>Σφάλμα Συστήματος</h1>
							<p class="error">Δεν μπορέσαμε να σας εξυπηρετήσουμε λόγω
							σφάλματος συστήματος. Ζητούμε συγγνώμη!</p>';
							echo '<p>' . mysqli_error($dbc) . '<br>
							Query: ' . $q1 . "</p>\n";
					} else {
							${$s.$ret} = array();
							while ($row1 = mysqli_fetch_array($r1, MYSQLI_BOTH)) {
								${$s.$ret}[] = $row1['R_seat'];
							}
							mysqli_free_result($r1);
					}
					if ($_SESSION['taksidi']=='return') {
						$ret++;
						$date2 = $_SESSION['findate'];
						$q2 = "SELECT Pl_seats FROM plane WHERE Pl_id = (select I_Pid from itinerary where I_dep='$des' AND I_arr='$dep' AND I_active=1)";
						$r2 = mysqli_query($dbc, $q2);
						$num2 = mysqli_num_rows($r2);
						if ($num2 > 0) {
							$row2 = mysqli_fetch_row($r2);
							$maxseats2 = $row2[0];
						}
						$q3 = "select R_seat from reserve, price, itinerary, plane
																where R_dep='$date2' and R_Prid in
																(select Pr_id from price where
																Pr_Iid = (select I_id from itinerary where I_dep='$des' and I_arr='$dep')) and R_Prid=Pr_id and 
																Pr_Iid=I_id and Pl_id=I_Pid";
						$r3 = mysqli_query($dbc, $q3);
						if (!$r3) {
							echo '<h1>Σφάλμα Συστήματος</h1>
								<p class="error">Δεν μπορέσαμε να σας εξυπηρετήσουμε λόγω
								σφάλματος συστήματος. Ζητούμε συγγνώμη!</p>';
								echo '<p>' . mysqli_error($dbc) . '<br>
								Query: ' . $q3 . "</p>\n";
						} else {
								while ($row3 = mysqli_fetch_array($r3, MYSQLI_BOTH)) {
									${$s.$ret}[] = $row3['R_seat'];
								}
								mysqli_free_result($r3);
						}
					}
					$sum=0;
					$err=0;
					for ($k=0; $k<$pas; $k++) {
						for ($j=0; $j<=$ret; $j++) {
							echo '<div style="font-family:sans-serif;font-size:20px;color:deeppink;margin-right:85px;margin-left:85px;border-right-color:white;border-left-color:white;border-top-color:white;border-bottom-color:blue;border-style:solid" class="pull-left">';
							if (($k==0) && ($j==0)) {
								echo '<p style="margin-left:80px;color:deeppink;width:300"><b><u>' . $dep . ' - ' . $des . '</u></b></p>';
							} else  if (($k==0) && ($j==1)){
								echo '<p style="margin-left:80px;color:deeppink;width:300"><b><u>' . $des . ' - ' . $dep . '</u></b></p>';
							}
							echo '<br><br><p style="margin-left:80px;width:300">Επιβάτης: ' . ($k+1) . 'ος</p>';
							echo '<br><br><img src="img/Front.jpg" alt="Plane" width="400" height="200"><div style="margin-left:120px">';
							for ($i=1; $i<=intval($maxseats/6); $i++) {
								if (!empty(${$s.$j})) {
									$n=0;
									foreach (${$s.$j} as $m) {
										if ($m=='A'.$i) {
											echo '<a href="#"title="Seats Available"><img style="background-color:#c2cac8;font-size:10px" alt="A' . $i . '" id="A' . $i . '" width="23" height="20"></a>';
											$n=1;
										}
									}
									if ($n==0) {
										echo '<a href="seatselect.php?seat'.$k.$j.'=A'.$i.'" title="Seats Available"><img style="font-size:10px" alt="A' . $i . '" id="A' . $i . '" width="23" height="20"></a>';
									}
								} else { 
								echo '<a href="seatselect.php?seat'.$k.$j.'=A'.$i.'" title="Seats Available"><img style="font-size:10px" alt="A' . $i . '" id="A' . $i . '" width="23" height="20"></a>';
								} 
								if (!empty(${$s.$j})) {
									$n=0;
									foreach (${$s.$j} as $m) {
										if ($m=='B'.$i) {
											echo '<a href="#"title="Seats Available"><img style="background-color:#c2cac8;font-size:10px" alt="B' . $i . '" id="B' . $i . '" width="23" height="20"></a>';
											$n=1;
										}
									}
									if ($n==0) {
										echo '<a href="seatselect.php?seat'.$k.$j.'=B'.$i.'" title="Seats Available"><img style="font-size:10px" alt="B' . $i . '" id="B' . $i . '" width="23" height="20"></a>';
									}
								} else { 
								echo '<a href="seatselect.php?seat'.$k.$j.'=B'.$i.'" title="Seats Available"><img style="font-size:10px" alt="B' . $i . '" id="B' . $i . '" width="23" height="20"></a>';
								} if (!empty(${$s.$j})) {
									$n=0;
									foreach (${$s.$j} as $m) {
										if ($m=='C'.$i) {
											echo '<a href="#"title="Seats Available"><img style="background-color:#c2cac8;font-size:10px" alt="C' . $i . '" id="C' . $i . '" width="23" height="20"></a>';
											$n=1;
										}
									}
									if ($n==0) {
										echo '<a href="seatselect.php?seat'.$k.$j.'=C'.$i.'" title="Seats Available"><img style="font-size:10px" alt="C' . $i . '" id="C' . $i . '" width="23" height="20"></a>';
									}
								} else { 
								echo '<a href="seatselect.php?seat'.$k.$j.'=C'.$i.'" title="Seats Available"><img style="font-size:10px" alt="C' . $i . '" id="C' . $i . '" width="23" height="20"></a>';
								}
								echo '&nbsp;&nbsp;&nbsp;';
								if (!empty(${$s.$j})) {
									$n=0;
									foreach (${$s.$j} as $m) {
										if ($m=='D'.$i) {
											echo '<a href="#"title="Seats Available"><img style="background-color:#c2cac8;font-size:10px" alt="D' . $i . '" id="D' . $i . '" width="23" height="20"></a>';
											$n=1;
										}
									}
									if ($n==0) {
										echo '<a href="seatselect.php?seat'.$k.$j.'=D'.$i.'" title="Seats Available"><img style="font-size:10px" alt="D' . $i . '" id="D' . $i . '" width="23" height="20"></a>';
									}
								} else { 
								echo '<a href="seatselect.php?seat'.$k.$j.'=D'.$i.'" title="Seats Available"><img style="font-size:10px" alt="D' . $i . '" id="D' . $i . '" width="23" height="20"></a>';
								} if (!empty(${$s.$j})) {
									$n=0;
									foreach (${$s.$j} as $m) {
										if ($m=='E'.$i) {
											echo '<a href="#"title="Seats Available"><img style="background-color:#c2cac8;font-size:10px" alt="E' . $i . '" id="E' . $i . '" width="23" height="20"></a>';
											$n=1;
										}
									}
									if ($n==0) {
										echo '<a href="seatselect.php?seat'.$k.$j.'=E'.$i.'" title="Seats Available"><img style="font-size:10px" alt="E' . $i . '" id="E' . $i . '" width="23" height="20"></a>';
									}
								} else { 
								echo '<a href="seatselect.php?seat'.$k.$j.'=E'.$i.'" title="Seats Available"><img style="font-size:10px" alt="E' . $i . '" id="E' . $i . '" width="23" height="20"></a>';
								} if (!empty(${$s.$j})) {
									$n=0;
									foreach (${$s.$j} as $m) {
										if ($m=='F'.$i) {
											echo '<a href="#"title="Seats Available"><img style="background-color:#c2cac8;font-size:10px" alt="F' . $i . '" id="F' . $i . '" width="23" height="20"></a>';
											$n=1;
										}
									}
									if ($n==0) {
										echo '<a href="seatselect.php?seat'.$k.$j.'=F'.$i.'" onclick="background-color:blue" title="Seats Available"><img style="font-size:10px" alt="F' . $i . '" id="F' . $i . '" width="23" height="20"></a>';
									}
								} else { 
								echo '<a href="seatselect.php?seat'.$k.$j.'=F'.$i.'" onclick="background-color:blue" title="Seats Available"><img style="font-size:10px" alt="F' . $i . '" id="F' . $i . '" width="23" height="20"></a>';
								}
								echo '<br>';
							}
							echo '</div><div><img src="img/Back.jpg" alt="Plane" width="400" height="200"></div>';
							if (isset($_GET['seat'.$k.$j.''])) {
								$_SESSION['seat'.$k.$j.'']=$_GET['seat'.$k.$j.''];
							}
							if (isset($_SESSION['seat'.$k.$j.''])) {
								echo '<p style="margin-left:80px;width:300" class="pull-top">Seat: ' . $_SESSION['seat'.$k.$j.''] . '</p></div>';
								$sum++;
							} else {
								echo '</div>';
							}
						}
						for ($w=0;$w<$k; $w++) {
							if (isset($_SESSION['seat'.$k.'0']) && isset($_SESSION['seat'.$w.'0'])) {
								if ($_SESSION['seat'.$k.'0']==$_SESSION['seat'.$w.'0']) {
									$err=1;
								}
							}
							if (isset($_SESSION['seat'.$k.'1']) && isset($_SESSION['seat'.$w.'1'])) {
								if ($_SESSION['seat'.$k.'1']==$_SESSION['seat'.$w.'1']) {
									$err=1;
								}
							}
						}
					}
					if ((($_SESSION['taksidi']=='return' && $sum==$pas*2) || ($_SESSION['taksidi']=='go' && $sum==$pas)) && $err==0) {
						echo '<div class="row"><button type="submit" name="submit" class="tm-pink-btn" style="margin-left:528px;margin-top:20px">Συνέχεια</button>
								<input type="hidden" name="seatsubmitted" value="1"></div>';
					} else if ($err==1) {
						echo 'Έχετε καταχωρήσει την ίδια θέση σε παραπάνω από έναν επιβάτη.';
					}
				?>
			</div>
			</form>
		</div>
</section>
	
	<!-- Footer -->
		<?php
			include('includes/footer.html');
		?>