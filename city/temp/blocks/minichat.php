<div class="mini-chat">
	 
	<div class="dropdown dropup" id="minichatform">
		<div class="dropdown-menu">
			<div class="chat">
				<div class="mCustomScrollbar" id="scrollbarminichat">
					<div  id="divResultMiniChat"></div>
				</div>
			</div>
			<div class="create-message">
				<div>
					<div class="create-message-inner">
							<div id="emoji2" class="smile"></div>
						<form onsubmit="return false;" method='post' id='add_privatemessage'>
							<input type="hidden" name="func" value="addPrivateMessage" />
							<input type="hidden" name="to" value="<? echo $_COOKIE['chatto']; ?>" />
							<input type="hidden" name="from" value="<? echo data_user('uid'); ?>" />
							<div class="message-textarea">
								<textarea placeholder="Решил написать свою историю..." name="message" id="mess_private" class="textarea"></textarea>
								<div class="message-function">
								</div>
							</div>
							
							<div class="button">
								<button type="submit" onclick="form_submit('#add_privatemessage','#scrollbarminichat'); $('#mess_private').val('');">
									Отправить
								</button>
							</div>
						</form>
					</div>
					
				</div>
			</div>
			<div class="your-chat">
				<div class="chat-user-info">
					<div class="chat-user">
						<a href="#"><span class="img-inner"><img src="<? echo htmlspecialchars(phpThumbURL('src=../../' . avatar2_user(elem_ad($uid, "author", "ads")) . '&w=68&h=68&zc=1', './common/phpthumb/phpThumb.php')); ?>" alt="user" class="img-circle img-responsive"></span></a>
					</div>
					<div class="chat-message-info">
						<a href="index.php?ops=users2&type=page&uid=<? echo $uuid; ?>" class="user-name"><?php echo elem_ad($uuid, "username", "users"); ?></a>
					</div>
					<div class="your-chat-action">
					<a href="/temp/index.php?ops=users2&type=cabinet"><img src="img/arrows.png" alt="arrows"></a>
					<a href="#" class="close-chat"><img src="img/close.png" alt="close"></a>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>$('.close-chat').click(function(event){
		event.preventDefault();
		$('.mini-chat .dropdown-menu').css("display", "none");
		});
	</script>