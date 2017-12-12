<div class="main-content">
	<div class="container-fluid">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-9 user-cabinet">
					<div class="row">
						<div class="notice">
							<h1>Личный кабинет </h1>
						</div>
						<div class="tabs-inner">
							<ul class="tabs">
								<li class="active">
									<a data-toggle="tab" href="#panel1">Сообщения <span>(<? echo count_messages_user(); ?>)</span></a>
								</li>
								<li>
									<a onclick="newrequest('notifications_read_user','','<? echo data_user('uid'); ?>');" data-toggle="tab" href="#panel2">Уведомления <span>(<? echo count_notifications_user(); ?>)</span></a>
								</li>
								<li>
									<a data-toggle="tab" href="#panel3">Личные данные</a>
								</li>
							</ul>

							<div class="tab-content">
								<div id="panel1" class="tab-pane fade in active">
									<div class="row">
										<div class="col-lg-4 col-md-4 col-sm-5 search-result">
											<div class="search-user">
												<div class="form-group search-inner">
													<a href="#" class="fa fa-search"></a>
													<input name="search" placeholder="Найти пользователя" required="" class="form-control" type="search">
												</div>
											</div>
											<div class="all-users">
												<? chats_user(); ?>
											</div>
										</div>
										<div class="col-lg-8 col-md-8 col-sm-7 cabinet-chat">
											<div class="chat">

												<div class="mCustomScrollbar"></div>
											</div>
											<div class="create-message">
												<div class="bg">
													<div class="create-message-inner">
														<form onsubmit="return false;" method='post' id='add_privatemessage'>
															<input type="hidden" name="func" value="addPrivateMessageF" />
															<input type="hidden" name="to" value="<? echo $_COOKIE['chatto']; ?>" />
															<input type="hidden" name="from" value="<? echo data_user('uid'); ?>" />
															<div class="message-function">
																<h2>Отправить сообщнение</h2>


															</div>

															<div class="message-textarea">
																<textarea id="mess_private" name="message" placeholder="Решил написать свою историю..."></textarea>
															</div>
															<div class="button">
																<button type="submit" onclick="form_submit('#add_privatemessage','.mCustomScrollbar'); $('#mess_private').val('');">
																	Отправить
																</button>
															</div>
														</form>

													</div>
												</div>
											</div>
										</div>
									</div>

								</div>
								<div id="panel2" class="tab-pane fade">
									<div class="mCustomScrollbar">
										<div class="chat-inner">
											<? notifications_user(); ?>
										</div>
									</div>
					
								</div>
								<div id="panel3" class="tab-pane fade personal-data">
									<form action="" method="post" id="user_update">
										<input type="hidden" name="func" value="update_user" />
										<div class="cabinet-left">
											<a href="index.php?ops=users2&type=page&uid=<? echo data_user('uid'); ?>">Просмотреть свою страницу</a>
											<img src="<? echo htmlspecialchars(phpThumbURL('src=../../' . avatar_user() . '&w=263', './common/phpthumb/phpThumb.php')); ?>" alt="" />
											<div id="uploader"></div>
										</div>
										<div class="cabinet-right row">
											<div class="form-group">
												<label for="firstname">Имя</label>
												<input type="text" name="firstname" value="<? echo data_user('firstname') ?>" class="form-control"/>
											</div>
											<div class="form-group">
												<label for="lastname">Фамилия</label>
												<input type="text" name="lastname" value="<? echo data_user('lastname') ?>" class="form-control"/>
											</div>
											<div class="form-group">
												<label for="city">Город</label>
												<input id="cities" onfocus="initMap2();" type="address" name="city" value="<? echo data_user('city') ?>" class="form-control" />
											</div>
										</div>
										<div class="cabinet-bottom row">
											<div class="form-group">
												<label for="email">E-mail*</label>
												<input type="text" name="email" value="<? echo data_user('email') ?>" class="form-control"/>
											</div>
											<div class="form-group">
												<label for="pass">Пароль*</label>
												<input type="password" name="pass" class="form-control"/>
											</div>
											<div class="form-group">
												<label for="pass2">Подтвердить новый пароль пароль*</label>
												<input type="password" name="pass2" class="form-control"/>
											</div>
											<div class="form-textarea">
												<label for="desc">Расскажите о себе:</label>
												<textarea name="desc" id="desc" cols="30" rows="7" class="form-control"><? echo data_user('desc') ?></textarea>
											</div>
										</div>
										<a class="more" onclick="form_submit('#user_update','#user_update_msg');">Сохранить</a>
									</form>
									<div id="user_update_msg"></div>
								</div>
							</div>
						</div>

					</div>

				</div>

				<div class="col-lg-3 col-md-3 sidebar">
					<div class="banner">
						<img src="img/banner.png" alt="banner" class="img-responsive" />
					</div>
					<div class="info">
						<div class="info-inner">
							<a href="#"> <span> <i> <img src="img/info-1.png" alt="logo"/> </i> </span> <strong>Нужна помощь на дороге?</strong> </a>
						</div>
						<div class="info-inner">
							<a href="#"> <span> <i> <img src="img/info-2.png" alt="logo"/> </i> </span> <strong>Где сейчас наряды ДПС?</strong> </a>
						</div>
						<div class="info-inner">
							<a href="#"> <span> <i> <img src="img/info-3.png" alt="logo"/> </i> </span> <strong>Где произошли аварии?</strong> </a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
		var uploader = new qq.FineUploader({
			debug: true,
			element: document.getElementById('uploader'),
			request: {
			endpoint: 'common/uploader/endpoint.php?path=<?php echo data_user('uid'); ?>&ops=users',
		},
		deleteFile: {
		enabled: true,
		multiple: false,
		endpoint: 'common/uploader/endpoint.php'
		}
		});
</script>