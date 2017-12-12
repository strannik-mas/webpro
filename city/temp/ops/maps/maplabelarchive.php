<? require_once 'map_func.php'; ?>
<div class="main-content">
	<div class="container-fluid">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-9 notice-info archive">
					<div class="row">
						<div class="notice">
							<h1><img src="img/archive.png" alt="archive"/>Архив меток на карте, город Москва</h1>
						</div>
					</div>
					<div class="notice-search row">
						<form method='post' id='filter_archive'>
							<input type="hidden" name="func" value="search_labels" />
							<div class="form-group-inner col-lg-9 col-md-9 col-sm-8">
								<div class="row">
									<div class="col-lg-6 col-md-7 col-sm-8 col-xs-12 check-inner">
										<div class="check">
											<input id="check10" type="checkbox" name="type3" value="3">
											<label for="check10"><span><img src="img/info-mini-1.png" alt=""/></span></label>
										</div>
										<div class="check">
											<input id="check11" type="checkbox" name="type2" value="2">
											<label for="check11"><span><img src="img/info-mini-2.png" alt=""/></span></label>
										</div>
										<div class="check">
											<input id="check12" type="checkbox" name="type1" value="1">
											<label for="check12"><span><img src="img/info-mini-3.png" alt=""/></span></label>
										</div>
									</div>

									<div class="form-group col-lg-6 col-md-5 col-sm-4 col-xs-12">
										<input type="text" placeholder="Адрес" name="adress" class="form-control" id="streetaddr_arch">
									</div>
								</div>
								<div class="row">
									<div class="form-group col-lg-3 col-md-3 col-sm-4 col-xs-12">
										<input type="text" placeholder="Дата добав" name="data" class="form-control" id="datepicker_arch">
									</div>
									<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
										<input type="text" placeholder="Название" name="name" class="form-control" id="name_arch">
									</div>	
									<div class="form-group col-lg-5 col-md-5 col-sm-4 col-xs-12">
										<input type="text" placeholder="Имя пользователя" name="nick" class="form-control" id="username_arch">
									</div>
								</div>
							</div>
							<div class="form-group-inner col-lg-3 col-md-3 col-sm-4">
								<div class="">
									<div class="radius">
										<input type="number" placeholder="Радиус 3 км" name="radius" class="form-control" id="radius_arch">
									</div>

									<div class="button">
										<button onclick="form_submit('#filter_archive','#labellist'); return false;" type="submit">Найти <i href="" class="fa fa-search"></i></button>
									</div>

								</div>

							</div>

						</form>
					</div>
					<div class="archive-accident-list" id="labellist">
						<? search_labels(); ?>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 sidebar">

					<div class="banner">
						<img src="img/banner.png" alt="banner" class="img-responsive" />
					</div>
					<div class="info">
						<div class="info-inner">
							<a href="#">
								<span>
									<i>
										<img src="img/info-1.png" alt="logo"/>
									</i>
								</span>
								<strong>Нужна помощь на дороге?</strong>
							</a>
						</div>
						<div class="info-inner">
							<a href="#">
								<span>
									<i>
										<img src="img/info-2.png" alt="logo"/>
									</i>
								</span>
								<strong>Где сейчас наряды ДПС?</strong>
							</a>
						</div>
						<div class="info-inner">
							<a href="#">
								<span>
									<i>
										<img src="img/info-mini-3.png" alt="logo"/>
									</i>
								</span>
								<strong>Где произошли аварии?</strong>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
