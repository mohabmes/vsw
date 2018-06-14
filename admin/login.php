<?php
require('../inc/connection.php');
require('../inc/function.php');

//if already Loggedin redirect to the main page
if(loggedin() && checkAdmin()){
	header('Location: index.php');
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
	//Filtering input
	$username = trim(filter_input(INPUT_POST,"username",FILTER_SANITIZE_STRING));
    $password = trim(filter_input(INPUT_POST,"password",FILTER_SANITIZE_STRING));
	
	//Password Hash
	$password = md5($password);
	
	//Check if empty
	if(empty($username)|| empty($password)){
		$error_message[] = "Please fill in the required fields: Username and Password.";
	}
	
	$profile = adminLogin($username, $password);
	if(!empty($profile)){
		//Set cookies
		$_SESSION['id']=$profile['id'];
		$_SESSION['username']=$profile['username']."admin";
		//redirect to the main page
		header('Location: index.php');
	}else{
		$error_message[] = "Invalid Username / Password, Try Again.";
	}

	if(isset($error_message)){
		echo '<div class="wrapper"><div class="error">'.$error_message[0].'</div></div>';
	}

}




?>
<head>
	<title>Admin Login</title>
	<link type="text/css" rel="stylesheet" href="../css/normalize.css">
	<link type="text/css" rel="stylesheet" href="../css/style.css">
</head>
<body>

	<div class="wrapper">
		<div class="content">
			<p>Admin Panel</p>
		</div>

		<div class="content">
			<form action="login.php" method="POST" class="form">
				<table>
					<tr>
						<th>Username</th>
						<td><input type="text" name="username"></td>
					</tr>
					<tr>
						<th>Password</th>
						<td><input type="password" name="password"></td>
					</tr>
					<tr>
						<th></th>
						<td><input type="submit" value="Login"></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</body>