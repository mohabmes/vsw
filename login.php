<?php
require('inc/connection.php');
require('inc/function.php');

//header title
$header = "Login";

require('inc/header.php');

//if already Loggedin redirect to the main page
if(loggedin()){
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
	
	//validate username AND password
	$user = login($username, $password);
	if(isset($user['id'])&& !empty($user['id'])){
		//Set cookies if its validate
		$_SESSION['id']=$user['id'];
		$_SESSION['username']=$user['username'];
		$_SESSION['fullname']=$user['fullname'];
		//redirect to the main page
		header('Location: index.php');
	}else{
		//Set error msg if its invalidate
		$error_message[] = "Invalid Username / Password, Try Again.";
	}
}
//if the error msg is set display it
if(isset($error_message)){
	echo '<div class="wrapper"><div class="error">'.$error_message[0].'</div></div>';
}
?>

<div class="wrapper content">
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
<br><br><br><br><br>
<?php require('inc/footer.php');?>