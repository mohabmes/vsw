<?php
require('inc/connection.php');
require('inc/function.php');

//ToDo header title
$header = "Upload";
require('inc/header.php');


if(isset($_GET['status'])){
	$header = "successed";
	if($_GET['status']=='uploaded'){
		echo '<br><br><br><br>';
		echo '<h1><center> :) </h1>';
		echo '<p><center>Your request is sent successfully, We will respond shortly.</p>';
		die();
	}
}

//header title
$header = "Upload";

//if not Loggedin redirect to the main page
if(!loggedin() || checkAdmin()){
	header('Location: index.php');
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	//Filtering input
	$title = trim(filter_input(INPUT_POST,"title",FILTER_SANITIZE_STRING));
	$description = trim(filter_input(INPUT_POST,"description",FILTER_SANITIZE_SPECIAL_CHARS));
	
	//Files to be uploaded
	$vid_tmp_name = $_FILES['video']['tmp_name'];
	$thumbn_tmp_name = $_FILES['thumbnail']['tmp_name'];
	
	//Check if empty (required fields)
	if(empty($title) || empty($vid_tmp_name)|| empty($thumbn_tmp_name) ){
			$error_message[] = "Please fill in the required fields: Title, Video and Thumbnail.";
	}
	if(empty($description)){
		$description = "(NULL)";
	}
	if(strlen($title)>70){
		$error_message[] = "HEY, Video title must be less than 70 character.";
	}
	
	if(!isset($error_message)){
		loader("Please Wait .. ");
		//date of the video
		$t=time();
		$date=date("M d, Y",$t);
		
		//name of the video & thumbnail
		$d = date_create();
		$name = date_timestamp_get($d);
		
		if (!is_dir('./media/video/')) {
			mkdir('./media/video/', 0755, true);         
		}
		if (!is_dir('./media/thumbnail/')) {
			mkdir('./media/thumbnail/', 0755, true);         
		}
		
		try{
			//Full direction of both video & thumbnail
			$vid_uploads_dir = './media/video/'.$name.'.mp4';
			$thumbn_uploads_dir = './media/thumbnail/'.$name.'.jpg';
			
			//Start uploading
			move_uploaded_file($vid_tmp_name, $vid_uploads_dir);
			move_uploaded_file($thumbn_tmp_name, $thumbn_uploads_dir);
			//Add video metadata to the DB
			addVideoRequest($title, $description, $_SESSION['id'], $name, $name, $date);
		}catch(Exception $e){
			$error_message[] = "Error : ".$e->getMessage();
		}
	}
	if(isset($error_message)){
		echo '<div class="wrapper"><div class="error">'.$error_message[0].'</div></div>';
	}else if(is_file($vid_uploads_dir) && is_file($thumbn_uploads_dir) ){
		//if the uploaded do exist then
		//Redirect to this page
		header('refresh:1;url=upload.php?status=uploaded');
		//header('Location: upload.php?status=uploaded');
	}else{
		$error_message[] = "Error occurred, Please try again !!";
	}
}
?>
<div class="wrapper content">
	<form action="upload.php" method="POST" enctype="multipart/form-data" class="form">
		<table>
			<tr>
				<th>Title *</th>
				<td><input type="text" name="title"  maxlength="70"></td>
			</tr>
			<tr>
				<th>Video *</th>
				<td><input type="file" name="video" accept="video/*"></td>
			</tr>
			<tr>
				<th>Thumbnail *</th>
				<td><input type="file" name="thumbnail" accept="image/*"></td>
			</tr>
			<tr>
				<th>Description</th>
				<td><textarea rows="4" cols="50" name="description" maxlength="250"></textarea></td>
			</tr>
			<tr>
				<th></th>
				<td><input type="submit" value="Upload"></td>
			</tr>
		</table>
	</form>
</div>
<?php require('inc/footer.php');?>