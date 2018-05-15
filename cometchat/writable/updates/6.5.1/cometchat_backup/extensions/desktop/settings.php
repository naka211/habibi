<?php

/*

CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license

*/

if (!defined('CCADMIN')) { echo "NO DICE"; exit; }

global $getstylesheet;
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php');
$branded_yes = $branded_no = "";
if ($branded) {
	$branded_yes = "checked";
}else{
	$branded_no = "checked";
}
$base_url = BASE_URL;
$invalidfile ='';
$changeimage='';
if($branded==0){
	$changeimage='<br><h3 style="border-bottom:0px"><a href="?module=dashboard&amp;action=loadexternal&amp;type=extension&amp;name=desktop&amp;uploadimages=true">Click here</a> to set header images for your white-labelled Desktop Messenger</h3><br>';
}
if(!empty($_REQUEST['invalidfile'])){
	if($_REQUEST['invalidfile'] == 'fileformat'){
    	$invalidfile = '<div>Invalid file or file format. Please try again.</div><div style="clear:both;padding:10px;"></div>';
	}
	if($_REQUEST['invalidfile'] == 'filedimensions'){
    	$invalidfile = '<div>Invalid file dimensions. Please upload files with appropriate dimensions.</div><div style="clear:both;padding:10px;"></div>';
	}
}

if(!empty($_GET['uploadimageprocess'])){
	$allowedExts = array("png","jpg", "jpeg");
	$folderarray=array("size");
	$size = array(200,60);
	$flag = 1;

	if(!empty($_FILES["file"]["name"])){
    	$filename = $_FILES["file"]["name"];
    	$filesize = getimagesize($_FILES["file"]["tmp_name"]);
    	if(($filesize[0] == $size[0]) && ($filesize[1] == $size[1])){
			    $temp = explode(".", $filename);
			    $extension = end($temp);
			    if (!in_array($extension, $allowedExts)) {
			        header("Location:?module=dashboard&action=loadexternal&type=extension&uploadimages=true&name=desktop&invalidfile=fileformat");
			        exit;
			    }
		}else{
			header("Location:?module=dashboard&action=loadexternal&type=extension&uploadimages=true&name=desktop&invalidfile=filedimensions");
		    exit;
		}
	}
	$foldername = $folderarray[0];
	if(!empty($_FILES["file"]["name"])){
	    if ($_FILES["file"]["error"] > 0) {
	    } else {
	        if (file_exists(dirname(__FILE__)."/images/logo_login.png")) {
	        	unlink(dirname(__FILE__)."/images/logo_login.png");
			}
			if (file_exists(dirname(__FILE__)."/images/logo_login.png.jpg")) {
	        	unlink(dirname(__FILE__)."/images/logo_login.jpg");
			}
			if (file_exists(dirname(__FILE__)."/images/logo_login.jpeg")) {
	        	unlink(dirname(__FILE__)."/images/logo_login.jpeg");
			}
	        if(move_uploaded_file($_FILES["file"]["tmp_name"],dirname(__FILE__)."/images/logo_login.$extension")){
	        	$_SESSION['cometchat']['error'] = 'File uploaded successfully';
	        	echo '<script type="text/javascript">window.opener.location.reload();window.close();</script>';
	    	}
	    }
	}
    exit;
}

if(!empty($_GET['uploadimages'])){
	echo <<<EOD
	<!DOCTYPE html>
	$getstylesheet
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<link href="../css.php?admin=1" media="all" rel="stylesheet" type="text/css" />
	<style type="text/css" rel="stylesheet">
	.red{
		color:#F00;
	}
	form{
		padding: 5px;
	}
	.title.device_type{
		padding-top:6px;
		width: 114px;
	}
	</style>
	<script src="{$base_url}/js.php?admin=1"></script>
	<script type="text/javascript" language="javascript">
	    function resizeWindow() {
	        window.resizeTo((510), (($('form').outerHeight(false)+window.outerHeight-window.innerHeight)));
	    }
	    $(function() {
			setTimeout(function(){
				resizeWindow();
			},200);
		});
	</script>
	<form style="height:100%" action="?module=dashboard&action=loadexternal&type=extension&name=desktop&uploadimageprocess=true" method="post" enctype="multipart/form-data">
		<div id="content" style="width:auto">
			<h2>Only for white-labelled Desktop Messenger</h2>
			<br>
			<h3>If you would like to use your own images and colors for the Desktop Messenger, you can make necessary changes here.</h3>
			<label style="color:#F00; font-size:18px">{$invalidfile}</label>
		    <label>Choose Header Image Icon for your Desktop Messenger (Only .png & .jpeg files supported):</label>
            <div style="clear:both;padding:15px;"></div>
            <span class="title device_type">Upload Image Here :</span>
            <input type="file" name="file" id="logo">
            <label><span class="red">* </span>200px x 60px</label><br>
		    <div style="clear:both;padding:15px;"></div>
		    <label style="display:none;"><span class="red">* </span>250px x 50px</label><br>
		    <label style="display:block;float:right">Fields marked with <span class="red">* </span>are compulsory</label>
			<input type="submit" value="Update Settings" class="button">&nbsp;&nbsp;or <a href="?module=dashboard&amp;action=loadexternal&amp;type=extension&amp;name=desktop">Back</a>
		</div>
	</form>
	<script type="text/javascript" language="javascript"> resizeWindow(); </script>
EOD;
exit;
}
if (empty($_GET['process'])) {
$brandedhtml = "";
if (isset($_REQUEST['branded']) && $_REQUEST['branded']==1) {
$brandedhtml = <<<EOD
	<div class="col-md-12" style="padding-top:7px;">Branded :</div>
	<div class="col-md-12">
		<input  name="BRANDED" value="1" {$branded_yes}  type="radio" style="margin-top:8px;" />&nbsp;&nbsp;Yes
		&nbsp;&nbsp;&nbsp;
		<input name="BRANDED"  value="0" {$branded_no} type="radio" />&nbsp;&nbsp;No
	</div>
EOD;
}
echo <<<EOD
	<!DOCTYPE html>
	<script src="../js.php?type=core&name=jquery"></script>
	<script>
	  $ = jQuery = jqcc;
	</script>
	<link href="{$base_url}/css.php?admin=1" rel="stylesheet">
	<script src="{$base_url}/js.php?admin=1" type="text/javascript"></script>
	<script type="text/javascript" language="javascript">
	    function resizeWindow() {
	    	window.resizeTo((510), (($('form').outerHeight(false)+window.outerHeight-window.innerHeight)));
	    }
	    function reset_colors(){
	    	$('#login_background_field').val('#FFFFFF');
	    	$('#login_placeholder_field').val('#777788');
	    	$('#login_button_pressed_field').val('#002832');
	    	$('#login_button_text_field').val('#FFFFFF');
	    	$('#login_foreground_text_field').val('#000000');
	    	$('#dm_details').submit()
	    }
	    var arr = ['#login_background','#login_placeholder','#login_button_pressed','#login_button_text','#login_foreground_text'];
	    var arrColor = ['$login_background','$login_placeholder','$login_button_pressed','$login_button_text','$login_foreground_text'];
	    $(function() {

	    	$.each(arr,function(i,val){
	    		$(val).ColorPicker({
					color: arrColor[i],
					onShow: function (colpkr) {
						$(colpkr).fadeIn(500);
						return false;
					},
					onHide: function (colpkr) {
						$(colpkr).fadeOut(500);
						return false;
					},
					onChange: function (hsb, hex, rgb) {
						$(val+' div').css('backgroundColor', '#' + hex);
						$(val).attr('newcolor','#'+hex);
						$(val+'_field').val('#'+hex.toUpperCase());
					}
				});
	    	}) ;

			setTimeout(function(){
				resizeWindow();
			},200);
		});
	</script>
 <body class="navbar-fixed sidebar-nav fixed-nav" style="background-color: white;"><br>
		<form id="dm_details" action="?module=dashboard&action=loadexternal&type=extension&name=desktop&process=true" method="post" enctype="multipart/form-data">
		<div class="row col-md-12" style="padding-bottom:5px;">
			<div class="col-md-11" >If you would like to use your own images and colors for the Desktop Messenger, you can make necessary changes here.</div>
		</div>
	    <div class="row col-md-12">
	    	<div class="row col-md-6">
				
	    	{$brandedhtml}

				<div class="col-md-12" style="padding-top:7px;">Login Color :</div>
				<div class="col-md-1">
					<div class="colorSelector themeSettings" field="login_background" id="login_background">
						<div style="background:$login_background"></div>
					</div>
				</div>
				<div class="col-md-11">
					<input type="text" class="form-control themevariables" id="login_background_field" name="login_background" value="$login_background" required="true">
				</div>
				<div class="col-md-12" style="padding-top:7px;">Login text hint:</div>
				<div class="col-md-1">
					<div class="colorSelector themeSettings" field="login_placeholder" id="login_placeholder">
						<div style="background:$login_placeholder"></div>
					</div>
				</div>
				<div class="col-md-11">
					<input type="text" class="form-control" id="login_placeholder_field" name="login_placeholder" value="$login_placeholder" required="true">
				</div>
				<div class="col-md-12" style="padding-top:7px;">Login button:</div>
				<div class="col-md-1">
					<div class="colorSelector themeSettings" field="login_button_pressed" id="login_button_pressed">
						<div style="background:$login_button_pressed"></div>
					</div>
				</div>
				<div class="col-md-11">
					<input type="text" class="form-control" id="login_button_pressed_field" name="login_button_pressed" value="$login_button_pressed" required="true">
				</div>
				<div class="col-md-12" style="padding-top:7px;">Login button text:</div>
				<div class="col-md-1">
					<div class="colorSelector themeSettings" field="login_button_text" id="login_button_text">
						<div style="background:$login_button_text"></div>
					</div>
				</div>
				<div class="col-md-11">
					<input type="text" class="form-control" id="login_button_text_field" name="login_button_text" value="$login_button_text" required="true">
				</div>
				<div class="col-md-12" style="padding-top:7px;">Login text:</div>
				<div class="col-md-1">
					<div class="colorSelector themeSettings" field="login_foreground_text" id="login_foreground_text">
						<div style="background:$login_foreground_text"></div>
					</div>
				</div>
				<div class="col-md-11">
					<input type="text" class="form-control" id="login_foreground_text_field" name="login_foreground_text" value="$login_foreground_text" required="true">
				</div>
		    </div>
		    	<div class="row col-md-12" style="padding-bottom:5px;padding-left:28px;">
	      			<input type="submit" value="Update Settings" class="btn btn-primary">
	    		</div>
		   </div>
EOD;
} else {
	if(isset($_POST)){
		configeditor($_POST);
		header("Location:?module=dashboard&action=loadexternal&type=extension&name=desktop");
	}
}
