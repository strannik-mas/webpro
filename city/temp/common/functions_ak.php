<?php
require_once ('phpthumb/phpThumb.config.php');
function npr($param) {
	echo '<pre>';
	print_r($param);
	echo '<pre/><br />';
}

function generateRandomString($length = 16) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

function pagination($items, $ipp = 10, $max = 100, $ops, $type) {
	$page = $_GET['page'] ? $_GET['page'] : 1;
	$out .= "<div id='pagination' class='plagination'><ul>";
	if ($page > 1) {
		$out .= "<li><a class=\"plag-arrows\" href=\"index.php?ops=" . $ops . "&type=" . $type . "&page=" . ($page - 1) . "\">&laquo;</a></li>";
	}
	$pages = ceil($items / $ipp);
	$x = 0;
	for ($i = 1; $i <= $pages; $i++) {
		if ($i == $page) {
			$active = " class='active' ";
		} else {$active = '';
		}
		$out .= "<li><a " . $active . " href=\"index.php?ops=" . $ops . "&type=" . $type . "&page=" . $i . "\">" . $i . "</a></li>";
	}
	if ($pages != $page) {
		$out .= "<li><a class=\"plag-arrows\" href=\"index.php?ops=" . $ops . "&type=" . $type . "&page=" . ($page + 1) . "\">&raquo;</a></li>";
	}
	$out .= "</ul></div>";

	if ($ipp < $items) {
		return $out;
	}
}

function encrypt($decrypted, $password = '43bvr&^F', $salt = 'vwer564UIOHG&#!#.,/;;:') {
	$key = hash('SHA256', $salt . $password, true);
	srand();
	$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC), MCRYPT_RAND);
	if (strlen($iv_base64 = rtrim(base64_encode($iv), '=')) != 22)
		return false;
	$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $decrypted . md5($decrypted), MCRYPT_MODE_CBC, $iv));
	return $iv_base64 . $encrypted;
}

function decrypt($encrypted, $password = '43bvr&^F', $salt = 'vwer564UIOHG&#!#.,/;;:') {
	$key = hash('SHA256', $salt . $password, true);
	$iv = base64_decode(substr($encrypted, 0, 22) . '==');
	$encrypted = substr($encrypted, 22);
	$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode($encrypted), MCRYPT_MODE_CBC, $iv), "\0\4");
	$hash = substr($decrypted, -32);
	$decrypted = substr($decrypted, 0, -32);
	if (md5($decrypted) != $hash)
		return false;
	return $decrypted;
}

function cookie($params){
	$name = $params[0];
	$value = $params[1];
	$secs = $params[2];
	echo setcookie($name, $value, time() + $secs, "/");
}

//ADS
function add_ad($data) {
	global $link;
	// npr($data);
	$user = data_user('uid');
	$link -> query("INSERT INTO ads SET uid='{$data['uid']}', slug='{$data['uid']}', name='{$data['name']}', `group`='{$data['group']}', `desc`='{$data['desc']}', price='{$data['price']}', ptype='{$data['check']}', city='{$data['adress']}', phone='{$data['phone']}', phone2='{$data['phone2']}', status=1, author='{$user}'");
	$link -> query("UPDATE images SET temp=0 WHERE entid='{$data['uid']}'");
	$link -> query("UPDATE users SET ads = (ads + 1) WHERE username='{$user}'");

	$result = "Submit succesful";
	return $result;
}

function draft_ad($data) {
	global $link;
	// npr($data);
	$link -> query("INSERT INTO ads SET uid='{$data['uid']}', slug='{$data['uid']}', name='{$data['name']}', `group`='{$data['group']}', `desc`='{$data['desc']}', price='{$data['price']}', ptype='{$data['check']}', city='{$data['adress']}', phone='{$data['phone']}', phone2='{$data['phone2']}', status=2");
	$link -> query("UPDATE images SET temp=0 WHERE entid='{$data['uid']}'");

	$result = "Draft Created";
	return $result;
}

function temp_ad($data) {
	global $link;
	// npr($data);
	$link -> query("INSERT INTO ads SET uid='{$data['uid']}', slug='{$data['uid']}', name='{$data['name']}', `group`='{$data['group']}', `desc`='{$data['desc']}', price='{$data['price']}', ptype='{$data['check']}', city='{$data['adress']}', phone='{$data['phone']}', phone2='{$data['phone2']}', status=3");
	$link -> query("UPDATE images SET temp=0 WHERE entid='{$data['uid']}'");

	$result = preview_ad($data['uid']);
	return $result;
}

function elem_ad($uid, $elem, $table) {
	global $link;
	$item = $link -> query("SELECT * FROM {$table} WHERE uid='{$uid}'");
	$item = mysqli_fetch_array($item);
	// npr($item);
	$result = $item[$elem];

	return $result;
}

function elem_ad_id($id, $elem, $table) {
	global $link;
	$item = $link -> query("SELECT * FROM {$table} WHERE id={$id}");
	$item = mysqli_fetch_array($item);
	// npr($item);
	$result = $item[$elem];

	return $result;
}

function images_ad($uid, $limit = 1000) {
	global $link;
	$result = '';
	$items = $link -> query("SELECT * FROM images WHERE entid='{$uid}' ORDER BY id ASC LIMIT {$limit}");
	while ($item = mysqli_fetch_assoc($items)) {
		$path = "{$item['path']}/{$item['filename']}";
		$result .= '<img src="' . htmlspecialchars(phpThumbURL('src=../../' . $path . '&w=263', './common/phpthumb/phpThumb.php')) . '">';
	}

	echo $result;
}

function images_src_ad($uid, $limit = 1000) {
	global $link;
	$result = '';
	$items = $link -> query("SELECT * FROM images WHERE entid='{$uid}' ORDER BY id ASC LIMIT {$limit}");
	while ($item = mysqli_fetch_assoc($items)) {
		$result[] = $item['path'] . "/" . $item['filename'];
	}

	return $result;
}

function preview_ad($uid) {
	$result = '';
	$result .= '<div>' . elem_ad($uid, "name") . '</div>';
	$result .= '<div>' . elem_ad($uid, "desc") . '</div>';
	$result .= '<div>' . elem_ad($uid, "price") . '</div>';
	$result .= '<div>' . elem_ad($uid, "ptype") . '</div>';
	$result .= '<div>' . elem_ad($uid, "city") . '</div>';
	$result .= '<div>' . elem_ad($uid, "phone") . '</div>';
	$result .= '<div>' . elem_ad($uid, "phone2") . '</div>';
	$result .= '<div>' . images_ad($uid) . '</div>';

	return $result;
}

function list_ad($data) {
	global $link;

	$data = $_POST ? $_POST : explode(',', $data);
	// npr($data);
	@$userid = $_GET['userid'];

	$ipp = 2;
	$max = 100;
	$page = $_GET['page'] ? $_GET['page'] : 1;

	if (!$_POST) {
		$limit = ($page - 1) * $ipp . ", " . $ipp;
	}

	$where = $data['images'] == 1 ? ' LEFT JOIN images ON images.entid = a.uid WHERE 1 ' : ' WHERE 1 ';
	$where .= strlen($userid) > 0 ? " AND a.`author` LIKE '%{$userid}%' " : '';
	$where .= strlen($data['search']) > 0 ? ' AND a.name LIKE "%' . $data['search'] . '%" ' : '';
	$where .= is_numeric($data['group']) ? ' AND a.`group` = ' . $data['group'] . ' ' : '';
	$where .= isset($_GET['group']) ? ' AND a.`group` = "' . $_GET['group'] . '" ' : '';
	$where .= $data['min-price'] > 0 ? ' AND a.price >= "' . $data['min-price'] . '" ' : '';
	$where .= $data['max-price'] > 0 ? ' AND a.price <= "' . $data['max-price'] . '" ' : '';

	$result = '';
	$order = isset($order) ? ' ORDER BY a.' . $order . ' DESC' : ' ORDER BY a.id DESC ';
	$limit = isset($limit) ? ' LIMIT ' . $limit : ' LIMIT 100';
	$query = "SELECT * FROM ads as a {$where} {$order} {$limit}";
	// echo $query;
	$items = $link -> query($query);
	// npr($items);
	if (!$items) {
		return 'No Results!';
		break;
	}

	$query2 = "SELECT * FROM ads as a {$where}";
	$itemscount = $link -> query($query2);
	$count = mysqli_num_rows($itemscount);

	while ($item = mysqli_fetch_assoc($items)) {
		$ptype = ($item['ptype'] == 1) ? 'Торг' : '';
		$group = $item['group'];
		$groupname = $link -> query("SELECT * FROM ad_groups WHERE id = '{$group}'");
		$groupname = mysqli_fetch_assoc($groupname);
		$groupname = $groupname['name'];
		$result .= '
		<div class="notice-item">
		' . edit_form_ad($item['author'], $item['uid']) . '
			<div class="notice-img">
				<img src="' . htmlspecialchars(phpThumbURL('src=../../' . images_src_ad($item['uid'], 1)[0] . '&w=263', './common/phpthumb/phpThumb.php')) . '">
			</div>

			<div class="notice-desc">
				<h2>' . $item['name'] . '</h2>
				<span class="price pull-right"><strong>' . $item['price'] . ' Руб. </strong><strong>' . $ptype . '</strong></span>
				<div class="notice-bottom">
					<div class="notice-link-inner">
						<a href="index.php?ops=ads&type=list&group=' . $group . '" class="notice-link">' . $groupname . '</a>
					</div>
					<div class="pull-right">
						<a href="index.php?ops=ads&type=page&uid=' . $item['uid'] . '" class="more">Подробнее</a>
					</div>
					<div class="data"><span>' . $item['timestamp'] . '</span></div>
				</div>
			</div>
			' . delete_form_ad($item['uid']) . '
		</div>
		';
	}

	if (!$_POST) {
		$result .= pagination($count, $ipp, $max, 'ads', 'list');
	}
	return $result;
}

function similar_ad($data) {
	global $link;
	$data = $_POST ? $_POST : explode(',', $data);
	$city = $data[0];

	$result = '';
	$query = "SELECT * FROM ads WHERE city LIKE '%{$city}%' ORDER BY id DESC LIMIT 3";
	// echo $query;
	$items = $link -> query($query);
	// npr($items);

	while ($item = mysqli_fetch_assoc($items)) {
		$uid = $item['uid'];
		$ptype = ($item['ptype'] == 1) ? 'Торг' : '';
		$group = $item['group'];
		$groupname = $link -> query("SELECT * FROM ad_groups WHERE id = '{$group}'");
		$groupname = mysqli_fetch_assoc($groupname);
		$groupname = $groupname['name'];
		$name = $item['name'];
		$price = $item['price'];
		$time = $item['timestamp'];
		$avatar = htmlspecialchars(phpThumbURL('src=../../' . images_src_ad($item['uid'], 1)[0] . '&w=200&h=150&zc=1', './common/phpthumb/phpThumb.php'));
		$result .= <<<EOT
<div class="col-lg-4 col-md-4 col-sm-4">
	<div class="similar-product-list">
		<div class="img-inner">
			<a href="index.php?ops=ads&type=page&uid=$uid">
				<img src="$avatar" alt="logo" class="img-responsive" />
			</a>
		</div>
		<div class="desc">
			<a href="index.php?ops=ads&type=page&uid=$uid">
				<h4>$name</h4>
			</a>
			<span class="price pull-right"><strong>$price Руб. </strong><strong>$ptype</strong></span>
			<span class="data">$time </span>
		</div>
	</div>
</div>
EOT;
	}
	return $result;
}

function delete_form_ad($uid) {
	$result = '
		<div class="delete">
			<form action="" method="post" id="delete_ad">
				<input type="hidden" name="func" value="delete_ad" />
				<input type="hidden" name="uid" value="' . $uid . '" />
				<button onclick="form_submit(\'#delete_ad\',\'.cmessage\'); return false;">Delete</button>
			</form>
		</div>
	';
	if (data_user('accesslevel') > 1) {
		return $result;
	}
}

function delete_ad() {
	global $link;
	$uid = $_POST['uid'];
	$link -> query("DELETE FROM ads WHERE uid='{$uid}'");
	$link -> query("DELETE FROM images WHERE entid='{$uid}'");
	echo "Ad Deleted";
}

function edit_form_ad($user, $uid) {
	if (get_user() == $user || data_user('accesslevel') > 1) {
		return "<div class='edit_ad'><a href='index.php?ops=ads&type=edit&uid=" . $uid . "'>Edit</a></div>";
	}
}

function edit_ad() {
	global $link;
	$uid = $_GET['uid'];
	$data = $_POST;
	$link -> query("UPDATE ads SET name='{$data['name']}', `group`='{$data['group']}', `desc`='{$data['desc']}', price='{$data['price']}', ptype='{$data['check']}', city='{$data['adress']}', phone='{$data['phone']}', phone2='{$data['phone2']}', author='{$user}' WHERE uid='{$uid}'");
	echo "Done";
}

//ADS

//USERS
function register_user() {
	global $link;
	if ($_POST) {
		$user = $_POST['username'];
		$email = $_POST['email'];
		$pass = $_POST['password'];
		$city = $_POST['city'];
		$uid = generateRandomString();
		$passen = encrypt($pass);
		$query = "INSERT INTO users SET username='{$user}', email='{$email}', pass='{$passen}', city='{$city}', uid='{$uid}'";
		if ($user && $email && $pass) {
			$insert = $link -> query($query);
			echo "User Succesfully created";
		} else {
			echo "Wrong data";
		}
	}
}

function update_user() {
	global $link;
	$uid = data_user('uid');
	if ($_POST) {
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$city = $_POST['city'];
		$email = $_POST['email'];
		$desc = $_POST['desc'];
		$pass = $_POST['pass'];
		$pass2 = $_POST['pass2'];

		if ($pass == $pass2 && strlen($pass) > 0) {
			$passen = encrypt($pass);
		} else {
			$passen = data_user('pass');
		}

		$query = "UPDATE users SET email='{$email}', pass='{$passen}', city='{$city}', firstname='{$firstname}', lastname='{$lastname}', `desc`='{$desc}' WHERE uid='{$uid}'";
		$insert = $link -> query($query);
		
		echo "User Succesfully Updated";
	}
}

function login_user() {
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
}

function logout_user() {
	global $link;
	$hash = $_COOKIE['userhash'];
	$user = decrypt($hash);
	$link -> query("UPDATE users SET status=0 WHERE username='{$user}'");
	setcookie('userhash', '', time() - (60 * 30), "/");
	setcookie('useracl', '', time() - (60 * 30), "/");
	echo <<<EOD
	<span class="dropdown" id="enterFormSpan"> <a data-toggle="dropdown" class="dropdown-toggle">Войти Х</a>
	<div class="dropdown-menu">
		<form method="POST" action="./common/ajax.php" id="login_user">
			<input type="hidden" name="func" value="login_user" />
			<input type="text" name="username" placeholder="Username" class="form-control" />
			<input type="password" name="password" placeholder="Password" class="form-control" />
			<a class="more" onclick="form_submit('#login_user','#enterFormSpan');">Login</a>
		</form>
	</div> </span>
EOD;
}

function get_user() {
	$hash = $_COOKIE['userhash'];
	@$user = decrypt($hash);
	return $user;
}

function status_user() {
	global $link;
	$hash = $_COOKIE['userhash'];
	@$user = decrypt($hash);
	$status = $link -> query("SELECT * FROM users WHERE username='{$user}'");
	$status = mysqli_fetch_assoc($status);
	$status = $status['status'];
	return $status;
}

function data_user($elem) {
	global $link;
	$hash = $_COOKIE['userhash'];
	@$user = decrypt($hash);
	$udata = $link -> query("SELECT * FROM users WHERE username='{$user}'");
	$udata = mysqli_fetch_assoc($udata);
	$udata = $udata[$elem];
	return $udata;
}

function avatar_user() {
	global $link;
	$user = data_user('uid');
	$query = "SELECT * FROM images WHERE entid='{$user}' AND unit='users' ORDER BY id DESC LIMIT 1";
	$udata = $link -> query($query);
	$udata = mysqli_fetch_assoc($udata);
	$path = $udata['path'];
	$filename = $udata['filename'];
	return $path . '/' . $filename;
}

function avatar2_user($user) {
	global $link;
	$udata = $link -> query("SELECT * FROM images WHERE entid='{$user}' AND unit='users' ORDER BY id DESC LIMIT 1");
	$udata = mysqli_fetch_assoc($udata);
	$path = $udata['path'];
	$filename = $udata['filename'];
	if(!$filename){
		$path = 'img';
		$filename = 'user.png';
	}
	return $path . '/' . $filename;
}

function profile_user($uid){
	echo "index.php?ops=users2&type=page&uid=".$uid;
}

function list_user($data) {
	global $link;

	$data = $_POST ? $_POST : explode(',', $data);
	// npr($data);
	
	$ipp = 2;
	$max = 100;
	$page = $_GET['page'] ? $_GET['page'] : 1;

	if (!$_POST) {
		$limit = ($page - 1) * $ipp . ", " . $ipp;
	}

	$where .= strlen($data['search']) > 0 ? ' AND a.username LIKE "%' . $data['search'] . '%" ' : '';
	$where .= $data['check'] > 0 ? ' AND status=1 ' : '';

	$result = '';
	$order = isset($order) ? ' ORDER BY a.' . $order . ' DESC' : ' ORDER BY a.id DESC ';
	$limit = isset($limit) ? ' LIMIT ' . $limit : ' LIMIT 100';
	$query = "SELECT * FROM users as a {$where} {$order} {$limit}";
	// echo $query;
	$items = $link -> query($query);
	// npr($items);
	if (!$items) {
		break;
	}

	$query2 = "SELECT * FROM users as a {$where}";
	$itemscount = $link -> query($query2);
	$count = mysqli_num_rows($itemscount);

	while ($item = mysqli_fetch_assoc($items)) {
		$status = status_user($item['username']);
		$uid = $item['uid'];
		$avatar = htmlspecialchars(phpThumbURL('src=../../' . avatar2_user($uid) . '&w=165&h=165&zc=1', './common/phpthumb/phpThumb.php'));
		$result .= '
		<div class="user-list-inner">
			<div class="user-list-photo">
				<a href="index.php?ops=users2&type=page&uid='.$uid.'">
					<img src="'.$avatar.'" alt="user-photo" class="img-circle" />
				</a>
			</div>
			<div class="user-list-info">
				<div class="row">
					<div class="col-lg-8 col-md-7 col-sm-6">
						<a href="index.php?ops=users2&type=page&uid='.$uid.'">
							<h4>' . $item['username'] . '</h4>
						</a>
						<div class="online-inner">
							<span class="user-offline">Была online ' . $item['timestamp'] . '</span>
						</div>
						<p>
							' . $item['desc'] . '
						</p>
					</div>
					<div class="col-lg-4 col-md-5 col-sm-6">
						<div class="count-action">
							<div>
								<span><i><img src="img/mail.png" alt="mail"/></i>' . $item['messages'] . ' <strong>сообщений</strong></span>
							</div>
							<div>
								<span><i><img src="img/notice-min.png" alt="notice"/></i>' . $item['labels'] . ' <strong> меток на карте</strong></span>
							</div>
							<div>
								<span><i><img src="img/map-min.png" alt="map"/></i>' . $item['ads'] . ' <strong> объявления</strong></span>
							</div>
						</div>
					</div>
					<div class="more-inner">
					<a class="login-button" onclick="$(\'#minichatform .dropdown-menu\').toggle(); newrequest(\'getMiniChat\',\'#scrollbarminichat\',\'<? echo $uid; ?>\'); newrequest(\'cookie\',\'\',\'chatto,'.$uid.',3600\');">Написать сообщение</a>
					</div>
				</div>
			</div>
		</div>
	</div>
		';
	}

	if (!$_POST) {
		$result .= pagination($count, $ipp, $max, 'users2', 'list');
	}
	return $result;
}

function small_list_user($data) {
	global $link;

	$data = $_POST ? $_POST : explode(',', $data);

	$where .= strlen($data['search']) > 0 ? ' AND a.username LIKE "%' . $data['search'] . '%" ' : '';
	$where .= ' AND status=1 ';

	$result = '';
	$order = isset($order) ? ' ORDER BY a.' . $order . ' DESC' : ' ORDER BY a.id DESC ';
	$limit = isset($limit) ? ' LIMIT ' . $limit : ' LIMIT 100';
	$query = "SELECT * FROM users as a WHERE 1 {$where} {$order} LIMIT 100";
	// echo $query;
	$items = $link -> query($query);
	// npr($items);

	while ($item = mysqli_fetch_assoc($items)) {
		$uid = $item['uid'];
		$username = $item['username'];
		$avatar = htmlspecialchars(phpThumbURL('src=../../' . avatar2_user($uid) . '&w=165&h=165&zc=1', './common/phpthumb/phpThumb.php'));
		$result .= <<<EOT
<div class="user">
	<div class="user-col-left"><a href="index.php?ops=users2&type=page&uid=$uid"><span class="img-inner"><img src="$avatar" alt="user" class="img-circle img-responsive"></span></a></div>
	
	<div class="user-col-right">
		<a href="index.php?ops=users2&type=page&uid=$uid" class="user-name">$username</a>
		<a class="message-to-user" onclick="$('#minichatform .dropdown-menu').toggle(); newrequest('getMiniChat','#scrollbarminichat','$uid'); newrequest('cookie','','chatto,$uid,3600');">Написать личку</a>
	</div>
</div>
EOT;
	}
	return $result;
}

function similar_user($data) {
	global $link;
	$city = $data[0];
	$result = '';
	$query = "SELECT * FROM `users` WHERE `city` LIKE '%{$city}%' ORDER BY `id` DESC LIMIT 3";
	// echo $query;
	$items = $link -> query($query);
	// npr($items);

	while ($item = mysqli_fetch_assoc($items)) {
		$uid = $item['uid'];
		$status = $item['status'];
		$messages = $item['messages'];
		$ads = $item['ads'];
		$labels = $item['labels'];
		$username = $item['username'];
		$avatar = htmlspecialchars(phpThumbURL('src=../../' . avatar2_user($uid) . '&w=165&h=165&zc=1', './common/phpthumb/phpThumb.php'));
		$statusclass = $status==1 ? 'user-online' : 'user-offline';
		$result .= <<<EOT
<div class="col-lg-4 col-md-4 col-sm-4">
	<div class="similar-user-inner">
		<div class="text-center">
			<a href="index.php?ops=users2&type=page&uid=$uid" class="similar-user-photo $statusclass"><img src="$avatar" alt="user" class="img-circle img-responsive"></a>
		</div>
		<p class="text-center">
			<a href="index.php?ops=users2&type=page&uid=$uid" class="user-name">$username</a>
		</p>
		<p class="data">
			online
		</p>
		<div class="count-action">
			<span><i><img src="img/mail.png" alt="mail"/></i>$messages</span>
			<span><i><img src="img/notice-min.png" alt="notice"/></i> $ads</span>
			<span><i><img src="img/map-min.png" alt="map"/></i> $labels</span>
		</div>
		<div class="text-center">
			<a class="message-to-user" onclick="$('#minichatform .dropdown-menu').toggle(); newrequest('getMiniChat','#scrollbarminichat','$uid'); newrequest('cookie','','chatto,$uid,3600');">Написать сообщение</a>
		</div>
	</div>
</div>
EOT;
	}
	return $result;
}

function notifications_user() {
	global $link;
	$uid = data_user('uid');
	$query = "SELECT * FROM `notifications` WHERE `to`LIKE '%{$uid}%' ORDER BY `id` DESC";
	$notifications = $link -> query($query);
	while ($note = mysqli_fetch_assoc($notifications)) {
		$url = $note['url'];
		$message = $note['message'];
		$date = $note['date'];
		$type = $note['type'];
		$from = elem_ad($note['from'], 'username', 'users');

		echo <<<EOT
<div class="note">
	<a href="{$note['url']}">
		<div class="type">{$type}</div>
		<div class="from">{$from}</div>
		<div class="message">{$message}</div>
		<div class="date">{$date}</div>
	</a>
</div>
EOT;
	}
}

function notify_user() {
	global $link;
	$uid = data_user('uid');
	$query = "SELECT * FROM `notifications` WHERE `to` LIKE '%{$uid}%' AND status=0 ORDER BY `id` DESC";
	$notifications = $link -> query($query);
	while ($note = mysqli_fetch_assoc($notifications)) {
		$id = $note['id'];
		$url = $note['url'];
		$message = $note['message'];
		$date = $note['date'];
		$type = $note['type'];
		$from = elem_ad($note['from'], 'username', 'users');
		$icon = htmlspecialchars(phpThumbURL('src=../../' . avatar2_user($uid) . '&w=68&h=68&zc=1', './common/phpthumb/phpThumb.php'));
		$icon = '<img src="'.$icon.'" alt="" />';

		echo <<<EOT
<a class="notification" href="$url">
<div class="icon">$icon</div>
<div class="from">$from</div>
<div class="message">$message</div>
<div class="date">$date</div>
</a>
EOT;
	}

if(mysqli_num_rows($notifications)>0){
echo <<<EOT
<a class="notification" onclick="newrequest('notifications_read_user', '.cmessage', '')">Clear Notifications</a>
EOT;
}
}

function notification_read_user($params){
	global $link;
	$uid = data_user('uid');
	$params = explode(',', $params);
	$id = $params[0];
	$url = $params[1];
	$query = "UPDATE `notifications` SET `status`=1 WHERE `id`={$id}";
	$notifications = $link -> query($query);
}

function notifications_read_user(){
	global $link;
	$uid = data_user('uid');
	$query = "UPDATE `notifications` SET `status`=1 WHERE `to` LIKE '%{$uid}%'";
	$notifications = $link -> query($query);
}

function count_notifications_user() {
	global $link;
	$uid = data_user('uid');
	$notifications = $link -> query("SELECT * FROM `notifications` WHERE `to`LIKE '%{$uid}%' AND `status`=0");
	$notifications = mysqli_num_rows($notifications);
	return $notifications;
}

function chats_user() {
	global $link;
	$uid = data_user('uid');
	$query = "SELECT * FROM `privatechat` WHERE `to`LIKE '%{$uid}%' GROUP BY `from` ORDER BY date DESC";
	$users = $link -> query($query);
	while ($user = mysqli_fetch_assoc($users)) {
		$uuid = $user['from'];
		$uuid = htmlspecialchars($uuid);
		$date = $user['date'];
		$from = elem_ad($uuid, 'username', 'users');
		$avatar = htmlspecialchars(phpThumbURL('src=../../' . avatar2_user($uuid) . '&w=68&h=68&zc=1', './common/phpthumb/phpThumb.php'));

		echo <<<EOT
<div class="search-result-inner">
	<div class="user">
		<div class="user-col-left">
			<a onclick="newrequest('getFullChat','.mCustomScrollbar','$uuid'); newrequest('cookie','','chatto,$uuid,3600');">
				<span class="img-inner">
					<img src="{$avatar}" alt="user" class="img-circle img-responsive">
				</span>
			</a>
		</div>
		<div class="user-col-right">
			<a onclick="newrequest('getFullChat','.mCustomScrollbar','$uuid'); newrequest('cookie','','chatto,$uuid,3600');" class="user-name">{$from}</a>
			<div class="data">
				{$date}
			</div>
		</div>
	</div>
</div>
EOT;
	}
}

function count_messages_user(){
	global $link;
	$uid = data_user('uid');
	$messages = $link -> query("SELECT * FROM `privatechat` WHERE `to`LIKE '%{$uid}%' AND `status`='0'");
	$messages = mysqli_num_rows($messages);
	return $messages;
}

function count_online_user(){
	global $link;
	$users = $link -> query("SELECT * FROM `users` WHERE `status`=1");
	$users = mysqli_num_rows($users);
	return $users;
}
//USERS

//CHAT
function chatcity(){
	setcookie('chatcity', $_POST['city'], time() + (60 * 300), "/");
	echo "Город ".$_POST['city'];
	header("Refresh:0");
}
//CHAT
?>