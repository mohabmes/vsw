<?php
require('inc/connection.php');
require('inc/function.php');
require('inc/video.php');

if(empty($_GET['id'])|| !is_numeric($_GET['id']) ){
	redirect_to('404');
}

$id = $_GET['id'];

$video = new Video();
//Check if video id exist first
$video = $video->getVideoData($id);

if($_SERVER["REQUEST_METHOD"] != "POST"){
	//if the query result is empty or not setted redirect
	if(empty($video))
		redirect_to('404');
}

//retrieve the uploader data
$uploader = new Video();
$uploader = $uploader->getUploaderData($id);
// print_r($uploader);
// exit();
$fullname = ucfirst($uploader['fullname']);
$username = $uploader['username'];
$title = ucfirst($video['title']);
$description = $video['description'];
$loca = $video['vid_loca'];
$date = $video['date'];

$votes = new Video();
$like = getVoteCount($id, 1);
$dislike = getVoteCount($id, 0);
$comments = $votes->getAllComment($id);


if($_SERVER["REQUEST_METHOD"] == "POST"){
	// loader("Wait a Sec");
	if(isset($_POST['comment'])){
		//Filtering input
		$comment = trim(filter_input(INPUT_POST,"comment",FILTER_SANITIZE_SPECIAL_CHARS));
		//date of the video
		$votes->addComment($comment, $id, get_session('id'), date("M d, Y",time()));

	}
	if(isset($_POST['Cdel'])){
		$votes->deleteComment($_POST['id']);
	}
	if(isset($_POST['Vdel'])){
		$delvotes = new Video();
		$delvotes->deleteVideo($_POST['id']);
		// $delvotes->deleteAllCommentOfVideo($id);
		//delete Video & Thumbnail src
		// $votes->deleteThumbnail_video($loca);
	}
	header('refresh:3;url=video.php?id='.$id.'&op=done');
}

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
$ip = ip2long($ip);
@$usr_id = get_session('id');
require('views/video.php');
?>
