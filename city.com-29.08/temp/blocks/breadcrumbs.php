<?php
@$ops = $_GET['ops'];
@$type = $_GET['type'];
@$uid = $_GET['uid'];
if(!$uid){
	@$uid = $_GET['item'];
}
if($ops=='ads'){
	$opsname = '<a href="index.php?ops=ads">Объявления</a>';
	$name = elem_ad($uid, 'name', 'ads');
}
if($ops=='chat'){
	$opsname = '<a href="index.php?ops=chat">Чат</a>';
}
if($ops=='maps'){
	$opsname = '<a href="index.php?ops=maps">Карта</a>';
	$name = elem_ad($uid, 'title', 'googlemaplabels');
}
if($ops=='users2'){
	$opsname = '<a href="index.php?ops=users2">Пользователи</a>';
	$name = elem_ad($uid, 'username', 'users');
}
?>
<div class="row">
	<div class="location">
		<span><? echo $opsname; ?></span>
		<span><? echo $name; ?></span>
	</div>
</div>