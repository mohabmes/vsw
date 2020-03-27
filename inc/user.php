<?php
 include('connection.php');
/**
 *
 */
class User
{
  public $id;
  public $username;
  public $fullname;
  public $email;
  public $password;

  function __construct()
  {
    // code...
  }

  function setInfo($id, $username, $fullname, $email)
  {
    $this->id = $id;
    $this->username = $username;
    $this->fullname = $fullname;
    $this->email = $email;
    return $this;
  }

  private function infoSetter($result){
    extract($result);
    $this->setInfo($id, $username, $fullname, $email);
  }

  function login($username, $password){
  	global $db;
  	try{
  		$q = $db->prepare("SELECT id,username,fullname,email FROM users WHERE username = ? AND password = ?");
  		$q->bindParam(1, $username);
  		$q->bindParam(2, $password);
  		$q->execute();
  		$result = $q->fetch(PDO::FETCH_ASSOC);
  		$this->infoSetter($result);
      return $this;
  	}catch(Exception $e){
  		$error_message[] = "Error : ".$e->getMessage();
  	}
  }

  function register($username, $email, $password, $fullname){
  	global $db;
  	try{
  		//INSERT INTO `users`(`username`, `email`, `password`) VALUES ([value-1],[value-2],[value-3])
  		$q = $db->prepare("INSERT INTO users (username, email, password, fullname) VALUES (?, ?, ?, ?)");
  		$q->bindParam(1, $username);
  		$q->bindParam(2, $email);
  		$q->bindParam(3, $password);
  		$q->bindParam(4, $fullname);
  		$q->execute();
  	}catch(Exception $e){
  		$error_message[] = "Error : ".$e->getMessage();
  	}
  }

  function getUserData($username){
  	global $db;
  	//Check if profile username exist
  	try{
  		$q = $db->prepare("SELECT id,username,fullname,email FROM users WHERE username = ?");
  		$q->bindParam(1, $username);
  		$q->execute();
  		$result = $q->fetch(PDO::FETCH_ASSOC);
      $this->infoSetter($result);
      return $this;
  	}catch(Exception $e){
  		$error_message[] = "Error : ".$e->getMessage();
  	}
  }



  function getRecentVideos($start_item){
  	global $db;
  	$s = $start_item;
  	//Get Recently Added Videos
  	//SELECT videos.id AS vid, title, description, id_owner, vid_loca, thumbnail_loca, date, users.id AS uid, username, fullname FROM videos JOIN users WHERE id_owner = users.id ORDER BY videos.id DESC
  	try{
  		$q = $db->prepare("SELECT videos.id AS vid, title, description, id_owner, vid_loca, thumbnail_loca, date, users.id AS uid, username, fullname FROM videos JOIN users WHERE id_owner = users.id ORDER BY videos.id DESC LIMIT ".$s." , 8");
  		//$q->bindParam(1, $s);
  		$q->execute();
  		$videos = $q->fetchAll(PDO::FETCH_ASSOC);
  		return $videos;
  	}catch(Exception $e){
  		$error_message[] = "Error : ".$e->getMessage();
  	}
  }

  function getNumOfVideos($id){
  	global $db;
  	//to get someone's videos count
  	try{
  		$q = $db->prepare("SELECT COUNT(id) FROM videos WHERE id_owner= ?");
  		$q->bindParam(1, $id);
  		$q->execute();
  		$result = $q->fetch(PDO::FETCH_ASSOC);
  		return $result['COUNT(id)'];
  	}catch(Exception $e){
  		$error_message[] = "Error : ".$e->getMessage();
  	}
  }
}

?>
