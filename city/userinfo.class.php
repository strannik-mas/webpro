<?php
/*
** Класс Информация о пользователе
*/
class UserInfo
{
	public $id;
	public $login;		// Логин пользователя
	public $password;   // Пароль пользователя
	public $fName;	// filename of user image
	public $path;	// relative path of user image
	
	public function __construct($id='', $login='', $password='', $pathRel='', $filename='')
	{
		$this->id = $id;
		$this->login = $login;
		$this->password = $password;
		$this->path = $pathRel;
		$this->fName = $filename;

	}
}
?>