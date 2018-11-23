<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo $header; ?></title>
		<meta charset="utf-8" lang="en">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="icon" type="image/icon" href="./assets/play.ico">
		<link type="text/css" rel="stylesheet" href="https://necolas.github.io/normalize.css/latest/normalize.css">
		<link type="text/css" rel="stylesheet" href="./css/style.css">
	</head>
<body>
	<nav class="clearfix">
		<div class="wrapper">
		    <ul>
				<li class="wlogo">
					<a href="index.php"><img src="assets/play.jpg"><span>Play</span></a>
					
				</li>
				
				<li style="text-align:center">
					<form action="search.php" method="GET">
						<input type="text" name="s"></input>
						<input type="submit" value="search"></input>
					</form>
				</li>
				
				<li style="text-align:right">
					<?php
						if(!loggedin() && !checkAdmin()){
							echo '<a href="register.php">Sign Up</a>
							<span class="separate">|</span>
							<a href="login.php">Login</a>';
						}else if(checkAdmin()){
							echo '<b><a href="admin/index.php">Admin Panel</a></b>
							<span class="separate">|</span>
							<a href="inc/logout.php">Logout</a>';
						}else{
							echo '
							<a href="upload.php"><img src="./assets/upload.png"></a>
							<span class="separate">|</span>
							<a href="profile.php?username='.$_SESSION['username'].'">'.ucfirst($_SESSION['fullname']).'</a>
							<span class="separate">|</span>
							<a href="inc/logout.php">Logout</a>';
						}
					
					?>
					
				</li>
		     </ul>
		</div>
    </nav>

<div class="wrapper">
