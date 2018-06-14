<?php
	require('connection.php');
	$_SESSION['id']=null;
	$_SESSION['username']=null;
	$_SESSION['fullname']=null;
	session_destroy();
	header('Location: ../index.php');
?>