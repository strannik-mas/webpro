<?php

//echo "1";
// Создание и инициирование базы данных пользователей
require('user.class.php');
//require('userinfo.class.php');

$user = new User();
echo '<pre>';
//var_dump(new UserInfo('', 'strannik', 'qwerty', "city/img", 'bezvih.gif'));
var_dump($user->addOrUpdate(new UserInfo('', 'strannik', 'qwerty', "city/img", 'bezvih.gif')));
echo '</pre>';
//var_dump($res);
//$user->addOrUpdate(new UserInfo('vasya', 'qwerty'));
//$user->addOrUpdate(new UserInfo('zzz', 'zzz'));
//$user->addOrUpdate(new UserInfo('qwerty', 'qwerty'));
?>