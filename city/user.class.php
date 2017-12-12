<?php
require('userinfo.class.php');
require('ticket.class.php');
require_once('records.class.php');

/*
** Класс Пользователь сайта
*/

class User
{
	// База данных пользователей
	private $db;
	
	//database
	const DB_HOST = 'localhost';
	const DB_NAME = 'city';
	const DB_LOGIN = 'city';
	const DB_PASSWORD = 'city12#';
	
	// Время жизни сессии в секундах
	const SESS_TIMEOUT = 180;
	
	// Констуктуор класса
	public function __construct()
	{
		// Открываем базу данных
		$this->db = mysqli_connect(self::DB_HOST, self::DB_LOGIN, self::DB_PASSWORD, self::DB_NAME) or die(mysqli_connect_error());
		//var_dump($this->db);
	}
	/*
	public function getUserID($uName, $hashPass){
		
		if(!$this->db->query("SELECT id FROM users 
				WHERE username='$uName' AND pass = '$hashPass'"));
			echo "SQL: $testSQL<br>" . 'failed get id user: (' . $this->db->errno . ")" . $this->db->error;
		else return false;
		
	}
	*/
	// Добваление нового пользователя или изменение существующего
	public function addOrUpdate($userInfo)
	{
		
		$login = $userInfo->login;
		$hash = md5($login . $userInfo->password);
		//var_dump($userInfo->path); exit();
		
		// Если такого пользователя нет...
		if (! mysqli_fetch_row($this->db->query("SELECT COUNT(id) FROM users 
				WHERE username='$login' AND pass = '$hash'"))[0])
		{
			//echo "string";
			// Добавляем пользователя
			$sql = "INSERT INTO users (username, pass) 
				VALUES ('$login', '$hash')";
			if(!$this->db->query($sql))
				echo "SQL: $sql<br>" . 'failed insert row: (' . $this->db->errno . ")" . $this->db->error;
			$userId = mysqli_fetch_row($this->db->query("SELECT id FROM users 
				WHERE username='$login' AND pass = '$hash'"))[0];
			$sql = "INSERT INTO images (entid, path, filename) 
				VALUES ($userId, '$userInfo->path', '$userInfo->fName')";
			if(!$this->db->query($sql))
				echo "SQL: $sql<br>" . 'failed insert image row: (' . $this->db->errno . ")" . $this->db->error;
				
		}else{
			echo "2";
			// Меняем ифнормацию о пользователе
			//$this->db->query("UPDATE users SET username = '$login', pass = '$hash' WHERE username = '$login'");
		}
			
	}
	
	// Проверка данных пользователя и возврат нового билета
	public function validate($userInfo)
	{
		$login = $userInfo->login;
		$hash = md5($login . $userInfo->password);
		// Если такой пользователь есть, получим его ID
		$userId = mysqli_fetch_row($this->db->query("SELECT id FROM users 
				WHERE username='$login' AND pass = '$hash'"))[0];
		
		$userName = mysqli_fetch_row($this->db->query("SELECT username FROM users 
				WHERE id = $userId"))[0];
//		var_dump($userName);		exit();
		if ($userId)
		{
			// Формируем новый билет
			$time = time();
			$ticket = new Ticket(md5($hash . $time), true, $userName);
			$this->db->query("INSERT INTO session (sess_id, user_id, last_request) 
				VALUES ('$ticket->id', $userId, $time)") or die($this->db->error);
			
			return $ticket;
		}	
		else
		{
			// Пользователь не найден - возвращаем пустой билет
			return new Ticket();
		}
	}
	
	// Обновление информации о сессии пользователя
	public function refreshSession($ticket)
	{
		$time = time();
		
		// Обновление сессии		
		$this->db->query("UPDATE session SET last_request = $time 
				WHERE sess_id = '$ticket->id'");
		$rowsChanged = $this->db->affected_rows;
		$deadTime = $time - User::SESS_TIMEOUT;
		$this->db->query("DELETE FROM session WHERE last_request < $deadTime");
		return $rowsChanged;
	}
	
//	public function deleteFromSession($id){
//		$deadTime = time() - User::SESS_TIMEOUT;
//		$this->db->query("DELETE FROM session WHERE sess_id = $id");
//	}

	// Возвращает список пользователей ONLINE в виде массива объектов UserInfo
	public function getOnlineUsers()
	{
		$res = $this->db->query("SELECT id, username 
				FROM users, session
				WHERE users.id = session.user_id");
		$users = array();
		while ($row = mysqli_fetch_row($res)){
			$users[] = new UserInfo(
				$row[0], 
				$row[1],
				'',
				mysqli_fetch_row($this->db->query("SELECT `path`  FROM `images` WHERE entid=$row[0]"))[0],
				mysqli_fetch_row($this->db->query("SELECT `filename`  FROM `images` WHERE entid=$row[0]"))[0]
			);		
		}
		return $users;
	}
	
	//add record to chat table
	public function addRecord($rec){
		$date = time();
		$userId = mysqli_fetch_row($this->db->query("SELECT user_id FROM session 
				WHERE sess_id='$rec->author'"))[0];
		$this->db->query("INSERT INTO `chat`(`from`, `to`, `message`, `date`, `status`)
		VALUES ('$userId', '$rec->recipient', '$rec->message', $date, $rec->status)") or die($this->db->error);

		//insert into notifications
		$this->db->query("INSERT INTO `notifications`(`unit`, `type`, `from`, `to`, `message`, `date`, `status`, `url`)
		VALUES ('chat', 'message', '$userId', '$rec->recipient', '$rec->message', $date, 0, 'http://city.com/index.php')") or die($this->db->error);

		$chatId = mysqli_fetch_row($this->db->query("SELECT `id` FROM `chat` 
				WHERE `from`='$rec->author' AND `date` = '$date'"))[0];
		return $chatId;
	}
	
	/**
	 * 
	 * @param stdObject $recTicket
	 * @param string $tableName			Name of used table
	 * @return \Records					Array of records from used table
	 */
	
	public function showResords($recTicket = '', $tableName){
		$res = $this->db->query("SELECT * FROM $tableName ORDER BY `date`");
		$records = array();
		if ($tableName == 'notifications')
			$sessID = $recTicket->id;
		else
			$sessID = $recTicket->from;
		while ($row = mysqli_fetch_assoc($res))
		{
			if($recTicket){
				$userId = mysqli_fetch_row($this->db->query("SELECT user_id FROM session 
				WHERE sess_id='$sessID'"))[0];
//				print_r($row);
				if($tableName == 'chat'){
					if ($userId == $row['from'] || $row['to'] == $userId || $row['to'] == 0) {
						$this->db->query("UPDATE $tableName SET status = 1 
				WHERE id = '" . $row['id'] . "'");
						$records[] = new Records(
							$row['id'], 
							mysqli_fetch_row($this->db->query("SELECT username FROM users 
				WHERE id='" . $row['from'] . "'"))[0], 
							$row['to'], 
							$row['message'], 
							$row['date'], 
							$row['status'],
							mysqli_fetch_row($this->db->query("SELECT `path`  FROM `images` 
				WHERE entid='" . $row['from'] . "'"))[0],
							mysqli_fetch_row($this->db->query("SELECT filename  FROM images 
				WHERE entid='" . $row['from'] . "'"))[0]
						);
					}
				}else if($tableName == 'notifications'){
					if($row['status'] == 1) continue;
					if ($row['to'] == $userId) {
						$this->db->query("UPDATE $tableName SET `status` = 1 WHERE `id` = '" . $row['id'] . "'");
						$records[] = new Records(
							$row['id'], 
							mysqli_fetch_row($this->db->query("SELECT username FROM users 
				WHERE id='" . $row['from'] . "'"))[0], 
							$row['to'], 
							$row['message'], 
							$row['date'], 
							$row['status'],
							$row['url']
						);
					}
				}
				
			}
			
		}
		return $records;
	}
	
	public function getLastMod(){
		$lastMod = mysqli_fetch_row($this->db->query('SELECT MAX(date) AS max_date FROM chat'))[0];
		return $lastMod;
	}
	
}	
/*
$a = new User;
//$uI = json_decode('{"id":"790a124066040713163fb4374eefb42d","valid":true,"name":"alex"}');
//echo(1);
echo '<pre>';
var_dump($a->addOrUpdate(new UserInfo('', 'strannik', 'qwerty', "city/img", 'bezvih.gif')));
//var_dump(new UserInfo('', 'strannik', 'qwerty', "city/img", 'bezvih.gif'));
echo '</pre>';
*/
?>