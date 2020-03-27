<?php
require('inc/function.php');
require('inc/user.php');
require('inc/video.php');

if(empty($_GET['username'])|| is_numeric($_GET['username']) ){
	redirect_to('404');
}

$user = new User();
$video = new Video();
$user = $user->getUserData($_GET['username']);

if(empty($user->username))
	redirect_to('404');

$videos = $video->getUserVideo($user->id);
$fullname = ucfirst($user->fullname);
include('views/profile.php');
?>
