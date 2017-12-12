<?php
session_start();
// Определение списка пользователей в режиме online
ini_set('display_errors',1);error_reporting(E_ALL);
require('../users/user.class.php');
// Читаем данные, переданные в POST
$rawPost = file_get_contents('php://input');
//$rawPost = '{"access_token":"cd35bd8191dd3206466212317c5c3309c0077aa3","expires_in":3600,"token_type":"Bearer","scope":null,"refresh_token":"4e632d003078598dbb6977301ff27ffa1e8e397f"}';
// Результат
$onlineUsers = array();
// Объект пользователя
$user = new User();
// Если данные были переданы...
if ($rawPost)
{	
	// Разбор пакета JSON
	$ticket = json_decode($rawPost);	
}else{
	$ticket = (object) $_SESSION;
}
$result = $user->refreshSession($ticket);
//	var_dump($result);
	// Если билет был правильным...
	//if ($result > 0)
	$onlineUsers = $user->getOnlineUsers();
// Заголовки ответа
header('Content-type: text/plain; charset=utf-8');
header('Cache-Control: no-store, no-cache');
header('Expires: ' . date('r'));
// return user list
echo json_encode($onlineUsers);
?>