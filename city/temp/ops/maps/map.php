<?php $uid = generateRandomString(); ?>
<div class="main-content">
	<div class="container-fluid map">
		<div class="accident-map row">
			<div id="map"></div>
			<!--<div class="map-marker"><span><img src="img/map-marker-2.png" alt="map-marker"/></span></div>-->
		</div>
		<div class="container map-search">
			<div class="row dropdown">
				<div class="col-lg-10 col-md-10 notice-info archive">
					<div class="notice-search row">
						<div class="label-links dropdown">
							<a href=""  data-toggle="dropdown" class="dropdown-toggle">Найти на карте </a>
							<a href="<?= $_SERVER['PHP_SELF'] . '?ops=maps&type=archive' ?>" class="archive-l">Архив меток </a>

						</div>
						<form class="map-form" action="<?= $_SERVER['PHP_SELF'] ?>" method='post' id='filter_labels' onsubmit="return false">
							<div class="form-group-inner col-lg-8 col-md-8 col-sm-7">
								<div class="row">
									<div class="col-lg-6 col-md-7 col-sm-8 col-xs-12 check-inner">
										<div class="check">
											<input id="check10" type="checkbox" name="check" value="3">
											<label for="check10"><span><img src="img/info-mini-1.png" alt=""/></span></label>
										</div>
										<div class="check">
											<input id="check11" type="checkbox" name="check" value="2">
											<label for="check11"><span><img src="img/info-mini-2.png" alt=""/></span></label>
										</div>
										<div class="check">
											<input id="check12" type="checkbox" name="check" value="1">
											<label for="check12"><span><img src="img/info-mini-3.png" alt=""/></span></label>
										</div>
<!--										<div class="check">
											<input id="check13" type="checkbox" name="check" value="4">
											<label for="check13"><span><img src="img/map-sel.png" alt=""/></span></label>
										</div>-->
									</div>

									<div class="form-group col-lg-6 col-md-5 col-sm-4 col-xs-12">
										<input type="text" placeholder="Адрес" name="adress" class="form-control searchTextField" id="streetaddr" required>
									</div>
								</div>
							</div>
							<div class="form-group-inner col-lg-4 col-md-4 col-sm-5">
								<div class="row">
									<div class="radius col-lg-6 col-md-6 col-sm-6">
										<input type="number" placeholder="Радиус 3 км" name="radius" class="form-control" required min="1" max="100" id="radius_label">
									</div>

									<div class="button col-lg-6 col-md-6 col-sm-6">
										<button type="submit">Найти <i href="" class="fa fa-search"></i></button>
									</div>

								</div>

							</div> 

						</form>
					</div>
				</div>
				<div class="col-lg-2 col-md-2 mob-notice">
					<div class="add-notice">
						<a href="#" data-toggle="dropdown" class="dropdown-toggle">
							<i><img src="img/label.png" alt="add"></i>
							<span>Добавить метку</span>
						</a>
						<div class="dropdown-menu">
							<a href="#" class="close" data-dismiss="modal">x</a>
							<form action="./common/ajax.php" method='post' id='add_label'>
								<input type="hidden" name="uid" value="<?php echo $uid; ?>" />
								<input type="hidden" name="func" value="addGoogleMapLabel" />
								<input type="hidden" name="uName" id="label_username" />
								<input type="hidden" name="lat" id="lat" />
								<input type="hidden" name="long" id="long" />
								<input type="hidden" name="type" id="label_type" />
								<div class="form-group-inner">
									<div class="form-group">
										<input type="text" placeholder="Название" name="name" class="form-control" id="name_label" required>
									</div>
									<div class="form-group selection-group">
									<select name="type" style="display: none;">
										<?php
										global $link;
										$groups = $link -> query("SELECT * FROM marker_types");
										while ($group = mysqli_fetch_assoc($groups)) {
											echo "<option value='" . $group['id'] . "'>" . $group['typename'] . "</option>";
										}
										?>
									</select>
									<div class="nice-select" tabindex="0">
										<span class="current">Выберите</span>
										<ul class="list">
											<?php
											$groups = $link -> query("SELECT * FROM marker_types");
											while ($group = mysqli_fetch_assoc($groups)) {
												echo "<li class='option' data-value='" . $group['id'] . "'>" . $group['typename'] . "</li>";
											}
											?>
										</ul>
									</div>
								</div>
									<div class="form-group">
										<input type="text" placeholder="Адрес" class="form-control searchTextField" id="address_label">
										<a href="" onclick="return whereami()">Моё местоположение</a>
									</div>
									<div class="form-group">
										<textarea placeholder="Описание" name="description" class="form-control" id="desc_label" required></textarea>
									</div>
									<div id="uploader" class='uploader'></div>
									<input type="hidden" name="uid" value="<?php echo $uid; ?>" />

									<div class="checkbox">
										<label>
											<input type="checkbox" id="anonim"> Опубликовать анонимно
										</label>
									</div>
									<div class="button">
											<a class="more" onclick="form_submit('#add_label','.dropdown-menu');">Опубликовать</a>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="label-archive">
						<a href="#"> Архив меток</a>
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
			endpoint: 'common/uploader/endpoint.php?path=<?php echo $uid; ?>&ops=maps',
		},
		deleteFile: {
			enabled: true,
			endpoint: 'common/uploader/endpoint.php'
		}
	});
</script>