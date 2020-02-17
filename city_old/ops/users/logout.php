<?php
// Авторизация пользователя
require('user.class.php');
$rawPost = file_get_contents('php://input');
if ($rawPost)
{
	$userID = json_decode($rawPost);
	$user = new User();
	$user->logout($userID);
}