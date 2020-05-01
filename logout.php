<?php
require('inc/connection.php');
require('inc/function.php');

unset_login_session();
session_destroy();

// print_r($_SESSION);
// exit();

redirect_to('index');
?>
