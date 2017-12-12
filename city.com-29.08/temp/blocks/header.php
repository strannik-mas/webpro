<?
if($_POST['login']==1){
	login_user();
}
if($_POST['login']==2){
	register_user();
}
if($_POST['func']=='chatcity'){
	chatcity();
}
if($_POST['func']=='logout_user'){
	logout_user();
}
if(status_user()==1 && $_SERVER['REQUEST_URI']=='/temp/index.php'){
	header("Location: index.php?ops=chat");
}
if(status_user()==0 && $_SERVER['REQUEST_URI']!='/temp/index.php'){
	header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--<script type="text/javascript" src="common/js/jquery-3.2.1.min.js"></script>-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="common/js/ajax.js"></script>
	<script src="common/js/jquery.validate.js" type="text/javascript"></script>
	<script src="common/js/additional-methods.js" type="text/javascript"></script>
	<script src="common/js/jquery-ui.min.js" type="text/javascript"></script>	
	<script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIMXemj5IM4SjajssX1dZRIE8MFgbuDtI&libraries=places&callback=initMap"></script>
	<script src="common/js/bootstrap.min.js"></script>
	<script src="common/js/jquery.nice-select.min.js"></script>
	<script src="common/js/fotorama.js"></script>
	<script type="text/javascript" src="common/js/ajaxform.js"></script>
	<script src="common/js/jquery.emoji.js"></script>
	<script type="text/javascript" src="common/js/main.js"></script>
	<script type="text/javascript" src="common/uploader/fine-uploader.js"></script>
	<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
	

	<title><?php  ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="common/css/bootstrap.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link rel="stylesheet" href="common/css/nice-select.css" />
	<link href="common/css/fotorama.css" rel="stylesheet">
	<link rel="stylesheet" href="common/css/font-awesome.min.css">
	<link href="common/css/styles.css" rel="stylesheet">
	<link href="common/css/media.css" rel="stylesheet">
	<link rel="stylesheet" href="common/css/jquery-ui.min.css">
	<link rel="stylesheet" href="common/uploader/fine-uploader-gallery.css">
<?php 
	if(stristr($_SERVER['QUERY_STRING'], 'tableeditor') !== FALSE) {
    	echo '<link rel="stylesheet" href="ops/tableeditor/css/style_table.css">';
  	} 
?>
<script type="text/template" id="qq-template">
	<div class="qq-uploader-selector qq-uploader qq-gallery" qq-drop-area-text="Перетяните фото сюда">
	<div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
	<div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
	</div>
	<div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
	<span class="qq-upload-drop-area-text-selector"></span>
	</div>
	<div class="qq-upload-button-selector qq-upload-button">
	<div>выберите файл</div>
	</div>
	<span class="qq-drop-processing-selector qq-drop-processing">
	<span>Processing dropped files...</span>
	<span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
	</span>
	<ul class="qq-upload-list-selector qq-upload-list" role="region" aria-live="polite" aria-relevant="additions removals">
	<li>
	<span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
	<div class="qq-progress-bar-container-selector qq-progress-bar-container">
	<div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
	</div>
	<span class="qq-upload-spinner-selector qq-upload-spinner"></span>
	<div class="qq-thumbnail-wrapper">
	<img class="qq-thumbnail-selector" qq-max-size="120" qq-server-scale>
	</div>
	<button type="button" class="qq-upload-cancel-selector qq-upload-cancel">X</button>
	<button type="button" class="qq-upload-retry-selector qq-upload-retry">
	<span class="qq-btn qq-retry-icon" aria-label="Retry"></span>
	Retry
	</button>

	<div class="qq-file-info">
	<div class="qq-file-name">
	<span class="qq-upload-file-selector qq-upload-file"></span>
	<span class="qq-edit-filename-icon-selector qq-btn qq-edit-filename-icon" aria-label="Edit filename"></span>
	</div>
	<input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
	<span class="qq-upload-size-selector qq-upload-size"></span>
	<button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">
	<span class="qq-btn qq-delete-icon" aria-label="Delete"></span>
	</button>
	<button type="button" class="qq-btn qq-upload-pause-selector qq-upload-pause">
	<span class="qq-btn qq-pause-icon" aria-label="Pause"></span>
	</button>
	<button type="button" class="qq-btn qq-upload-continue-selector qq-upload-continue">
	<span class="qq-btn qq-continue-icon" aria-label="Continue"></span>
	</button>
	</div>
	</li>
	</ul>

	<dialog class="qq-alert-dialog-selector">
	<div class="qq-dialog-message-selector"></div>
	<div class="qq-dialog-buttons">
	<button type="button" class="qq-cancel-button-selector">Close</button>
	</div>
	</dialog>

	<dialog class="qq-confirm-dialog-selector">
	<div class="qq-dialog-message-selector"></div>
	<div class="qq-dialog-buttons">
	<button type="button" class="qq-cancel-button-selector">No</button>
	<button type="button" class="qq-ok-button-selector">Yes</button>
	</div>
	</dialog>

	<dialog class="qq-prompt-dialog-selector">
	<div class="qq-dialog-message-selector"></div>
	<input type="text">
	<div class="qq-dialog-buttons">
	<button type="button" class="qq-cancel-button-selector">Cancel</button>
	<button type="button" class="qq-ok-button-selector">Ok</button>
	</div>
	</dialog>
	</div>
</script>
</head>