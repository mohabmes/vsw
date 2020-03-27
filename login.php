<?php
require('inc/function.php');
require('inc/user.php');

//if already Loggedin redirect to the main page
if(loggedin())
	redirect_to('index');
// echo md5('PasswordPassword');
// exit();

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$username = $_POST['username'];
	$password = $_POST['password'];
	//Check if empty
	if(empty($username)|| empty($password)){
		set_error_msg("Please fill in the required fields: Username and Password.");
		redirect_to('login');
	}
	//Filtering input
	$username = trim(filter_input(INPUT_POST,"username",FILTER_SANITIZE_STRING));
  $password = trim(filter_input(INPUT_POST,"password",FILTER_SANITIZE_STRING));

	//Password Hash
	$password = md5($password);


	//validate username AND password
	$user = new User();
	$user->login($username, $password);
	if(!empty($user->username)){
		//Set cookies if its validate
		set_login_session($user->id, $user->username, $user->fullname);
		//redirect to the main page
		redirect_to('index');
	}else{
		//Set error msg if its invalidate
		set_error_msg("Invalid Username / Password, Try Again.");
		redirect_to('login');
	}
}

load_view('login');
?>
