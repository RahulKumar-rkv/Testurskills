<?php
	ob_start();
	session_start();
	if( isset($_SESSION['user'])!="" ){
		header("Location: home.php");
	}
	include_once 'dbconnect.php';

	$error = false;

	if ( isset($_POST['btn-signup']) ) {
		
		// clean user inputs to prevent sql injections
		$uname = trim($_POST['username']);
		$uname = strip_tags($uname);
		$uname = htmlspecialchars($uname);
		
		$name = trim($_POST['fullname']);
		$name = strip_tags($name);
		$name = htmlspecialchars($name);
		
		$email = trim($_POST['email']);
		$email = strip_tags($email);
		$email = htmlspecialchars($email);
		
		$pass = trim($_POST['pass']);
		$pass = strip_tags($pass);
		$pass = htmlspecialchars($pass);
		
		// basic username validation
		if (empty($uname)) {
			$error = true;
			$unameError = "Please enter your user name.";
		} else if (strlen($uname) < 3) {
			$error = true;
			$unameError = "Name must have atleat 3 characters.";
		} else if (!preg_match("/^[a-zA-Z]+$/",$uname)) {
			$error = true;
			$unameError = "UserName must contain alphabets.";
		} else {
			// check username exist or not
			$query = "SELECT user_name FROM users WHERE user_name='$uname'";
			$result = mysql_query($query);
			$count = mysql_num_rows($result);
			if($count!=0){
				$error = true;
				$unameError = "Provided username is already in use.";
			}
		}
		
		// basic name validation
		if (empty($name)) {
			$error = true;
			$nameError = "Please enter your full name.";
		} else if (strlen($name) < 3) {
			$error = true;
			$nameError = "Name must have atleat 3 characters.";
		} else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
			$error = true;
			$nameError = "Name must contain alphabets and space.";
		}
		
		//basic email validation
		if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$error = true;
			$emailError = "Please enter valid email address.";
		} else {
			// check email exist or not
			$query = "SELECT email FROM users WHERE email='$email'";
			$result = mysql_query($query);
			$count = mysql_num_rows($result);
			if($count!=0){
				$error = true;
				$emailError = "Provided Email is already in use.";
			}
		}
		// password validation
		if (empty($pass)){
			$error = true;
			$passError = "Please enter password.";
		} else if(strlen($pass) < 6) {
			$error = true;
			$passError = "Password must have atleast 6 characters.";
		}
		
		// password encrypt using SHA256();
		$password = hash('sha256', $pass);
		
		// if there's no error, continue to signup
		if( !$error ) {
			
			$query = "INSERT INTO users(user_name,name,email,password) VALUES('$uname','$name','$email','$password')";
			$res = mysql_query($query);
				
			if ($res) {
				$errTyp = "success";
				$errMSG = "Successfully registered, you may login now";
				unset($uname);
				unset($name);
				unset($email);
				unset($pass);
			} else {
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";	
			}				
		}
	}
?>
<!doctype html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>TestUrSkills</title>
	
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
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

	<section style="margin-top:100px; margin-bottom:100px;">
		<div class="container">
			<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
			
				<div style="border:1px solid gray;padding:25px;" class="col-md-offset-3 col-md-6">
				
					<?php
					if ( isset($errMSG) ) {
						
						?>
						<div class="form-group">
						<div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
						<span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
						</div>
						</div>
						<?php
					}
					?>
					
					<div class="form-group">
						<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
						<input type="text" name="username" class="form-control" placeholder="Enter User Name" maxlength="50" value="<?php echo $uname; ?>" />
						</div>
						<span class="text-danger"><?php echo $unameError; ?></span>
					</div>
					
					<div class="form-group">
						<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
						<input type="text" name="fullname" class="form-control" placeholder="Enter Full Name" maxlength="50" value="<?php echo $name; ?>" />
						</div>
						<span class="text-danger"><?php echo $nameError; ?></span>
					</div>
					
					<div class="form-group">
						<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
						<input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php echo $email; ?>" />
						</div>
						<span class="text-danger"><?php echo $emailError; ?></span>
					</div>
					
					<div class="form-group">
						<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
						<input type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="15" />
						</div>
						<span class="text-danger"><?php echo $passError; ?></span>
					</div>
					
					<div class="form-group">
						<button type="submit" class="btn btn-primary" name="btn-signup">Sign Up</button>
					</div>
					
					<div class="form-group">
						<a href="index.php">Sign in Here...</a>
					</div>
				
				</div>
		   
			</form>
		</div>
	</section>
	
	<footer style="background-color: #f0f5f5; padding:15px;">
        <div class="container text-center">
			<p>Copyright © TestUrSkills - Online Assessment Test</p>
			<p>Designed & Developed by Rahul Kumar</p>
        </div>
    </footer>

</body>
</html>
<?php ob_end_flush(); ?>