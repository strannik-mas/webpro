<?php $uid = generateRandomString(); ?>
<div class="create-message">
	<div class="bg">
		<div class="create-message-inner">
			<form onsubmit="return false;" action="./common/ajax.php" method='post' id='add_comment'>
				<input type="hidden" name="uid" value="<?php data_user("uid"); ?>" />
				<input type="hidden" name="func" value="addComment" />
				<input type="hidden" name="user" value="<?php get_user(); ?>" />
				<div class="message-function">
					<h2>Отправить сообщнение</h2>

					<div class="pull-right message-attached">
						<a href="#" class="smile">
							<img src="ops/chat/img/smile.png" alt="smile" />
						</a>
					</div>

				</div>

				<div class="message-textarea">
					<textarea placeholder="Решил написать свою историю..." id="txtMessage"></textarea>
				</div>
				<div class="button">
					<button type="submit" onclick="form_submit_append('#add_comment','#tempdiv');">Отправить</button>

				</div>
			</form>

		</div>
	</div>
</div>

