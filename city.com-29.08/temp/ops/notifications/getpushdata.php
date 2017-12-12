<?php
ini_set('display_errors',1);error_reporting(E_ALL);
require('../users/user.class.php');
/*
** Скрипт возвращает сообщения для пользователя
*/
$rawPost = file_get_contents('php://input');

// Если данные были переданы...
if ($rawPost)
{
	// Разбор пакета JSON
	$rec = json_decode($rawPost);
	//var_dump($rec);
	$user = new User();
	$records = $user->showResords($rec, 'notifications');
	
}

// Передаем заголовки и JSON пакет данных
header('Content-type: text/plain; charset=utf-8');
header('Cache-Control: no-store, no-cache');
header('Expires: ' . date('r'));
echo json_encode($records);

