<?php 
	//$uid = $_GET['uid'];
	$from = data_user('uid');
	$date = date("Y-m-d H:i:s");
	$status = status_user();
	$accesslevel = elem_ad($from, 'accesslevel', 'users');
?>
<div class="container feedback-page">
<?php
//POST
	if(isset($_POST['add_feedback'])) {
		$text  = $_POST['text'];
		$query = "INSERT INTO feedback SET  `uid`='{$from}', `text`='{$text}', `date`='{$date}'";
		$link -> query($query);
		?>
		<div class="thanks">
			<p>Большое спасибо за информацию!</p>
			<p>Мы исправим ошибку в ближайшее время.</p>
		</div>

		<?php
		
		} 

//GET
	if(status_user()!=10){
?>
			<h2>Если Вы обнаружили ошибку на сайте, пожалуйста, сообщите нам о ней!</h2>
	<?php
		}else{ 
	$querys = "SELECT * FROM `feedback` WHERE `uid` LIKE '%{$from}%' ORDER BY `id` DESC";
	$feedbacks = $link -> query($querys);

	if (mysqli_num_rows($feedbacks) <= 0 )
 {
	echo "Нет отзывов";
}
	while ($feedback = mysqli_fetch_assoc($feedbacks) )
	{
		
	?>
			<div class="feedback-text">
				<div class="user-name">
					<a href="index.php?ops=users2&type=page&uid=<?php echo $feedback['uid']; ?>">
						<?php echo elem_ad($feedback['uid'], 'username', 'users'); ?>
					</a>
				</div>
				<div class="text">
					<?php echo $feedback['text']; ?>
				</div>
				<div class="date">
					<?php echo $feedback['date']; ?>
				</div>
			</div>

		<?php 
	}
}
?>
<?php if(status_user()!=10){ 
	 ?>
	<div class="create-message feedback">
		<div class="bg">
			<div class="create-message-inner">
					<h2>Отправить сообщение об ошибке</h2>
				<form method="POST" action="" id="feedback">
					<input type="hidden" name="from" value="<? echo data_user('uid'); ?>" />
					<div class="message-textarea">
						<textarea name="text" placeholder="Сообщение..." id="txtfeedback"></textarea>
					</div>
					<div class="button">
						<button type="submit" name="add_feedback">
							Отправить 
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php 
	}
?>
</div>

