<!DOCTYPE html>
  	<!-- Header -->
		<?php
			$page_title='Logged out';
			include('../includes/adminheader.php');
		?>
		
<?php
	if ($_SESSION) {
		$_SESSION = array();
		session_destroy();
		setcookie('PHPSESSID', '', time()-3600, '/', '', 0, 0);
		echo "<h1 style='text-align:right;color:#CC2C2C'>Logged out</h1>
		<p style='text-align:right;color:#CC2C2C'>Έχετε αποσυνδεθεί τώρα!</p>\n";
	}
	
?>	
		
		
<div class="login" style="height:757px">
	<div class="heading">
		<h2>Sign in</h2>
		<form action="adminhome.php" method="post">
			<div class="input-group input-group-lg">
				<span class="input-group-addon"><i class="fa fa-user"></i></span>
				<input type="text" name="username" class="form-control" placeholder="Username">
			</div>
			<div class="input-group input-group-lg">
			  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
			  <input type="password" name="password" class="form-control" placeholder="Password">
			</div>
			<div>
				<button type="submit" class="float">Login</button>
				<input type="hidden" name="submitted" value="1">
			</div>
		</form>
	</div>
 </div>

	<!-- Footer -->
		<?php
			include('../includes/adminfooter.html');
		?>	
