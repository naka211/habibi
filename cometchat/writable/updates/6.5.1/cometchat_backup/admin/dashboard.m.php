<?php

/*

CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license

*/

if (!defined('CCADMIN')) { echo "NO DICE"; exit; }

function index() {
	global $body, $currentversion, $client, $ts, $livesoftware, $marketplace, $plan, $planInfo;
	$available_version = setConfigValue('LATEST_VERSION','');
	if(cc_version_compare($available_version , $currentversion) < 1){
		$available_version = '';
	}

	$stats = '';
	$showplan = '';
	if (!empty($_GET['d'])) {
		header("Location: ".ADMIN_URL."\r\n");
		exit;
	}

	$onlineusers = onlineusers();
	$totalmessages = getMesseageCnt();

	$hrs24 = getTimeStamp()-60*60*24;
	$sql = ("select (select count(id) from cometchat where sent >= '".mysqli_real_escape_string($GLOBALS['dbh'],$hrs24)."') + (select count(id) from cometchat_chatroommessages where sent >= '".mysqli_real_escape_string($GLOBALS['dbh'],$hrs24)."') as totalmessages");
	$query = mysqli_query($GLOBALS['dbh'],$sql);
	$r = mysqli_fetch_assoc($query);
	$totalmessagest = !empty($r['totalmessages'])?$r['totalmessages']:0;

	$warningMsg = '';
	if ( ADMIN_USER == 'cometchat' && ADMIN_PASS == 'cometchat' && empty($client)) {
		$warningMsg = <<<EOD
		<div class="col-sm-12 col-lg-12">
				<div class="card card-inverse card-danger">
					<div class="pb-0" style="padding:16px;">
						<p>Warning: Default login detected, this is a security risk. Please update your login information in the Settings  -> General tab.</p>
					</div>
				</div>
			</div>
EOD;
	}else if(!preg_match('/^[0-9a-f]{40}$/i', ADMIN_PASS) && empty($client)){
		$warningMsg = <<<EOD
		<div class="col-sm-12 col-lg-12">
				<div class="card card-inverse card-danger">
					<div class="pb-0" style="padding:16px;">
						<p>Warning: Our login mechanism has been enhanced. To make your Admin Panel safer, please update your login information in the Settings -> General tab</p>
					</div>
				</div>
			</div>
EOD;
	}

	if (empty($totalmessages)) {
		$totalmessages = 0;
	}

	$cc_version_class = 'card-success';
	$acc_version_class = 'card-primary';
	if ($available_version != '') {
		$cc_version_class  = 'card-danger';
		$acc_version_class = 'card-success';
	}

	if(!empty($client)) {
		$active_plan = $planInfo['mapping'][$plan];
		$showplan = <<<EOD
		<div class="col-sm-6 col-lg-6">
				<div class="card card-inverse card-primary">
					<div class="card-block pb-0">
						<h1 class="mb-0" style="font-size:37px;">$active_plan</h1>
						<p>Your cometchat plan</p>
					</div>
				</div>
			</div>
EOD;
	}

$body = <<<EOD
	<div class="row">
		$warningMsg
		<div class="col-sm-6 col-lg-6">
		<div class="row">
			<div class="col-sm-6 col-lg-6">
				<div class="card card-inverse card-primary">
					<div class="card-block pb-0">
						<h1 class="mb-0">$onlineusers</h1>
						<p>Users Chatting</p>
					</div>
				</div>
			</div>
			<!--/col-->
			<div class="col-sm-6 col-lg-6">
				<div class="card card-inverse card-primary">
					<div class="card-block pb-0">
						<h1 class="mb-0">$totalmessages</h1>
						<p>Messages Exchanged</p>
					</div>
				</div>
			</div>
			<!--/col-->
			<div class="col-sm-6 col-lg-6">
				<div class="card card-inverse {$cc_version_class}">
					<div class="card-block pb-0">
						<h1 class="mb-0">v$currentversion</h1>
						<p>Current Version</p>
					</div>
				</div>
			</div>
			<!--/col-->
			<!--/col-->
			<div class="col-sm-6 col-lg-6">
				<div class="card card-inverse card-primary">
					<div class="card-block pb-0">
						<h1 class="mb-0">$totalmessagest</h1>
						<p>Messages Sent In The Last 24 Hours</p>
					</div>
				</div>
			</div>
			{$showplan}
EOD;
if(empty($client)) {
	if ($available_version == '') {
		$button = '<a href="?module=update&action=forceUpdate&ts='.$ts.'" class="btn" style="color: #fff;background-color: #1266f1;border-color: #0e61eb;">Force Update</a>';
		$body .= <<<EOD
		<div class="col-sm-6 col-lg-6">
			<div class="card card-inverse card-primary">
				<div class="card-block pb-0">
				<h3 class="mb-0" style="font-size:20px;"> CometChat is up to date</h3>
				<p style="margin-top:1rem;float:right;">{$button}</p>
				</div>
			</div>
		</div>
EOD;
	}else {
		$writablepath = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'writable'.DIRECTORY_SEPARATOR;
		$button = '<a href="?module=update&action=updateNow&ts='.$ts.'" class="btn" style="color: #fff;background-color: #1266f1;border-color: #0e61eb;"> Update Now</a>';
		if(!file_exists($writablepath.'updates'.DIRECTORY_SEPARATOR.$available_version.DIRECTORY_SEPARATOR.'cometchat.zip')){
			$button = '<a href="?module=update&force=1&ts='.$ts.'" class="btn" style="color: #fff;background-color: #1266f1;border-color: #0e61eb;"><i class="fa fa-download"></i> Download</a>';
		}
		$body .= <<<EOD
		<div class="col-sm-6 col-lg-6">
			<div class="card card-inverse card-primary">
				<div class="card-block pb-0">
					<h1 class="mb-0">v{$available_version} <span style="position:relative;float:right;">{$button}</span></h1>
					<p>Available Version &nbsp;<br><a style="color:white;" href="https://www.cometchat.com/change-log"  target="_blank">Change Log</a></p>
				</div>
			</div>
		</div>
		<!--/col-->
EOD;
	}
}
$body .= <<<EOD
			<div class="col-sm-6 col-lg-6">
				<div class="card">
					<div class="card-block pb-0">
						<h3 class="mb-0" style="font-size:20px;"> Love CometChat ?</h3>
						<p style="margin-top:1rem;"><span>Take a minute to <a href="https://www.cometchat.com/reviews/write/" target="_blank">write us a testimonial</a></span></p><br>
					</div>
				</div>
			</div>
		</div>
		</div>
		<div class="col-sm-6 col-lg-6">
			<div class="card">
				<div class="card-header">
						CometChat News
				</div>
				<div class="card-block">
					<iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FCometChat%2F&tabs=timeline&width=500&height=300&small_header=true&adapt_container_width=true&hide_cover=true&show_facepile=false&appId=143961562477205" width="100%" height="300" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
				</div>
			</div>
		</div>
	</div>
EOD;

if (empty($_SESSION['cometchat']['VERSION_CHECK']) && $marketplace == 0) {

	$body .= <<<EOD
		<script>
			function cmpVersion(a, b) {
			    var i, cmp, len, re = /(\.0)+[^\.]*$/;
			    a = (a + '').replace(re, '').split('.');
			    b = (b + '').replace(re, '').split('.');
			    len = Math.min(a.length, b.length);
			    for( i = 0; i < len; i++ ) {
			        cmp = parseInt(a[i], 10) - parseInt(b[i], 10);
			        if( cmp !== 0 ) {
			            return cmp;
			        }
			    }
			    return a.length - b.length;
			}

			function checkVersion(a, b) {
			    return cmpVersion(a, b) >= 0;
			}		
			jQuery(function() {
				var current_version = '{$currentversion}';
				$.ajax({
					url: 'https://my.cometchat.com/{$livesoftware}/getversion?callback=?',
					type: 'get',
					dataType: 'jsonp',
					crossDomain:true,
					xhrFields: {
						withCredentials: false
					},
					success: function(data) {
						if(data.version){
							var version = data.version;
							if(checkVersion(version,current_version)){
								window.location.href = 'index.php?module=dashboard&action=updateNewVersion&version='+version;
							}else{
								window.location.href = 'index.php?module=dashboard&action=updateNewVersion&version=empty';
							}
	                	}
					},
					error:function(data){
						console.log("error data",data);
					}
				});
			});
		</script>
EOD;
$_SESSION['cometchat']['VERSION_CHECK'] = 1;
}
	template();
}

function updateNewVersion(){
	global $ts;
	if($_GET['version'] == 'empty'){
		$newVersion = array('LATEST_VERSION' => '');
	}else{
		$newVersion = array('LATEST_VERSION' => $_GET['version']);
	}
	configeditor($newVersion);
	header("Location:?module=dashboard&ts={$ts}");
	exit();
}

function loadexternal() {
	if (file_exists(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.$_GET['type'].'s'.DIRECTORY_SEPARATOR.$_GET['name'].DIRECTORY_SEPARATOR.'settings.php')) {
		include_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.$_GET['type'].'s'.DIRECTORY_SEPARATOR.$_GET['name'].DIRECTORY_SEPARATOR.'settings.php');
	} else {
echo <<<EOD
<form>
<div id="content">
		<h2>No configuration required</h2>
		<h3>Sorry there are no settings to modify</h3>
		<input type="button" value="Close Window" class="button" onclick="javascript:window.close();">
</div>
</form>
EOD;
	}
}

function loadthemetype() {
	if (file_exists(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.$_GET['type'].'s'.DIRECTORY_SEPARATOR.$_GET['name'].DIRECTORY_SEPARATOR.'settings.php')) {
		include_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.$_GET['type'].'s'.DIRECTORY_SEPARATOR.$_GET['name'].DIRECTORY_SEPARATOR.'settings.php');
	} else {
echo <<<EOD
<form>
<div id="content">
		<h2>No configuration required</h2>
		<h3>Sorry there are no settings to modify</h3>
		<input type="button" value="Close Window" class="button" onclick="javascript:window.close();">
</div>
</form>
EOD;
	}
}

function themeembedcodesettings() {
	if (file_exists(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.$_GET['type'].'s'.DIRECTORY_SEPARATOR.$_GET['name'].DIRECTORY_SEPARATOR.'settings.php')) {
		$generateembedcodesettings = 1;
		include_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.$_GET['type'].'s'.DIRECTORY_SEPARATOR.$_GET['name'].DIRECTORY_SEPARATOR.'settings.php');
	} else {
echo <<<EOD
<form>
<div id="content">
		<h2>No configuration required</h2>
		<h3>Sorry there are no settings to modify</h3>
		<input type="button" value="Close Window" class="button" onclick="javascript:window.close();">
</div>
</form>
EOD;
	}
}
