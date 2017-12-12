<?php
$elem = $_GET['type'];
if($elem=='agreement'){
	require_once("agreement.php");
}elseif($elem=='feedback'){
	require_once("feedback.php");
}else{
	require_once("help.php");
}
?>