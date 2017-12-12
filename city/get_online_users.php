<?php
// Определение списка пользователей в режиме online
require('user.class.php');

// Читаем данные, переданные в POST
$rawPost = file_get_contents('php://input');
//$rawPost = '{"id":"feed1e53e909ba5e8e8fab83da3ecaf7","valid":true,"name":"mas"}';
// Результат
$onlineUsers = array();

// Если данные были переданы...
if ($rawPost)
{
	// Объект пользователя
	$user = new User();
	// Разбор пакета JSON
	$ticket = json_decode($rawPost);
	$result = $user->refreshSession($ticket);
//	var_dump($result);
	// Если билет был правильным...
	//if ($result > 0)
		$onlineUsers = $user->getOnlineUsers();
}
// Заголовки ответа
header('Content-type: text/plain; charset=utf-8');
header('Cache-Control: no-store, no-cache');
header('Expires: ' . date('r'));
// return user list
echo json_encode($onlineUsers);
?>