<?php
	if($_GET['type'] == archive) {
		require_once('maplabelarchive.php');
?>
<script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIMXemj5IM4SjajssX1dZRIE8MFgbuDtI&libraries=places&callback=initMap"></script>
<script type="text/javascript" src="ops/maps/js/archivelabels.js"></script>
<?php
	}
	else {
		require_once('map.php');
?>
<script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIMXemj5IM4SjajssX1dZRIE8MFgbuDtI&libraries=places&callback=initMap"></script>
<script type="text/javascript" src="ops/maps/js/googlelabel.js"></script>
<?php	
	}
?>