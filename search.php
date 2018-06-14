<?php
require('inc/connection.php');
require('inc/function.php');

if(!isset($_GET['s']) || empty($_GET['s']) ){
	header('Location: index.php');
	die();
}

$search = trim(filter_input(INPUT_GET,"s",FILTER_SANITIZE_STRING));

try{
	$q = $db->prepare('SELECT videos.id as vid,title,description,id_owner,vid_loca,date,users.id,username,fullname FROM videos JOIN users WHERE videos.id_owner=users.id AND (title LIKE \'%'.$search.'%\' OR description LIKE \'%'.$search.'%\') ORDER BY videos.id DESC' );
	//$q->bindParam(1, $search);
	//$q->bindParam(2, $search);
	$q->execute();
	$searchResult = $q->fetchALL(PDO::FETCH_ASSOC);
}catch(Exception $e){
	$error_message[] = "Error : ".$e->getMessage();
}

$header = "Search | ".$search;
require('inc/header.php');
?>

<div class="wrapper">

	<p class="title">Search | <?php echo $search;?></p>
	<div class="panel">
	<?php
		if(!isset($searchResult)|| empty($searchResult)){
			echo '<br><br><br><center><< No Result Found >></center>';
		}else{
			foreach($searchResult as $k=>$i){
				searchPreview($i);
			}
		}
	?>	
	</div>
</div>

<?php require('inc/footer.php');?>