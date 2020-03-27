<?php

function loggedin(){
	if(!empty($_SESSION['username'])){
		return true;
	}else{
		return false;
	}
}

function set_session($key, $value){
	$_SESSION[$key] = $value;
}

function get_session($key){
	if(!empty($_SESSION[$key]))
		return $_SESSION[$key];
	else
		return false;
}

function unset_session($key){
	unset($_SESSION[$key]);
}

function set_error_msg($error_msg){
	$_SESSION['error'][] = $error_msg;
}

function get_error_msg(){
	$error_msg = get_session('error');
	if(!empty($error_msg)){
		$allError = '';
		foreach ($error_msg as $error) {
			$allError .= $error;
		}
		unset_session('error');
		return $allError;
	}
	return false;
}

function set_login_session($id, $username, $fullname){
	set_session('id', $id);
	set_session('username', $username);
	set_session('fullname', $fullname);
}

function unset_login_session(){
	unset_session('id');
	unset_session('username');
	unset_session('fullname');
}

function redirect_to($to){
	header("Location: {$to}.php");
	exit();
}

function load_view($view){
	return require("views/{$view}.php");
}

function create_dir($path_to_dirname){
	if (!is_dir($path_to_dirname)) {
		mkdir($path_to_dirname, 0755, true);
	}
}



/************ Vote *****************/
function votedBefore($id, $vid){
	global $db;
	try{
		$q = $db->prepare("SELECT id FROM votes WHERE id_owner = ? AND id_vid = ? ");
		$q->bindParam(1, $id);
		$q->bindParam(2, $vid);
		$q->execute();
		$cnt = $q->fetch(PDO::FETCH_ASSOC);
		return @$cnt['id'];
	}catch(Exception $e){
		$error_message[] = "Error : ".$e->getMessage();
	}
}
function addVote($v, $id, $vid){
	global $db;
	try{
		$q = $db->prepare("INSERT INTO votes( vote, id_owner, id_vid) VALUES ( ? , ? , ? )");
		$q->bindParam(1, $v);
		$q->bindParam(2, $id);
		$q->bindParam(3, $vid);
		$q->execute();
	}catch(Exception $e){
		$error_message[] = "Error : ".$e->getMessage();
	}
}

function updateVoted($v, $id, $vid, $voteid){
	global $db;
	try{
		$q = $db->prepare("UPDATE votes SET vote = ? ,id_owner = ? ,id_vid = ?  WHERE id = ?");
		$q->bindParam(1, $v);
		$q->bindParam(2, $id);
		$q->bindParam(3, $vid);
		$q->bindParam(4, $voteid);
		$q->execute();
	}catch(Exception $e){
		$error_message[] = "Error : ".$e->getMessage();
	}
}


  function getVoteCount($id, $v){
  	global $db;
  	try{
  		$q = $db->prepare("SELECT COUNT(id) FROM votes WHERE vote = ? AND id_vid = ? ");
  		$q->bindParam(1, $v);
  		$q->bindParam(2, $id);
  		$q->execute();
  		$cnt = $q->fetch(PDO::FETCH_ASSOC);
  		return $cnt['COUNT(id)'];
  	}catch(Exception $e){
  		$error_message[] = "Error : ".$e->getMessage();
  	}
  }
?>
