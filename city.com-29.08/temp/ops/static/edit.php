<?php
if(data_user('accesslevel')==10){
	$uid = $_GET['uid'];
	global $link;
	
	if($_POST){
		$change = $_POST['html'];
		$insert = "UPDATE static SET html='{$change}' WHERE uid='{$uid}'";
		$link->query($insert);
		echo "Update Successful!";
	}
	
	$query1 = "SELECT * FROM static WHERE 1";
	$result1 = $link->query($query1);
	while($item = mysqli_fetch_assoc($result1)){
		echo '<a class="editbtn" href="index.php?ops=static&type=edit&uid='.$item['uid'].'">'.$item['uid'].'</a>';
	}
	
	$query = "SELECT * FROM static WHERE uid='{$uid}'";
	$result = $link->query($query);
	$result = mysqli_fetch_row($result);
	$html = $result[2];
?>
<h1><? echo $uid; ?></h1>
<form action="" method="post">
	<textarea name="html" id="html" cols="30" rows="10"><? echo $html; ?></textarea>
	<input type="submit" value="Submit" />
</form>
<script> 
var roxyFileman = './ckeditor/fileman/index.html'; 
$(function(){
CKEDITOR.replace( 'html',{filebrowserBrowseUrl:roxyFileman,
filebrowserImageBrowseUrl:roxyFileman+'?type=image',
removeDialogTabs: 'link:upload;image:upload'}); 
});
</script>
<?
}else{
echo "There is nothing here for you!";
}
?>