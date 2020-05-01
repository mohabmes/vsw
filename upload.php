<?php
require('inc/connection.php');
require('inc/function.php');
require('inc/video.php');

if(isset($_GET['status'])){
	$header = "successed";
	require('inc/header.php');
	if($_GET['status']=='uploaded'){
		echo '<br><br><br><br>';
		echo '<h1><center> :) </h1>';
		echo '<p><center>Your request is sent successfully, We will respond shortly.</p>';
		die();
	}
}

//if not Loggedin redirect to the main page
if(!loggedin())
	redirect_to('login');


if($_SERVER["REQUEST_METHOD"] == "POST"){

	//Filtering input
	$title = trim(filter_input(INPUT_POST,"title",FILTER_SANITIZE_STRING));
	$description = trim(filter_input(INPUT_POST,"description",FILTER_SANITIZE_SPECIAL_CHARS));

	//Files to be uploaded
	$vid_tmp_name = $_FILES['video']['tmp_name'];
	$thumbn_tmp_name = $_FILES['thumbnail']['tmp_name'];

	//Check if empty (required fields)
	if(empty($title) || empty($vid_tmp_name)|| empty($thumbn_tmp_name) ){
			set_error_msg("Please fill in the required fields: Title, Video and Thumbnail.");
			redirect_to('upload');
	}
	if(empty($description)){
		$description = "(NULL)";
	}
	if(strlen($title)>70){
		set_error_msg("HEY, Video title must be less than 70 character.");
		redirect_to('upload');
	}

		//name of the video & thumbnail
		$name = get_session('id').'-'.date_timestamp_get(date_create());

		create_dir('./media/video/');
		create_dir('./media/thumbnail/');

		try{

			$video_name = $_FILES['video']['type'];
			$videos_ext = str_split($video_name, strpos($video_name, '/')+1)[1];
			$thumbnail_name = $_FILES['thumbnail']['type'];
			$thumbnail_ext = str_split($thumbnail_name, strpos($thumbnail_name, '/')+1)[1];

			//Full direction of both video & thumbnail
			$vid_uploads_dir = './media/video/'.$name .'.'.$videos_ext;
			$thumbn_uploads_dir = './media/thumbnail/'.$name. '.'. $thumbnail_ext;

			//Start uploading
			move_uploaded_file($vid_tmp_name, $vid_uploads_dir);
			move_uploaded_file($thumbn_tmp_name, $thumbn_uploads_dir);

			$video = new Video();
			$video->setInfo($title, $description, get_session('id'), $vid_uploads_dir, $thumbn_uploads_dir, date("M d, Y",time()))
						->add();
		}catch(Exception $e){
			$error_message[] = "Error : ".$e->getMessage();
		}

	if(is_file($vid_uploads_dir) && is_file($thumbn_uploads_dir) ){
		//if the uploaded do exist then
		//Redirect to this page
		header('refresh:1;url=upload.php?status=uploaded');
		//header('Location: upload.php?status=uploaded');
	}else{
		set_error_msg("Error occurred, Please try again !!");
		redirect_to('upload');
	}
}
load_view('upload');
?>
