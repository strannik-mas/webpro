<div class="all-users" id="divUsers">
	<h3>Пользователи</h3>
	<p><span><? echo count_online_user(); ?> online</span></p>
	<div class="ausers">
		<? echo small_list_user(1); ?>
	</div>
</div>

<div class="search-user">
	<div class="form-group search-inner">
		<form method="post" id="small_list_user">
			<input type="hidden" name="func" value="small_list_user" />
			<a onclick="form_submit('#small_list_user','.ausers','');" class="fa fa-search"></a>
			<input name="search" placeholder="Найти пользователя" required="" type="search" class="form-control" name="search">
		</form>
	</div>
</div>