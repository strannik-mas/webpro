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
							<a href="#"  data-toggle="dropdown" class="dropdown-toggle">Найти на карте </a>
							<a href="<?= $_SERVER['PHP_SELF'] . '?ops=maps&type=archive' ?>" class="archive-l">Архив меток </a>

						</div>
						<form class="map-form">
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
										<div class="check">
											<input id="check13" type="checkbox" name="check" value="4">
											<label for="check13"><span><img src="img/map-sel.png" alt=""/></span></label>
										</div>
									</div>

									<div class="form-group col-lg-6 col-md-5 col-sm-4 col-xs-12">
										<input type="text" placeholder="Адрес" name="adress" class="form-control" id="streetaddr">
									</div>
								</div>
							</div>
							<div class="form-group-inner col-lg-4 col-md-4 col-sm-5">
								<div class="row">
									<div class="radius col-lg-6 col-md-6 col-sm-6">
										<input type="text" placeholder="Радиус 3 км" name="radius" class="form-control">
									</div>

									<div class="button col-lg-6 col-md-6 col-sm-6">
										<button type="submit">Найти <i href="#" class="fa fa-search"></i></button>
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
							<form action="">
								<div class="form-group-inner">
									<div class="form-group">
										<input type="text" placeholder="Название" name="name" class="form-control">
									</div>
									<div class="form-group"  id="marker_types">      
										<select><!--
										 <option>Тип1</option>
										 <option>Тип2</option>-->
										</select>
									</div>
									<div class="form-group">
										<input type="text" placeholder="Адрес" name="address" class="form-control">
										<a href="" onclick="return whereami()">Моё местоположение</a>
									</div>
									<div class="form-group">
										<textarea placeholder="Описание" name="description" class="form-control"></textarea>
									</div>
									<div id="uploader" class='uploader'></div>
									<input type="hidden" name="uid" value="<?php echo $uid; ?>" />

									<div class="checkbox">
										<label>
											<input type="checkbox"> Опубликовать анонимно
										</label>
									</div>
									<div class="button">
										<button type="submit">Добавить</button>
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