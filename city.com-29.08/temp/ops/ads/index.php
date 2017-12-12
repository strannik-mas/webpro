<?php
$elem = $_GET['type'];
if($elem=='add'){
	require_once("add.php");
}elseif($elem=='page'){
	require_once("page.php");
}elseif($elem=='edit'){
	require_once("edit.php");
}else{
	require_once("list.php");
}
?>
<link rel="stylesheet" href="./ops/ads/css/style.css" />
<script type="text/javascript" src="./ops/ads/js/core.js"></script>