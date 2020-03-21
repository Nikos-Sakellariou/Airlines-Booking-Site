<!DOCTYPE html>
  	<!-- Header -->
		<?php
			$page_title='My Airlines - Contact';
			include('includes/header.php');
		?>
		
<body class="tm-gray-bg">
	<!-- Banner -->
		<?php
			include('includes/banner.html');
		?>

	<!-- gray bg -->	
	<section class="container tm-home-section-1" id="more">
		<div class="row">
			<!-- slider -->
			<div class="flexslider effect2 effect2-contact tm-contact-box-1">
				<ul class="slides">
					<li>
						<img src="img/world-map.png" alt="image" class="contact-image" />
						<div class="contact-text">
							<h2 class="slider-title">Explore The World</h2>
							<p class="slider-description">Being one of the fastest growing online travel agencies in South-Eastern-Europe, we are continuously trying to find ways to challenge ourselves in pursuit of being the best in everything we do. Our aim is to provide to our customers with the best booking experience in the world. We thrive in an environment that values communication, ingenuity, and creativity, while fostering a workplace of growth and development. We embrace a culture where simple words like innovation, team spirit, passion, development, fun and technology form our strategy and define our actions.</p>
							<div class="slider-social">
								<a href="#" class="tm-social-icon"><i class="fa fa-twitter"></i></a>
								<a href="#" class="tm-social-icon"><i class="fa fa-facebook"></i></a>
								<a href="#" class="tm-social-icon"><i class="fa fa-pinterest"></i></a>
								<a href="#" class="tm-social-icon"><i class="fa fa-google-plus"></i></a>
							</div>
						</div>			      
					</li>
				</ul>
			</div>
		</div>
	</section>		
	
	<!-- white bg -->
	<section class="section-padding-bottom">
		<div class="container">
			<div class="row">
				<div class="tm-section-header section-margin-top">
					<div class="col-lg-4 col-md-3 col-sm-3"><hr></div>
					<div class="col-lg-4 col-md-6 col-sm-6"><h2 class="tm-section-title">Contact Us</h2></div>
					<div class="col-lg-4 col-md-3 col-sm-3"><hr></div>	
				</div>				
			</div>
			<div class="row">
				<!-- contact form -->
				<form action="#" method="post" class="tm-contact-form">
					<div class="col-lg-6 col-md-6">
						<div id="google-map"></div>
						<div class="contact-social">
							<a href="#" class="tm-social-icon tm-social-facebook"><i class="fa fa-facebook"></i></a>
				      		<a href="#" class="tm-social-icon tm-social-dribbble"><i class="fa fa-dribbble"></i></a>
				      		<a href="#" class="tm-social-icon tm-social-twitter"><i class="fa fa-twitter"></i></a>
				      		<a href="#" class="tm-social-icon tm-social-instagram"><i class="fa fa-instagram"></i></a>
				      		<a href="#" class="tm-social-icon tm-social-google-plus"><i class="fa fa-google-plus"></i></a>
						</div>
					</div> 
					<div class="col-lg-6 col-md-6 tm-contact-form-input">
						<div class="form-group">
							<input type="text" id="contact_name" class="form-control" placeholder="NAME" />
						</div>
						<div class="form-group">
							<input type="email" id="contact_email" class="form-control" placeholder="EMAIL" />
						</div>
						<div class="form-group">
							<input type="text" id="contact_subject" class="form-control" placeholder="SUBJECT" />
						</div>
						<div class="form-group">
							<textarea id="contact_message" class="form-control" rows="6" placeholder="MESSAGE"></textarea>
						</div>
						<div class="form-group">
							<button class="tm-submit-btn" type="submit" name="submit">Submit now</button> 
						</div>               
					</div>
				</form>
			</div>			
		</div>
	</section>

	<!-- Footer -->
		<?php
			include('includes/footer.html');
		?>