<!DOCTYPE html>
	<?php
			session_start();
			$page_title='Admin - Login';
			if (isset($_POST['submitted'])) {
				$errors = array();
				if ((empty($_POST['username'])) && (empty($_POST['password']))) {
					$errors[] = "Ξεχάσατε να συμπληρωσετε όλα τα πεδία.";
				}else if ((empty($_POST['username']))){
					$errors[] = "Ξεχάσατε να συμπληρωσετε username!";
				}else if ((empty($_POST['password']))){
					$errors[] = "Ξεχάσατε να συμπληρωσετε password!";
				}else {
					require_once('../mysqli_connect.php');
					$user = mysqli_real_escape_string($dbc, trim($_POST['username']));
					$pass = mysqli_real_escape_string($dbc, trim($_POST['password']));
					$hpass = sha1($pass);
					$q = "select A_name, A_pass from admin where A_name='$user' and A_pass='$hpass'";
					$r = mysqli_query($dbc, $q);
					$num = mysqli_num_rows($r);
					if ($num > 0) {
						$row = mysqli_fetch_row($r);
						$page_title='Admin - Home';
					} else {
						$errors[] = "Λάθος username ή password.Παρακαλώ απευθυνθείτε στο διαχειριστή του συστήματος.";
					}

				}
			} else if ($_SESSION) {
				$page_title='Admin - Home';
			} else {
				$page_title='Admin - Login';
			}
			session_write_close();
	?>
	
	<!-- Header -->
		<?php
			include('../includes/adminheader.php');
			if ((!($_SESSION)) && ($page_title=='Admin - Home')) {
				$_SESSION['admin']= $user;
			}
		?>
<section class="section-padding-bottom" style="min-height:750px">
	<?php			
		if (!empty($errors)) {
			echo '<h2>&nbsp;&nbsp;Σφάλμα</h2>
			<p class="error">&nbsp;&nbsp;&nbsp;&nbsp;Εντοπίστηκαν τα ακόλουθα σφάλματα:<br>';
			foreach ($errors as $m) {
				echo "&nbsp;&nbsp;&nbsp;&nbsp; - $m <br>\n";
			}
		} else if ($_SESSION) {
			echo "
			<div class='login'>
				<div class='heading'>
					<h2>Καλώς ορίσατε {$_SESSION['admin']}</h2>
				</div>
			 </div>";
			
		}
	?>	
<div class="login" style="min-height:200px">
	<div class="heading">
		<h2><?php if ($_SESSION) { echo 'Sign out';} ?></h2>
		<form action="adminSignIn.php">
			<div>
				<button type="submit" class="float"><?php if ($_SESSION) { echo 'Logout'; } else { echo 'Go Back';} ?></button>
				<input type="hidden" name="submitted1" value="1">
			</div>
		</form>
	</div>
 </div>
	</section>	
	<!-- Footer -->
		<?php
			include('../includes/adminfooter.html');
		?>	