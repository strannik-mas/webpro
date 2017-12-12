<head>
<script src="jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="jquery.validate.js" type="text/javascript"></script>
<script src="additional-methods.js" type="text/javascript"></script>
<script src="jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript" src="ajaxeditor.js"></script>
<script type="text/javascript" src="chat.js"></script>
<script type="text/javascript" src="xmlhttprequest.js"></script>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="jquery-ui.min.css">
</head>
<div id="container">
<form action="<?php $_SERVER['PHP_SELF'] ?>" method='post' id='f1'>
<fieldset>
<legend>Add</legend>
	<label for="col_name">Column name</label>
	<input id="col_name" type="text" name="col_name" style="text-decoration:underline"><br>
	<label for="type">Type of field</label>
	<select id="type">
		<option selected value="0">Select type of field</option>
		<option value="VARCHAR">VARCHAR</option>
		<option value="INT">INT</option>
		<option value="DECIMAL">DECIMAL</option>
		<option value="TEXT">TEXT</option>
	</select><br>
	<label for="length">Length of field</label>
	<input id="length" type="number" name="length" style="text-decoration:underline" required><br>
	<label class="fr" for="decimal" style="display:none">Length of decimal fraction</label>
	<input class="fr" id="decimal" type="number" name="decimal" style="text-decoration:underline; display:none"><br>
	<input type="submit" name="insert" value="Insert column" id="but1" style="margin:5px 5px">
</fieldset>
</form>
<form action="<?php $_SERVER['PHP_SELF'] ?>" method='post' id='f2'>
<fieldset>
<legend>Delete</legend>
	<label>Column name</label>
	<select id="del_col">
	</select>
	<input
	<input type="submit" value="Delete column" name="delete" id="but2">
</fieldset>
</form>
<form action="<?php $_SERVER['PHP_SELF'] ?>" method='post' id='f3' onsubmit="return false;">
	<fieldset>
		<legend>Search</legend>
		<input id='searchable' name='searchable' type='text'>
		<select id="search_col"></select>
		<input type='submit' id='btn5' value='Search'>
	</fieldset>
<table border='1' width='600px' id='t1'>

</table>
<fieldset>
<legend>Add/Delete rows</legend>
	<input type="submit" value="Insert row" name="ins_row" id="but3">
	<input type="submit" value="Delete checked row(s)" name="del_row" id="but4">
</fieldset>

</form>
</div>

<!--Notifications-->
<!--use files ajaxeditor.js, chat.js (for init notify_worker) and notify_worker.js-->
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" id="notifyform" onsubmit="return false;">
	<fieldset>
		<legend>Notify</legend>
		<div class="selectDiv">
			<label>Unit: <select id="unitselect">
			<option>user</option>
			<option>blog</option>
			<option>chat</option>
			</select></label><br>
			<label>Type: <select id="typeselect">
				<option>message</option>
				<option>like</option>
				<option>comment</option>
				<option>favorite</option>
			</select></label><br>
			<label for="fromnotify">From: </label>
			<select id="fromnotify"></select><br>
			<label for="tonotify">To: </label>
			<select id="tonotify"></select>
		</div>
			<label for="notifyarea">Text: </label>
			<textarea id="notifyarea" rows="4" cols="20" required></textarea>
			<input type="submit" value="Send" />
				
	</fieldset>
</form>

<!--Chat-->
<!-- Форма входа -->
	<form id="frmLogin" onsubmit="return false" class="block">
		<h2>Authorization</h2>
		<div>
			<label for="txtLogin">Login</label>
			<input id="txtLogin" type="text" />
		</div>
		<div>
			<label for="txtPassword">Password</label>
			<input id="txtPassword" type="password" />
		</div>
		<button onclick="validateUser()">Login</button>
		<button onclick="hideForm()">Cancel</button>
		<div id="divMessage" class="block">
			<h2>Error</h2>
			<div>Wrong login or password!</div>
			<button onclick="hideErrorMessage()">Close</button>
		</div>
	</form> 
	
	<!-- Панель списка пользователей -->
	<div id="divUsers" class="block">
		<h2>User(s) online</h2>
		<button onclick="showLoginForm(this)" id='but_users'>Login</button>
		<ul></ul>
	</div>
	<h2>CHAT</h2>
	<form onsubmit="return false">
		<div>
			<textarea id="txtMessage"></textarea>
		</div>
		<select id="recipients"></select>
		<button onclick="addRecord()">Send</button>
	</form>
	<div id="divResult"></div>