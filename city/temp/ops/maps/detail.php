<?
require_once 'map_func.php';
?>
<div class="main-content">
	<div class="container-fluid">
		<div class="container">
			<div class="row map-selected">
				<div class="notice"></div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 accident-desc"></div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 accident-map" id="mapLabel"></div>
			</div>
			<div class="row accident-comm">
				<div class="col-lg-9 col-md-9 col-sm-9">
					<div class="chat">
						<h4>Комментарии</h4>
							<div class="mCustomScrollbar">
								<div  id="divResultComments">
									<? list_comment($_GET['item']); ?>
								</div>
							</div>
					</div>
					<? if(status_user()==1){ ?>
					<div class="create-message">
						<div class="bg">
							<div class="create-message-inner">
								<form onsubmit="return false;" method='post' id='add_comment'>
									<input type="hidden" name="func" value="addComment" />
									<input type="hidden" name="uid" value="<?= $_GET['item']?>" />
									<input id="parent" type="hidden" name="parent" value="0" />
									<div class="message-function">
										<h2>Отправить сообщнение</h2>
										<div class="pull-right message-attached">
											<a href="#" class="smile">
												<img src="ops/chat/img/smile.png" alt="smile" />
											</a>
										</div>
									</div>
									<div class="message-textarea">
										<textarea placeholder="Решил написать свою историю..." id="txtMessage" name="message"></textarea>
									</div>
									<div class="button">
										<button type="submit" onclick="form_submit('#add_comment','#divResultComments'); $('#txtMessage').val('');">Отправить</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<? } ?>
				</div>
				
				<div class="col-lg-3 col-md-3 col-sm-3 accident-sidebar">
					<div class="all-users">
						<h3>Автор</h3>
						<div class="user" id="label_author">
						</div>
					</div>
						<h4>Другие метки неподалеку</h4>
						<div class="accident-map">
							<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d143663.78246742918!2d37.539327938352486!3d55.76290399207961!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1suk!2sru!4v1496735844893" width="100%" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>
							<div class="map-marker"><span><img src="img/map-marker.png" alt="map-marker"/></span></div>
						</div>
						<h5>ДТП подрезали троллейбус</h5>
						<p class="type"><span>Тип: </span>ДТП</p>
						<p class="type"><span>Адрес: </span>ул. Менделеева, 30</p>
						<div class="text-center"><a href="#" class="more">Подробнее</a></div>
				</div>
			</div>
		</div>
	</div>
</div>