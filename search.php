<?php
require('inc/connection.php');
require('inc/function.php');

if(!isset($_GET['s']) || empty($_GET['s']) ){
	header('Location: index.php');
	die();
}

$search = trim(filter_input(INPUT_GET,"s",FILTER_SANITIZE_STRING));

try{
	$q = $db->prepare('SELECT videos.id as vid,title,description,id_owner,thumbnail_loca,date,users.id,username,fullname FROM videos JOIN users WHERE videos.id_owner=users.id AND (title LIKE \'%'.$search.'%\' OR description LIKE \'%'.$search.'%\') ORDER BY videos.id DESC' );

	$q->execute();
	$searchResult = $q->fetchALL(PDO::FETCH_ASSOC);
}catch(Exception $e){
	$error_message[] = "Error : ".$e->getMessage();
}
require('views/search.php');
?>
