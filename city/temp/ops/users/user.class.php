<?php
require('userinfo.class.php');
//echo $_SERVER['DOCUMENT_ROOT'];
require_once($_SERVER['DOCUMENT_ROOT'] . '/temp/ops/chat/records.class.php');
/*
ini_set('display_errors',1);error_reporting(E_ALL);
require_once('./../users/OAuth2/Autoloader.php');
OAuth2\Autoloader::register();
*/

/*
** Класс Пользователь сайта
*/

class User
{
	// База данных пользователей
	private $db;
	
	//database
	private $_params; 			//array from conf.ini file
	
	// Время жизни сессии в секундах
	const SESS_TIMEOUT = 90;
	
	// Констуктуор класса
	public function __construct()
	{
		$this->_params = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/temp/common/conf.ini');
		// Открываем базу данных
//var_dump($this->_params['db.user']);
		$this->db = mysqli_connect($this->_params['db.host'], $this->_params['db.user'], $this->_params['db.pass'], $this->_params['db.name']) or die(mysqli_connect_error());
	}
	/*
	public function getUserID($uName, $hashPass){
		
		if(!$this->db->query("SELECT id FROM users 
				WHERE username='$uName' AND pass = '$hashPass'"));
			echo "SQL: $testSQL<br>" . 'failed get id user: (' . $this->db->errno . ")" . $this->db->error;
		else return false;
		
	}
*/

	/**
	*Function addOrUpdateUser user by login and password or data from social 
	* @var array $userInfo			login and password
	* @var string $sql		simple MySQL query string to insert 
	*/
	// Добваление нового пользователя или изменение существующего
	public function addOrUpdateUser($userInfo)
	{
				
		// Если такого пользователя нет...
		if (! mysqli_fetch_row($this->db->query("SELECT COUNT(username) FROM oauth_users WHERE username='$userInfo[0]'"))[0])
		{
			//echo "string";
			// Добавляем пользователя
			$sql = "INSERT INTO oauth_users (username, password, first_name, last_name) 
				VALUES ('$userInfo[0]', '$userInfo[1]'," . ($userInfo[2] ? "'".$userInfo[2]."'" : "''") .", " . ($userInfo[3] ? "'".$userInfo[3]."'" : "''").")";
			if(!$this->db->query($sql))
				echo "SQL: $sql<br>" . 'failed insert row: (' . $this->db->errno . ")" . $this->db->error;
			/*
			$userId = mysqli_fetch_row($this->db->query("SELECT id FROM users 
				WHERE username='$login' AND pass = '$hash'"))[0];
			$sql = "INSERT INTO images (entid, path, filename) 
				VALUES ($userId, '$userInfo->path', '$userInfo->fName')";

			if(!$this->db->query($sql))
				echo "SQL: $sql<br>" . 'failed insert image row: (' . $this->db->errno . ")" . $this->db->error;
				*/
			else {
				if(!$userInfo[4])
					echo "Вы успешно зарегестрировались!";
			}
		}else{
			if(!$userInfo[4]){
				var_dump($userInfo[4]);
				echo "Такой пользователь уже существует. Смените логин";
			}
			// Меняем ифнормацию о пользователе
			//$this->db->query("UPDATE users SET username = '$login', pass = '$hash' WHERE username = '$login'");
		}			
	}

	public function addSessionData($accToken, $clientID, $uID){
		$flag = false;
		$time = time();
		$sql = "INSERT INTO oauth_access_tokens (access_token, client_id, user_id) 
				VALUES ('$accToken', '$clientID', '$uID')";
		if(!$this->db->query($sql)){
			echo "SQL: $sql<br>" . 'failed insert row: (' . $this->db->errno . ")" . $this->db->error;
			$flag = false;
		}
		else $flag = true;

		$sql = "INSERT INTO session (sess_id, user_id, last_request) 
				VALUES ('$accToken', '$uID', $time)";
		if(!$this->db->query($sql)){
			echo "SQL: $sql<br>" . 'failed insert row: (' . $this->db->errno . ")" . $this->db->error;
			$flag = false;
		}
		else $flag = true;
		if($flag)
			return $this->getOnlineUsers();
	}

	// Обновление информации о сессии пользователя
	public function refreshSession($ticket)
	{
		$time = time();
		if(isset($ticket->access_token)){
			
			$sessionId = mysqli_fetch_row($this->db->query("SELECT sess_id FROM session WHERE sess_id = '$ticket->access_token'"))[0];
			if($sessionId){
				// Обновление сессии		
				$this->db->query("UPDATE session SET last_request = $time 
					WHERE sess_id = '$ticket->access_token'");
			}else{
				$userId = mysqli_fetch_row($this->db->query("SELECT user_id FROM oauth_access_tokens WHERE access_token ='$ticket->access_token'"))[0];
				$this->db->query("INSERT INTO session (sess_id, user_id, last_request) 
					VALUES ('$ticket->access_token', '$userId', $time)") or die($this->db->error);
			}
		}		
		$rowsChanged = $this->db->affected_rows;
		$deadTime = $time - User::SESS_TIMEOUT;
		$this->db->query("DELETE FROM session WHERE last_request < $deadTime");
		
		$this->db->query("DELETE FROM oauth_access_tokens WHERE UNIX_TIMESTAMP(expires) < $time");

		$this->db->query("DELETE FROM oauth_refresh_tokens WHERE UNIX_TIMESTAMP(expires) < $time");
		
		return $rowsChanged;
				
	}
	public function logout($id){
		$this->db->query("DELETE FROM session WHERE sess_id = $id");
	}
	
	
/*	
	public function deleteFromSession($id){
		$deadTime = time() - User::SESS_TIMEOUT;
		$this->db->query("DELETE FROM session WHERE sess_id = $id");
	}
*/
	// Возвращает список пользователей ONLINE в виде массива объектов UserInfo
	public function getOnlineUsers()
	{
		$res = $this->db->query("SELECT username 
				FROM oauth_users, session
				WHERE username = session.user_id");
		$users = array();
		while ($row = mysqli_fetch_row($res)){
			$users[] = new UserInfo(
				$row[0], 
				mysqli_fetch_row($this->db->query("SELECT `path`  FROM `images` WHERE entid='$row[0]'"))[0],
				mysqli_fetch_row($this->db->query("SELECT `filename`  FROM `images` WHERE entid='$row[0]'"))[0]
			);		
		}
		return $users;
	}

	public function getAllUsers(){
		$res = $this->db->query("SELECT * FROM oauth_users");
		while ($row = mysqli_fetch_assoc($res)){
			$uArr[$row['username']] = array('password' => $row['password'], 'first_name' => $row['first_name'], 'last_name' => $row['last_name']);
		}
		return $uArr;
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
		$res = $this->db->query("SELECT * FROM $tableName ORDER BY `date` DESC");
		$records = array();
		if ($tableName == 'notifications')
			$sessID = $recTicket->access_token;
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
							$row['from'], 
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
							mysqli_fetch_row($this->db->query("SELECT username FROM oauth_users 
				WHERE username='" . $row['from'] . "'"))[0], 
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