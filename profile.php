<?php
require('inc/connection.php');
require('inc/function.php');

if(!isset($_GET['username'])|| empty($_GET['username'])|| is_numeric($_GET['username']) ){
	header('Location: 404.php');
}
$username = $_GET['username'];

//Check if profile username exist
$userData = getUserData($username);

if(!isset($userData)||empty($userData)){
	header('Location: 404.php');
}

$id = $userData['id'];

if(empty($error_message)&& !isset($error_message)){
	$videos = getUserVideo($id);
	$fullname = ucfirst($userData['fullname']);
	$header = "Profile | ".$fullname;
	require('inc/header.php');
}
?>

<p class="title"><?php echo '<a href="profile.php?username='.$username.'">'.$fullname.'</a> (@'.$username.')';?></p>
	<div class="panel">
		<?php
			if(empty($videos)){
				echo '<br><center><< No Video to show >></center>';
			}else{
				foreach($videos as $k=>$i){
					//$videos as $k => $i)
					videoPreview($i);
				}
			}
		?>
	</div>
<?php require('inc/footer.php');?>
