<!DOCTYPE html>

  	<!-- Header -->
<?php
if (!(isset($_POST['seatsubmitted']))) {
	if (!(isset($_POST['detsubmitted']))) {
	header('Location: index.php');
	}
}
$page_title='Done';
include('includes/header.php');
?>

<section class="tm-white-bg section-padding-bottom">
		<div class="container">
			<div class="row">
				<div class="tm-section-header section-margin-top">
					<div class="col-lg-4 col-md-3 col-sm-3"><hr></div>
					<div class="col-lg-4 col-md-6 col-sm-6"><h2 class="tm-section-title" style="text-transform:none">Στοιχεία Επιβάτη</h2></div>
					<div class="col-lg-4 col-md-3 col-sm-3"><hr></div>	
				</div>				
			</div>
			<div class="row">
				<!-- Testimonial -->
			<div id="Sign-Up">
			<fieldset style="width:30%"><legend>Υποβολή Στοιχείων</legend>
			<table border="0">
			<tr>
			<form action="done.php" method="post" class="hotel-search-form">
			<?php
			$epivates = $_SESSION['epivates'];
			?>
			<?php for ($checkpassenger = 1;$checkpassenger<=$epivates;$checkpassenger++){ ?>
			<div class="tm-form-inner" style="border-color:black;border-style:dotted;">
				<p><i><u>Επιβάτης <?php echo $checkpassenger;?>ος</u></i></p><br>
				<div class="form-group">
					<p>Όνομα</p><input type="text" name="fname<?php echo $checkpassenger;?>">
				</div>
				<div class="form-group">
					<p>Επώνυμο</p>
					<input type="text" name="lname<?php echo $checkpassenger;?>">
				</div>
				<div class="form-group">
					<p>Α.Δ.Τ.</p><input type="text" name="adt<?php echo $checkpassenger;?>">
				</div>
				<div class="form-group">
					<p>Ημερομηνία Γέννησης</p><input type="date" name="bdate<?php echo $checkpassenger;?>">
				</div>
				<div class="form-group">
					<p>Θέση Μετάβασης: 
					<b><?php echo $_SESSION['seat'.($checkpassenger-1).'0'];?></b>
					</p>
				</div>
				<div class="form-group">
				
					<?php if ($_SESSION['taksidi']=='return') {echo '<p>Θέση Επιστροφής: <b>' . $_SESSION['seat'.($checkpassenger-1).'1']; }?></b>
					</p>
				</div>
			</div>
			
			<?php } ?>
			<?php if (isset($_POST['seatsubmitted'])) {
				echo '
			<tr> <td><input id="button" type="submit" name="submit" value="Υποβολή" class="tm-pink-btn"></td>
			<input type="hidden" name="detsubmitted" value="1">
			</tr>';
			}
			?>
			</form>
			</table>
			</fieldset>
			</div>				
			</div>			
		</div>



<?php

$anaxwrisi = $_SESSION['anaxwrisi'];
$proorismos = $_SESSION['proorismos'];
$startdate = $_SESSION['startdate'];
$findate = $_SESSION['findate'];
$taksidi = $_SESSION['taksidi'];
$deptime1 = $_SESSION['deptime1'];
$arrtime1 = $_SESSION['arrtime1'];

//echo $epivates;        
//echo $anaxwrisi;
//echo $proorismos;                       /* auta ta echo na diagrafoun, itan gia testarisma an pernane oi metavlites */
//echo $startdate;
//echo $findate;
//echo $taksidi;
 

if (isset($_POST['detsubmitted'])) 
{
			$fname = "fname";
			$lname = "lname";
			$adt = "adt";
			$bdate = "bdate";
			$seat = "seat";
			$seattype = "";
			$errors = array();
			require_once('mysqli_connect.php');

	for ($i = 1; $i <= $epivates; $i++) 
		{
				
				$errors = array();
				
				${$seattype.$i.(0)}="";
				${$seattype.$i.(1)}="";
				${$fname.$i} = $_POST["fname$i"]; 
				${$lname.$i} = $_POST["lname$i"];
				${$adt.$i} = $_POST["adt$i"];
				${$bdate.$i} = $_POST["bdate$i"];
				${$seat.$i.(0)} = $_SESSION['seat'.($i-1).'0'];
				if ($taksidi=='return') {
					${$seat.$i.(1)} = $_SESSION['seat'.($i-1).'1'];
					if (empty(${$seat.$i.(1)}))
					{
						$errors[] = "Ξεχάσατε να δηλώσετε τον τύπο καθίσματος επιστροφής του " . $i . "ου επιβάτη !";
					}
				}

			if (empty(${$fname.$i})) 
				{
					$errors[] = "Ξεχάσατε να δηλώσετε το όνομα του " . $i . "ου επιβάτη !";
				} 
		    /*else 
				{
					$fn = mysqli_real_escape_string($dbc, 
					trim(${$fname.$i}));
				}*/

			if (empty(${$lname.$i})) 
				{
					$errors[] = "Ξεχάσατε να δηλώσετε το επώνυμο του " . $i . "ου επιβάτη !";
				} 
			/*else 
				{
					$ln = mysqli_real_escape_string($dbc, 
					trim(${$lname.$i}));
				}*/

			if (empty(${$adt.$i})) 
				{
					$errors[] = "Ξεχάσατε να δηλώσετε τον αριθμό ταυτότητας του " . $i . "ου επιβάτη !";
				}
			/*else 
				{
					$ad = mysqli_real_escape_string($dbc, 
					trim(${$adt.$i}));
				}*/

			if (empty(${$bdate.$i})) 
				{
					$errors[] = "Ξεχάσατε να δηλώσετε την ημερομηνία γέννησης του " . $i . "ου επιβάτη !";
				} 
			/*else 
				{
					$dat = mysqli_real_escape_string($dbc, 
					trim(${$bdate.$i}));
				}*/

			if (empty(${$seat.$i.(0)}))
				{
					$errors[] = "Ξεχάσατε να δηλώσετε τον τύπο καθίσματος του " . $i . "ου επιβάτη !";
				}
			/*else 
				{
					$myseat = mysqli_real_escape_string($dbc, 
					trim(${$seat.$i}));
				}*/

			if (!empty($errors)) 
				{
					echo '<h1>Σφάλμα!</h1>
					<p class="error">Εντοπίστηκαν τα ακόλουθα σφάλματα:<br>';
					foreach ($errors as $m) 
							{
								echo " - $m <br>\n";
							}
					echo "</p><p>Παρακαλώ επανεισάγετε τα στοιχεία σας!</p>\n";
				} 
			else 
				{
					$q  = "select * from customer where C_Lname='${$lname.$i}' and C_Trdoc='${$adt.$i}'";
					$r = mysqli_query($dbc, $q); 
					if (!$r) 
							{
								echo '<h1>Σφάλμα Συστήματος</h1>
								<p class="error">Δεν μπορέσατε να εγγραφείτε λόγω σφάλματος συστήματος. Ζητούμε συγγνώμη!</p>';
								echo '<p>' . mysqli_error($dbc) . '<br> Query: ' . $q . "</p>\n";
							}
						else 
							{
								$num = mysqli_num_rows($r);
								if ($num == 0) {
									$q1 = "insert into customer (C_Fname, C_Lname, C_Trdoc, C_Bdate) values ('${$fname.$i}', '${$lname.$i}', '${$adt.$i}', '${$bdate.$i}')";
									$r1 = mysqli_query($dbc, $q1);
									if (!$r1) 
										{
											echo '<h1>Σφάλμα Συστήματος</h1>
											<p class="error">Δεν μπορέσατε να εγγραφείτε λόγω σφάλματος συστήματος. Ζητούμε συγγνώμη!</p>';
											echo '<p>' . mysqli_error($dbc) . '<br> Query: ' . $q1 . "</p>\n";
										}
									else 
										{
											//echo  "Η καταχώρηση των στοιχείων του " . $i . "ου επιβάτη ολοκληρώθηκε επιτυχώς!<br>\n";
												
										}
								}
					
							}
					
					if (${$seat.$i.(0)}[0]=='A' || ${$seat.$i.(0)}[0]=='F') {
						${$seattype.$i.(0)}='Παράθυρο';
					} else if (${$seat.$i.(0)}[0]=='C' || ${$seat.$i.(0)}[0]=='D') {
						${$seattype.$i.(0)}='Διάδρομος';
					} else{
						${$seattype.$i.(0)}='other';
					}
					
					
					$q2 = "insert into reserve (R_Cid, R_etick, R_Prid, R_seat, R_seattype, R_dep) values 
						  ((select max(C_id) from customer where C_Trdoc = '${$adt.$i}'), 
						  (select concat(C_Trdoc,max(C_id)) from customer where C_Trdoc='${$adt.$i}'), 
						  (select Pr_id   
						  from price, itinerary, period 
						  where Pr_Iid=I_id and 
						  Pr_Peid=Pe_id and 
						  (I_dep = '$anaxwrisi' and I_arr = '$proorismos') and                    
						  Pr_Peid in (select Pe_id from period where '$startdate' between Pe_startdate and Pe_findate)),
						  ('${$seat.$i.(0)}'),
						  ('${$seattype.$i.(0)}'),
						  ('$startdate')
						   )";
					$r2 = mysqli_query($dbc, $q2);
					
					if (!$r2) 
						{
							echo '<h1>Σφάλμα Συστήματος</h1>
							<p class="error">Δεν μπορέσαμε να καταχωρήσουμε την κράτηση λόγω σφάλματος συστήματος. Ζητούμε συγγνώμη!</p>';
							echo '<p>' . mysqli_error($dbc) . '<br> Query: ' . $q2 . "</p>\n";
						}
					else 
						{
							//echo "Η δέσμευση θέσης του " . $i . "ου επιβάτη επίσης ολοκληρώθηκε επιτυχώς!<br>\n";
							
							$q4 = "select R_etick from customer, reserve, price, itinerary
							where R_Cid = C_id and R_Prid = Pr_id and Pr_Iid = I_id and
							I_dep = '$anaxwrisi' and I_arr = '$proorismos' and C_Trdoc = '${$adt.$i}' and R_dep = '$startdate'";
							$r4 = mysqli_query($dbc, $q4);
							$num1 = mysqli_num_rows($r4);
							if ($num1 > 0) 
								{
									$row1 = mysqli_fetch_row($r4);
									//echo "O αριθμός εισιτηρίου του " . $i . " ου επιβάτη είναι ο: " . "<strong>" . $row1[0] . "</strong>" . "<br>\n";
									
								}
							else
								{
									echo "Κάτι πήγε στραβά με στην προσπάθεια έκδοσης εισιτηρίου. Προσπαθήστε ξανά!";
								}
							
							$q6 = "select R_seat from reserve where R_etick = '$row1[0]'";
							$r6 = mysqli_query($dbc, $q6);
							$num3 = mysqli_num_rows($r6);
							
							if ($num3 > 0) 
								{
									$row3 = mysqli_fetch_row($r6);
									//echo "O αριθμός της θέσης του " . $i . " ου επιβάτη είναι ο: " . "<strong>" . $row3[0] . "</strong>" . "<br>\n";
								}
							else
								{
									echo "Κάτι πήγε στραβά με στην προσπάθεια έκδοσης εισιτηρίου. Προσπαθήστε ξανά!";
								}
								
							$q9 = "select I_num from itinerary where I_dep = '$anaxwrisi' and I_arr = '$proorismos'";
							$r9 = mysqli_query($dbc, $q9);
							$num6 = mysqli_num_rows($r9);
							if ($num6 > 0) 
								{
									$row6 = mysqli_fetch_row($r9);
									//echo $row6[0];
								}
							else
								{
											
									echo "Κάτι πήγε στραβά με την προσπάθεια εμφάνισης του αριθμού πτήσης. Προσπαθήστε ξανά!";
								}	
						}
					
					if ($taksidi == 'return')	
						{
							if (${$seat.$i.(1)}[0]=='A' || ${$seat.$i.(1)}[0]=='F') {
								${$seattype.$i.(1)}='Παράθυρο';
							} else if (${$seat.$i.(1)}[0]=='C' || ${$seat.$i.(1)}[0]=='D') {
								${$seattype.$i.(1)}='Διάδρομος';
							} else{
								${$seattype.$i.(1)}='other';
							}
							$q3 = "insert into reserve (R_Cid, R_etick, R_Prid, R_seat, R_seattype, R_dep) values 
						  ((select max(C_id) from customer where C_Trdoc = '${$adt.$i}'), 
						  (select concat(C_Trdoc,max(C_id)*4) from customer where C_Trdoc='${$adt.$i}'), 
						  (select Pr_id   
						  from price, itinerary, period 
						  where Pr_Iid=I_id and 
						  Pr_Peid=Pe_id and 
						  (I_dep = '$proorismos' and I_arr = '$anaxwrisi') and                    
						  Pr_Peid in (select Pe_id from period where '$findate' between Pe_startdate and Pe_findate)),
						  ('${$seat.$i.(1)}'),
						  ('${$seattype.$i.(1)}'),
						  ('$findate'))";
						  
							$r3 = mysqli_query($dbc, $q3);

							if (!$r3) 
								{		
									echo '<h1>Σφάλμα Συστήματος</h1>
									<p class="error">Δεν μπορέσαme να καταχωρήσουμε την κράτηση λόγω σφάλματος συστήματος. Ζητούμε συγγνώμη!</p>';
									echo '<p>' . mysqli_error($dbc) . '<br> Query: ' . $q3 . "</p>\n";
								}
							else 
								{
									//echo "Η δέσμευση θέσης επιστροφής του " . $i . "ου επιβάτη επίσης ολοκληρώθηκε επιτυχώς!";
									
									$q5 = "select R_etick from customer, reserve, price, itinerary
									where R_Cid = C_id and R_Prid = Pr_id and Pr_Iid = I_id and
									I_dep = '$proorismos' and I_arr = '$anaxwrisi' and C_Trdoc = '${$adt.$i}' and R_dep = '$findate'";
									$r5 = mysqli_query($dbc, $q5);
									$num2 = mysqli_num_rows($r5);
									if ($num2 > 0) 
										{
											$row2 = mysqli_fetch_row($r5);
											//echo $row2[0];
										}
									else
										{
											
											echo "Κάτι πήγε στραβά με την προσπάθεια έκδοσης εισιτηρίου επιστροφής. Προσπαθήστε ξανά!";
										}
										
									$q7 = "select R_seat from reserve where R_etick = '$row2[0]'";
									$r7 = mysqli_query($dbc, $q7);
									$num4 = mysqli_num_rows($r7);
							
									if ($num4 > 0) 
										{
											$row4 = mysqli_fetch_row($r7);
											//echo "O αριθμός της θέσης του " . $i . " ου επιβάτη είναι ο: " . "<strong>" . $row4[0] . "</strong>" . "<br>\n";
										}
									else
										{
											echo "Κάτι πήγε στραβά με στην προσπάθεια έκδοσης εισιτηρίου. Προσπαθήστε ξανά!";
										}
									$q8 = "select I_num from itinerary where I_dep = '$proorismos' and I_arr = '$anaxwrisi'";
									$r8 = mysqli_query($dbc, $q8);
									$num5 = mysqli_num_rows($r8);
									if ($num5 > 0) 
										{
											$row5 = mysqli_fetch_row($r8);
											//echo $row5[0];
										}
									else
										{
											
											echo "Κάτι πήγε στραβά με την προσπάθεια εμφάνισης του αριθμού πτήσης. Προσπαθήστε ξανά!";
										}	
										
										$deptime2 = $_SESSION['deptime2'];
										$arrtime2 = $_SESSION['arrtime2'];
								}
						}
					else
						{
							//$row2 = null; //anaferetai sto array $eisitirio to opoio typvnei $i kai eisitirio pane kai ela 
							//echo "Ο/Η " . "<strong>" . ${$fname.$i} . "</strong>" . " " . "<strong>" . ${$lname.$i} . "</strong>" . " δεν έχει επιλέξει εισιτήριο μετ' επιστροφής, συνεπώς δεν εκδίδεται αντίστοιχο εισιτήριο!<br>\n";
							
						}
				}
				//$eisitirio = array($i,$row1[0], $row2[0]);
				//foreach ($eisitirio as $k) 
					//		{
						//		echo " - $k <br>\n";
							//}
				//$onoma = ${$fname.$i};       /*onoma*/
				//$_SESSION['onoma'] = $onoma;
				//$epitheto = ${$lname.$i};         /*epitheto*/
				//$_SESSION['epitheto'] = $epitheto;
				//$apo = $anaxwrisi;          /* meros apo*/
				//$_SESSION['apo'] = $apo;	
				//$pros = $proorismos;          /*meros pros*/
				//$_SESSION['pros'] = $pros;
				//$meraanaxwrisis = $startdate;          /*imera anaxwrisis*/
				//$_SESSION['meraanaxwrisis'] = $meraanaxwrisis;
				//$typos = ${$seat.$i};          /*typos kathismatos*/
				//$_SESSION['typos'] = $typos;
				//$meraepistrofis = $findate;          /*imera epistrofis*/
				//$_SESSION['meraepistrofis'] = $meraepistrofis;
				
				if (($taksidi == 'go') && (empty($errors)))
					{
						if ($epivates==1)
							{
						echo "<br><hr><h2 class=tm-section-title style=text-transform:none>ΚΑΡΤΑ ΕΠΙΒΙΒΑΣΗΣ</h2>";
							}
						else 
							{
						echo "<br><hr><h2 class=tm-section-title style=text-transform:none>ΚΑΡΤΑ ΕΠΙΒΙΒΑΣΗΣ " . $i . "ου επιβάτη</h2>";
							}
						echo "<div style='font-size:14px;margin-left:90px'>Όνομα: " . "<strong>" . ${$fname.$i} . "</strong>" . "<br>\n";
						echo "Επίθετο: " . "<strong>" . ${$lname.$i} . "</strong>" . "<br>\n";
						echo "Από: " . "<strong>" . $anaxwrisi . "</strong>" . "<br>\n";
						echo "Ώρα Αναχώρησης: " . "<strong>" . $deptime1 . "</strong>" . "<br>\n";
						echo "Προς: " . "<strong>" . $proorismos . "</strong>" . "<br>\n";
						echo "Ώρα Άφιξης: " . "<strong>" . $arrtime1 . "</strong>" . "<br>\n";
						echo "Αριθμός Πτήσης: " . "<strong>" . $row6[0] . "</strong>" . "<br>\n";
						echo "Ημερομηνία Αναχώρησης: " . "<strong>" . $startdate . "</strong>" . "<br>\n";
						echo "Αριθμός Εισιτηρίου: " . "<strong>" . $row1[0] . "</strong>" . "<br>\n";
						echo "Αριθμός Θέσης: " . "<strong>" . ${$seat.$i.(0)} . "</strong>" . "<br>\n";
						echo "Τύπος Θέσης: " . "<strong>" . ${$seattype.$i.(0)} . "</strong>" . "</div><br>\n";
					}
					
				if (($taksidi == 'return') && (empty($errors)))
					{
						if ($epivates==1)
							{
						echo "<br><hr><h2 class=tm-section-title style=text-transform:none>ΚΑΡΤΑ ΕΠΙΒΙΒΑΣΗΣ ΜΕΤΑΒΑΣΗΣ</h2>";
							}
						else 
							{
						echo "<br><hr><h2 class=tm-section-title style=text-transform:none>ΚΑΡΤΑ ΕΠΙΒΙΒΑΣΗΣ ΜΕΤΑΒΑΣΗΣ " . $i . "ου επιβάτη</h2>";
							}
						echo "<div style='font-size:14px;margin-left:90px'>Όνομα: " . "<strong>" . ${$fname.$i} . "</strong>" . "<br>\n";
						echo "Επίθετο: " . "<strong>" . ${$lname.$i} . "</strong>" . "<br>\n";
						echo "Από: " . "<strong>" . $anaxwrisi . "</strong>" . "<br>\n";
						echo "Ώρα Αναχώρησης: " . "<strong>" . $deptime1 . "</strong>" . "<br>\n";
						echo "Προς: " . "<strong>" . $proorismos . "</strong>" . "<br>\n";
						echo "Ώρα Άφιξης: " . "<strong>" . $arrtime1 . "</strong>" . "<br>\n";
						echo "Αριθμός Πτήσης: " . "<strong>" . $row6[0] . "</strong>" . "<br>\n";
						echo "Ημερομηνία Αναχώρησης: " . "<strong>" . $startdate . "</strong>" . "<br>\n";
						echo "Αριθμός Εισιτηρίου: " . "<strong>" . $row1[0] . "</strong>" . "<br>\n";
						echo "Αριθμός Θέσης: " . "<strong>" . ${$seat.$i.(0)} . "</strong>" . "<br>\n";
						echo "Τύπος Θέσης: " . "<strong>" . ${$seattype.$i.(0)} . "</strong>" . "</div><br>\n";
						
						if ($epivates==1)
							{
						echo "<br><hr><h2 class=tm-section-title style=text-transform:none>ΚΑΡΤΑ ΕΠΙΒΙΒΑΣΗΣ ΕΠΙΣΤΡΟΦΗΣ</h2>";
							}
						else 
							{
						echo "<br><hr><h2 class=tm-section-title style=text-transform:none>ΚΑΡΤΑ ΕΠΙΒΙΒΑΣΗΣ ΕΠΙΣΤΡΟΦΗΣ " . $i . "ου επιβάτη</h2>";
							}
						echo "<div style='font-size:14px;margin-left:90px'>Όνομα: " . "<strong>" . ${$fname.$i} . "</strong>" . "<br>\n";
						echo "Επίθετο: " . "<strong>" . ${$lname.$i} . "</strong>" . "<br>\n";
						echo "Από: " . "<strong>" . $proorismos . "</strong>" . "<br>\n";
						echo "Ώρα Αναχώρησης: " . "<strong>" . $deptime2 . "</strong>" . "<br>\n";
						echo "Προς: " . "<strong>" . $anaxwrisi . "</strong>" . "<br>\n";
						echo "Ώρα Άφιξης: " . "<strong>" . $arrtime2 . "</strong>" . "<br>\n";
						echo "Αριθμός Πτήσης: " . "<strong>" . $row5[0] . "</strong>" . "<br>\n";
						echo "Ημερομηνία Αναχώρησης: " . "<strong>" . $findate . "</strong>" . "<br>\n";
						echo "Αριθμός Εισιτηρίου: " . "<strong>" . $row2[0] . "</strong>" . "<br>\n";
						echo "Αριθμός Θέσης: " . "<strong>" . ${$seat.$i.(1)} . "</strong>" . "<br>\n";
						echo "Τύπος Θέσης: " . "<strong>" . ${$seattype.$i.(1)} . "</strong>" . "</div><br>\n";
					}	
		}
					//$j = $i - 1;
					//echo "Η καταχώρηση στοιχείων και η κράτηση και του/των " . $j . " επιβάτη/ων ολοκληρώθηκε με επιτυχία!";
					mysqli_close($dbc);
					session_destroy();
					echo '<section class="tm-white-bg section-padding-bottom"><form action="index.php" method="post" style="backgroung-color:blue"><button type="submit" name="submit" class="tm-pink-btn" style="margin-left:600px;margin-top:20px">Επιστροφή</button>
						<input type="hidden" name="submitted" value="1"></form></section>';
					include('includes/footer.html');
					exit();
}
?>
</section>
<!--Footer-->
		<?php
			include('includes/footer.html');
		?>