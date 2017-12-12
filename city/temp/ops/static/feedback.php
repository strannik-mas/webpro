<?php 
	//$uid = $_GET['uid'];
	$username = data_user('username');
	$from = data_user('uid');
	$date = date("Y-m-d H:i:s");
?>
<div class="container feedback-page">
<?php
//POST
	if(isset($_POST['add_feedback'])) {
		$text  = $_POST['text'];
		$query = "INSERT INTO feedback SET  `uid`='{$from}', `username`='{$username}', `text`='{$text}', `date`='{$date}'";
		$link -> query($query);
		} 

//GET
	$querys = "SELECT * FROM `feedback` WHERE `uid` LIKE '%{$from}%' ORDER BY `id`";
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
					<?php echo $feedback['username']; ?>
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
?>
	<div class="create-message feedback">
		<div class="bg">
			<div class="create-message-inner">
					<div id="emoji3" class="smile"></div>
					<h2>Отправить комментарий</h2>
				<form method="POST" action="" id="feedback">
					<input type="hidden" name="from" value="<? echo data_user('uid'); ?>" />
					<div class="message-textarea">
						<textarea name="text" placeholder="Комментарий" id="txtfeedback"></textarea>
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
</div>

