<div class="nav">
	<div class="container-fluid">
		<div class="container">
			<div class="row">
				<div class="nav-inner">
					<div class="nav-top dropdown">
						<div class="logo">
							<img src="ops/chat/img/logo-black.png" alt="logo" />
						</div>
						
						<div class="profile ">
							<a href="#" data-toggle="dropdown" class="dropdown-toggle">
								<span class="user-messages">
									<img src="ops/chat/img/user.png" alt="user" class="img-circle img-responsive">
								</span>
							</a>
							<div class="dropdown-menu">
								<ul>
									<li><a href="#">Личные данные</a></li>
									<li><a href="#">Уведомления (4)</a></li>
									<li><a href="#">Сообщения (6)</a></li>
								</ul>
							</div>
						</div>
					</div>
						
					<div class="nav-list">
						<ul>
							<li><a href="index.php?ops=chat">Чат</a></li>
							<li><a href="index.php?ops=maps">Карта<span><strong>SOS</strong></span></a></li>
							<li><a href="index.php?ops=ads">Объявления</a></li>
						</ul>
						<div class="pull-right profile" id="divRightProfile">
				        	<span class="dropdown">
				        	<!---->
					        	<a href="#" data-toggle="dropdown" class="dropdown-toggle"><span class="user-messages"><img src="ops/chat/img/user.png" alt="user" class="img-circle img-responsive"></span>Личный кабинет </a>
					        	<div class="dropdown-menu">
							         <ul>
								          <li><a href="#">Личные данные</a></li>
								          <li><a href="#">Уведомления (4)</a></li>
								          <li><a href="#">Сообщения (6)</a></li>
							         </ul>
						        </div>
					       	</span>
				        	<span class="dropdown" id="enterFormSpan">
				        		<a href="#" data-toggle="dropdown" class="dropdown-toggle">Войти Х</a>
						        	<div class="dropdown-menu">
							         	<form onsubmit="return false;">
							          		<div class="form-group">
							           			<input type="text" id="txtLogin" class="form-control" placeholder="Введите login" name="username">
							            	</div>
								            <div class="form-group">
								         		<input type="password" id="txtPassword" class="form-control" placeholder="Введите пароль" name="password">
								            </div>
								            <div class="checkbox">
								           		<label>
								             		<input type="checkbox"> Запомнить
								           		</label>
								            </div>
								            <div class="social-link">
												<span>вход через соц.сети</span>
												<ul>
												<?= '<li><a href="' . $confData['google_url'] . '?' . urldecode($googleQueryUrl) . '"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>' ?>
													<li><a href=""><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
												<?= '<li><a href="' . $confData['vk_url'] . '?' . urldecode($vkQueryUrl) . '"><i class="fa fa-vk" aria-hidden="true"></i></a></li>' ?>
													<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
													<li><a href="#"><i class="fa fa-odnoklassniki" aria-hidden="true"></i></a></li>
													
												</ul>
											</div>
								            <button type="submit" class="btn btn-default" onclick="validateUser();">Войти</button>
							         	</form>
						        	</div>
				       		</span>
				       </div>
					</div>
				</div>
			</div>
			<?php include('breadcrumbs.php'); ?>
		</div>
	</div>
</div>