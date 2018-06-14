<?php
require('inc/connection.php');
require('inc/function.php');

//ToDo header title
$header = "Register Now";
require('inc/header.php');


if(isset($_GET['status'])){
	$header = "Thanks";
	if($_GET['status']=='thanks'){
		echo '<br><br><br><br>';
		echo '<h1><center>:)</h1>';
		echo '<p><center>Registered Successfully !!</p>';
		die();
	}
}

//ToDo header title
$header = "Sign Up";

//if already Loggedin redirect to the main page
if(loggedin()){
	header('Location: index.php');
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
	//Filtering input
	$fullname = trim(filter_input(INPUT_POST,"fullname",FILTER_SANITIZE_STRING));
	$username = strtolower(trim(filter_input(INPUT_POST,"username",FILTER_SANITIZE_STRING)));
    $email = 	strtolower(trim(filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL)));
    $password = strtolower(trim(filter_input(INPUT_POST,"password",FILTER_SANITIZE_STRING)));
    $password_again = strtolower(trim(filter_input(INPUT_POST,"password_again",FILTER_SANITIZE_STRING)));
	
	//Password Hash
	$password = md5($password);
	$password_again = md5($password_again);
	
	//Check if empty
	if(empty($fullname)|| empty($username)|| empty($email)|| empty($password)|| empty($password_again)){
		$error_message[] = "Please fill in the required fields: Fullname, Username, Email and Password.";
	}
	
	//Check if password match && lenght
	if($password!=$password_again){
		$error_message[] = "Password didn't Match.";
	}else if(strlen($password)<=4){
		$error_message[] = 'Password is too short.';
	}
	
	//check if the username already exist
	$userTaken = getUserData($username);
	if(!empty($userTaken)){
		$error_message[] = "That username is taken. Try another.";
	}
	
	if(!isset($error_message) && empty($error_message)){
		//send the user data to the database
		register($username, $email, $password, $fullname);
		//After Registeration Log the user in
		$profile = login($username, $password);
		if(isset($profile['id'])){
			//Set cookies
			$_SESSION['id']=$profile['id'];
			$_SESSION['username']=$profile['username'];
			$_SESSION['fullname']=$profile['fullname'];
			//Redirect to thanks page
			header('Location: register.php?status=thanks');
		}
	}
}
//if the error msg is set display it
if(isset($error_message)){
	echo '<div class="wrapper"><div class="error">'.$error_message[0].'</div></div>';
}
?>
<div class="wrapper content">
	<form action="register.php" method="POST" class="form">
		<table>
			<tr>
				<th>Fullname</th>
				<td><input type="text" name="fullname"></td>
			</tr>
			<tr>
				<th>Username</th>
				<td><input type="text" name="username"></td>
			</tr>
			<tr>
				<th>Email</th>
				<td><input type="email" name="email"></td>
			</tr>
			<tr>
				<th>Password</th>
				<td><input type="password" name="password"></td>
			</tr>
			<tr>
				<th>Password</th>
				<td><input type="password" name="password_again"></td>
			</tr>
			<tr>
				<th></th>
				<td><input type="submit" value="Register"></td>
			</tr>
		</table>
	</form>
</div>
<?php require('inc/footer.php');?>