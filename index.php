<?php
require('inc/connection.php');
require('inc/function.php');
require('inc/video.php');


$video = new Video();
//Get number of Videos to create pagination
$numVideos = $video->getAllVideosCount();
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


//Get Recently Added Videos
$videos = $video->getRecentVideos($start_item);
// include('views/main.php');
include('views/main.php');
?>
