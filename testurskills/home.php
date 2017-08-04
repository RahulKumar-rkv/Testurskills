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
					<div class="col-md-3">
						<ul class="nav nav-pills nav-stacked">
							<li><img class="img-responsive img-thumbnail" src="images/dp.jpg"/></li>
							<li class="active"><a data-toggle="tab" href="#test">Take Test</a></li>
							<li><a data-toggle="tab" href="#profile">Profile</a></li>
							<li><a data-toggle="tab" href="#performance">Performance</a></li>
						</ul>
					</div>
					<div class="col-md-9">
						<div style="padding:25px;" class="tab-content">
							<div class="text-center">
								<h3> Welcome <?php echo $userRow['user_name']; ?></h3>
							</div>							
							<div id="test" class="tab-pane fade in active">
								<form class="form-inline" action="home.php" method="post">
									<div class="row">
										<div style="border:1px solid gray;padding:25px;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<div class="form-group">
												<label for="subject" class="sr-only">Subject</label>
												
												  <select class="form-control" name="subject" required>
													  <option>Select a subject</option>
													  <?php
															$get_sub = mysql_query("select * from subjects");
								
															while($row_sub=mysql_fetch_array($get_sub)){
																$s_id = $row_sub['sub_id'];
																$s_name = $row_sub['sub_name'];
									
																echo "<option value='$s_id'>$s_name</option>";
															}
													  ?>
												  </select>
	
											</div>
											<div class="form-group">
												<label for="difficulty" class="sr-only">Difficulty</label>
												
												  <select class="form-control" name="difficulty" required>
													  <option>Select difficulty</option>
														<?php
															$get_diff = mysql_query("select * from difficulty");
								
															while($row_diff=mysql_fetch_array($get_diff)){
																$d_id = $row_diff['diff_id'];
																$d_name = $row_diff['diff_name'];
									
																echo "<option value='$d_id'>$d_name</option>";
															}
														?>
												  </select>
												
											</div>
											<button type="submit" name="take_test" class="btn btn-primary">Take Test</button>
											<button type="button" class="btn btn-primary">Quit Test</button>
								
										</div>
										
										<?php
										
											if(isset($_POST['take_test'])){
												$sub = $_POST['subject'];
												$diff = $_POST['difficulty'];
												
												$sql = mysql_query("select * from subjects");
												while($row_sub=mysql_fetch_array($sql)){
													$sub_id = $row_sub['sub_id'];
													$sub_name = $row_sub['sub_name'];
												}
												
												$sql_ques = mysql_query("select * from questions where sub='$sub' and difficulty='$diff'");
															
												$count = mysql_num_rows($sql_ques);
												
												if($count==0){
														
														echo "<h2 style='padding:20px;'>There are no questions in this subject</h2>";
													
													}
												else {
													while($row_sub_ques=mysql_fetch_array($sql_ques)){
														
														$ques = $row_sub_ques['ques'];
														$opt1 = $row_sub_ques['opt1'];
														$opt2 = $row_sub_ques['opt2'];
														$opt3 = $row_sub_ques['opt3'];
														$opt4 = $row_sub_ques['opt4'];
													
														echo "
															<div>
																<h2>$ques</h2>
																<h5>$opt1</h5>
																<h5>$opt2</h5>
																<h5>$opt3</h5>
																<h5>$opt4</h5>						
															</div>
														";

													}	
												}												
											}
										
										
										
										
										?>
										
										
										
									</div>							   
								</form>
							</div>
							<div id="profile" class="tab-pane fade">
							  <h4> Name : <?php echo $userRow['name']; ?></h4>
							  <p> Email : <?php echo $userRow['email']; ?></p>						  
							</div>
							<div id="performance" class="tab-pane fade">
							  <h3>Performance Chart</h3>
							  <p>Graph</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
    
    
		<!-- jQuery -->
		<script src="jquery/jquery.min.js"></script>
		
		<!-- Bootstrap Core JavaScript -->
		<script src="bootstrap/js/bootstrap.min.js"></script>
    
	</body>
</html>
<?php ob_end_flush(); ?>