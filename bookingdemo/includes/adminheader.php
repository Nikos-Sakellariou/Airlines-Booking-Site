<!DOCTYPE html>
<html lang="en">
<title><?php echo $page_title; ?></title> <!-- vazw san titlo selidas mia metavliti pou prepei na tin orisw prin na kalesw to arxeio -->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,700' rel='stylesheet' type='text/css'>
  <link href="../css/font-awesome.min.css" rel="stylesheet">
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet">  
  <link href="../css/flexslider.css" rel="stylesheet">
  <link href="../css/templatemo-style.css" rel="stylesheet">
</head>
<header class="tm-gray-bg">
  	<div class="tm-header">
  		<div class="container">
  			<div class="row">
  				<div class="col-lg-6 col-md-4 col-sm-3 tm-site-name-container">
  					<a href="#" class="tm-site-name">Booking</a>	
  				</div>
	  			<div class="col-lg-6 col-md-8 col-sm-9">
	  				<div class="mobile-menu-icon">
		              <i class="fa fa-bars"></i>
		            </div>
	  				<nav class="tm-nav">
						<ul>
							<?php if ($page_title=='Admin - Home') { 
									echo '<li><a href="adminhome.php" class="active">Home</a></li>';
									echo '<li><a href="adminroutes.php">Routes</a></li>';
									echo '<li><a href="adminplanes.php">Planes</a></li>';
									echo '<li><a href="adminpricing.php">Pricing</a></li>';
									echo '<li><a href="admincustomers.php">Customers</a></li>';
								}else if ($page_title=='Admin - Routes') {
									echo '<li><a href="adminhome.php">Home</a></li>';
									echo '<li><a href="adminroutes.php" class="active">Routes</a></li>';
									echo '<li><a href="adminplanes.php">Planes</a></li>';
									echo '<li><a href="adminpricing.php">Pricing</a></li>';
									echo '<li><a href="admincustomers.php">Customers</a></li>';
								}else if ($page_title=='Admin - Planes') {
									echo '<li><a href="adminhome.php">Home</a></li>';
									echo '<li><a href="adminroutes.php">Routes</a></li>';
									echo '<li><a href="adminplanes.php" class="active">Planes</a></li>';
									echo '<li><a href="adminpricing.php">Pricing</a></li>';
									echo '<li><a href="admincustomers.php">Customers</a></li>';
								}else if ($page_title=='Admin - Pricing') {
									echo '<li><a href="adminhome.php">Home</a></li>';
									echo '<li><a href="adminroutes.php">Routes</a></li>';
									echo '<li><a href="adminplanes.php">Planes</a></li>';
									echo '<li><a href="adminpricing.php" class="active">Pricing</a></li>';
									echo '<li><a href="admincustomers.php">Customers</a></li>';
								}else if ($page_title=='Admin - Customers') {
									echo '<li><a href="adminhome.php">Home</a></li>';
									echo '<li><a href="adminroutes.php">Routes</a></li>';
									echo '<li><a href="adminplanes.php">Planes</a></li>';
									echo '<li><a href="adminpricing.php">Pricing</a></li>';
									echo '<li><a href="admincustomers.php" class="active">Customers</a></li>';
								}else {
									echo '<li><a>Home</a></li>';
									echo '<li><a>Routes</a></li>';
									echo '<li><a>Planes</a></li>';
									echo '<li><a>Pricing</a></li>';
									echo '<li><a>Customers</a></li>';
								}
							?>
						</ul>
					</nav>		
	  			</div>				
  			</div>
  		</div>	  	
  	</div>
</header>	
<?php 
session_start();
?>