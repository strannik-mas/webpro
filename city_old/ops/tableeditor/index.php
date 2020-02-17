<script type="text/javascript" src="ops/tableeditor/js/ajaxeditor.js"></script>
<div id="container">
	<div id="tableSelect">
		<label for="alltable_select">Select table</label>
		<select id="alltable_select"></select>
	</div>
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
	<table border='1' width='600px' id='t1' class="paginated"></table>
	<fieldset>
	<legend>Add/Delete rows</legend>
		<input type="submit" value="Insert row" name="ins_row" id="but3">
		<input type="submit" value="Delete checked row(s)" name="del_row" id="but4">
	</fieldset>
	</form>
</div>


<div class="pagination" style="display: none" id="pagination">
	<form action="<?php $_SERVER['PHP_SELF'] ?>" method='post' id="pagespaginationform" onsubmit="return false;" >
		<label>Количество строк на странице
		<input id="nuberitemsforpages" name="nuberitemsforpages" value="10" type="numbers" required></label>
	</form>
	<ul id="numpages">
	</ul>
	<br />
</div>