<?php
require('connection.php');
require('function.php');
$user = $_GET['user'];
$vote = $_GET['vote'];
$vid = $_GET['vid'];

$voteid= votedBefore($user, $vid);

if(!empty($voteid)){
	updateVoted($vote, $user, $vid, $voteid);
}else{
	addVote($vote, $user, $vid);
}
$like = getVoteCount($vid, 1);
$dislike = getVoteCount($vid, 0);
?>

<input type="button" name="vote" value="UpVote" width="30" height="30" onclick="getVote(1)">
<span><?php echo $like; ?></span>
<input type="button" name="vote" value="DownVote" width="30" height="30" onclick="getVote(0)">
<span><?php echo $dislike; ?></span>
