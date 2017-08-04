<?php

	session_start();
	
	if (!isset($_SESSION['admin'])) {
		header("Location: index.php");
	} else if(isset($_SESSION['admin'])!="") {
		header("Location: home.php");
	}
	
	if (isset($_GET['logout'])) {
		unset($_SESSION['admin']);
		session_unset();
		session_destroy();
		header("Location: index.php");
		exit;
	}
?>