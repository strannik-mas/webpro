<?php
$elem = $_GET['type'];
if($elem=='agreement'){
	require_once("agreement.php");
}elseif($elem=='feedback'){
	require_once("feedback.php");
}elseif($elem=='edit'){
	require_once("edit.php");
}else{
	require_once("help.php");
}
?>