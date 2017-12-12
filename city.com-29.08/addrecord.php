<?php
require('user.class.php');
/*
** Скрипт возвращает последние записи в гостевой книге
*/

// Читаем данные, переданные в POST
$rawPost = file_get_contents('php://input');
//$rawPost = '{"login":"admin2","password":"admin2"}';

// Заголовки ответа
header('Content-type: text/plain; charset=utf-8');
header('Cache-Control: no-store, no-cache');
header('Expires: ' . date('r'));

// Если данные были переданы...
if ($rawPost)
{
	// Разбор пакета JSON
	$record = json_decode($rawPost);
//	print_r($record);
	// Открытие БД
	$user = new User();
	$result = $user->addRecord($record);
	
	
	// Возврат результата
	echo json_encode(
		array
		(
			'result' => 'OK', 
			'lastInsertRowId' => $result
		)
	);
}
else
{
	// Данные не переданы
	echo json_encode(
		array
		(
			'result' => 'No data'
		)
	);
}
?>