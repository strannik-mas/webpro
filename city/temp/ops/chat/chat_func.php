<?php
function add_chat() {
	global $link;
	$uid = data_user('uid');
	$city = strlen($_COOKIE['chatcity'])>0 ? $_COOKIE['chatcity'] : data_user('city');
	$message = $_POST['message'];
	$parent = $_POST['parent'];
	$link -> query("INSERT INTO `chat`(`from`, `message`, `city`, `parent`) VALUES ('$uid', '$message', '$city', '$parent')") or die($link -> error);
	if($parent>0){
		$link -> query("INSERT INTO `notifications`(`unit`, `type`, `from`, `message`, `status`) VALUES ('chat', 'message', '{$uid}', '{$message}', 0)") or die($link -> error);
	}
	$link -> query("UPDATE users SET messages = (messages + 1) WHERE uid='{$uid}'");
	echo list_chat();
}

function list_chat() {
	global $link;
	$city = strlen($_COOKIE['chatcity'])>0 ? $_COOKIE['chatcity'] : data_user('city');
	echo $query = "SELECT t.* FROM (SELECT * FROM `chat` WHERE `city` LIKE '%{$city}%' ORDER BY `chat`.id DESC LIMIT 200) t ORDER BY t.id ASC";
	$chats = $link -> query($query);
	while ($chat = mysqli_fetch_assoc($chats)) {
		$id = $chat['id'];
		$uuid = $chat['from'];
		$message = $chat['message'];
		$date = $chat['date'];
		$parent = $chat['parent'];
		$username = elem_ad($uuid, 'username', 'users');
		$avatar = htmlspecialchars(phpThumbURL('src=../../' . avatar2_user($uuid) . '&w=68&h=68&zc=1', './common/phpthumb/phpThumb.php'));
		if($parent>0){
			$answer = '<script>$( document ).ready(function() { $("#record_'.$id.'").appendTo("#record_'.$parent.'"); });</script>';
			$class = 'answer';
		}else{
			$answer = '';
			$class = '';
		}
		
			echo <<<EOT
<div id="record_$id" class="record $class">
	<a class="avatar" href="index.php?ops=users2&type=apge&uid=$uuid"><img src="$avatar" alt="avatar" /></a>
	<div class="name">$username</div>
	<div class="date">$date</div>
	<div class="message">$message</div>
	<div class="reply" onclick="$('#parent').val('{$id}'); $('.message-function h2').html('Reply');">Reply</div>
</div>
$answer
EOT;
	}
echo "<script>$('#scrollbar').scrollTop($('#scrollbar')[0].scrollHeight);</script>";
}

function add_help() {
	global $link;
	$uid = data_user('uid');
	$city = $_GET['city'] ? $_GET['city'] : data_user('city');
	$message = $_POST['message'];
	$parent = $_POST['parent'];
	$link -> query("INSERT INTO `helpchat`(`from`, `message`, `city`, `parent`) VALUES ('$uid', '$message', '$city', '$parent')") or die($link -> error);
	if($parent>0){
		$link -> query("INSERT INTO `notifications`(`unit`, `type`, `from`, `message`, `status`) VALUES ('help', 'message', '{$uid}', '{$message}', 0)") or die($link -> error);
	}
	return list_help();
}

function list_help() {
	global $link;
	$city = $_GET['city'] ? $_GET['city'] : data_user('city');
	$query = "SELECT t.* FROM (SELECT * FROM `helpchat` WHERE `city` LIKE '%{$city}%' ORDER BY `chat`.id DESC LIMIT 200) t ORDER BY t.id ASC";
	$chats = $link -> query($query);
	while ($chat = mysqli_fetch_assoc($chats)) {
		$id = $chat['id'];
		$uuid = $chat['from'];
		$message = $chat['message'];
		$date = $chat['date'];
		$parent = $chat['parent'];
		$username = elem_ad($uuid, 'username', 'users');
		$avatar = htmlspecialchars(phpThumbURL('src=../../' . avatar2_user($uuid) . '&w=68&h=68&zc=1', './common/phpthumb/phpThumb.php'));
		if($parent>0){
			$answer = '<script>$("#record_'.$id.'").appendTo("#record_'.$parent.'");</script>';
			$class = 'answer';
		}else{
			$answer = '';
			$class = '';
		}
		
			echo <<<EOT
<div id="record_$id" class="record $class">
	<a class="avatar" href="index.php?ops=users2&type=apge&uid=$uuid"><img src="$avatar" alt="avatar" /></a>
	<div class="name">$username</div>
	<div class="date">$date</div>
	<div class="message">$message</div>
	<div class="reply" onclick="$('#parent').val('{$id}'); $('.message-function h2').html('Reply');">Reply</div>
</div>
$answer
EOT;
	}
echo "<script>$('#scrollbar').scrollTop($('#scrollbar')[0].scrollHeight);</script>";
}

function getLastModified() {
	global $link;
	$lastMod = mysqli_fetch_row($link -> query('SELECT MAX(date) AS max_date FROM chat'))[0];
	return $lastMod;
}

function getMiniChat($params) {
	global $link;
	$uid = data_user('uid');
	$uid2 = is_array($params) ? $params[0] : $params;
	$sql = "SELECT t1.id, t1.from, t1.to, t1.message, t1.date, t2.path, t2.filename, t3.username 
			FROM privatechat t1
			LEFT JOIN images t2
			ON t2.entid = t1.from AND t2.unit='user' AND t2.entity = 'avatar'
			LEFT JOIN users t3
			ON t1.from = t3.uid
			WHERE (`from` = '$uid' AND `to` = '$uid2') OR (`to` = '$uid' AND `from` = '$uid2')
			ORDER BY t1.date";
	if (!$res = $link -> query($sql)) {
		echo "SQL: $sql<br>" . 'failed get mini chat messages: (' . $link -> errno . ")" . $link -> error;
	} else {

		$link -> query("UPDATE privatechat SET status = 1 WHERE `to` = '" . $uid . "'");
		while ($arr = mysqli_fetch_assoc($res)) {
			$time = $arr['date'];
			$message = $arr['message'];
			$from = $arr['from'];
			$username = elem_ad($from, 'username', 'users');
			$avatar = htmlspecialchars(phpThumbURL('src=../../' . avatar2_user($from) . '&w=68&h=68&zc=1', './common/phpthumb/phpThumb.php'));
			@$result .= <<<EOT
<div class="chat-inner">
	<div class="chat-item row">
		<div class="chat-user-info">
			<div class="chat-user">
				<a><span class="img-inner"><img src="$avatar" alt="" class="img-circle img-responsive mCS_img_loaded"></span></a>
			</div>
			<div class="chat-message-info">
				<a class="user-name">$username</a><span><span class="data">$time</span></span>
			</div>
		</div>
		<div class="chat-message">
			<p>
				$message
			</p>
		</div>
	</div>
</div>
EOT;
		}
		$result .= "<script>$('#scrollbarminichat').scrollTop($('#scrollbarminichat')[0].scrollHeight);</script>";
		return $result;
	}
}

function getFullChat($params) {
	global $link;
	$uid = data_user('uid');
	$uid2 = is_array($params) ? $params[0] : $params;
	$sql = "SELECT t1.id, t1.from, t1.to, t1.message, t1.date, t2.path, t2.filename, t3.username 
			FROM privatechat t1
			LEFT JOIN images t2
			ON t2.entid = t1.from AND t2.unit='user' AND t2.entity = 'avatar'
			LEFT JOIN users t3
			ON t1.from = t3.uid
			WHERE (`from` LIKE '%$uid%' AND `to` LIKE '%$uid2%') OR (`to` LIKE '%$uid%' AND `from` LIKE '%$uid2%')
			ORDER BY t1.date";
	if (!$res = $link -> query($sql)) {
		echo "SQL: $sql<br>" . 'failed get mini chat messages: (' . $link -> errno . ")" . $link -> error;
	} else {

		$link -> query("UPDATE privatechat SET status = 1 WHERE `to` LIKE '%" . $uid . "%'");
		while ($arr = mysqli_fetch_assoc($res)) {
			$time = $arr['date'];
			$message = $arr['message'];
			$from = $arr['from'];
			$username = elem_ad($from, 'username', 'users');
			$avatar = htmlspecialchars(phpThumbURL('src=../../' . avatar2_user($from) . '&w=68&h=68&zc=1', './common/phpthumb/phpThumb.php'));
			@$result .= <<<EOT
<div class="chat-inner">
	<div class="chat-item row">
		<div class="chat-user">
			<a href="index.php?ops=users2&type=page&uid={$from}"><span class="img-inner"><img src="{$avatar}" alt="user" class="img-circle img-responsive"></span></a>
		</div>
		<div class="chat-message">
			<div class="chat-message-info">
				<a href="index.php?ops=users2&type=page&uid={$from}" class="user-name">{$username}</a>
				<span class="pull-right"><span class="data">{$time}</span></span>
			</div>
			<p>
				{$message}
			</p>
		</div>
	</div>
</div>
EOT;
		}
		$result .= "<script>$('.mCustomScrollbar').scrollTop($('.mCustomScrollbar')[0].scrollHeight);</script>";
		return $result;
	}
}

function addPrivateMessage($postParams) {
	global $link;
	$params = $_POST;
	$from = data_user('uid');
	$to = $params['to'];
	$username = data_user('username');
	$avatar = "/" . $_SERVER['HTTP_HOST'] . "/" . avatar2_user($uid);
	$time = date("Y-m-d H:i:s");
	$message = $params['message'];
	$url = "index.php?ops=users2&type=cabinet";

	$query = "INSERT INTO notifications SET `unit`='user', `type`='message', `message`='{$message}', `from`='{$from}', `to`='{$to}', `url`='{$url}', `status`=0";
	$link -> query($query);

	$sql = "INSERT INTO `privatechat`(`from`, `to`, `message`, `status`)
		VALUES ('$from', '{$to}', '{$message}', 0)";
	if (!$resComment = $link -> query($sql)) {
		echo "SQL: $sql<br>" . 'failed to add message to mini-chat: (' . $link -> errno . ")" . $link -> error;
	} else {
		echo getMiniChat($to);
	}

}

function addPrivateMessageF($postParams) {
	global $link;
	$params = $_POST;
	$from = data_user('uid');
	$to = $params['to'];
	$username = data_user('username');
	$avatar = "/" . $_SERVER['HTTP_HOST'] . "/" . avatar2_user($uid);
	$time = date("Y-m-d H:i:s");
	$message = $params['message'];
	$url = "index.php?ops=users2&type=cabinet";

	$query = "INSERT INTO notifications SET `unit`='user', `type`='message', `message`='{$message}', `from`='{$from}', `to`='{$to}', `url`='{$url}', `status`=0";
	$link -> query($query);

	$sql = "INSERT INTO `privatechat`(`from`, `to`, `message`, `status`)
		VALUES ('$from', '{$to}', '{$message}', 0)";
	if (!$resComment = $link -> query($sql)) {
		echo "SQL: $sql<br>" . 'failed to add message to mini-chat: (' . $link -> errno . ")" . $link -> error;
	} else {
		echo getFullChat($to);
	}

}
