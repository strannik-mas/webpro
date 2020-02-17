<script type="text/javascript" src="ops/chat/js/chat.js"></script>
<script type="text/javascript" src="ops/chat/js/xmlhttprequest.js"></script>
<div class="main-content">
	<div class="container-fluid">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-9 notice-add">
					<div class="row">
						<div class="notice">
							<h1><img src="ops/chat/img/map.png" alt="logo"/>Город Москва</h1>
							<span class="who">&laquo; Кто в чате?</span>
						</div>
						<div class="chat">
							<div class="chat-nav">
								<a href="#" class="chat-common">Общий чат</a>
								<a href="#" class="chat-help">Помощь</a>
							</div>
							<div class="mCustomScrollbar" id="scrollbar">
								<div  id="divResult"></div>
							</div>
						</div>
						<div class="create-message">
							<div class="bg">
								<div class="create-message-inner">
									<form onsubmit="return false;">
										<div class="message-function">
											<h2>Отправить сообщнение</h2>
											
											<div class="pull-right message-attached">
												<a href="#" class="clip">
													<img src="ops/chat/img/clip.png" alt="clip" />
												</a>
												<a href="#" class="smile">
													<img src="ops/chat/img/smile.png" alt="smile" />
												</a>
											</div>

										</div>

										<div class="message-textarea">
											<textarea placeholder="Решил написать свою историю..." id="txtMessage"></textarea>
										</div>
										<div class="button">
										<button type="submit" onclick="addRecord()">Отправить</button>
										</div>
									</form>
										
								</div>
							</div>
						</div>

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