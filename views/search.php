<?php
$header = "Search | ".$search;
require('inc/header.php');
?>

<div class="wrapper">

	<p class="title">Search | <?php echo $search;?></p>
	<div class="panel">
	<?php if(!isset($searchResult)|| empty($searchResult)): ?>
			<br><br><br><center><< No Result Found >></center>
	<?php else:?>
			<?php foreach($searchResult as $k=>$i):?>
				<div class="searchPreview">
					<a href="video.php?id=<?=$i['vid']?>">
						<img src="<?=$i['thumbnail_loca']?>" type="image/jpg">
						<h3><?=$i['title']?></h3>
					</a>
					<a href="../profile.php?username=<?=$i['username']?>"><?=ucfirst($i['fullname'])?></a>
					<b><?=$i['date']?></b>
					<p><?=$i['description']?></p>
				</div>
			<?php endforeach;?>

	<?php endif;?>
	</div>
</div>

<?php require('inc/footer.php');?>
