<?php
if(status_user()==0){
	echo "No Access";
	break;
}
$elem = $_GET['type'];
if($elem=='login'){
	require_once("login.php");
}elseif($elem=='page'){
	require_once("page.php");
}elseif($elem=='cabinet'){
	require_once("cabinet.php");
}else{
	require_once("list.php");
}
?>