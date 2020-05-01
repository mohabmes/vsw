<?php
require('inc/connection.php');
require('inc/function.php');

$header = "404";
require('inc/header.php');


?>
<style>

.hugetxt, .ctxt{
	color: grey;
	width: 100%;
	text-align:center;
	font-size:10em;
}

.hugetxt{
	margin-bottom:0;
}
.ctxt{
	font-size:1em;
	color: black;
	margin:0;
	margin-bottom:130px;
}
</style>

<p class="hugetxt">404</p>
<p class="ctxt">The link you followed may be broken.</p>
	

<?php require('inc/footer.php');?>
