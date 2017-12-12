<?php
/*
** Класс Билет сессии
*/
class Ticket
{
	public $id;			// Идентификатор сессии
	public $valid;		// Правильность билета
	public $name;		// Имя текущего пользователя
	
	public function __construct($id='', $valid=false, $n='')
	{
		$this->id = $id;
		$this->valid = $valid;
		$this->name = $n;
	}
}
?>