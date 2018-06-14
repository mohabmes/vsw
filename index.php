<?php
require('inc/connection.php');
require('inc/function.php');

//header title
$header = "Play | Homepage";

//Get number of Videos to create pagination
$numVideos = getAllVideosCount();
//$numPages = $numVideos/8;

$start_item=0;
$item_on_page=8;
$end_item=$start_item+$item_on_page;
$pages = intval($numVideos/$item_on_page);
$pages += ($numVideos%$item_on_page>0);


if(!empty($_GET['p'])&& isset($_GET['p']) && is_numeric($_GET['p'])){
	if($_GET['p']>$pages){
		header('Location: 404.php');
	}
	$p = intval($_GET['p']);
	$start_item = ($p-1)*$item_on_page;
}
//Get 4 random videos
$randomVideos = get4RandomVideos();

//Get Recently Added Videos
$videos = getRecentVideos($start_item);

require('inc/header.php');
?>

<p class="title">Random Videos</p>
<div class="panel">
<?php 
	foreach($randomVideos as $k => $i){
		videoPreview($i);
	}
?>
</div>

<p class="title">Added Recently</p>
<div class="panel wrapper">		
	<?php
		if(empty($videos)){
			echo '<center><< No Videos to show >></center>';
		}else{
			foreach($videos as $k => $i){
				videoPreview($i);
			}
		}
	?>
</div>

<div class="content">
	<?php
		for($i=1; $i<=$pages; $i++){
			echo '<a href="index.php?p='.$i.'">'.$i.'</a>';
			if($i<$pages){echo '<span class="separate"> | </span>';}
		}
	?>
</div>

<?php require('inc/footer.php');?>
