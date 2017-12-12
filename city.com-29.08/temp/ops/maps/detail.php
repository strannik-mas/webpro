<?
require_once 'map_func.php';
$uid = $_GET['item'];
$uuid = elem_ad($uid, 'user','googlemaplabels');
$username = elem_ad($uid, 'username','googlemaplabels');
$avatar = avatar3_user($uuid, '50', '50');
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
							<div class="user-col-left">
								<a href="index.php?ops=users2&type=page&uid=<? echo $uuid; ?>">
									<span class="img-inner">
										<img src="<? echo $avatar; ?>" alt="user" class="img-circle img-responsive">
									</span></a></div><div class="user-col-right">
								<a href="index.php?ops=users2&type=page&uid=<? echo $uuid; ?>" class="user-name"><? echo $username; ?></a>
								<a onclick="$('#minichatform .dropdown-menu').toggle(); newrequest('getMiniChat','#scrollbarminichat','<? echo $uuid; ?>'); newrequest('cookie','','chatto,<? echo $uuid; ?>,3600');">Написать в личку</a>
							</div>
						</div>
					</div>
						<h4>Другие метки неподалеку</h4>
						<? similar_labels(); ?>
				</div>
			</div>
		</div>
	</div>
</div>