<?php
global $link;
	if ($_POST) {
		$user = $_POST['username'];
		$pass = $_POST['password'];
		$query = "SELECT * FROM users WHERE username='$user'";
		if ($user && $pass) {
			$check = $link -> query($query);
			$check = mysqli_fetch_assoc($check);
			if ($pass == decrypt($check['pass'])) {
				$userhash = encrypt($check['username']);
				$useracl = encrypt($check['accesslevel']);
				setcookie('userhash', $userhash, time() + (60 * 300), "/");
				setcookie('useracl', $useracl, time() + (60 * 300), "/");
				$link -> query("UPDATE users SET status=1 WHERE username='{$check['username']}'");
			} else {
				echo 'Wrong Credentials';
			}
		} else {
			echo "Wrong data";
		}
	}
?>
