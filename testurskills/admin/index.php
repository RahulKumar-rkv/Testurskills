<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	
	// it will never let you open index(login) page if session is set
	if ( isset($_SESSION['admin'])!="" ) {
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
		
			$res=mysql_query("SELECT * FROM admin WHERE admin_email='$email'");
			$row=mysql_fetch_array($res);
			$count = mysql_num_rows($res); // if uname/pass correct it returns must be 1 row
			
			if( $count == 1 && $row['admin_password']==$password ) {
				$_SESSION['admin'] = $row['admin_id'];
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
		
		<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
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

		<section style="margin-top: 100px;margin-bottom: 100px;padding: 25px;">
			<div class="container">
				<div class="row">
					<h2 class="text-center">TestUrSkills Admin Panel</h2>
					<div class="panel panel-default col-lg-offset-3 col-md-offset-3 col-sm-offset-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
					  <div class="panel-heading">
						<h3 class="panel-title">:: Admin Login ::</h3>
					  </div>
					  <div class="panel-body">
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
							 
						</form>
					  </div>
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