<?php

function loggedin(){
	if(isset($_SESSION['username'])){
		return true;
	}else{
		return false;
	}
}

function checkAdmin(){
	@$session = $_SESSION['username'];
	$str = substr($session, strlen($session)-5, strlen($session));
	if($str=="admin"){
		return true;
	}else{
		return false;
	}
}

function get4RandomVideos(){
	global $db;
	//Get 4 random videos
	try{
		$q = $db->prepare("SELECT videos.id AS vid, title, description, id_owner, vid_loca, thumbnail_loca, date, users.id AS uid, username, fullname FROM videos JOIN users WHERE id_owner = users.id order by rand() limit 4");
		$q->execute();
		$videos = $q->fetchAll(PDO::FETCH_ASSOC);
		return $videos;
	}catch(Exception $e){
		$error_message[] = "Error : ".$e->getMessage();
	}
}

function videoPreview($i){
	echo '
	<div class="video-preview">
		<a href="video.php?id='.$i['vid'].'">
			<img src="./media/thumbnail/'.$i['thumbnail_loca'].'.jpg">
			<img src="assets/play.jpg" class="logo">
			<p>'.$i['title'].'</p>
		</a>
		<hr>
		<a href="profile.php?username='.$i['username'].'">'.$i['fullname'].'</a>
		<i>'.$i['date'].'</i>
	</div>';
}

function adminPreview($i){
	echo 
	'<div class="panel">
		<video controls name="media" poster="../media/thumbnail/'.$i['vid_loca'].'.jpg">
			<source src="../media/video/'.$i['vid_loca'].'.mp4" type="video/mp4">
				Media Player Error.
		</video>
		<h3>'.$i['title'].'</h3>
		<a href="../profile.php?username='.$i['username'].'">'.ucfirst($i['fullname']).'</a>
		<b>'.$i['date'].'</b>
		<p>'.$i['description'].'</p>
		<form action="index.php" method="POST">
			<input type="text" name="id" value="'.$i['id'].'" style="display:none;">
			<input type="submit" value="Accept" name="state">
			<input type="submit" value="Ignore" name="state">
		</form>
	</div>';
}


function searchPreview($i){
	echo 
	'<div class="searchPreview">
		<a href="video.php?id='.$i['vid'].'">
			<img src="./media/thumbnail/'.$i['vid_loca'].'.jpg" type="image/jpg">
			<h3>'.$i['title'].'</h3>
		</a>
		<a href="../profile.php?username='.$i['username'].'">'.ucfirst($i['fullname']).'</a>
		<b>'.$i['date'].'</b>
		<p>'.$i['description'].'</p>
	</div>';
}

function getUserData($username){
	global $db;
	//Check if profile username exist
	try{
		$q = $db->prepare("SELECT * FROM users WHERE username = ?");
		$q->bindParam(1, $username);
		$q->execute();
		$result = $q->fetch(PDO::FETCH_ASSOC);
		return $result;
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

function login($username, $password){
	global $db;
	try{
		$q = $db->prepare("SELECT id,username,fullname FROM users WHERE username = ? AND password = ?");
		$q->bindParam(1, $username);
		$q->bindParam(2, $password);
		$q->execute();
		$result = $q->fetch(PDO::FETCH_ASSOC);
		return $result;
	}catch(Exception $e){
		$error_message[] = "Error : ".$e->getMessage();
	}
}

function adminLogin($username, $password){
	global $db;
	try{
		$q = $db->prepare("SELECT id,username FROM admins WHERE username = ? AND password = ?");
		$q->bindParam(1, $username);
		$q->bindParam(2, $password);
		$q->execute();
		$result = $q->fetch(PDO::FETCH_ASSOC);
		return $result;
	}catch(Exception $e){
		$error_message[] = "Error : ".$e->getMessage();
	}
}


function getUserVideo($id){
	global $db;
	//retrieve the profile video data
	try{
		$q = $db->prepare("SELECT videos.id AS vid,title,description,id_owner,vid_loca,thumbnail_loca,date,username,fullname FROM videos JOIN users WHERE users.id=videos.id_owner AND users.id = ? ORDER BY videos.id DESC");
		$q->bindParam(1, $id);
		$q->execute();
		$result = $q->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}catch(Exception $e){
		$error_message[] = "Error : ".$e->getMessage();
	}
}

function getAllVideosCount(){
	global $db;
	//to get someone's videos count
	try{
		$q = $db->prepare("SELECT COUNT(id) FROM videos");
		$q->execute();
		$numVideos = $q->fetch(PDO::FETCH_ASSOC);
		$numVideos = $numVideos['COUNT(id)'];
		return $numVideos;
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

function addVideoRequest($title, $description, $id, $name, $name, $date){
	global $db;
	//Add video metadata to the DB
	//INSERT INTO `videos`(`title`, `description`, `id_owner`, `vid_loca`, `thumbnail_loca`, `date`) 
	//VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6])
	$q = $db->prepare("INSERT INTO requests (title, description, id_owner, vid_loca, thumbnail_loca, date ) VALUES ( ?, ?, ?, ?, ? ,? )");
	$q->bindParam(1, $title);
	$q->bindParam(2, $description);
	$q->bindParam(3, $id);
	$q->bindParam(4, $name);
	$q->bindParam(5, $name);
	$q->bindParam(6, $date);
	$q->execute();
}

function addVideo($title, $description, $id, $name, $name, $date){
	global $db;
	//Add video metadata to the DB
	//INSERT INTO `videos`(`title`, `description`, `id_owner`, `vid_loca`, `thumbnail_loca`, `date`) 
	//VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6])
	$q = $db->prepare("INSERT INTO videos (title, description, id_owner, vid_loca, thumbnail_loca, date ) VALUES ( ?, ?, ?, ?, ? ,? )");
	$q->bindParam(1, $title);
	$q->bindParam(2, $description);
	$q->bindParam(3, $id);
	$q->bindParam(4, $name);
	$q->bindParam(5, $name);
	$q->bindParam(6, $date);
	$q->execute();
}

function getRequestData($id){
	global $db;
	//retrieve the certain Request Data
	try{
		$q = $db->prepare("SELECT users.id as uid,title,description,thumbnail_loca,date FROM requests JOIN users WHERE users.id=requests.id_owner AND requests.id= ? ORDER BY requests.id");
		$q->bindParam(1, $id);
		$q->execute();
		$result = $q->fetch(PDO::FETCH_ASSOC);
		return $result;
	}catch(Exception $e){
		$error_message[] = "Error : ".$e->getMessage();
	}
}

function getAllRequest($start_item, $item_on_page){
	global $db;
	//retrieve the limited Requests Data
	try{
		//SELECT requests.id,title,description,vid_loca,thumbnail_loca,date,COUNT(requests.id),username FROM requests JOIN users where requests.id_owner = users.id
		$q = $db->prepare("SELECT requests.id,title,description,vid_loca,thumbnail_loca,date,id_owner,username,fullname FROM requests JOIN users where requests.id_owner = users.id ORDER BY requests.id LIMIT ".$start_item.",".$item_on_page."");
		$q->execute();
		$result = $q->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}catch(Exception $e){
		$error_message[] = "Error : ".$e->getMessage();
	}
}

function deleteVideoRequest($id){
	global $db;
	//DELETE FROM `requests` WHERE `id`
	$q = $db->prepare("DELETE FROM requests WHERE id= ?");
	$q->bindParam(1, $id);
	$q->execute();
}

function deleteVideo($id){
	global $db;
	//DELETE FROM `videos` WHERE `id`
	$q = $db->prepare("DELETE FROM videos WHERE id= ?");
	$q->bindParam(1, $id);
	$q->execute();
}

function deleteAllCommentOfVideo($id){
	global $db;
	//DELETE FROM `comments` WHERE `id_video`
	$q = $db->prepare("DELETE FROM comments WHERE id_video= ?");
	$q->bindParam(1, $id);
	$q->execute();
}

function deleteThumbnail_video($loca){
	unlink('./media/thumbnail/'.$loca.'.jpg');
	unlink('./media/video/'.$loca.'.mp4');
}

function deleteThumbnail_videoAdmin($loca){
	unlink(realpath('../media/thumbnail/'.$loca.'.jpg'));
	unlink(realpath('../media/video/'.$loca.'.mp4'));
}

function getUploaderData($id){
	global $db;
	//retrieve the uploader data
	try{
		$q = $db->prepare("SELECT videos.id_owner vid,users.id,username,fullname FROM videos JOIN users WHERE videos.id_owner=users.id AND videos.id = ?");
		$q->bindParam(1, $id);
		$q->execute();
		$result = $q->fetch(PDO::FETCH_ASSOC);
		return $result;
	}catch(Exception $e){
		$error_message[] = "Error : ".$e->getMessage();
	}
}

function getVideoData($id){
	global $db;
	//Check if video id exist first
	try{
		$q = $db->prepare("SELECT * FROM videos WHERE id = ?");
		$q->bindParam(1, $id);
		$q->execute();
		$result = $q->fetch(PDO::FETCH_ASSOC);
		return $result;
	}catch(Exception $e){
		$error_message[] = "Error : ".$e->getMessage();
	}
}

function getRequestCount(){
	global $db;
	//Check if video id exist first
	try{
		$q = $db->prepare("SELECT COUNT(id) FROM requests");
		$q->execute();
		$count = $q->fetch();
		$count = $count['COUNT(id)'];
		return $count;
	}catch(Exception $e){
		$error_message[] = "Error : ".$e->getMessage();
	}
}

function getAllComment($id){
	global $db;
	//retrieve the limited Requests Data
	try{
		//SELECT requests.id,title,description,vid_loca,thumbnail_loca,date,COUNT(requests.id),username FROM requests JOIN users where requests.id_owner = users.id
		$q = $db->prepare("SELECT comments.id,content,date,id_owner,id_video,username,fullname FROM comments JOIN users where id_owner=users.id AND id_video = ? ORDER by comments.id");
		$q->bindParam(1, $id);
		$q->execute();
		$result = $q->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}catch(Exception $e){
		$error_message[] = "Error : ".$e->getMessage();
	}
}

function addComment($content, $id_video, $id_owner, $date){
	global $db;
	try{
		//INSERT INTO `comments`(`content`, `id_video`, `id_owner`, `date`) VALUES ([value-1],[value-2],[value-3],[value-4])
		$q = $db->prepare("INSERT INTO comments(content, id_video, id_owner, date) VALUES ( ? , ? , ? , ?)");
		$q->bindParam(1, $content);
		$q->bindParam(2, $id_video);
		$q->bindParam(3, $id_owner);
		$q->bindParam(4, $date);
		$q->execute();
	}catch(Exception $e){
		$error_message[] = "Error : ".$e->getMessage();
	}
}

function deleteComment($id){
	global $db;
	try{
		//DELETE FROM comments WHERE id
		$q = $db->prepare("DELETE FROM comments WHERE id = ?");
		$q->bindParam(1, $id);
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

function votedBefore($id, $vid){
	global $db;
	try{
		$q = $db->prepare("SELECT id FROM votes WHERE id_owner = ? AND id_vid = ? ");
		$q->bindParam(1, $id);
		$q->bindParam(2, $vid);
		$q->execute();
		$cnt = $q->fetch(PDO::FETCH_ASSOC);
		return $cnt['id'];
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

function loader($msg){
	echo '<div class="overlay">
				<div class="loader"></div>
				<p>'.$msg.'</p>
		</div>';
}

?>
