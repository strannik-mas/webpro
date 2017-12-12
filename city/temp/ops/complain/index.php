<?php 
	$uid = $_GET['uid'];
	$username = data_user('username');
	$from = data_user('uid');
	$ops = $_GET['type'];
?>
<div class="add-complain" id="#complain_body">
	<form method="POST" action="" id="complain">
		<input type="hidden" name="uid" value="<?php echo $uid; ?>" >
		<input type="hidden" name="from" value="<? echo data_user('uid'); ?>" />
		<input type="hidden" name="ops" value="<? echo $ops; ?>" />
		<input type="hidden" name="username" value="<? echo $username; ?>" />
		<select name="type_complain[]">
			<option value="1">1</option>
			<option value="2">2</option>
		</select>
		<textarea placeholder="Текс жалобы" name="text">
			
		</textarea>
		<div class="button">
			<button type="submit" name="add_complain">
				Отправить жалобу
			</button>
		</div>
	</form>
</div>
<?php
//POST
	if(isset($_POST['add_complain'])) {
		$text  = $_POST['text'];
		foreach ($_POST['type_complain'] as $select) {
			//echo $select;
		}
		$type = $select;
		$query = "INSERT INTO complain SET `uid`='{$uid}', `ops`='{$ops}', `from`='{$from}', `username`='{$username}', `text`='{$text}', `type`='{$type}'";
		$link -> query($query);
		} 

//GET
	$querys = "SELECT * FROM `complain` WHERE `uid` LIKE '%{$uid}%' ORDER BY `id`";
	$complains = $link -> query($querys);

if (mysqli_num_rows($complains) <= 0 )
 {
	echo "Нет Жалоб";
}
	while ($complain = mysqli_fetch_assoc($complains) )
	{
		?>
		<div class="complain-text">
			<div class="user-name">
				<?php echo $complain['username']; ?>
			</div>
			<div class="text">
				<?php echo $complain['text']; ?>
			</div>
			<div class="type">
				<?php echo $complain['type']; ?>
			</div>
			
		
			
		</div>

		<?php 
	}
?>