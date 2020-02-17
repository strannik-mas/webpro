<?php
require('../users/user.class.php');
/*
** Скрипт возвращает последние записи в чате
*/
$rawPost = file_get_contents('php://input');
//$rawPost = '{"from":"1c83eb77814ce9b465c7a26c2137afaf","to":"38"}';

define('MAX_RECORDS', 10);
$user = new User();
// Если данные были переданы...
if ($rawPost)
{
	// Разбор пакета JSON
	$rec = json_decode($rawPost);	
	$records = $user->showResords($rec, 'chat');
	
}else{
	$ticket = (object) $_SESSION;
	$records = $user->showResords($ticket, 'chat');
}
$lastMod = $user->getLastMod();

// Передаем заголовки и JSON пакет данных
header('Content-type: text/plain; charset=utf-8');
header('Cache-Control: no-store, no-cache');
header('Expires: ' . date('r'));
header('Last-Modified: ' . date('r', $lastMod));
echo json_encode($records);

?>