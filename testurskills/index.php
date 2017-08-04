<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	
	// it will never let you open index(login) page if session is set
	if ( isset($_SESSION['user'])!="" ) {
		header("Location: home.php");
		exit;
	}
	
	$error = false;
	
	if( isset($_POST['btn-login']) ) {	
		
		// prevent sql injections/ clear user invalid inputs
		$email = trim($_POST['email']);
		$email = strip_tags($email);
		$email = htmlspecialchars($email);
		
		$pass = trim($_POST['pass']);
		$pass = strip_tags($pass);
		$pass = htmlspecialchars($pass);
		// prevent sql injections / clear user invalid inputs
		
		if(empty($email)){
			$error = true;
			$emailError = "Please enter your email address.";
		} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$error = true;
			$emailError = "Please enter valid email address.";
		}
		
		if(empty($pass)){
			$error = true;
			$passError = "Please enter your password.";
		}
		
		// if there's no error, continue to login
		if (!$error) {
			
			$password = hash('sha256', $pass); // password hashing using SHA256
		
			$res=mysql_query("SELECT * FROM users WHERE email='$email'");
			$row=mysql_fetch_array($res);
			$count = mysql_num_rows($res); // if uname/pass correct it returns must be 1 row
			
			if( $count == 1 && $row['password']==$password ) {
				$_SESSION['user'] = $row['user_id'];
				header("Location: home.php");
			} else {
				$errMSG = "Incorrect Credentials, Try again...";
			}
				
		}
		
	}
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>TestUrSkills</title>
		
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		
		<link href="css/style.css" rel="stylesheet"> 
	</head>

	<body>
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
					</button>
					<a class="navbar-brand page-scroll" href="#page-top">TestUrSkills</a>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-right">
						<li>
							<a class="page-scroll" href="#about">About</a>
						</li>
						<li>
							<a class="page-scroll" href="#login">Login</a>
						</li>
						<li>
							<a class="page-scroll" href="#contact">Contact</a>
						</li>
					</ul>
				</div>
				<!-- /.navbar-collapse -->
			</div>
			<!-- /.container-fluid -->
		</nav>
		<header>
			<div class="header-content">
				<div class="header-content-inner">
					<h1>TestUrSkills</h1>
					<hr>
					<p>Online Assessment Test</p>
					<a href="#about" class="btn btn-primary btn-xl page-scroll">Know More</a>
				</div>
			</div>
		</header>

		<section>
			<div style="padding: 25px;" class="container">
				<div class="row">
					<div style="padding: 30px;" class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<p class="intro_para text-justify">This is the last online exam system you will ever need! With our online Exam Portal you will Easily able to test your skills and imporove them. We provide detailed analysis of your exam and compare those results with the topper so that you can get clear idea about your skill level in that topic. Feature rich UI makes your exam giving more convenient and Easy.
						</p>
					</div>
					<div style="border: 1px solid gray;padding: 25px;" class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					
						<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">    

							<?php
							if ( isset($errMSG) ) {										
								?>
								<div class="form-group">
								<div class="alert alert-danger">
								<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
								</div>
								</div>
								<?php
							}
							?>									
							<div class="form-group">
								<div class="input-group">
								<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
								<input type="email" name="email" class="form-control" placeholder="Your Email" value="<?php echo $email; ?>" maxlength="40" />
								</div>
								<span class="text-danger"><?php echo $emailError; ?></span>
							</div>									
							<div class="form-group">
								<div class="input-group">
								<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
								<input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="15" />
								</div>
								<span class="text-danger"><?php echo $passError; ?></span>
							</div>									
							<div class="form-group">
								<button type="submit" class="btn btn-primary" name="btn-login">Sign In</button>
							</div>
							<div class="form-group">
								<a href="register.php">Sign Up Here...</a>
							</div>						   
						</form>					
					</div>
				</div>
			</div>
		</section>

		
		<section>
			<div class="container-fluid">
				
			</div>
		</section>

		<footer style="background-color: #f0f5f5; padding:15px;">
			<div class="container text-center">
				<p>Copyright © TestUrSkills - Online Assessment Test</p>
				<p>Designed & Developed by Rahul Kumar</p>
			</div>
		</footer>

		<!-- jQuery -->
		<script src="jquery/jquery.min.js"></script>
		
		<!-- Bootstrap Core JavaScript -->
		<script src="bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>
<?php ob_end_flush(); ?>