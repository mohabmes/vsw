<?php $header = "Profile | ". ucfirst($user->fullname); require('inc/header.php');?>

<p class="title"><?php echo '<a href="profile.php?username='.$user->username.'">'.$user->fullname.'</a> (@'.$user->username.')';?></p>
	<div class="panel">
		<?php if(empty($videos)):?>
				<br><center><< No Video to show >></center>
		<? else: ?>
			<? foreach($videos as $k=>$i):?>
						<div class="video-preview">
							<a href="video.php?id=<?=$i['vid']?>">
								<img src="<?=$i['thumbnail_loca']?>">
								<img src="assets/play.jpg" class="logo">
								<p><?=$i['title']?></p>
							</a>
							<hr>
							<a href="profile.php?username=<?=$i['username']?>"><?=$i['fullname']?></a>
							<i><?=$i['date']?></i>
						</div>
				<? endforeach;?>
			<? endif;?>
	</div>
<?php require('inc/footer.php');?>
