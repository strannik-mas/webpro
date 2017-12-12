<? if(status_user()==0){ ?>
<div class="login_form">
	<form method="POST" action="./common/ajax.php" id="login_user">
		<input type="hidden" name="func" value="login_user" />
		<input type="text" name="username" placeholder="Username" class="form-control" />
		<input type="password" name="password" placeholder="Password" class="form-control" />
		<a class="more" onclick="form_submit('#login_user','.cmessage');">Login</a>
	</form>
</div>
<? } ?>
<? if(status_user()==1){ ?>
<div class="logout_form">
	<form method="POST" action="./common/ajax.php" id="logout_user">
		<input type="hidden" name="func" value="logout_user" />
		<a class="more" onclick="form_submit('#logout_user','.cmessage');">Logout</a>
	</form>
</div>
<? } ?>