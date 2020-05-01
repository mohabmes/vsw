<?php
require('inc/connection.php');
require('inc/function.php');
require('inc/user.php');

//if already Loggedin redirect to the main page


if(isset($_GET['status'])){
	$header = "Thanks";
	require('inc/header.php');
	if($_GET['status']=='thanks'){
		echo '<br><br><br><br>';
		echo '<h1><center>:)</h1>';
		echo '<p><center>Registered Successfully !!</p>';
		die();
	}
}

if(loggedin())
	redirect_to('index');

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
		set_error_msg("Please fill in the required fields: Fullname, Username, Email and Password.");
		redirect_to('register');
	}elseif($password!=$password_again){
		set_error_msg("Password didn't Match.");
		redirect_to('register');
	}else if(strlen($password)<=4){
		set_error_msg("Password is too short.");
		redirect_to('register');
	}

	$user = new User();
	//check if the username already exist
	$user = $user->getUserData($username);
	if(!empty($user->username)){
			set_error_msg("That username is taken. Try another.");
			redirect_to('register');
	}


	//send the user data to the database
	$user->register($username, $email, $password, $fullname);
	//After Registeration Log the user in
	$profile = $user->login($username, $password);
	if(!empty($profile->username)){
		//Set cookies
		set_login_session($user->id, $user->username, $user->fullname);
		//Redirect to thanks page
		header('Location: register.php?status=thanks');
	}

}
load_view('register');
?>
