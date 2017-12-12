<div class="main-content">
	<div class="container-fluid">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-9 notice-info">
					<div class="notice-search row">
						<form method="POST" action="./common/ajax.php" id="list_ad">
							<input type="hidden" name="func" value="list_ad" />
							<div class="form-group-inner col-lg-8 col-md-7">
								<div class="form-group search-inner">
									<a href="#" class="fa fa-search"></a>
									<input name="search" placeholder="Найти по названию" required="" type="search" class="form-control">
								</div>
								<div class="row">
									<div class="form-group col-lg-6 col-md-6 col-sm-12">
										<select name="group">
											<option>Рубрика</option>
											<?php
											global $link;
											$groups = $link -> query("SELECT * FROM ad_groups");
											while ($group = mysqli_fetch_assoc($groups)) {
												echo "<option value='" . $group['id'] . "'>" . $group['name'] . "</option>";
											}
											?>
										</select>
										
									</div>
									<div class="form-group col-lg-3 col-md-3 col-sm-4 col-xs-6">
										<input type="text" placeholder="Цена от" name="min-price" class="form-control">
									</div>
									<div class="form-group col-lg-3 col-md-3 col-sm-4 col-xs-6">
										<input type="text" placeholder="Цена до" name="max-price" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group-inner col-lg-4 col-md-5">
								<div class="check-big">
									<div class="check">
										<input id="check1" type="checkbox" name="like" value="">
										<label for="check1">Подписаться на объявления</label>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-8 check-min">
										<div class="check">
											<input id="check2" type="checkbox" name="images" value="1">
											<label for="check2">Только с фото</label>
										</div>
										<div class="check">
											<input id="check3" type="checkbox" name="address" value="1">
											<label for="check3">Все города</label>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-4 button">
										<button type="submit" onclick="form_submit('#list_ad','.notice-list'); return false;">
											Найти <i href="#" class="fa fa-search"></i>
										</button>
									</div>

								</div>

							</div>

						</form>
					</div>
					<div id="list_ad" class="notice-list">
						<?php echo list_ad(1); ?>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>