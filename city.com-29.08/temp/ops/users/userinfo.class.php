<?php
/*
** Класс Информация о пользователе
*/
class UserInfo
{
	public $login;		// Логин пользователя
	public $fName;	// filename of user image
	public $path;	// relative path of user image
	
	public function __construct($login='', $pathRel='', $filename='')
	{
		$this->login = $login;
		$this->path = $pathRel;
		$this->fName = $filename;
	}
}
?>