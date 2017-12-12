<? $uid = $_GET['uid']; ?>
<div class="main-content">
	<div class="container-fluid">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-9 user-page">
					<div class="row">
						<div class="notice">
							<h1><? echo elem_ad($uid, 'username', 'users'); ?><? if(elem_ad($uid, 'status', 'users')==1){ ?> <span class="user-online">online</span><? } ?><? if(elem_ad($uid, 'status', 'users')==0){ ?> <span class="user-online">offline</span><? } ?></h1>
						</div>
						<div class="about-user">
							<div class="row">
								<div class="user-photo  col-lg-4 col-md-4 col-sm-4">
									<img src="<? echo htmlspecialchars(phpThumbURL('src=../../' . avatar2_user($uid) . '&w=263', './common/phpthumb/phpThumb.php')); ?>" alt="" />
								</div>
								<div class="user-main-info col-lg-8 col-md-8 col-sm-8">
									<span class="place"><i class="fa fa-map-marker" aria-hidden="true"></i><? echo elem_ad($uid, 'city', 'users'); ?></span>
									<span class="time">Registered <? echo elem_ad($uid, 'timestamp', 'users'); ?></span>
									<h4>Активность пользователя</h4>
									<div class="count-action row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
											<span><i><img src="img/mail.png" alt="mail"/></i><? echo elem_ad($uid, 'messages', 'users'); ?> <strong>сообщений в городском чате</strong></span>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
											<span><i><img src="img/notice-min.png" alt="notice"/></i><? echo elem_ad($uid, 'labels', 'users'); ?> <strong> меток на карте</strong><a href="index.php?ops=maps&type=archive&userid=<? echo $uid; ?>">Посмотреть</a></span>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
											<span><i><img src="img/map-min.png" alt="map"/></i><? echo elem_ad($uid, 'ads', 'users'); ?> <strong> объявления</strong><a href="index.php?ops=ads&type=list&userid=<? echo $uid; ?>">Посмотреть</a></span>
										</div>

									</div>
									<div>
										<a class="login-button" onclick="$('#minichatform .dropdown-menu').toggle(); newrequest('getMiniChat','#scrollbarminichat','<? echo $uid; ?>'); newrequest('cookie','','chatto,<? echo $uid; ?>,3600');">Написать сообщение</a>
										<div class="complain">
											<div class="text-center">
												<a href="#"> <i class="fa fa-exclamation-circle" aria-hidden="true"></i> <i class="link-text">Пожаловаться</i> </a>
											</div>
										</div>
									</div>

								</div>
							</div>

							<div class="about-user-inner">
								<h2>Обо мне</h2>
								<? echo elem_ad($uid, 'desc', 'users'); ?>
							</div>
							<div class="similar-users row">
								<? echo similar_user(elem_ad($uid, 'city', 'users')); ?>
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
