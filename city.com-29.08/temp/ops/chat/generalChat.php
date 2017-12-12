<? 
require_once 'chat_func.php';
$city = strlen($_COOKIE['chatcity'])>0 ? $_COOKIE['chatcity'] : data_user('city');
?>
<div class="main-content">
	<div class="container-fluid">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-9 notice-add">
					<div class="row">
						<div class="notice">
							<h1><img src="ops/chat/img/map.png" alt="logo"/>Город <? echo $city; ?></h1>
							<form action="" method="post" id="changecity">
								<input type="hidden" name="ops" value="chat" />
								<input type="hidden" name='func' value="chatcity" />
								<input onfocus="initMap2();" type="address" name="city" class="form-control" id="cities" placeholder="Введите местоположение">
								<input class="more" type="submit" value="Изменить город" />
							</form>
						</div>
						<div class="chat">
							<div class="chat-nav">
								<a href="index.php?ops=chat" class="chat-common chat-tab">Общий чат</a>
								<a href="index.php?ops=chat&type=help" class="chat-help chat-tab">Помощь</a>
							</div>
							<div class="mCustomScrollbar" id="scrollbar">
								<div  id="divResult"><? list_chat(); ?></div>
							</div>
						</div>
						
<?
if(status_user()!=1){
	echo "You have to login to send a message";
}else{
?>
<?php $uid = generateRandomString(); ?>
<div class="create-message">
	<div class="bg">
		<div class="create-message-inner">
			<div id="emoji" class="smile"></div>
		
			<form onsubmit="return false;" action="./common/ajax.php" method='post' id='add_generalchat'>
				<input type="hidden" name="uid" value="<?php data_user("uid"); ?>" />
				<input type="hidden" name="func" value="add_chat" />
				<input id="parent" type="hidden" name="parent" value="0" />
				<div class="message-function">
					<h2>Отправить сообщнение</h2>
				</div>
				<div class="message-textarea">
					<textarea name="message" placeholder="Решил написать свою историю..." id="txtMessage"></textarea>
				</div>
				<div class="button">
					<button type="submit" onclick="form_submit('#add_generalchat','#divResult'); $('#txtMessage').val(''); $('#parent').val(''); $('.message-function h2').html('Отправить сообщнение');">Отправить</button>
				</div>
			</form>

		</div>
	</div>
</div>
<? } ?>

					</div>
					
				</div>
				<div class="col-lg-3 col-md-3 sidebar">
					<?php include('blocks/right_image.php') ?>
					<?php include('blocks/right_users.php') ?>
				</div>
			</div>
		</div>
	</div>
</div>