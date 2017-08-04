<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	
	// if session is not set this will redirect to login page
	if( !isset($_SESSION['user']) ) {
		header("Location: index.php");
		exit;
	}
	// select loggedin users detail
	$res=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
	$userRow=mysql_fetch_array($res);
?>
<?php
	include("functions/functions.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Welcome - <?php echo $userRow['email']; ?></title>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="css/style_all.css" rel="stylesheet"> 
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
							<a class="page-scroll" href="#contact">Contact</a>
						</li>		
						<li class="dropdown">
						  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						  <span class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php echo $userRow['user_name']; ?>&nbsp;<span class="caret"></span></a>
						  <ul class="dropdown-menu">
							<li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
						  </ul>
						</li>
					</ul>
				</div>
				<!-- /.navbar-collapse -->
			</div>
			<!-- /.container-fluid -->
		</nav>
	
		<section style="margin-top:100px; margin-bottom:100px;">
			<div class="container">
				<div class="row">
					<?php getSubQues(); ?>
				</div>
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