<?php
	if($_GET['type'] == help) {
		require_once('helpChat.php');
	}
	else {
		require_once('generalChat.php');
		echo '<script type="text/javascript" src="ops/chat/js/chat.js"></script>';
	}	
?>