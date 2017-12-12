<?php $uid = $_GET['uid']; ?>
<div class="main-content">
	<div class="container-fluid">
		<div class="container add_ad">
			<div class="row">
				<div class="col-lg-9 col-md-9 notice-add">
					<div class="row">
						<div class="notice">
							<h1>Edit объявление</h1>
						</div>
						<form method="POST" action="./common/ajax.php" id="edit_ad">
							<input type="hidden" name="uid" value="<?php echo $uid; ?>" />
							<input type="hidden" name="func" value="edit_ad" />
							<div class="form-add">
								<div class="form-group caption">
									<label>Заголовок</label>
									<input name="name" placeholder="" required="" class="form-control" type="text" value="<?php elem_ad($uid, "name", "ads"); ?>">
								</div>
								<div class="form-group selection-group">
									<label>Выведите полходящую рубрику для товара </label>
									<select name="group" style="display: none;">
										<?php
										global $link;
										$groups = $link -> query("SELECT * FROM ad_groups");
										while ($group = mysqli_fetch_assoc($groups)) {
											echo "<option value='" . $group['id'] . "'>" . $group['name'] . "</option>";
										}
										?>
									</select>
									<div class="nice-select" tabindex="0">
										<span class="current"></span>
										<ul class="list">
											<?php
											$groups = $link -> query("SELECT * FROM ad_groups");
											while ($group = mysqli_fetch_assoc($groups)) {
												echo "<li class='option' data-value='" . $group['id'] . "'>" . $group['name'] . "</li>";
											}
											?>
										</ul>
									</div>
								</div>
								<div class="textarea-inner">
									<p>
										Описание  товара
									</p>
									<div class="textarea">
										<textarea name="desc"><?php elem_ad($uid, "desc", "ads"); ?></textarea>
									</div>

									<div class="textarea-hint">
										<i>Опишите товар в подробностях - хорошие описания помогают решиться на покупку.</i>
									</div>
								</div>
								<div id="uploader"></div>

							</div>

							<div class="form-add-choose">
								<div>
									<div class="form-group price-choose">
										<label>Цена</label>
										<input name="price" placeholder="" class="form-control" type="number'" value="<?php elem_ad($uid, "price", "ads"); ?>">
										<span>Руб</span>
									</div>
									<div class="check-big">
										<div class="check">
											<input id="check4" name="check" value="1" type="checkbox">
											<label for="check4">Договорная</label>
										</div>
									</div>
								</div>
								<div class="your-city">
									<span>Ваш город:</span><i class="fa fa-map-marker" aria-hidden="true"></i><input value="<?php elem_ad($uid, "city", "ads"); ?>" onfocus="initMap2();" type="address" placeholder="Адрес" name="adress" class="form-control" id="cities">
								</div>
								<div class="form-tel">
									<label>Телефон</label>
									<input name="phone" placeholder="" class="form-control" type="tel" value="<?php elem_ad($uid, "phone", "ads"); ?>">
									<a onclick="$('.form-tel2').toggle();" class="add-tel">+<span> Добавить еще телефон</span></a>
								</div>
								<div class="form-tel2">
									<label>Телефон 2</label>
									<input name="phone2" placeholder="" class="form-control" type="tel" value="<?php elem_ad($uid, "phone2", "ads"); ?>">
								</div>
								<div class="buttons-submit">
									<a class="more" onclick="$('input[name=func]').val('add_ad'); form_submit('#edit_ad','.add_ad');">Опубликовать</a>

								</div>

							</div>
						</form>

					</div>

				</div>

				<div class="col-lg-3 col-md-3 sidebar">
					<div class="banner">
						<img src="img/banner.png" alt="banner" class="img-responsive">
					</div>
					<div class="info">
						<div class="info-inner">
							<a href="#"> <span> <i> <img src="img/info-1.png" alt="logo"> </i> </span> <strong>Нужна помощь на дороге?</strong> </a>
						</div>
						<div class="info-inner">
							<a href="#"> <span> <i> <img src="img/info-2.png" alt="logo"> </i> </span> <strong>Где сейчас наряды ДПС?</strong> </a>
						</div>
						<div class="info-inner">
							<a href="#"> <span> <i> <img src="img/info-3.png" alt="logo"> </i> </span> <strong>Где произошли аварии?</strong> </a>
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
                endpoint: 'common/uploader/endpoint.php?path=<?php echo $uid; ?>&ops=ads',
            },
            deleteFile: {
                enabled: true,
                endpoint: 'common/uploader/endpoint.php'
            }
        });
        
var input = document.getElementById('streetaddr');
	
	var options = {
		offset: 3,
		types: ['address']/*,
		location: [uluru.lat+','+uluru.lng],
		radius: ['300']*/
	};
console.dir(options);
	var autocomplete = new google.maps.places.Autocomplete(input, options);

	google.maps.event.addListener(autocomplete, 'place_changed', function () {
		var place = autocomplete.getPlace(); //получаем место
		console.log(place);
		console.log(place.name);  //название места
		console.log(place.id);  //уникальный идентификатор места
	});
</script>