<?php
	if($_GET['type'] == archive && !isset($_GET['item'])) {
		require_once('maplabelarchive.php');
?>
<script type="text/javascript" src="ops/maps/js/archivelabels.js"></script>
<script type="text/javascript" src="ops/maps/js/datepicker-ru.js"></script>
<?php
	}elseif (isset($_GET['item'])) {
		require_once('detail.php');
		echo "<script type='text/javascript' src='ops/maps/js/detail.js'></script>";
	}
	else {
		require_once('map.php');
?>
<script type="text/javascript" src="ops/maps/js/googlelabel.js"></script>
<?php	
	}
?>