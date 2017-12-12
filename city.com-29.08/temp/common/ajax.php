<?php
include ("../common.inc.php");
//require_once ($_SERVER['DOCUMENT_ROOT'] . '/temp/ops/users/user.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/temp/ops/tableeditor/tableeditor.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/temp/ops/maps/map_func.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/temp/ops/chat/chat_func.php');
if ($_GET) {
	$func = $_GET['func'];
	if($func == "insertNotify"){
		require_once($_SERVER['DOCUMENT_ROOT'] . '/temp/ops/notifications/notify_func.php');
	}
	$data = $_GET['params'];
	if ($data && $func != 'filterLabels')
		$data = explode(',', $data);
	elseif($data && $func == 'filterLabels')
		$data = explode('|', $data);
//	var_dump($data);
}
if ($_POST) {
	$func = $_POST['func'];
	$data = $_POST;
	
}
if ($func)
	ajaxfunc($func, $data);

function ajaxfunc($func, $data) {
	$out = '';

	if ($func == "addOrUpdateUser") {
		$user = new User();
		$out .= $user -> addOrUpdateUser($data);
	} else
		$out .= $func($data);
	echo $out;
}
?>