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
		
			<form class="form-horizontal" action="insert_question.php" method="post">
				<div class="row">
					<div style="border:1px solid gray;padding:25px;" class="col-lg-offset-3 col-md-offset-3 col-sm-offset-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
					
						<div class="form-group">
							<label for="question" class="col-sm-2 control-label">Question</label>
							<div class="col-sm-10">
							  <textarea class="form-control" name="question" rows="3"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="subject" class="col-sm-2 control-label">Subject</label>
							<div class="col-sm-10">
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
						</div>
						<div class="form-group">
							<label for="difficulty" class="col-sm-2 control-label">Difficulty</label>
							<div class="col-sm-10">
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
						</div>
						<div class="form-group">
							<label for="opt1" class="col-sm-2 control-label">Option 1</label>
							<div class="col-sm-10">
							  <input type="text" class="form-control" name="opt1" placeholder="Option 1" required>
							</div>
						</div>
						<div class="form-group">
							<label for="opt1" class="col-sm-2 control-label">Option 2</label>
							<div class="col-sm-10">
							  <input type="text" class="form-control" name="opt2" placeholder="Option 2" required>
							</div>
						</div>
						<div class="form-group">
							<label for="opt1" class="col-sm-2 control-label">Option 3</label>
							<div class="col-sm-10">
							  <input type="text" class="form-control" name="opt3" placeholder="Option 3" required>
							</div>
						</div>
						<div class="form-group">
							<label for="opt1" class="col-sm-2 control-label">Option 4</label>
							<div class="col-sm-10">
							  <input type="text" class="form-control" name="opt4" placeholder="Option 4" required>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
							  <button type="submit" name="insert_post" class="btn btn-primary">Insert Now</button>
							</div>
						</div>
					
					</div>
				</div>
		   
			</form>
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

<?php
	
	if(isset($_POST['insert_post'])){
		
		//getting the text data from the fields
		$question = $_POST['question'];
		$sub = $_POST['subject'];
		$diff = $_POST['difficulty'];
		$opt1 = $_POST['opt1'];
		$opt2 = $_POST['opt2'];
		$opt3 = $_POST['opt3'];
		$opt4 = $_POST['opt4'];
		
		$insert_question = mysql_query("insert into questions (sub,difficulty,ques,opt1,opt2,opt3,opt4) values ('$sub','$diff','$question','$opt1','$opt2','$opt3','$opt4')");
		
		if($insert_question){
			
			echo"<script>alert('question has been inserted!')</script>";
			echo "<script>window.open('insert_question.php','_self)</script>";
			
		}
		
	}
	
?>