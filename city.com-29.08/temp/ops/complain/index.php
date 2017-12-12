<?php 
	$uid = $_GET['uid'];
	$uuid = $_GET['uuid'];
	$ops = $_GET['cops'];
	$author_name = elem_ad($uuid, 'username', 'users');
	//$ads_name = elem_ad($uid, 'name', 'ads');
	//$ads_desc = elem_ad($uid, 'desc', 'ads');
	$from = data_user('uid');
	$from_name = elem_ad($from, 'username', 'users');
	//$author_avatar = htmlspecialchars(phpThumbURL('src=../../' . avatar2_user($uuid) . '&w=50&h=50&zc=1', './common/phpthumb/phpThumb.php'));
	//$from_avatar = htmlspecialchars(phpThumbURL('src=../../' . avatar2_user($from) . '&w=50&h=50&zc=1', './common/phpthumb/phpThumb.php'));
	$status = status_user(); // if 1 logged in
	$accesslevel = elem_ad($from, 'accesslevel', 'users'); // 0 guest, 1 loggedin, 10 admin
?>
<div class="container complain-page">
	
	<h2>Жалоба</h2>
	<?php
	//POST
		if(isset($_POST['add_complain'])) {
			$text  = $_POST['text'];
			$type = $_POST['type_complain'];
			$query = "INSERT INTO complain SET `uid`='{$uid}', `ops`='{$ops}', `from`='{$from}', `to`='{$uuid}', `text`='{$text}', `option`='{$type}'";
			$link -> query($query);
				?>
		<div class="thanks">
			<p>Большое спасибо за информацию!</p>
			<p>Жалоба будет рассмотрена в ближайшее время.</p>
		</div>

		<?php
			} 
	
	//GET
		if($accesslevel != 10){
	?>
		
	<?php
		}else{ 
		$querys = "SELECT * FROM `complain` WHERE `uid` LIKE '%{$uid}%' ORDER BY `id` DESC";
		$complains = $link -> query($querys);
	
	if (mysqli_num_rows($complains) <= 0 )
	 {
		echo "Нет Жалоб";
	}
		while ($complain = mysqli_fetch_assoc($complains) )
		{
			?>
			<div class="complain-text">
				<div class="complain-caption">
					<div>от кого
					</div>
					<div>на кого 
					</div>
					<div>причина
					</div>
					<div>сообщение
					</div>
					<div>тип
					</div>
					
				</div>
				<div class="complain-desc">
					<div class="user-name">
						<a href="index.php?ops=users2&type=page&uid=<?php echo $complain['from']; ?>">
							<?php echo elem_ad($complain['from'], 'username', 'users'); ?>
						</a>
					</div>
					<div class="user-name">
						<a href="index.php?ops=users2&type=page&uid=<?php echo $complain['to']; ?>">
							<?php echo elem_ad($complain['to'], 'username', 'users'); ?>
						</a>
					</div>
					<div>
						<?php echo $complain['option']; ?>
					</div>
					<div class="text">
						<?php echo $complain['text']; ?>
					</div>
					<div class="type">
						<a href="index.php?ops=<?php echo $complain['ops']; ?>&type=page&uid=<?php echo $complain['uid']; ?>"><?php echo $complain['ops']; ?></a>
					</div>
				</div>
				
			
				
			</div>
	
				<?php 
			}
		}
	?>
	<?php if($accesslevel>0 && $accesslevel!=10){ 
	 ?>
	<div class="add-complain bg" id="#complain_body">
		<div class="add-complain-inner">
			<h2>Отправить жалобу</h2>
		<form method="POST" action="" id="complain">
			<input type="hidden" name="uid" value="<?php echo $uid; ?>" >
			<input type="hidden" name="from" value="<? echo data_user('uid'); ?>" />
			<input type="hidden" name="ops" value="<? echo $ops; ?>" />
			<select name="type_complain">
				<option value="1">1</option>
				<option value="2">2</option>
			</select>
			<div class="create-message feedback">
				<div class="">
					<div class="create-message-inner">
						<textarea placeholder="Текс жалобы" name="text"></textarea>
					</div>
				</div>
			</div>
			<div class="button">
				<button type="submit" name="add_complain">
					Отправить жалобу
				</button>
			</div>
		</form>
		</div>
	</div>
	<?php 
		}
	?>
</div>