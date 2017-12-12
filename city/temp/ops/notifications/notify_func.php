<?php
/**
	 * Function for insert data for Push Notifications service
	 * in field `from` and `to` function select id from users table
	 * @var array $params			Array of parametest sending by user
	 * @var int $fromID				ID user which try send push notify
	 * @var int $toID				ID user-recipient to which a message is sent
	 * @var string $sql				simple MySQL query string to insert data to `notifications` table in database 
	 */
	function insertNotify($params){
		global $link;
		$fromID = mysqli_fetch_row($link->query("SELECT id FROM users 
				WHERE username='$params[2]'"))[0];
		$toID = mysqli_fetch_row($link->query("SELECT id FROM users 
				WHERE username='$params[3]'"))[0];
		$sql = "INSERT INTO `notifications` (`unit`, `type`, `from`, `to`, `message`, `status`, `url`) 
				VALUES ('$params[0]', '$params[1]', $fromID, $toID, '$params[4]', 0, '$params[5]')";
//	$link->query($sql);
		if($link->query($sql)) echo 'Данные внесены';
		else echo "SQL: $sql<br>" . 'failed insert notify data: (' . $link->errno . ")" . $link->error;
	}
?>