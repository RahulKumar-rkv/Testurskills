<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	
	// if session is not set this will redirect to login page
	if( !isset($_SESSION['admin']) ) {
		header("Location: index.php");
		exit;
	}
	// select loggedin users detail
	$res=mysql_query("SELECT * FROM admin WHERE admin_id=".$_SESSION['admin']);
	$userRow=mysql_fetch_array($res);
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
							<a class="page-scroll" href="#contact">Contact</a>
						</li>		
						<li class="dropdown">
						  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
						  <span class="glyphicon glyphicon-user"></span>&nbsp;Hi' Admin &nbsp;<span class="caret"></span></a>
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
		
		<section style="margin-top: 100px;margin-bottom: 100px">
			<div class="container">
				<div class="row">
					<table class="table table-bordered table-hover">
						<tr>
							<td>USER ID</td>
							<td>USER NAME</td>
							<td>FULL NAME</td>
							<td>EMAIL ID</td>
						</tr>
						
						<?php
							//$servername = "localhost";
							//$username = "root";
							//$password = "";
							//$dbname = "ccna";

							// Create connection
							//$conn = new mysqli($servername, $username, $password, $dbname);
							// Check connection
							//if ($conn->connect_error) {
							//	die("Connection failed: " . $conn->connect_error);
							//} 

							$sql = mysql_query("SELECT * FROM users");
							//$row = mysql_fetch_array($sql);
							$count = mysql_num_rows($sql);
							//$result = $conn->query($sql);

							if ($count > 0) {
								// output data of each row
								while($row = mysql_fetch_array($sql)) {
									echo "
										<tr>
											<td>".$row['user_id']."</td>
											<td>".$row['user_name']."</td>
											<td>".$row['name']."</td>
											<td>".$row['email']."</td>
										</tr>								
									";
								}
							} else {
								echo "0 results";
							}
						?>
					
					</table>
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