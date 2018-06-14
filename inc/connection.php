<?php
	ini_set('display_errors', 'On');
	try {
		$db = new PDO("mysql:host=localhost;dbname=media", 'root');
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (Exception $e) {
		echo "Error : ".$e->getMessage();
	}
	@session_start();
?>