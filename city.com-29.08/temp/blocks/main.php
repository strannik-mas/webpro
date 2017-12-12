<div id="cnotice" class="cnotice">
	<div class="cmessage"></div>
	<div class="chide" onclick="$('.cnotice').hide();">x</div>
</div>
<?php
	$ops_folder = $_GET['ops'];
	require_once ('ops/' . $ops_folder . '/index.php');
?>