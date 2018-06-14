<?php

require('../inc/connection.php');
require('../inc/function.php');

//if already Loggedin redirect to the main page
if(!loggedin() || !checkAdmin()){
	header('Location: login.php');
}


//Get number of Request to create pagination
$count = getRequestCount();

$start_item=0;
$item_on_page=4;
$end_item=$start_item+$item_on_page;
$pages = intval($count/$item_on_page);
$pages += ($count%$item_on_page>0);

if(!empty($_GET['p'])&& isset($_GET['p']) && is_numeric($_GET['p'])){
	if($_GET['p']>$pages){
		header('Location: index.php');
		die();
	}
	$p = intval($_GET['p']);
	$start_item = ($p-1)*$item_on_page;
}

/*
//Get Recently Added Videos
$videos = getRecentVideos($start_item, $item_on_page);
*/
$allRequests = getAllRequest($start_item, $item_on_page);


if($_SERVER["REQUEST_METHOD"] == "POST"){
	loader("Wait a Sec");
	$id = $_POST['id'];
	$state = $_POST['state'];
	
	//get the data of certain request
	$vid = getRequestData($id);
	
	$title=$vid['title'];
	$description=$vid['description'];
	$loca=$vid['thumbnail_loca'];
	$date=$vid['date'];
	$id_owner=$vid['uid'];
	
	if($state=='Accept'){
		//Add video metadata to the DB
		addVideo( $title, $description, $id_owner, $loca, $loca, $date);
	}else if($state=='Ignore'){
		//delete video & thumbnail
		deleteThumbnail_videoAdmin($loca);
	}
	//delete Request
	deleteVideoRequest($id);
	
	if(!empty($_GET['p'])&& isset($_GET['p'])){
		header('refresh:3;url=index.php?p='.$p.'&op=done');
	}else{
		header('refresh:3;url=index.php');
	}
}
?>
<head>
	<title>Admin Panel</title>
	<link type="text/css" rel="stylesheet" href="../css/normalize.css">
	<link type="text/css" rel="stylesheet" href="../css/style.css">
</head>
<body style="margin: 20px auto;">
	<div class="wrapper">
		<div class="content">
			<p>Admin Panel<span class="separate">|</span><a href="../index.php">Home</a><span class="separate">|</span><a href="../inc/logout.php">Logout</a></p>
		</div>
		<center><p>Request ( <?php echo $count;?> )</p></center>
		
		<?php
			if(!isset($allRequests)|| empty($allRequests)){
				echo '<br><br><br><center><< No Upload Request Yet >></center>';
				die();
			}
			foreach($allRequests as $k=>$i){
				adminPreview($i);
			}
		?>			
	</div>
	<div class="content">
	<?php
		for($i=1; $i<=$pages; $i++){
			if($i==1){echo '<a href="index.php">'.$i.'</a>';}
			else echo '<a href="index.php?p='.$i.'">'.$i.'</a>';
			if($i<$pages){echo '<span class="separate"> | </span>';}
		}
	?>
	</div>
</body>