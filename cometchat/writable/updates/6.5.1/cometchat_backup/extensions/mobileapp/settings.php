<?php

/*

CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license

*/

if (!defined('CCADMIN')) { echo "NO DICE"; exit; }

//global $getstylesheet;
include_once(dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."config.php");
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php');
global $lang;
$base_url = BASE_URL;

$hidden = '';
$hiddenwhitelabapp = '';
$mobileappOptionYes = '';
$mobileappOptionNo = '';
$useWhitelabelledappCheck = '';

if($mobileappOption) {
	$mobileappOptionYes = 'checked="checked"';
	$mobileappOptionNo = '';
} else {
	$hidden = 'style="display:none;"';
	$mobileappOptionYes = '';
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



if (empty($_GET['process'])) {
	echo <<<EOD
<!DOCTYPE html>
<html>
	<head>
	<script src="../js.php?type=core&name=jquery"></script>
	<script type="text/javascript">
		$ = jQuery = jqcc;
	</script>

	<link href="{$base_url}/css.php?admin=1" rel="stylesheet">
	<script src="{$base_url}/js.php?admin=1" type="text/javascript"></script>
	<script type="text/javascript">
		function resizeWindow() {
			window.resizeTo((550), (($('form').outerHeight(false)+window.outerHeight-window.innerHeight)));
		}

		$(function() {
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
		});
	</script>
</head>
<body class="navbar-fixed sidebar-nav fixed-nav" style="background-color: white;">
	<form action="?module=dashboard&action=loadexternal&type=extension&name=mobileapp&process=true" method="post" enctype="multipart/form-data">
		<div class="col-md-6">
			<div class="form-group row col-md-12" style="padding-bottom:5px;">
				<div class="col-md-12" style="padding-top:7px;">Title:</div>
				<div class="col-md-12">
					<input type="text" class="form-control" id="app_title" name="app_title" value="$app_title" placeholder="CometChat" />
				</div>
			</div>

			<div class="form-group row col-md-12">
				<div class="col-md-12" style="padding-top:7px;">AdMob Ad Unit Id:</div>
				<div class="col-md-12">
					<input type="text" class="form-control" id="adunit_field" name="adunit_id" value="$adunit_id" />
				</div>
				<div class="col-md-12" style="padding-top:7px;">
					<a href="https://support.google.com/admob/answer/3052638?hl=en" target="_blank"> AdMob Ad unit id </a> is used to display Google Admob advertisements in Mobile App.
				</div>
			</div>

			<div class="form-group row col-md-12" style="padding-top:5px;">
				<div class="col-md-12" style="padding-top:7px;">Enable invite via sms:</div>
				<div class="col-md-12">
					<input  name="invite_via_sms" value="1" {$invite_via_smsYes} type="radio" style="margin-top:8px;" />&nbsp;&nbsp;Yes
					&nbsp;&nbsp;&nbsp;
					<input name="invite_via_sms" {$invite_via_smsNo} value="0" type="radio" />&nbsp;&nbsp;No
				</div>
				<div class="col-md-12">
					You can invite user to use Mobile App by sending download link of Mobile App via SMS.
				</div>
			</div>

			<div class="form-group row col-md-12" style="padding-top:5px;">
				<div class="col-md-12" style="padding-top:7px;">Enable share this app:</div>
				<div class="col-md-12">
					<input  name="share_this_app" value="1" {$share_this_appYes} type="radio" style="margin-top:8px;" />&nbsp;&nbsp;Yes
					&nbsp;&nbsp;&nbsp;
					<input name="share_this_app" {$share_this_appNo} value="0" type="radio" />&nbsp;&nbsp;No
				</div>
				<div class="col-md-12">
					Share this app feature allows you to share the app link to all your friends accross different social media networks.
				</div>
			</div>

			<div class="form-group row col-md-12" style="padding-top:5px;">
				<div class="col-md-12" style="padding-top:7px;">Enable Deep Linking:</div>
				<div class="col-md-12">
					<input  name="mobileappOption" value="1" {$mobileappOptionYes} type="radio" style="margin-top:8px;" />&nbsp;&nbsp;Yes
					&nbsp;&nbsp;&nbsp;
					<input name="mobileappOption" {$mobileappOptionNo} value="0" type="radio" />&nbsp;&nbsp;No
				</div>
				<div class="col-md-12">
					Deep linking allows your users to open the mobile app directly from the mobile browser.
				</div>
			</div>

			<div class="form-group row col-md-12">
				<div class="col-md-12" style="padding-top:7px;">Register URL:</div>
				<div class="col-md-12">
					<input type="text" class="form-control" id="register_url" name="register_url" value="$register_url" />
				</div>
			</div>

			<div class="form-group row col-md-12">
				<div class="col-md-12" style="padding-top:7px;">Firebase server key:</div>
				<div class="col-md-12">
					<input type="text" class="form-control" id="firebase_field" name="firebaseauthserverkey" value="$firebaseauthserverkey" />
				</div>
				<div class="col-md-12" style="padding-top:7px;">
				Firebase server key allows you to start receiving push notifications on your mobile app.
				</div>
			</div>

			<div class="form-group row col-md-12" style="padding-bottom:5px;padding-left:28px;">
				<input type="submit" value="Update Settings" class="btn btn-primary" />
			</div>
		</div>
	</form>
</body>
</html>
EOD;
} else {
	configeditor($_POST);
	header("Location:?module=dashboard&action=loadexternal&type=extension&name=mobileapp");
}
