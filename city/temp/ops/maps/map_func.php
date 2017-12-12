<?php
//add map coords
function addGoogleMapLabel($params) {
	$username = get_user();
	$uid = data_user('uid');
	$desc = $params['description'];
	//npr($params);
	global $link;
	$sql = "INSERT INTO `googlemaplabels` (`uid`, `user`, `username`, `lat`, `long`, `title`, `type`, `desc`) 
				VALUES ('{$params['uid']}', '{$uid}', '{$username}', '{$params['lat']}', '{$params['long']}', '{$params['name']}', {$params['type']}, '{$desc}')";
	if ($link -> query($sql)) {
		$link -> query("UPDATE images SET temp=0 WHERE entid='{$params['uid']}'");
		$link -> query("UPDATE users SET labels = (labels + 1) WHERE username='{$username}'");
		return 'Данные внесены';
	} else {
		return "SQL: $sql<br>" . 'failed insert map data: (' . $link -> errno . ")" . $link -> error;
	}
}

//get all coords and description
function getAllLabels($type) {
	global $link;
	if (!empty($type)) {
		$sql = "SELECT t1.lat, t1.long, t1.desc, t1.title, t1.user, t1.username, `marker_types`.`typename`, `images`.`path` as marker_path, `images`.`filename` as marker_filename, t1.date, t1.id
							FROM googlemaplabels t1
							LEFT JOIN marker_types ON marker_types.id = t1.type
							LEFT JOIN images ON images.type = t1.type AND images.entity = 'marker'";
		if ($type[0] == 'AllDiv') {//если на странице архива меток
			$sql = "SELECT t1.lat, t1.long, t1.desc, t1.title, t1.user, t1.username, `marker_types`.`typename`, `images`.`path` as marker_path, `images`.`filename` as marker_filename, t1.date, t1.id, COUNT(  `comments`.`entid` )
							FROM googlemaplabels t1
							LEFT JOIN marker_types ON marker_types.id = t1.type
							LEFT JOIN images ON images.type = t1.type AND images.entity = 'marker'
							LEFT JOIN comments ON `comments`.`entid` = t1.id AND comments.unit = 'maps' AND comments.entity = 'comment' GROUP BY t1.id";
			$sqlAvatar = "SELECT `images`.`path` as avatar_path, `images`.`filename` as avatar_filename
FROM googlemaplabels
LEFT JOIN images ON `googlemaplabels`.`user` = `images`.`entid`  AND `images`.`unit` = 'user' ORDER BY `images`.`id` LIMIT 1";
			$sqlCountPhotos = "SELECT COUNT(`images`.`entid` ) 
							FROM googlemaplabels
							LEFT JOIN images ON  `images`.`entid` =  `googlemaplabels`.`uid` 
							AND images.unit =  'maps'
							AND images.entity =  'upload'
							GROUP BY  `googlemaplabels`.`id` ";
		} elseif ($type[(count($type) - 1)] == 'AllDiv') {
			$sql = "SELECT t1.lat, t1.long, t1.desc, t1.title, t1.user, t1.username, `marker_types`.`typename`, `images`.`path` as marker_path, `images`.`filename` as marker_filename, t1.date, t1.id, COUNT(  `comments`.`entid` )
							FROM googlemaplabels t1
							LEFT JOIN marker_types ON marker_types.id = t1.type
							LEFT JOIN images ON images.type = t1.type AND images.entity = 'marker'
							LEFT JOIN comments ON `comments`.`entid` = t1.id AND comments.unit = 'maps' AND comments.entity = 'comment'";
			$sqlAvatar = "SELECT `images`.`path` as avatar_path, `images`.`filename` as avatar_filename
								FROM googlemaplabels  
								LEFT JOIN images ON `googlemaplabels`.`user` = `images`.`entid`  AND images.unit = 'user' ORDER BY `images`.id LIMIT 1";
			$sqlCountPhotos = "SELECT COUNT(`images`.`entid` ) 
					FROM googlemaplabels
					LEFT JOIN images ON  `images`.`entid` =  `googlemaplabels`.`uid` 
					AND images.unit =  'maps'
					AND images.entity =  'upload'";
		}

		if ($type[0] <= 4 && $type[0] > 0) {
			$sql .= " WHERE t1.type = $type[0]";
			if ($sqlAvatar != '') {
				$sqlAvatar .= " WHERE `googlemaplabels`.`type` = $type[0]";
				$sqlCountPhotos .= " WHERE `googlemaplabels`.`type` = $type[0]";
			}
			for ($i = 1; $i < count($type); $i++) {
				if ($type[$i] != 'AllDiv') {
					$sql .= " OR t1.type=$type[$i]";
					if ($sqlAvatar != '')
						$sqlAvatar .= " OR `googlemaplabels`.`type`=$type[$i]";
					if ($sqlCountPhotos != '')
						$sqlCountPhotos .= " OR `googlemaplabels`.`type`=$type[$i]";
				} else {
					$sql .= " GROUP BY t1.id";
					$sqlAvatar .= " ORDER BY googlemaplabels.id";
					$sqlCountPhotos .= " GROUP BY `googlemaplabels`.`id`";
				}
			}

		}
		if ($sqlAvatar != '') {
			if (!$resAvatars = $link -> query($sqlAvatar)) {
				echo "SQL: $sqlAvatar<br>" . 'failed get avatars: (' . $link -> errno . ")" . $link -> error;
			} else {
				$avatarsPhoto = result2Array($resAvatars, false);
				//					echo "SQL: $sqlAvatar<br>";
			}
		}

		if ($sqlCountPhotos != '') {
			if (!$resPhotos = $link -> query($sqlCountPhotos)) {
				echo "SQL: $sqlCountPhotos <br>" . 'failed get count photos: (' . $link -> errno . ")" . $link -> error;
			} else {
				$photosCountArr = result2Array($resPhotos, false);
				//					echo "SQL: $sqlCountPhotos<br>";
			}
		}

		if (!$res = $link -> query($sql)) {
			echo "SQL: $sql<br>" . 'failed get labels: (' . $link -> errno . ")" . $link -> error;
		} else {
			$arr = result2Array($res, false);
			//var_dump($avatarsPhoto);
			if ($type[0] == 'AllDiv' || $type[(count($type) - 1)] == 'AllDiv') {
				$resArr = array_map(null, $arr, $avatarsPhoto, $photosCountArr);
				//					var_dump($resArr);
				$arrIt = new ArrayIterator($resArr);
				$it = new RecursiveArrayIterator($arrIt);
				$flatIt = new RecursiveIteratorIterator($it);
				$j = 1;
				foreach ($flatIt as $label) {
					echo $label . ($j < (count($arr[0]) + count($avatarsPhoto[0]) + count($photosCountArr[0])) ? "&&" : "|");

					if ($j == count($arr[0]) + count($avatarsPhoto[0]) + count($photosCountArr[0]))
						$j = 0;
					$j++;
				}
			} elseif ($type[0] == 'All' || ($type[0] <= 4 && $type[0] > 0 && $type[(count($type) - 1)] != 'AllDiv')) {

				for ($i = 0; $i < count($arr); $i++) {
					$j = 1;
					foreach ($arr[$i] as $label) {
						echo $label . ($j < (count($arr[$i])) ? "&&" : "");
						$j++;
					}
					echo($i < count($arr) - 1 ? "|" : "");
				}
			}

		}
	}
}

function haversineGreatCircleDistance($postParams) {
	var_dump($postParams);
	/*$latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000*/
	// convert from degrees to radians
	$latFrom = deg2rad($latitudeFrom);
	$lonFrom = deg2rad($longitudeFrom);
	$latTo = deg2rad($latitudeTo);
	$lonTo = deg2rad($longitudeTo);

	$latDelta = $latTo - $latFrom;
	$lonDelta = $lonTo - $lonFrom;

	$angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
	return $angle * $earthRadius;
}

//получение данных для текущей метки (кнопка Подробнее)
function getCurrentLabel($params) {
	global $link;
	$id = $params[1];
	$sql = "SELECT t1.lat, t1.long, t1.desc, t1.title, t1.user, t1.`username`, `marker_types`.`typename`, `images`.`path` as marker_path, `images`.`filename` as marker_filename, t1.date, `comments`.`description`, `comments`.`timestamp`, `users`.`username`, `comments`.`parent`
				FROM googlemaplabels t1
				LEFT JOIN marker_types ON marker_types.id = t1.type
				LEFT JOIN images ON images.type = t1.type AND images.entity = 'marker'
				LEFT JOIN comments ON `comments`.`entid` = '$id' AND comments.unit = 'maps' AND comments.entity = 'comment'				LEFT JOIN users ON `users`.`uid` = `comments`.`uid`
				WHERE t1.uid='$id'";

	$sqlPhotos = "SELECT `images`.`path`,  `images`.`filename`
						FROM googlemaplabels
						LEFT JOIN images ON  `images`.`entid` =  `googlemaplabels`.`uid` 
						AND images.unit =  'maps'
						AND images.entity =  'upload'
						WHERE  `googlemaplabels`.`uid`= '$id' ";

	$sqlAvatar = "SELECT `images`.`path` as avatar_path, `images`.`filename` as avatar_filename
						FROM comments, images 
						WHERE `comments`.`entid` = '$id' AND `images`.`entid` = `comments`.`uid`";

	$sqlAuthorAvatar = "SELECT `images`.`path`, `images`.`filename`, t2.uid
						FROM googlemaplabels t1, users t2
						LEFT JOIN images ON `images`.`entid` =  t2.uid
						WHERE  t1.uid='$id' AND t1.username=t2.username";

	if (!$res = $link -> query($sql)) {
		echo "SQL: $sql<br>" . 'failed get labels info: (' . $link -> errno . ")" . $link -> error;
	} else {
		$arr = result2Array($res);
		// npr($arr);
		if (!$resPhotos = $link -> query($sqlPhotos)) {
			echo "SQL: $sqlPhotos<br>" . 'failed get fotos: (' . $link -> errno . ")" . $link -> error;
		} else {
			$arr['photos'] = result2Array($resPhotos);
			//					echo "SQL: $sqlAvatar<br>";
		}
		if (!$resAvatar = $link -> query($sqlAvatar)) {
			echo "SQL: $sqlAvatar<br>" . 'failed get avatar foto: (' . $link -> errno . ")" . $link -> error;
		} else {
			$arr['avatars'] = result2Array($resAvatar);
			//						echo "SQL: $sqlAvatar<br>";
		}
		if (!$resAuthorAvatar = $link -> query($sqlAuthorAvatar)) {
			echo "SQL: $sqlAuthorAvatar<br>" . 'failed get author`s avatar: (' . $link -> errno . ")" . $link -> error;
		} else {
			$arr['author'] = result2Array($resAuthorAvatar);
			//						echo "SQL: $sqlAvatar<br>";
		}
		//					var_dump($arr);
		return json_encode($arr);
	}
}

function addcomment() {
	global $link;
	$id = $_POST['uid'];
	$uuid = data_user('uid');
	$city = data_user('city');
	$author = elem_ad($id, 'user', 'googlemaplabels');
	$message = $_POST['message'];
	$parent = $_POST['parent'];
	$url = "index.php?ops=maps&type=archive&item=" . $id;
	$query = "INSERT INTO `comments` SET `parent`='{$parent}', `entid`='{$id}', `from`='{$uuid}', `city`='{$city}', `description`='{$message}', `unit`='maps'";
	$link -> query($query) or die($link -> error);
	$query2 = "INSERT INTO `notifications` SET `unit`='maps', `type`='comment', `from`='$uuid', `message`='$message', `status`=0, `url`='$url', `to`='$author'";
	$link -> query($query2) or die($link -> error);
	return list_comment($id);
}

function list_comment($uid) {
	global $link;
	$id = $_GET['item'] > 0 ? $_GET['item'] : $uid;
	$city = data_user('city');
	$query = "SELECT * FROM `comments` WHERE `entid` = '{$id}' ORDER BY `id` DESC LIMIT 100";
	$chats = $link -> query($query);
	while ($chat = mysqli_fetch_assoc($chats)) {
		$id = $chat['id'];
		$uuid = $chat['from'];
		$message = $chat['description'];
		$date = $chat['date'];
		$parent = $chat['parent'];
		$username = elem_ad($uuid, 'username', 'users');
		$avatar = htmlspecialchars(phpThumbURL('src=../../' . avatar2_user($uuid) . '&w=68&h=68&zc=1', './common/phpthumb/phpThumb.php'));
		if ($parent > 0) {
			$answer = '<script>$( document ).ready(function() { $("#record_'.$id.'").appendTo("#record_'.$parent.'"); });</script>';
			$class = 'answer';
		} else {
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
}

function label_group($id) {
	global $link;
	$query = "SELECT * FROM marker_types WHERE id='{$id}'";
	$result = $link -> query($query);
	$result = mysqli_fetch_assoc($result);
	$result = $result['typename'];
	return $result;
}

function label_comments($uid) {
	global $link;
	$query = "SELECT * FROM googlemaplabels WHERE uid='{$uid}'";
	$result = $link -> query($query);
	$result = mysqli_num_rows($result);
	return $result;
}

function label_photos($uid) {
	global $link;
	$query = "SELECT * FROM images WHERE entid='{$uid}'";
	$result = $link -> query($query);
	$result = mysqli_num_rows($result);
	return $result;
}

function search_labels() {
	global $link;
	$data = $_POST;
	@$userid = $_GET['userid'];
	$username = $data['nick'];
	$type1 = $data['type1'];
	$type2 = $data['type2'];
	$type3 = $data['type3'];
	$address = strlen($data['adress']) > 0 ? $data['adress'] : 'Poltavskyi Shliakh Street, Kharkiv, Kharkiv Oblast, Ukraine';
	$date = $data['data'];
	$name = $data['name'];
	$radius = $data['radius'] > 0 ? $data['radius'] : '7000';

	$ipp = 2;
	$max = 100;
	$page = $_GET['page'] ? $_GET['page'] : 1;

	$where = strlen($username) > 0 ? " AND username LIKE '%{$username}%' " : '';
	$where .= strlen($userid) > 0 ? " AND user LIKE '%{$userid}%' " : '';
	$where .= strlen($name) > 0 ? " AND title LIKE '%{$name}%' " : '';
	$where .= strlen($date) > 0 ? " AND date LIKE '%{$date}%' " : '';
	if($type1>0||$type2>0||$type3>0){
		$where .= ' AND (type=5 ';
		$where .= strlen($type1) > 0 ? " OR type = '{$type1}' " : '';
		$where .= strlen($type2) > 0 ? " OR type = '{$type2}' " : '';
		$where .= strlen($type3) > 0 ? " OR type = '{$type3}' " : '';
		$where .= ') ';
	}

	if (!$_POST) {
		$limit = ($page - 1) * $ipp . ", " . $ipp;
	}
	$limit = isset($limit) ? ' LIMIT ' . $limit : ' LIMIT 100';
	$query2 = "SELECT * FROM googlemaplabels WHERE 1 {$where}";
	$itemscount = $link -> query($query2);
	$count = mysqli_num_rows($itemscount);

	$query = "SELECT * FROM googlemaplabels WHERE 1 {$where} ORDER BY `id` DESC {$limit}";
	$labels = $link -> query($query);
	while ($label = mysqli_fetch_assoc($labels)) {
		$id = $label['id'];
		$uid = $label['uid'];
		$uuid = $label['user'];
		$username2 = $label['username'];
		$photos = label_photos($uid);
		$comments = label_comments($uid);
		$lon1 = $label['long'];
		$lat1 = $label['lat'];
		$avatar = htmlspecialchars(phpThumbURL('src=../../' . avatar2_user($uuid) . '&w=68&h=68&zc=1', './common/phpthumb/phpThumb.php'));
		$type = $label['type'];
		$type = label_group($type);

		$laddress = file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?latlng=" . $lat1 . "," . $lon1 . "&sensor=true");
		$laddress = json_decode($laddress, true);
		$laddress = $laddress['results'][0]['formatted_address'];

		$geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=false');
		$geo = json_decode($geo, true);

		if ($geo['status'] == 'OK') {
			$lat2 = $geo['results'][0]['geometry']['location']['lat'];
			$lon2 = $geo['results'][0]['geometry']['location']['lng'];
		}
		$distance = distance($lat1, $lon1, $lat2, $lon2);
		if ($distance <= $radius) {
			echo <<<EOT
<div class="archive-accident row">
	<div class="col-lg-4 col-md-4 col-sm-4 accident-map">
		<iframe width="100%" height="260" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q={$lat1},{$lon1}&amp;key=AIzaSyCghtB-Fop8TIVrZCNAynBa-ZZVgC5AUSc"></iframe>
	</div>
	<div class="col-lg-5 col-md-5 col-sm-4 col-xs-6 accident-desc accident-desc-height">
		<h4>{$label['title']}</h4>
		<div class="type"><span>Тип:</span> {$type} </div>
		<div class="type"><span>Адрес:</span> {$laddress} </div>
		<div class="user-info">
			<a href="index.php?ops=users2&type=page&uid={$uuid}" class="user-face"><img src="{$avatar}" alt="user" class="img-circle img-responsive"></a>
			<div class="user-info-text">
				<a href="index.php?ops=users2&type=page&uid={$uuid}" class="user-name">{$username2}</a>
			</div>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-4 col-xs-6 accident-info">
		<div class="data">Добавлена {$label['date']}</div>
		<p>
			<img src="img/comm.png" alt="comm"/>
			<span>{$comments}</span> комментариев
		</p>
		<p>
			<img src="img/camera.png" alt="camera"/>
			<span>{$photos}</span> фото
		</p>
		<div class="more-inner"><a href="index.php?ops=maps&type=archive&item={$uid}" class="more">Подробнее</a></div>
	</div>
</div>
EOT;
		}
	}
	if (!$_POST) {
		echo pagination($count, $ipp, $max, 'maps', 'archive');
	}
}

function distance($lat1, $lon1, $lat2, $lon2) {

	$theta = $lon1 - $lon2;
	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	$dist = acos($dist);
	$dist = rad2deg($dist);
	$miles = $dist * 60 * 1.1515;
	$unit = strtoupper($unit);

	return ($miles * 1.609344);
}
?>