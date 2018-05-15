<?php

/*

CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license

*/

if (!defined('CCADMIN')) { echo "NO DICE"; exit; }

global $getstylesheet;
include_once(dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."config.php");
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php');
global $lang;

$hidden = '';
$hiddenwhitelabapp = '';
$mobileappOptionYes = '';
$mobileappOptionNo = '';
$useWhitelabelledappCheck = '';

if($mobileappOption) {
	$mobileappOptionYes = 'checked="checked"';
} else {
	$hidden = 'style="display:none;"';
	$mobileappOptionNo = 'checked="checked"';
}

if($useWhitelabelledapp) {
	$useWhitelabelledappCheck = 'checked="checked"';
} else {
	$hiddenwhitelabapp = 'display:none;';
}

if ($invite_via_sms == 1) {
	$invite_via_smsYes = 'checked="checked"';
	$invite_via_smsNo = '';
} else {
	$invite_via_smsNo = 'checked="checked"';
	$invite_via_smsYes = '';
}

if ($share_this_app == 1) {
	$share_this_appYes = 'checked="checked"';
	$share_this_appNo = '';
} else {
	$share_this_appNo = 'checked="checked"';
	$share_this_appYes = '';
}

if($invite_via_sms == 0 && $share_this_app == 0){
	$share_text_style = 'display:none;';
} else {
	$share_text_style = 'display:block;';
}

$invalidfile ='';
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
	$folderarray = array("ldpi", "mdpi", "hdpi", "xhdpi", "xxhdpi", "xxxhdpi","iOS","iOS@2x","iOS@3x");
	$size = array(array(108,36),array(144,48),array(216,72),array(288,96),array(432,144),array(576,192),array(125,25),array(250,50),array(250,50));
	$flag = 1;
    for ($i = 0; $i < 9; $i++) {
    	if(!empty($_FILES["file$i"]["name"])){
	    	$filename = $_FILES["file$i"]["name"];
	    	$filesize = getimagesize($_FILES["file$i"]["tmp_name"]);
	    	if(($filesize[0] == $size[$i][0] || $filesize[0] == $size[$i][1]) && $filesize[1] == $size[$i][1]){
	    		if($i < 6 || $filesize[0] != $size[$i][1]){
				    $temp = explode(".", $filename);
				    $extension = end($temp);
				    if (!in_array($extension, $allowedExts)) {
				        header("Location:?module=dashboard&action=loadexternal&type=extension&uploadimages=true&name=mobileapp&invalidfile=fileformat");
				        exit;
				    }
				}else{
					header("Location:?module=dashboard&action=loadexternal&type=extension&uploadimages=true&name=mobileapp&invalidfile=filedimensions");
				    exit;
				}
			}else{
				header("Location:?module=dashboard&action=loadexternal&type=extension&uploadimages=true&name=mobileapp&invalidfile=filedimensions");
			    exit;
			}
		}
	}
	for ($i = 0; $i < 9; $i++) {
		$foldername = $folderarray[$i];
		if(!empty($_FILES["file$i"]["name"])){
		    if ($_FILES["file$i"]["error"] > 0) {
		    } else {
		        if (file_exists(dirname(__FILE__)."/images/drawable-$foldername/ic_launcher.png")) {
		        	unlink(dirname(__FILE__)."/images/drawable-$foldername/ic_launcher.png");
				}
				if (file_exists(dirname(__FILE__)."/images/drawable-$foldername/ic_launcher.jpg")) {
		        	unlink(dirname(__FILE__)."/images/drawable-$foldername/ic_launcher.jpg");
				}
				if (file_exists(dirname(__FILE__)."/images/drawable-$foldername/ic_launcher.jpeg")) {
		        	unlink(dirname(__FILE__)."/images/drawable-$foldername/ic_launcher.jpeg");
				}
		        if(move_uploaded_file($_FILES["file$i"]["tmp_name"],dirname(__FILE__)."/images/drawable-$foldername/ic_launcher.$extension")){
		        	$_SESSION['cometchat']['error'] = 'File uploaded successfully';
		        	echo '<script type="text/javascript">window.opener.location.reload();window.close();</script>';
		    	}
		    }
		}
	}
    exit;
}

if(!empty($_GET['uploadimages'])){
	$android = "0";
	$iOS = "0";
	if (file_exists(dirname(__FILE__)."/images/drawable-ldpi/ic_launcher.png") || file_exists(dirname(__FILE__)."/images/drawable-ldpi/ic_launcher.jpg") || file_exists(dirname(__FILE__)."/images/drawable-ldpi/ic_launcher.jpeg")) {
    	$android = "1";
	}
	if (file_exists(dirname(__FILE__)."/images/drawable-iOS/ic_launcher.png") || file_exists(dirname(__FILE__)."/images/drawable-iOS/ic_launcher.jpg") || file_exists(dirname(__FILE__)."/images/drawable-iOs/ic_launcher.jpeg")) {
    	$iOS = "1";
	}
	echo <<<EOD
	<!DOCTYPE html>
	$getstylesheet
	<script src="../js.php?type=core&name=jquery"></script>
	<script>
		$ = jQuery = jqcc;
	</script>
	<link href="../css.php?admin=1" media="all" rel="stylesheet" type="text/css" />
	<style type="text/css" rel="stylesheet">
	.red{
		color:#F00;
	}
	.title.device_type{
		padding-top:6px;
	}
	</style>
	<script src="../js.php?admin=1"></script>
	<script type="text/javascript" language="javascript">
	    function resizeWindow() {
	        window.resizeTo((650), (($('form').outerHeight(false)+window.outerHeight-window.innerHeight)));
	    }
	    var iOS = "{$iOS}";
	    var android = "{$android}";
	    function validateForm(){
	    	if(
	    		(
	    			(
	    				(
	    					($('#ic_iOS').val() == null || $('#ic_iOS').val() == "") ||
	    					($('#ic_iOS_2x').val() == null || $('#ic_iOS_2x').val() == "")
	    				)
					 &&
	    				(iOS == "0")
	    			)
	    		)
	    		 &&
	    		(
	    			(
	    		 		(
	    		 			($('#ic_36').val() == null || $('#ic_36').val() == "") ||
		    		 		($('#ic_48').val() == null || $('#ic_48').val() == "") ||
							($('#ic_72').val() == null || $('#ic_72').val() == "") ||
							($('#ic_96').val() == null || $('#ic_96').val() == "") ||
							($('#ic_144').val() == null || $('#ic_144').val() == "")
						) &&
	    				(android == "0")
	    			)
				)
			){
	    		alert('Fields marked with * are compulsory');
	    		return false;
	    	}
	    }
	    $(function() {
			setTimeout(function(){
				resizeWindow();
			},200);
		});
	</script>
	<form style="height:100%" action="?module=dashboard&action=loadexternal&type=extension&name=mobileapp&uploadimageprocess=true" onsubmit="return validateForm()" method="post" enctype="multipart/form-data">
		<div id="content" style="width:auto">
			<h2>Only for white-labelled mobileapp</h2>
			<br>
			<h3>If you would like to use your own images and colors for the mobile app, you can make necessary changes here.</h3>
			<label style="color:#F00; font-size:18px">{$invalidfile}</label>
		    <label>Choose Header Image Icon for your App (Only .png & .jpeg files supported):</label>
		    <div style="font-weight:bold" class="titlefull">For Android (dimensions: width x height) :</div>
            <div style="clear:both;padding:10px;"></div>
            <span class="title device_type">LDPI: </span>
            <input type="file" name="file0" id="ic_36">
		    <label><span class="red">* </span>36px x 36px / 108px x 36px</label><br>
		    <div style="clear:both;padding:10px;"></div>
		    <span class="title device_type">MDPI: </span>
            <input type="file" name="file1" id="ic_48">
		    <label><span class="red">* </span>48px x 48px / 144px x 48px</label><br>
		    <div style="clear:both;padding:10px;"></div>
		    <span class="title device_type">HDPI: </span>
            <input type="file" name="file2" id="ic_72">
		    <label><span class="red">* </span>72px x 72px / 216px x 72px</label><br>
		    <div style="clear:both;padding:10px;"></div>
		    <span class="title device_type">XHDPI: </span>
            <input type="file" name="file3" id="ic_96">
		    <label><span class="red">* </span>96px x 96px / 288px x 96px</label><br>
		    <div style="clear:both;padding:10px;"></div>
		    <span class="title device_type">XXHDPI: </span>
            <input type="file" name="file4" id="ic_144">
		    <label><span class="red">* </span>144px x 144px / 432px x 144px</label><br>
		    <div style="clear:both;padding:10px;"></div>
		    <span class="title device_type">XXXHDPI: </span>
            <input type="file" name="file5" id="ic_192">
		    <label>192px x 192px / 576px x 192px(optional)</label><br>

		    <div style="clear:both;padding:10px;"></div>
            <div style="font-weight:bold" class="titlefull">For iOS (dimensions: width x height) :</div>
            <div style="clear:both;padding:10px;"></div>
            <span class="title device_type">iOS: </span>
            <input type="file" name="file6" id="ic_iOS">
		    <label><span class="red">* </span>125px x 25px</label><br>
		    <div style="clear:both;padding:10px;"></div>
		    <span class="title device_type">iOS@2x: </span>
            <input type="file" name="file7" id="ic_iOS_2x">
		    <label><span class="red">* </span>250px x 50px</label><br>
		    <div style="clear:both;padding:10px;"></div>
		    <span class="title device_type" style="display:none;">iOS@3x: </span>
            <input type="file8" name="file8" id="ic_iOS_3x" style="display:none;">
		    <label style="display:none;"><span class="red">* </span>250px x 50px</label><br>
		    <label style="display:block;float:right">Fields marked with <span class="red">* </span>are compulsory</label>
		    <div style="clear:both;padding:10px;"></div>
			<input type="submit" value="Update Settings" class="button">&nbsp;&nbsp;or <a href="?module=dashboard&amp;action=loadexternal&amp;type=extension&amp;name=mobileapp">Back</a>
		</div>
	</form>
	<script type="text/javascript" language="javascript"> resizeWindow(); </script>
EOD;
exit;
}

if (empty($_GET['process'])) {
echo <<<EOD
<!DOCTYPE html>

$getstylesheet
</style>
<script src="../js.php?type=core&name=jquery"></script>
<script>
  $ = jQuery = jqcc;
</script>
<link href="../css.php?admin=1" media="all" rel="stylesheet" type="text/css" />
<style rel="stylesheet" type="text/css">
	html{
		overflow-y: hidden;
	}
	form{
		padding: 5px;
	}
	#content{
		margin: 0;
	}
</style>
<script src="../js.php?admin=1"></script>
<script type="text/javascript" language="javascript">
    function resizeWindow() {
    	window.resizeTo((550), (($('form').outerHeight(false)+window.outerHeight-window.innerHeight)));
    }
    var arr = ['#login_background','#login_placeholder','#login_button_pressed','#login_button_text','#login_foreground_text','#actionbar_color','#actionbar_text_color','#left_bubble_color','#left_bubble_text_color','#right_bubble_color','#right_bubble_text_color','#tab_highlight_color'];
    var arrColor = ['$login_background','$login_placeholder','$login_button_pressed','$login_button_text','$login_foreground_text','$actionbar_color','$actionbar_text_color','$left_bubble_color','$left_bubble_text_color','$right_bubble_color','$right_bubble_text_color','$tab_highlight_color'];
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

		$('input:radio').change(function(){
			var radio_array = [];
			var i = 0;
			$('input[type="radio"]:checked').each(function() {
				radio_array[i++] = $(this).val();
			});
			if(radio_array.indexOf('1')>=0){
				$('.invite_text').show(600);
			} else {
				$('.invite_text').hide(600);
			}
		});

		$(".mobileappradio").click(function(){
	        var optionval = $(this).attr("value");

	        if(optionval == "1"){
	        	$("#mobileappdetails").show();
	        	resizeWindow();
	        } else {
	        	$("#mobileappdetails").hide();
	        	resizeWindow();
	        }
	    });

		$(".whilteappcheckbox").click(function(){
	        if($('.whilteappcheckbox').attr('checked')) {
			    $("#whiteappdetails").show();
			    resizeWindow();
			} else {
			    $("#whiteappdetails").hide();
			    resizeWindow();
			}
	    });
		$("form").submit(function(){
	        if(!$('.whilteappcheckbox').attr('checked')) {
			    $(".whilteappcheckbox").attr("value", "0");
			    $(".whilteappcheckbox").attr("checked", "checked");
			} else {
				$(".whilteappcheckbox").attr("value", "1");
			}
	    });
	});
</script>
<form action="?module=dashboard&action=loadexternal&type=extension&name=mobileapp&process=true" method="post" enctype="multipart/form-data">
	<div id="content" style="width:auto;height:520px;overflow-y:scroll">
		<h2>Settings</h2>
		<br>
		<h3>If you would like to use your own images and colors for the mobile app, you can make necessary changes here.</h3>
		<div>
			<div id="centernav" style="float:none;overflow:hidden;">
				<div class="title" style="padding-top:14px;">Home Url:</div>
				<div class="element">
					<input type="text" class="inputbox" id="homeUrl_field" name="homepage_URL" value="$homepage_URL" style="float: right;width: 147px;height:28px" placeholder="www.yoursite.com">
				</div>
			</div>
			<h3 style="border-bottom:0px;margin: 5px 0px 0px 135px">If you want to display a home tab in the app</h3>
			<h3 style="border-bottom:0px;margin: 5px 0px 0px 135px">App will load the above URL on click of Home icon. The contents of the site page need to be optimized by your team for mobile rendering. This feature is experimental and is not officially supported.</h3>
			<div id="centernav" style="float:none;overflow:hidden;">
				<div class="title" style="padding-top:14px;">Title:</div>
				<div class="element">
					<input type="text" class="inputbox" id="app_title" name="app_title" value="$app_title" style="float: right;width: 147px;height:28px" placeholder="CometChat">
				</div>
			</div><br>
			<div id="centernav" style="float:none;overflow:hidden;">
				<div class="title" style="padding-top:14px;">AdMob Ad Unit Id:</div>
				<div class="element">
					<input type="text" class="inputbox" id="adunit_field" name="adunit_id" value="$adunit_id" style="float: right;width: 147px;height:28px">
				</div>
			</div>
			<h3 style="border-bottom:0px;margin: 5px 0px 0px 135px">If you want to display Google Admob ads in your app</h3>

			<h3 style="border-bottom:0px;margin: 5px 0px 0px 135px"><a href="https://support.google.com/admob/answer/3052638?hl=en" target="_blank"> AdMob Ad unit id </a> is used to display advertisements in Mobile App.</h3>

			<div class="title long">Enable invite via sms:</div><div class="element"><input name="invite_via_sms" value="1" $invite_via_smsYes type="radio">Yes <input name="invite_via_sms" $invite_via_smsNo value="0" type="radio">No</div>
			<div style="clear:both;padding:10px;"></div>
			<h3 style="border-bottom:0px;margin: 5px 0px 0px 135px">You can invite user to use Mobile App by sending download link of Mobile App via SMS.</h3>

			<div class="title long">Enable share this app:</div><div class="element"><input name="share_this_app" value="1" $share_this_appYes type="radio">Yes <input name="share_this_app" $share_this_appNo value="0" type="radio">No</div>
			<div style="clear:both;padding:10px;"></div>
			<h3 style="border-bottom:0px;margin: 5px 0px 0px 135px">Share this app feature allows you to share the app link to all your friends accross different social media networks.</h3>

			<div class="title long">Enable Deep Linking:</div><div class="element"><input name="mobileappOption" value="1" type="radio" class="mobileappradio" $mobileappOptionYes>Yes <input name="mobileappOption" value="0" type="radio" class="mobileappradio" $mobileappOptionNo>No</div>
			<div style="clear:both;padding:10px;"></div>
			<h3 style="border-bottom:0px;margin: 5px 0px 0px 135px">Deep linking allows your users to open the mobile app directly from the mobile browser.</h3>

			<div id="mobileappdetails" $hidden>
				<div class="subtitle"><input name="useWhitelabelledapp" value="$useWhitelabelledapp" type="checkbox" class="whilteappcheckbox" $useWhitelabelledappCheck>Have the CometChat White-labelled Mobile App</div>
				<div style="clear:both;padding:5px;"></div>
				<h3 style="border-bottom:0px;margin: 0px 0px 0px 135px">If you do not have the CometChat White-labelled Mobile App, then your users will be directed to the free CometChat Mobile App if you have this feature enabled.</h3>
				<div style="clear:both;padding:10px;"></div>
				<div id="whiteappdetails" style="margin: 5px 0px 0px 95px;$hiddenwhitelabapp">
					<div class="title">App Bundle id:</div><div class="element"><input type="text" class="inputbox" name="mobileappBundleid" value="$mobileappBundleid"></div>
					<div style="clear:both;padding:5px;"></div>
					<div class="title">Playstore URL:</div><div class="element"><input type="text" class="inputbox" name="mobileappPlaystore" value="$mobileappPlaystore"></div>
					<div style="clear:both;padding:10px;"></div>
					<div class="title">Appstore URL:</div><div class="element"><input type="text" class="inputbox" name="mobileappAppstore" value="$mobileappAppstore"></div>
					<div style="clear:both;padding:10px;"></div>
				</div>
				
			</div>

			<div class="title long">Firebase server key:</div>
			<div class="element">
				<input type="text" class="inputbox" id="firebase_field" name="firebaseauthserverkey" value="$firebaseauthserverkey" style="float: right;width: 147px;height:28px">
			</div>
			<div style="clear:both;padding:10px;"></div>
			<h3 style="border-bottom:0px;margin: 5px 0px 0px 135px">Firebase server key allows you to start receiving push notifications on your mobile app.</h3>

			<br>
			<br>
			<div id="centernav" style="float:none;overflow:hidden;">
				<div class="title" style="padding-top:14px;">Login Color:</div>
				<div class="element">
					<input type="text" class="inputbox themevariables" id="login_background_field" name="login_background" value="$login_background" style="float: right;width: 100px;height:28px" required="true">
					<div class="colorSelector themeSettings" field="login_background" id="login_background">
						<div style="background:$login_background">
						</div>
					</div>
				</div>
			</div>
			<div id="centernav" style="float:none;overflow:hidden;">
				<div class="title" style="padding-top:14px;">Login text hint:</div>
				<div class="element">
					<input type="text" class="inputbox themevariables" id="login_placeholder_field" name="login_placeholder" value="$login_placeholder" style="float: right;width: 100px;height:28px" required="true">
					<div class="colorSelector themeSettings" field="login_placeholder" id="login_placeholder">
						<div style="background:$login_placeholder">
						</div>
				</div>
			</div>

			<div id="centernav" style="float:none;overflow:hidden;">
				<div class="title" style="padding-top:14px;">Login button:</div>
				<div class="element">
					<input type="text" class="inputbox themevariables" id="login_button_pressed_field" name="login_button_pressed" value="$login_button_pressed" style="float: right;width: 100px;height:28px" required="true">
					<div class="colorSelector themeSettings" field="login_button_pressed" id="login_button_pressed">
						<div style="background:$login_button_pressed">
						</div>
				</div>
			</div>

			<div id="centernav" style="float:none;overflow:hidden;">
				<div class="title" style="padding-top:14px;">Login button text:</div>
				<div class="element">
					<input type="text" class="inputbox themevariables" id="login_button_text_field" name="login_button_text" value="$login_button_text" style="float: right;width: 100px;height:28px" required="true">
					<div class="colorSelector themeSettings" field="login_button_text" id="login_button_text">
						<div style="background:$login_button_text">
						</div>
				</div>
			</div>

			<div id="centernav" style="float:none;overflow:hidden;">
				<div class="title" style="padding-top:14px;">Login text:</div>
				<div class="element">
					<input type="text" class="inputbox themevariables" id="login_foreground_text_field" name="login_foreground_text" value="$login_foreground_text" style="float: right;width: 100px;height:28px" required="true">
					<div class="colorSelector themeSettings" field="login_foreground_text" id="login_foreground_text">
						<div style="background:$login_foreground_text">
						</div>
				</div>
			</div>

			<div id="centernav" style="float:none;overflow:hidden;">
				<div class="title" style="padding-top:14px;">Action bar color:</div>
				<div class="element">
					<input type="text" class="inputbox themevariables" id="actionbar_color_field" name="actionbar_color" value="$actionbar_color" style="float: right;width: 100px;height:28px" required="true">
					<div class="colorSelector themeSettings" field="actionbar_color" id="actionbar_color">
						<div style="background:$actionbar_color">
						</div>
				</div>
			</div>

			<div id="centernav" style="float:none;overflow:hidden;">
				<div class="title" style="padding-top:14px;">Actionbar text color:</div>
				<div class="element">
					<input type="text" class="inputbox themevariables" id="actionbar_text_color_field" name="actionbar_text_color" value="$actionbar_text_color" style="float: right;width: 100px;height:28px" required="true">
					<div class="colorSelector themeSettings" field="actionbar_text_color" id="actionbar_text_color">
						<div style="background:$actionbar_text_color">
						</div>
				</div>
			</div>

			<div id="centernav" style="float:none;overflow:hidden;">
				<div class="title" style="padding-top:14px;">Left bubble color:</div>
				<div class="element">
					<input type="text" class="inputbox themevariables" id="left_bubble_color_field" name="left_bubble_color" value="$left_bubble_color" style="float: right;width: 100px;height:28px" required="true">
					<div class="colorSelector themeSettings" field="left_bubble_color" id="left_bubble_color">
						<div style="background:$left_bubble_color">
						</div>
				</div>
			</div>

			<div id="centernav" style="float:none;overflow:hidden;">
				<div class="title" style="padding-top:14px;">Left bubble text color:</div>
				<div class="element">
					<input type="text" class="inputbox themevariables" id="left_bubble_text_color_field" name="left_bubble_text_color" value="$left_bubble_text_color" style="float: right;width: 100px;height:28px" required="true">
					<div class="colorSelector themeSettings" field="left_bubble_text_color" id="left_bubble_text_color">
						<div style="background:$left_bubble_text_color">
						</div>
				</div>
			</div>

			<div id="centernav" style="float:none;overflow:hidden;">
				<div class="title" style="padding-top:14px;">Right bubble color:</div>
				<div class="element">
					<input type="text" class="inputbox themevariables" id="right_bubble_color_field" name="right_bubble_color" value="$right_bubble_color" style="float: right;width: 100px;height:28px" required="true">
					<div class="colorSelector themeSettings" field="right_bubble_color" id="right_bubble_color">
						<div style="background:$right_bubble_color">
						</div>
				</div>
			</div>

			<div id="centernav" style="float:none;overflow:hidden;">
				<div class="title" style="padding-top:14px;">Right bubble text color:</div>
				<div class="element">
					<input type="text" class="inputbox themevariables" id="right_bubble_text_color_field" name="right_bubble_text_color" value="$right_bubble_text_color" style="float: right;width: 100px;height:28px" required="true">
					<div class="colorSelector themeSettings" field="right_bubble_text_color" id="right_bubble_text_color">
						<div style="background:$right_bubble_text_color">
						</div>
				</div>
			</div>

			<div id="centernav" style="float:none;overflow:hidden;">
				<div class="title" style="padding-top:14px;">Tab highlight color:</div>
				<div class="element">
					<input type="text" class="inputbox themevariables" id="tab_highlight_color_field" name="tab_highlight_color" value="$tab_highlight_color" style="float: right;width: 100px;height:28px" required="true">
					<div class="colorSelector themeSettings" field="tab_highlight_color" id="tab_highlight_color">
						<div style="background:$tab_highlight_color">
						</div>
				</div>
			</div>


		</div>
		<div>

		    <br>
		    <br>
		    <h3 style="border-bottom:0px"><a href="?module=dashboard&amp;action=loadexternal&amp;type=extension&amp;name=mobileapp&amp;uploadimages=true">Click here</a> to set header images for your white-labelled mobileapp</h3>
		    <br>
		    <br>
		    <input type="submit" value="Update Settings" class="button">&nbsp;&nbsp;or <a href="javascript:window.close();">cancel or close</a>
	    </div>
	</div>
</form>
EOD;
} else {
	configeditor($_POST);
	header("Location:?module=dashboard&action=loadexternal&type=extension&name=mobileapp");
}
