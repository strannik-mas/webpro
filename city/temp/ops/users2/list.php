<div class="main-content">
	<div class="container-fluid">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-9 user-page-list">
					<div class="row">
						<div class="notice">
							<h1><img src="img/user-list.png" alt="user-list"/>Пользователи</h1>
						</div>
						<div class="notice-search row">
							<form id="user_filter">
								<input type="hidden" name="func" value="list_user" />
								<div class="form-group-inner col-lg-8 col-md-7 col-sm-6">
									<div class="form-group search-inner">
										<a class="fa fa-search" onclick="form_submit('#user_filter','.user-list'); return false;"></a>
										<input name="search" placeholder="Найти по названию" required="" class="form-control fa fa-search" type="search">
									</div>

								</div>
								<div class="form-group-inner col-lg-4 col-md-5 col-md-6">
									<div class="check-big">
										<div class="check">
											<input id="check1" name="check" value="check1" type="checkbox">
											<label for="check1">только online</label>
										</div>
									</div>
								</div>
							</form>
						</div>
						<div class="user-list">
							<? echo list_user(1); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>