<div class="nav">
	<div class="container-fluid">
		<div class="container">
			<div class="row">
				<div class="nav-inner">
					<div class="nav-top dropdown">
						<div class="logo">
							<a href="index.php?ops=chat"><img src="ops/chat/img/logo-black.png" alt="logo" /></a>
						</div>

						<? if(status_user()==1){ ?>
						<div class="profile ">
							<a href="#" data-toggle="dropdown" class="dropdown-toggle"> <span class="user-messages"> <img src="<? echo htmlspecialchars(phpThumbURL('src=../../' . avatar2_user(data_user('uid')) . '&w=50&h=50&zc=1', './common/phpthumb/phpThumb.php')) ?>" alt="user" class="img-circle img-responsive"> </span> </a>
							<div class="dropdown-menu">
								<ul>
									<li>
										<a href="index.php?ops=users2&type=cabinet">Личные данные</a>
									</li>
									<li>
										<a href="#">Уведомления (4)</a>
									</li>
									<li>
										<a href="#">Сообщения (6)</a>
									</li>
								</ul>
							</div>
						</div>
						<? } ?>
					</div>
					

					<div class="nav-list">
						<ul>
							<li>
								<a href="index.php?ops=chat">Чат</a>
							</li>
							<li>
								<a href="index.php?ops=maps">Карта<span><strong>SOS</strong></span></a>
							</li>
							<li>
								<a href="index.php?ops=ads">Объявления</a>
							</li>
							<li>
								<a href="index.php?ops=users2&type=list">Пользователи</a>
							</li>
						</ul>
						<div class="pull-right profile" id="divRightProfile">
							<? if(status_user()==1){ ?>
							<div class="notifications"><? echo count_notifications_user(); ?></div>
							<span class="dropdown"> <!----> <a href="#" data-toggle="dropdown" class="dropdown-toggle"><span class="user-messages"><img src="<? echo htmlspecialchars(phpThumbURL('src=../../' . avatar2_user(data_user('uid')) . '&w=50&h=50&zc=1', './common/phpthumb/phpThumb.php')) ?>" alt="user" class="img-circle img-responsive"></span>Личный кабинет </a>
								<div class="dropdown-menu">
									<ul>
										<li>
											<a href="index.php?ops=users2&type=cabinet">Личные данные</a>
										</li>
										<li>
											<a href="index.php?ops=users2&type=cabinet">Уведомления (<? echo count_notifications_user(); ?>)</a>
										</li>
										<li>
											<a href="index.php?ops=users2&type=cabinet">Сообщения (<? echo count_messages_user(); ?>)</a>
										</li>
									</ul>
								</div> </span>
								<? } ?>
							<? if(status_user()==0){
							?>
							<span class="dropdown dropdown-log" id="enterFormSpan"> <a data-toggle="dropdown" class="dropdown-toggle">Войти Х</a>
								<div class="dropdown-menu">
									<form method="POST" action="./common/ajax.php" id="login_user">
										<input type="hidden" name="func" value="login_user" />
										<input type="text" name="username" placeholder="Ваш Логин" class="form-control" />
										<input type="password" name="password" placeholder="Пароль" class="form-control" />
										<a class="more" onclick="form_submit('#login_user','#enterFormSpan');">Login</a>
									</form>
								</div>
								</span>
							<? } ?>
							<? if(status_user()==1){ ?>
							<div class="logout_form">
								<form method="POST" action="" id="logout_user">
									<input type="hidden" name="func" value="logout_user" />
									<input type="submit" value="Выйти Х" />
								</form>
							</div>
							<? } ?>
						</div>
					</div>
				</div>
			</div>
			<?php
			include ('breadcrumbs.php');
			?>
		</div>
	</div>
</div>