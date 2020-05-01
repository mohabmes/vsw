<?php
//header title
$header = "Play | Homepage";
require('inc/header.php');
?>


<p class="title">Added Recently</p>
<div class="panel wrapper">
	<?php if(empty($videos)): ?>
			<center><< No Videos to show >></center>
	<?php else: ?>
			<?php foreach($videos as $k => $i):?>
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
			<?php endforeach; ?>
	<?php endif; ?>
</div>

<div class="content">
	<?php for($i=1; $i<=$pages; $i++):?>
			<a href="index.php?p='.$i.'"<?=$i?></a>
			<?php if($i<$pages):?>
				<span class="separate"> | </span>
			<?php endif ?>
	<?php endfor; ?>
</div>

<?php require('inc/footer.php');?>
