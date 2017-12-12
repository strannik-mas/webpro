<?php 
	$uid = $_GET['uid'];
	$uuid = elem_ad($uid, "author", "ads");
?>
<div class="main-content">
	<div class="container-fluid">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-9 notice-info">
					<div class="row">
						<div class="notice">
							<h1><?php echo elem_ad($uid, "name", "ads"); ?></h1>
						</div>
						<div class="product-view col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="fotorama" data-nav="thumbs"  data-arrows="false" data-vertical="true" data-fullscreenIcon="true" data-navPosition="right" data-width="100%" data-ratio="800/600">
								<?php images_ad($uid); ?>
							</div>
						</div>
						<div class="product-view-desc col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
							<span class="place"><i class="fa fa-map-marker" aria-hidden="true"></i><?php echo elem_ad($uid, "city", "ads"); ?></span>
							<span class="data pull-right"> <?php echo elem_ad($uid, "timestamp", "ads"); ?></span>
							<h2>Автор</h2>
							<div class="user-info">
								<a class="user-face"><img class="img-circle img-responsive" src="<? echo htmlspecialchars(phpThumbURL('src=../../' . avatar2_user(elem_ad($uid, "author", "ads")) . '&w=50&h=50&zc=1', './common/phpthumb/phpThumb.php')); ?>" alt="" /></a>
								<div class="user-info-text">
									<a href="index.php?ops=users2&type=page&uid=<? echo $uuid; ?>" class="user-name"><?php echo elem_ad($uuid, "username", "users"); ?></a>
								</div>
							</div>
							<div class="complain">
								<span></span>
								<div class="text-center">
									<a href="index.php?ops=complain&type=ads&uid=<?php echo $uuid; ?>" onclick=""> <i class="fa fa-exclamation-circle" aria-hidden="true"></i> <i class="link-text">Пожаловаться</i> </a>
								</div>
							</div>
							<div class="buttons-inner">
								<div>
									<a href="#" class="more showphone" onclick="$('.phone').toggle();">Показать телефон</a>
									<script>$('.showphone').click(function(event){
										event.preventDefault();
										});
									</script>
									<div class="phone"><?php echo elem_ad($uid, "phone", "ads"); ?></div>
									<? if(elem_ad($uid, "phone2", "ads") != 0){ ?>
									<div class="phone"><?php echo elem_ad($uid, "phone2", "ads"); ?></div>
									<? } ?>
								</div>
								<div>
									<a class="login-button" onclick="$('#minichatform .dropdown-menu').toggle(); newrequest('getMiniChat','#scrollbarminichat','<? echo $uid; ?>'); newrequest('cookie','','chatto,<? echo $uid; ?>,3600');">Написать продавцу</a>
								</div>

							</div>
						</div>

					</div>
					<div class="product-desc">
						<h2>Описание</h2>
						<?php echo elem_ad($uid, "desc", "ads"); ?>
					</div>
					<div class="similar-product row">
						<h3>Похожие  объявления</h3>
						<? echo similar_ad(elem_ad($uid, "city", "ads")); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

