<?php
// Класс записи чата
class Records
{
	public $id;       // Код записи
	public $author;   // Автор записи
	public $to;		  // Recipient
	public $message;  // Сообщение автора
	public $date;     // Дата и время сообщения
	public $status;
	public $path;	  // relative path of image
	public $filename;
	
	public function __construct($id=0, $author='', $recipient = '', $message='', $date='', $st = 0, $pathRel='', $fn='')
	{
		$this->id = $id;
		$this->author = $author;
		$this->to = $recipient;
		$this->message = $message;
		$this->date = $this->convertDate2String($date);
		$this->status = $st;
		$this->path = $pathRel;
		$this->filename = $fn;
	}
	
	// Преобразует дату в строковый вид
	public function convertDate2String($date)
	{
		if (is_numeric($date))
			return date('d.m.Y H:i:s', $date);
		else
			return $date;
	}
}
?>