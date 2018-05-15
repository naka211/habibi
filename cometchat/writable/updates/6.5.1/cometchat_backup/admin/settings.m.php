<?php

/*
CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license

*/

if (!defined('CCADMIN')) { echo "NO DICE"; exit; }

$options = array(
    "hideBar"						=> array('choice','Hide bar for non-logged in users?'),
    "autoPopupChatbox"				=> array('choice','Auto-open chatbox when a new message arrives:'),
    "messageBeep"					=> array('choice','Beep on arrival of message from new user?'),
    "beepOnAllMessages"				=> array('choice','Beep on arrival of all messages?'),
    "searchDisplayNumber"			=> array('textbox','The number of users in Whos Online list after which search bar will be displayed:'),
    "thumbnailDisplayNumber"		=> array('textbox','The number of users in Whos Online list after which thumbnails will be hidden:'),
    "displayOfflineNotification"	=> array('choice','If yes, user offline notification will be displayed:'),
    "displayBusyNotification"		=> array('choice','If yes, user busy notification will be displayed:'),
    "notificationTime"				=> array('textbox','The number of milliseconds for which a notification will be displayed:'),
    "announcementTime"				=> array('textbox','The number of milliseconds for which an announcement will be displayed:'),
	/*"scrollTime"					=> array('textbox','Can be set to 800 for smooth scrolling when moving from one chatbox to another'),*/
    "armyTime"						=> array('choice','If set to yes, time will be shown in 24-hour clock format:'),
    "disableForMobileDevices"		=> array('choice','If set to yes, CometChat bar will be hidden in mobile devices:'),
    "startOffline"					=> array('choice','Load bar in offline mode for all first time users?'),
/*    "fixFlash"						=> array('choice','Set to yes, if Adobe Flash animations/ads are appearing on top of the bar (experimental):'),*/
    "lightboxWindows"				=> array('choice','Set to yes, if you want to use the lightbox style popups:'),
    /*"sleekScroller"					=> array('choice','Set to yes, if you want to use the new sleek scroller'),*/
    "desktopNotifications"			=> array('choice','If yes, Google desktop notifications will be enabled for Google Chrome:'),
    "windowTitleNotify"				=> array('choice','If yes, notify new incoming messages by changing the browser title:'),
    "floodControl"					=> array('textbox','Chat spam control in milliseconds (Disabled if set to 0):'),
    "windowFavicon"					=> array('choice','If yes, Update favicon with number of messages (Supported on Chrome, Firefox, Opera):'),
    "blockpluginmode"				=> array('choice','If set to yes, show blocked users in Who\'s Online list:'),
    "apikey"						=> array('display','API key for RESTful APIs for User Management on custom coded sites:'),
    "lastseen"                   	=> array('choice','If set to yes, users last seen will be shown:'),
);

if(empty($apikey) && empty($client)){
	$apikey = md5(time().$_SERVER['SERVER_NAME']);
	$apisave = array('apikey' => $apikey);
	configeditor($apisave);
}
if(!empty($client)) {
	$excludesettings = array('hideOffline','minHeartbeat','maxHeartbeat');
	foreach ($excludesettings as $value) {
		unset($options[$value]);
	}
}

function index() {
	global $body, $navigation, $options, $ts, $apikey, $gatrackerid, $client;
	$form = '';

	foreach ($options as $option => $result) {
		global ${$option};
		$form .= '<div class="form-group row"><div class="col-md-12"><label class="form-control-label">'.$result[1].'</label>';
		if ($result[0] == 'textbox') {
			$form .= '<input class="form-control" name="'.$option.'" value="'.${$option}.'" autocomplete="off" type="text">';
		}
		if ($result[0] == 'display') {
			$form .= '<input class="form-control" readonly name="'.$option.'" value="'.${$option}.'" autocomplete="off" type="text">';
		}
		if ($result[0] == 'choice') {
			if (${$option} == 1) {
				$form .='<div class=""><label class=""><div style="position:relative;"><input style="position: absolute;" name="'.$option.'" value="1" type="radio" checked ></div><span style="padding-left:25px;">Yes</span></label><label class=""><div style="position:relative;"><input style="position: absolute;left:8px;" name="'.$option.'" value="0" type="radio"></div><span style="padding-left:30px;">No</span></label></div>';
			} else {
				$form .='<div class=""><label class=""><div style="position:relative;"><input style="position: absolute;" name="'.$option.'" value="1" type="radio" ></div><span style="padding-left:25px;">Yes</span></label><label class=""><div style="position:relative;"><input style="position: absolute;left:8px;" name="'.$option.'" value="0" type="radio" checked></div><span style="padding-left:30px;">No</span></label></div>';
			}
		}
		if ($result[0] == 'dropdown') {
			$form .= '<select class="form-control"  name="'.$option.'">';
			foreach ($result[2] as $opt) {
				if ($opt == ${$option}) {
					$form .= '<option value="'.$opt.'" selected>'.ucwords($opt);
				} else {
					$form .= '<option value="'.$opt.'">'.ucwords($opt);
				}
			}
			$form .= '</select>';
		}
		$form .= '</div></div>';
	}

$dy = $dn = "";
if (defined('DISPLAY_ALL_USERS') && DISPLAY_ALL_USERS == 1) {
	$dy = "checked";
} else {
	$dn = "checked";
}
$baseurl = BASE_URL;
$baseurl_field = '';
if (empty($GLOBALS['client'])) {
	$baseurl_field = '<div class="form-group row"><div class="col-md-12"><label class="form-control-label">Base URL:</label><input class="form-control" name="BASE_URL" value="'.$baseurl.'" required="true" autocomplete="off" type="text"></div></div>';
}
$cc_bary = $cc_barn = "";
if (defined('BAR_DISABLED') && BAR_DISABLED == 1) {
	$cc_bary = "checked";
} else {
	$cc_barn = "checked";
}
$disabled_cometchat = <<<EOD
	<div class="form-group row">
	<div class="col-md-12"><label class="form-control-label">Disable CometChat:</label>
		<div class=""><label class=""><div style="position:relative;"><input style="position: absolute;" name="BAR_DISABLED" value="1" $cc_bary type="radio" ></div><span style="padding-left:25px;">Yes</span></label><label class=""><div style="position:relative;"><input style="position: absolute;left:8px;" name="BAR_DISABLED" value="0" $cc_barn type="radio"></div><span style="padding-left:30px;">No</span></label></div>
	</div></div>
EOD;

$body .= <<<EOD
<div class="row">
  <div class="col-sm-12 col-lg-12">
  	<div class="row">
	  	<div class="col-sm-12 col-lg-12">
		    <div class="card">
		      	<div class="card-header">
		        	Web Settings
		      	</div>
		      	<div class="card-block">
		      	<form action="?module=settings&action=updatesettings&ts={$ts}" method="post">
		      		{$disabled_cometchat}
					{$form}
					{$baseurl_field}
		      		<div class="form-group row"><div class="col-md-12"><label class="form-control-label">Google Analytics ID:</label>
		      			<input class="form-control" type="text" name="gatrackerid" value="{$gatrackerid}" >
		      		</div>
		      		</div>
					<div class="row col-md-12" style="padding-bottom:5px;">
				      <input type="submit" value="Update Settings"  class="btn btn-primary">
				    </div>
				</form>

	            </div>
	    	</div>
	  	</div>
	</div>
  </div>
</div>
EOD;
	template();

}

function updatesettings() {
	global $ts;

	configeditor($_POST);
	$_SESSION['cometchat']['error'] = 'Setting details updated successfully';
	header("Location:?module=settings&ts={$ts}");
}
function generalsettings() {
	global $ts, $body, $client;
	$generalsettings = $licensekey_interface = $changeuserpass_interface = $storage_interface = $caching_interface = $devsettings_interface = $customsettings_interface = '';
	$form = '';
$options = array(
    "disableRecentTab"				=> array('choice','Disable Recent Chats?'),
    "disableContactsTab"			=> array('choice','Disable Contacts Chats?'),
    "disableGroupTab"				=> array('choice','Disable Groups Chats?'),
    "hideOffline"					=> array('choice','Hide offline users in Who\'s Online list?'),
    "minHeartbeat"					=> array('textbox','Minimum poll-time in milliseconds (1 second = 1000 milliseconds):'),
    "maxHeartbeat"					=> array('textbox','Maximum poll-time in milliseconds'),
    "typingTimeout"					=> array('textbox','The number of milliseconds after which typing to will timeout:'),
    "idleTimeout"					=> array('textbox','The number of seconds after which user will be considered as idle:'),
    "displayOnlineNotification"		=> array('choice','If yes, user online notification will be displayed:')
);
if(!empty($client)) {
	$excludesettings = array('hideOffline','minHeartbeat','maxHeartbeat');
	foreach ($excludesettings as $value) {
		unset($options[$value]);
	}
}

foreach ($options as $option => $result) {
	global ${$option};
	$form .= '<div class="form-group row"><div class="col-md-12"><label class="form-control-label">'.$result[1].'</label>';
	if ($result[0] == 'textbox') {
		$form .= '<input class="form-control" name="'.$option.'" value="'.${$option}.'" autocomplete="off" type="text">';
	}
	if ($result[0] == 'display') {
		$form .= '<input class="form-control" readonly name="'.$option.'" value="'.${$option}.'" autocomplete="off" type="text">';
	}
	if ($result[0] == 'choice') {
		if (${$option} == 1) {
			$form .='<div class=""><label class=""><div style="position:relative;"><input style="position: absolute;" name="'.$option.'" value="1" type="radio" checked ></div><span style="padding-left:25px;">Yes</span></label><label class=""><div style="position:relative;"><input style="position: absolute;left:8px;" name="'.$option.'" value="0" type="radio"></div><span style="padding-left:30px;">No</span></label></div>';
		} else {
			$form .='<div class=""><label class=""><div style="position:relative;"><input style="position: absolute;" name="'.$option.'" value="1" type="radio" ></div><span style="padding-left:25px;">Yes</span></label><label class=""><div style="position:relative;"><input style="position: absolute;left:8px;" name="'.$option.'" value="0" type="radio" checked></div><span style="padding-left:30px;">No</span></label></div>';
		}
	}
	if ($result[0] == 'dropdown') {
		$form .= '<select class="form-control"  name="'.$option.'">';
		foreach ($result[2] as $opt) {
			if ($opt == ${$option}) {
				$form .= '<option value="'.$opt.'" selected>'.ucwords($opt);
			} else {
				$form .= '<option value="'.$opt.'">'.ucwords($opt);
			}
		}
		$form .= '</select>';
	}
	$form .= '</div></div>';
}
	if(empty($client)) {
		$changeuserpass_interface = changeuserpass();
		$licensekey_interface = licensekey();
		$storage_interface = storage();
	}
	if (!empty($_REQUEST['dev']) && $_REQUEST['dev'] == 1) {
		$devsettings_interface = devsettings();
	}
	$customsettings_interface = customsettings();
	$banuser_interface = banuser();
	$ccauth_interface = ccauth();
	$clearcache_interface = clearcachefiles();
	$caching_interface = caching();
	$whosonline_interface = whosonline();


$generalsettings = <<<EOD
		<div class="col-sm-12 col-lg-12">
		    <div class="card">
		      	<div class="card-header">
		        	General Settings
		      	</div>
		      	<div class="card-block">
			      	<form id="devsetting" action="?module=settings&action=updatedevsetting&ts={$ts}" method="post">
			      		{$form}
						<div class="row col-md-10" style="padding-bottom:5px;">
					      	<input type="submit" value="Update"  class="btn btn-primary">
					    </div>
		            </form>
	            </div>
	    	</div>
	  	</div>
EOD;

	$body = <<<EOD
	<div class="row">
	  <div class="col-sm-6 col-lg-6">
	  	<div class="row">
	  		$generalsettings
	  		$devsettings_interface
		  	$ccauth_interface
		  	$customsettings_interface
		</div>
	  </div>
	  	<div class="col-sm-6 col-lg-6">
			<div class="row">
				$whosonline_interface
				$changeuserpass_interface
				$clearcache_interface
				$caching_interface
				$licensekey_interface
				$banuser_interface
				$storage_interface
			</div>
		</div>
	</div>
EOD;
	template();
}
function caching() {
/*START: caching*/
global $ts;
$caching_interface = "";
if (empty($GLOBALS['client'])) {
	$nc = "";
	$mc = "";
	$fc = "";
	$mcr = "";
	$apc = "";
	$win = "";
	$sqlite = "";
	$memcached = "";
	$MC_SERVER = MC_SERVER;
	$MC_PORT = MC_PORT;
	$MC_USERNAME = MC_USERNAME;
	$MC_PASSWORD = MC_PASSWORD;
	$MC_NAME = MC_NAME;


	if($MC_NAME == 'files') {
		$fc = "selected = ''";
	} elseif ($MC_NAME == 'memcache') {
		$mc = "selected = ''";
	} elseif ($MC_NAME == 'memcachier') {
		$mcr = "selected = ''";
	}  elseif ($MC_NAME == 'wincache') {
		$win = "selected = ''";
	} elseif ($MC_NAME == 'sqlite') {
		$sqlite = "selected = ''";
	}  elseif ($MC_NAME == 'memcached') {
		$memcached = "selected = ''";
	} elseif ($MC_NAME == 'apc') {
		$apc = "selected = ''";
	} else {
		$nc = "selected = ''";
	}

$caching_interface .= <<<EOD
  <div class="col-sm-12 col-lg-12">
  	<div class="row">
	  	<div class="col-sm-12 col-lg-12">
		    <div class="card">
		      	<div class="card-header">
		        	Caching
		      	</div>
		      	<div class="card-block">
		      	<h6><small>You can set CometChat to use either Memcaching or File caching.</small></h6>
		      	<form id="memcache" action="?module=settings&action=updatecaching&ts={$ts}" method="post">
				<div class="form-group row">
					<div class="col-md-12">
						<label class="form-control-label">Select caching type:</label>
		      			<select class="form-control" id="MC_NAME" name="MC_NAME" >
							<option value="" {$nc}>No caching</option>
							<option value="memcache" {$mc}>Memcache</option>
							<option value="files" {$fc}>File caching</option>
							<option value="memcachier" {$mcr}>Memcachier</option>
							<option value="apc" {$apc}>APC</option>
							<option value="wincache" {$win}>Wincache</option>
							<option value="sqlite" {$sqlite}>SQLite</option>
							<option value="memcached" {$memcached}>Memcached</option>
						</select>
		      		</div>
	      		</div>
	      		<div class="form-group row memcache" style="display:none">
					<div class="col-md-12">
					<label class="form-control-label">Memcache server name:</label>
					<input class="form-control" type="text" id="MC_SERVER" name="MC_SERVER" value={$MC_SERVER}  required="true" >
					</div>
				</div>

	      		<div class="form-group row memcache" style="display:none">
					<div class="col-md-12">
					<label class="form-control-label">Memcache server port:</label>
					<input class="form-control" type="text" id="MC_PORT" name="MC_PORT" value={$MC_PORT} required="true" >
					</div>
				</div>

	      		<div class="form-group row memcachier" style="display:none">
					<div class="col-md-12">
					<label class="form-control-label">Memcachier Username:</label>
					<input class="form-control" type="text" id="MC_USERNAME"  name="MC_USERNAME" value="{$MC_USERNAME}" >
					</div>
				</div>

	      		<div class="form-group row memcachier" style="display:none">
					<div class="col-md-12">
					<label class="form-control-label">Memcachier Username:</label>
					<input class="form-control" type="text" id="MC_PASSWORD" name="MC_PASSWORD" value="{$MC_PASSWORD}" >
					</div>
				</div>
				<div class="row col-md-12" style="padding-bottom:5px;"><br>
			      <input type="submit" value="Update"  class="btn btn-primary">
			    </div>
			   </form>
	            </div>
	    	</div>
	  	</div>
	</div>
  </div>
<script>
	$(function(){

		if($("#MC_NAME option:selected").val() == 'memcache' || $("#MC_NAME option:selected").val() == 'memcached') {
			$('.memcache').css('display','block');
			$('.memcachier').hide();
		} else if($("#MC_NAME option:selected").val() == 'memcachier') {
			$('.memcache').css('display','block');
			$('.memcachier').show();
			$('#MC_USERNAME,#MC_PASSWORD').attr('required','true');
		}
	});


	$('select[id^=MC_NAME]').change(function() {
		$('#MC_USERNAME,#MC_PASSWORD').removeAttr('required');
		if($("#MC_NAME option:selected").index() == 1 || $("#MC_NAME option:selected").index() == 7) {
		   $('.memcache').css('display','block');
		   $('.memcachier').hide();
		} else if ($("#MC_NAME option:selected").index() == 3){
		   $('#MC_USERNAME,#MC_PASSWORD').attr('required','true');
		   $('.memcache').css('display','block');
		   $('.memcachier').show();
		} else {
		   $('.memcache').css('display','none');
		   $('.memcachier').hide();
		}
	});
	setTimeout(function () {
			var myform = document.getElementById('memcache');
			myform.addEventListener('submit', function(e) {
				e.preventDefault();
				if ($("#MC_NAME option:selected").index() == 1 && ($('#MC_SERVER').val() == null || $('#MC_SERVER').val() == '' || $('#MC_PORT').val() == null || $('#MC_PORT').val() == '')) {
					alert('Please enter memcache server name and port.');
					return false;
				} else if ($("#MC_NAME option:selected").index() == 3 && ($('#MC_SERVER').val() == null || $('#MC_SERVER').val() == '' || $('#MC_PORT').val() == null || $('#MC_PORT').val() == '' || $('#MC_USERNAME').val() == null || $('#MC_USERNAME').val() == '' || $('#MC_PASSWORD').val() == null || $('#MC_PASSWORD').val() == '' )) {
					alert('Please enter all the details for memcachier server.');
				} else if ($("#MC_NAME option:selected").index() == 7 && ($('#MC_SERVER').val() == null || $('#MC_SERVER').val() == '' || $('#MC_PORT').val() == null || $('#MC_PORT').val() == '')){
					alert('Please enter all the details for memcached server.');
				} else {
					myform.submit();
				}
			});
	}, 500);
</script>
EOD;
}
return $caching_interface;

}

function updatecaching(){
	if (!empty($GLOBALS['client'])) { header("Location:?module=dashboard&ts=".$GLOBALS['ts']); exit; }
    global $ts;
	$conn = 1;
	$errorCode = 0;
	$memcacheAuth = 0;
	include_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."cometchat_cache.php");
	if ($_POST['MC_NAME'] == 'memcachier') {
		$memcacheAuth = 1;
		$conn = 0;
		$memcache = new MemcacheSASL;
		$memcache->addServer($_POST['MC_SERVER'], $_POST['MC_PORT']);
		if($memcachierAuth = $memcache->setSaslAuthData($_POST['MC_USERNAME'], $_POST['MC_PASSWORD'])) {
			$memcache->set('auth', 'ok');
			if(!$conn = $memcache->get('auth')) {
				$errorCode = 3;
			}
			$memcache->delete('auth');
		} else {
			$errorCode = 3;
		}
	} elseif ($_POST['MC_NAME'] != '') {
			$conn = 0;
			$memcacheAuth = 1;
			phpFastCache::setup("storage",$_POST['MC_NAME']);
			$memcache = new phpFastCache();
			$driverPresent = (isset($memcache->driver->option['availability'])) ? 0 : 1;
			if ($driverPresent) {
				if(($_POST['MC_NAME'] == 'memcache' && class_exists("Memcache")) || ($_POST['MC_NAME'] == 'memcached' && class_exists("Memcached"))) {
					if ($_POST['MC_NAME'] == 'memcache'){
						$server = array(array($_POST['MC_SERVER'],$_POST['MC_PORT'],1));
						$memcache->option('server', $server);
					}
					if ($_POST['MC_NAME'] == 'memcached'){
						$server = array(array($_POST['MC_SERVER'],$_POST['MC_PORT'],1));
						$memcache->option('server', $server);
					}
					$memcache->set('auth','ok',30);
					if (!$conn = $memcache->get('auth')){
						$errorCode = 1;
					}
					$memcache->delete('auth');
				}
			}
	}
	if (!$errorCode) {
		configeditor($_POST);
		$_SESSION['cometchat']['error'] = 'Caching details updated successfully.';
	} else {
		if($_POST['MC_NAME']== 'memcachier') {
			$_SESSION['cometchat']['error'] = 'Failed to update caching details. Please check your Memchachier server details';
		} elseif ($_POST['MC_NAME'] == 'files') {
			$_SESSION['cometchat']['error'] = 'Please check file permission of your cache directory. Please try 755/777/644';
		} elseif ($_POST['MC_NAME'] == 'apc') {
			$_SESSION['cometchat']['error'] = 'Failed to update caching details. Please check your APC configuration.';
		} elseif ($_POST['MC_NAME'] == 'wincache') {
			$_SESSION['cometchat']['error'] = 'Failed to update caching details. Please check your Wincache configuration.';
		} elseif ($_POST['MC_NAME'] == 'sqlite') {
			$_SESSION['cometchat']['error'] = 'Failed to update caching details. Please check your SQLite configuration.';
		} elseif ($_POST['MC_NAME'] == 'memcached') {
			$_SESSION['cometchat']['error'] = 'Failed to update caching details. Please check your Memcached configuration.';
		} else {
			$_SESSION['cometchat']['error'] = 'Failed to update caching details. Please check your Memcache server configuration.';
		}
	}
	header("Location:?module=settings&action=generalsettings&ts={$ts}");
}

function whosonline() {
	global $body;
    global $ts;

	$dy = "";
	$dn = "";

	if (defined('DISPLAY_ALL_USERS') && DISPLAY_ALL_USERS == 1) {
		$dy = "checked";
	} else {
		$dn = "checked";
	}

$body = <<<EOD
<div class="col-sm-12 col-lg-12">
	<div class="card">
		<div class="card-header">
	    	Who's online list
	  	</div>
		<div class="card-block">
			<h7>You can set CometChat to show either all online users or all friends in the "Who's Online" list.</h7>
			<form action="?module=settings&action=updatewhosonline&ts={$ts}" method="post">
				<div class="form-group row">
					<div class="col-md-12">
			      	<label class="form-control-label">Show all online users:</label>
			      		<div class=""><label class=""><div style="position:relative;"><input style="position: absolute;" name="DISPLAY_ALL_USERS" value="1" $dy type="radio" ></div><span style="padding-left:25px;">Yes</span></label><label class=""><div style="position:relative;"><input style="position: absolute;left:8px;" name="DISPLAY_ALL_USERS" value="0" $dn type="radio"></div><span style="padding-left:30px;">No</span></label></div>
					</div>
				</div>

				<div class="row col-md-12"><br>
					<input type="submit" value="Update"  class="btn btn-primary">
				</div>
			</form>
		</div>
	</div>
</div>
EOD;
	return $body;
}

function updatewhosonline() {
    global $ts;
	configeditor($_POST);
	$_SESSION['cometchat']['error'] = 'Whos online listing updated successfully';
	header("Location:?module=settings&action=generalsettings&ts={$ts}");

}

function devsettings() {
	global $body, $ts;
	$dmo = $dmof = $elo = $elof = $cdo = $cdof = $recentTy = $recentTn = $contactTy = $contactTn = $groupTy = $groupTn = "";

	if (DEV_MODE == 1) {
		$dmo = "checked";
	} else {
		$dmof = "checked";
	}
	if (ERROR_LOGGING == 1) {
		$elo = "checked";
	} else {
		$elof = "checked";
	}
	if (CROSS_DOMAIN == 1) {
		$cdo = "checked";
	} else {
		$cdof = "checked";
	}
	if(!defined('CC_SITE_URL')) {
		$CC_SITE_URL =  '';
	} else {
		$CC_SITE_URL =  CC_SITE_URL;
	}


if (empty($GLOBALS['client'])) {
$body = <<<EOD
<div class="col-sm-12 col-lg-12">
    <div class="card">
      	<div class="card-header">
        	Developer Settings
      	</div>
	    <div class="card-block">
			<form id="devsetting" action="?module=settings&action=updatedevsetting&ts={$ts}" method="post">
				<div class="form-group row">
					<div class="col-md-12">
			      	<label class="form-control-label">Dev Mode:</label>
			      		<div class=""><label class=""><div style="position:relative;"><input style="position: absolute;" type="radio" name="DEV_MODE" value="1" $dmo ></div><span style="padding-left:25px;">Yes</span></label><label class=""><div style="position:relative;"><input style="position: absolute;left:8px;" type="radio" name="DEV_MODE" value="0" $dmof></div><span style="padding-left:30px;">No</span></label></div>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-md-12">
			      	<label class="form-control-label">Error Logging:</label>
			      		<div class=""><label class=""><div style="position:relative;"><input style="position: absolute;" type="radio" name="ERROR_LOGGING" value="1" $elo ></div><span style="padding-left:25px;">Yes</span></label><label class=""><div style="position:relative;"><input style="position: absolute;left:8px;" type="radio" name="ERROR_LOGGING" value="0" $elof></div><span style="padding-left:30px;">No</span></label></div>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-md-12">
			      	<label class="form-control-label">Cross Domain:</label>
			      		<div class=""><label class=""><div style="position:relative;"><input style="position: absolute;" type="radio" id="cdon" name="CROSS_DOMAIN" value="1" $cdo ></div><span style="padding-left:25px;">Yes</span></label><label class=""><div style="position:relative;"><input style="position: absolute;left:8px;" type="radio" id="cdoff" name="CROSS_DOMAIN" value="0" $cdof></div><span style="padding-left:30px;">No</span></label></div>
					</div>
				</div>

				<div id="ccurl" class="form-group row serverurl_text">
					<div class="col-md-12">
			      		<label class="form-control-label">Enter Site URL:</label>
			      		<input class="form-control" id="CC_SITE_URL" name="CC_SITE_URL" value="{$CC_SITE_URL}" autocomplete="off" type="text">
					</div>
				</div>

				<div class="row col-md-10" style="padding-bottom:5px;">
			      	<input type="submit" value="Update"  class="btn btn-primary">
			    </div>

			</form>
		</div>
	</div>
</div>
EOD;
}

$body .= <<<EOD
<script type="text/javascript">
		$(function() {
			if($('input[name=CROSS_DOMAIN]:checked').val() == 0){
				$("#ccurl").hide();
			}
			$('#cdoff').click(function(){
				$('#ccurl').hide('slow');
			});
			$('#cdon').click(function(){
				$('#ccurl').show('slow');
			});
			$("#leftnav_settings").find('a').removeClass('active_setting');
			$("#dev_settings").addClass('active_setting');

			$("#devsetting").submit(function(){
				var CROSS_DOMAIN = $('input[name=CROSS_DOMAIN]:checked').val();
				var CC_SITE_URL = $('input[name=CC_SITE_URL]').val();
				if(CROSS_DOMAIN == 1 && CC_SITE_URL == ''){
					alert("Please enter your site URL");
					return false;
				}
				return true;
			});
		});
	</script>
EOD;

return $body;

}

function updatedevsetting(){	
    global $ts;
	configeditor($_POST);
	$_SESSION['cometchat']['error'] = 'Settings updated successfully';
	header("Location:?module=settings&action=generalsettings&ts={$ts}");
}

function customsettings() {
	global $body, $ts, $customjs, $customcss, $enablecustomjs, $enablecustomcss, $enablecustomphp;
	$customIntegration = $cje = $cjd = $cce = $ccd = $cpe = $cpd = $vcj = $vcc = "";
	$vcj = $vcc = 'style="display:none;"';

	if ($enablecustomjs == 1) {
		$cje = "checked";
		$vcj = 'style="display:inline-block;"';
	} else {
		$cjd = "checked";
	}
	if ($enablecustomcss == 1) {
		$cce = "checked";
		$vcc = 'style="display:inline-block;"';
	} else {
		$ccd = "checked";
	}
	if ($enablecustomphp == 1) {
		$cpe = "checked";
	} else {
		$cpd = "checked";
	}

if (empty($GLOBALS['client'])) {
$customIntegration = <<<EOD
				<div class="form-group row">
					<div class="col-md-12">
			      	<label class="form-control-label">Enable Custom PHP:</label>
			      		<div class=""><label class=""><div style="position:relative;"><input style="position: absolute;" type="radio" id="cdon" name="enablecustomphp" value="1" $cpe ></div><span style="padding-left:25px;">Yes</span></label><label class=""><div style="position:relative;"><input style="position: absolute;left:8px;" type="radio" id="cdoff" name="enablecustomphp" value="0" $cpd></div><span style="padding-left:30px;">No</span></label></div>
					</div>
				</div>
EOD;
}

$body = <<<EOD
<div class="col-sm-12 col-lg-12">
    <div class="card">
      	<div class="card-header">
        	Custom Settings
      	</div>
	    <div class="card-block">
			<form id="customsetting" action="?module=settings&action=updatecustomsetting&ts={$ts}" method="post">
				<div class="form-group row">
					<div class="col-md-12">
			      	<label class="form-control-label">Enable Custom JavaScript:</label>
			      		<div class=""><label class=""><div style="position:relative;"><input style="position: absolute;" type="radio" name="enablecustomjs" value="1" $cje ></div><span style="padding-left:25px;">Yes</span></label><label class=""><div style="position:relative;"><input style="position: absolute;left:8px;" type="radio" name="enablecustomjs" value="0" $cjd></div><span style="padding-left:30px;">No</span></label><label class="" $vcj><span style="padding-left:25px;"><a class="" href="?module=editor&customjs=1&ts={$ts}">View/Edit</a></span></label></div>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-md-12">
			      	<label class="form-control-label">Enable Custom CSS:</label>
			      		<div class=""><label class=""><div style="position:relative;"><input style="position: absolute;" type="radio" name="enablecustomcss" value="1" $cce ></div><span style="padding-left:25px;">Yes</span></label><label class=""><div style="position:relative;"><input style="position: absolute;left:8px;" type="radio" name="enablecustomcss" value="0" $ccd></div><span style="padding-left:30px;">No</span></label><label class="" $vcc><span style="padding-left:25px;"><a class="" href="?module=editor&customcss=1&ts={$ts}">View/Edit</a></span></label></div>
					</div>
				</div>
				{$customIntegration}
				<div class="row col-md-10" style="padding-bottom:5px;">
			      	<input type="submit" value="Update"  class="btn btn-primary">
			    </div>

			</form>
		</div>
	</div>
</div>
EOD;
return $body;

}

function updatecustomsetting(){
    global $ts;
	configeditor($_POST);
	$_SESSION['cometchat']['error'] = 'Settings updated successfully';
	header("Location:?module=settings&action=generalsettings&ts={$ts}");
}


function clearcachefiles() {
	global $body, $ts;

$body = <<<EOD
<div class="col-sm-12 col-lg-12">
	<div class="card">
	  	<div class="card-header">
	    	Clear Cache
	    	<h4><small>Click Clear Cache to remove all cached and CSS/JS minified files.</small></h4>
	  	</div>
	  	<div class="card-block">
	  	<form action="?module=settings&action=clearcachefilesprocess&ts={$ts}" method="post">

		<div class="row col-md-12" style="padding-bottom:5px;"><br>
	      <input type="submit" value="Clear Cache"  class="btn btn-primary">
	    </div>

	   </form>
	    </div>
	</div>
</div>
EOD;

return $body;
}

function clearcachefilesprocess() {
    global $ts,$client;
	$_SESSION['cometchat']['error'] = 'Cache cleared successfully';

	include_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'jsmin.php');
	clearcachejscss(dirname(dirname(__FILE__)));
	if(function_exists('purgecache')) {
		purgecache($client);
	}
	if(isset($_SERVER['HTTP_REFERER'])) {
		header("Location:".$_SERVER['HTTP_REFERER']);
		exit();
	}
	header("Location:?module=settings&action=generalsettings&ts={$ts}");
}



function rrmdir($dir) {
	if (is_dir($dir)) {
		$objects = scandir($dir);
		foreach ($objects as $object) {
			if ($object != "." && $object != "..") {
				if (filetype($dir."/".$object) == "dir")
					rrmdir($dir."/".$object);
				else
					unlink   ($dir."/".$object);
			}
		}
		reset($objects);
		rmdir($dir);
	}
}

function disablecometchat() {
	global $body, $navigation, $ts;
	$dy = $dn = "";

	if (defined('BAR_DISABLED') && BAR_DISABLED == 1) {
		$dy = "checked";
	} else {
		$dn = "checked";
	}

$body .= <<<EOD
<div class="row">
  <div class="col-sm-8 col-lg-8">
  	<div class="row">
	  	<div class="col-sm-12 col-lg-12">
		    <div class="card">
		      	<div class="card-header">
		        	Disable CometChat
		      	</div>
		      	<div class="card-block">
		      	<h6>This feature will temporarily disable CometChat on your site.</h6>
		      	<form action="?module=settings&action=updatedisablecometchat&ts={$ts}" method="post">
				<div class="row col-md-12" style="padding-bottom:5px;"><br>
					<div class="col-md-4" style="text-align:right;padding-top:7px;"><label >Disable CometChat:</label></div>
					<div class="col-md-4"><input name="BAR_DISABLED" value="1" $dy type="radio" style="margin-top:8px;">&nbsp;&nbsp;Yes&nbsp;&nbsp;&nbsp;<input name="BAR_DISABLED" value="1" $dn type="radio">&nbsp;&nbsp;No</div>
			    </div>
				<div class="row col-md-12" style="padding-bottom:5px;"><br>
			      <input type="submit" value="UPDATE"  class="btn btn-primary">
			    </div>

			   </form>
	            </div>
	    	</div>
	  	</div>
	</div>
  </div>
  	<div class="col-sm-4 col-lg-4">
		<div class="card">
		  	<div class="card-header">
		    	Tips
		  	</div>
		  	<ul id="modules_availablemodules">
					<li>Displaying all online users is recommended for small sites only.</li>
 				</ul>
		</div>
		</div>
	</div>
</div>
<script>

</script>
EOD;

	template();

}

function updatedisablecometchat() {
    global $ts;
	configeditor($_POST);
	$_SESSION['cometchat']['error'] = 'CometChat updated successfully';
	header("Location:?module=settings&action=disablecometchat&ts={$ts}");

}

function banuser() {
	global $body,$navigation,$bannedUserIDs,$bannedUserIPs,$bannedMessage,$bannedWords,$ts;
	$bannedids = $bannedips = '';
	foreach ($bannedUserIDs as $b) {
		$bannedids .= $b.',';
	}
	foreach ($bannedUserIPs as $b) {
		$bannedips .= $b.',';
	}
	$bannedw = '';
	foreach ($bannedWords as $b) {
		$bannedw .= "'".$b.'\',';
	}
$body = <<<EOD
<div class="col-sm-12 col-lg-12">
<div class="card">
  	<div class="card-header">
    	Banned Words and Users
  		<h4><small>You can ban users and add words to the abusive list.</small></h4>
  	</div>
  	<div class="card-block">
      	<form action="?module=settings&action=banuserprocess&ts={$ts}" method="post">
	  		<div class="form-group row">
				<div class="col-md-12">
				<label class="form-control-label">Banned Words:</label>
				<input class="form-control" type="text" name="bannedWords" value="$bannedw">
				</div>
			</div>

	  		<div class="form-group row">
				<div class="col-md-12">
				<label class="form-control-label">Banned User IDs:</label>
				<input class="form-control" type="text" name="bannedUserIDs" value="$bannedids">
				</div>
			</div>

	  		<div class="form-group row">
				<div class="col-md-12">
				<label class="form-control-label">Banned User IPs:</label>
				<input class="form-control" type="text" name="bannedUserIPs" value="$bannedips">
				</div>
			</div>

	  		<div class="form-group row">
				<div class="col-md-12">
				<label class="form-control-label">Banned Message:</label>
				<input class="form-control" type="text" name="bannedMessage" value="$bannedMessage" required="true">
				</div>
			</div>

			<div class="row col-md-12">
		      <input type="submit" value="Update"  class="btn btn-primary">
		    </div>
	   	</form>
    </div>
	<div class="card-footer">
		<a class="searchuser" href="javascript:void();">If you do not know the user's ID</a>
	</div>
</div>
</div>
<script>
	$(function(){
		$(this).click(function(){
			$('#suggestions').html('');
		});
		$(".searchuser").click(function(){
			$("#adminModellink").trigger('click');
			$("#admin-modal-title").text('Find User ID');
			$("#admin-modal-body").css('height','200px');
			var form ='<div class="form-group row">';
				form +='<div class="col-md-12">';
				form +='<label class="form-control-label">Username:</label>';
				form +='<input type="text" class="form-control" id="susername" name="susername" required="true" autocomplete="off" placeholder="Enter Username">';
				form +='</div></div>';
			 	form +='<div class="form-group row">';
				form +='<div class="col-md-12">';
				form +='<button  type="button" id="search" class="btn btn-primary">Search</button>';
				form +='</div></div>';

			$("#admin-modal-body").html(form);
			$("#search").off('click').click(function(){
				var user = $("#susername").val();
				if(user == ''){
					alert("please enter the username");
					return false;
				}else{
			       	$.ajax({
						type: "POST",
						url: "?module=settings&action=searchlogs&ts={$ts}",
						data: {susername: user},
						success: function(data) {
							$("#admin-modal-title").text('Search Result');
							$("#admin-modal-body").css('height','520px');
							$("#admin-modal-body").html(data);
							$('[data-toggle="tooltip"]').tooltip();
			            }
					});
				}
			});
		});
	});
</script>
EOD;
return $body;
}


function banuserprocess() {
    global $ts;
	if (!empty($_POST['bannedMessage'])) {
		if(!empty($_POST['bannedUserIDs'])){
			$_POST['bannedUserIDs'] = rtrim($_POST['bannedUserIDs'], ',');
    		$_POST['bannedUserIDs'] = explode(',', $_POST['bannedUserIDs']);
		}else{
			$_POST['bannedUserIDs'] = array();
		}

		if(!empty($_POST['bannedWords'])){
			$_POST['bannedWords'] = rtrim($_POST['bannedWords'], ',');
			$_POST['bannedWords'] = str_replace("'", "", $_POST['bannedWords']);
    		$_POST['bannedWords'] = explode(',', $_POST['bannedWords']);
		}else{
			$_POST['bannedWords'] = array();
		}

		if(!empty($_POST['bannedUserIPs'])){
			$_POST['bannedUserIPs'] = rtrim($_POST['bannedUserIPs'], ',');
    		$_POST['bannedUserIPs'] = explode(',', $_POST['bannedUserIPs']);
		}else{
			$_POST['bannedUserIPs'] = array();
		}
		$_SESSION['cometchat']['error'] = 'Banned words and users successfully modified.';

		configeditor($_POST);
	}
	header("Location:?module=settings&action=generalsettings&ts={$ts}");
}

function changeuserpass() {
	if (!empty($GLOBALS['client'])) { header("Location:?module=dashboard&ts=".$GLOBALS['ts']); exit; }
	global $body;
	global $navigation;
    global $ts;

	$nuser = ADMIN_USER;
	$npass = ADMIN_PASS;

$body = <<<EOD
  	<div class="col-sm-12 col-lg-12">
	    <div class="card">
	      	<div class="card-header">
	        	Change Administration Username and Password
	      	</div>
	      	<div class="card-block">

	      	<form action="?module=settings&action=changeuserpassprocess&ts={$ts}" method="post">

      		<div class="form-group row">
				<div class="col-md-12">
				<label class="form-control-label">Email:</label>
				<input class="form-control" name="ADMIN_USER" placeholder="Enter your email" value="$nuser" required="true" autocomplete="off" type="email">
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-12">
				<label class="form-control-label">Old Password:</label>
				<input class="form-control" name="old_PASS" value="" required="true" autocomplete="off" type="password">
				</div>
			</div>

      		<div class="form-group row">
				<div class="col-md-12">
				<label class="form-control-label">New Password:</label>
				<input class="form-control" name="ADMIN_PASS" value="" required="true" autocomplete="off" type="password">
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-12">
				<label class="form-control-label">Confirm New Password:</label>
				<input class="form-control" name="Confirm_PASS" value="" required="true" autocomplete="off" type="password">
				</div>
			</div>

			<div class="row col-md-12" style="padding-bottom:5px;"><br>
		      <input type="submit" value="Update"  class="btn btn-primary">
		    </div>

		   </form>
            </div>
    	</div>
  	</div>
EOD;
return $body;
}

function changeuserpassprocess() {
	global $ts;
	if (!empty($_POST['ADMIN_USER']) && !empty($_POST['ADMIN_PASS']) && !empty($_POST['Confirm_PASS']) && !empty($_POST['old_PASS'])) {
		if((sha1($_POST['old_PASS'])==ADMIN_PASS) || ($_POST['old_PASS']==ADMIN_PASS)){
			if($_POST['ADMIN_PASS']==$_POST['Confirm_PASS']){
				$_POST['ADMIN_PASS']=sha1($_POST['ADMIN_PASS']);
				$_SESSION['cometchat']['error'] = 'User/pass successfully modified';
				configeditor($_POST);
			}else{
				$_SESSION['cometchat']['error'] = 'Comfirm password did not match';
				$_SESSION['cometchat']['type'] = 'alert';
				header("Location:?module=settings&action=generalsettings&ts={$ts}");
				exit();
			}
		}else{
			$_SESSION['cometchat']['error'] = 'Old password did not match';
			$_SESSION['cometchat']['type'] = 'alert';
			header("Location:?module=settings&action=generalsettings&ts={$ts}");
			exit();
		}
	}
	header("Location:?module=dashboard&ts={$ts}");
}



function baseurl() {
	if (!empty($GLOBALS['client'])) { header("Location:?module=dashboard&ts=".$GLOBALS['ts']); exit; }
	global $body;
	global $navigation;
    global $ts;

	$baseurl = BASE_URL;

$body .= <<<EOD
<div class="row">
  <div class="col-sm-8 col-lg-8">
  	<div class="row">
	  	<div class="col-sm-12 col-lg-12">
		    <div class="card">
		      	<div class="card-header">
		        	Update Base URL
		      	</div>
		      	<div class="card-block">

		      	<h4><small>If CometChat is not working on your site, your Base URL might be incorrect.<br>Our detection algorithm suggests: <b><script>document.write(window.location.pathname.replace(/admin\/.*/,"").replace("admin",""));</script></b></small></h4>
		      	<form action="?module=settings&action=updatebaseurl&ts={$ts}" method="post">
				<div class="row col-md-12" style="padding-bottom:5px;"><br>
					<div class="col-md-4" style="text-align:right;padding-top:7px;"><label >Base URL:</label></div>
					<div class="col-md-4"><input class="form-control" name="BASE_URL" value="$baseurl" required="true" autocomplete="off" type="text"></div>
			    </div>
				<div class="row col-md-12" style="padding-bottom:5px;"><br>
			      <input type="submit" value="UPDATE"  class="btn btn-primary">
			    </div>

			   </form>
	            </div>
	    	</div>
	  	</div>
	</div>
  </div>
  	<div class="col-sm-4 col-lg-4">
		<div class="card">
		  	<div class="card-header">
		    	Tips
		  	</div>
		  	<ul id="modules_availablemodules">
					<li>Displaying all online users is recommended for small sites only.</li>
 				</ul>
		</div>
		</div>
	</div>
</div>
EOD;
	template();
}

function updatebaseurl() {
	if (!empty($GLOBALS['client'])) { header("Location:?module=dashboard&ts=".$GLOBALS['ts']); exit; }
    global $ts;
	if (!empty($_POST['BASE_URL'])) {

		$baseurl = str_replace('\\','/',$_POST['BASE_URL']);

		if ($baseurl[0] != '/' && strpos($baseurl,'http://')===false && strpos($baseurl,'https://')===false) {
			$baseurl = '/'.$baseurl;
		}

		if ($baseurl[strlen($baseurl)-1] != '/') {
			$baseurl = $baseurl.'/';
		}

		$_SESSION['cometchat']['error'] = 'Base URL successfully modified';
		configeditor($_POST);
	}
	header("Location:?module=settings&action=baseurl&ts={$ts}");
}



function comet() {
	if (!empty($GLOBALS['client'])) { header("Location:?module=dashboard&ts=".$GLOBALS['ts']); exit; }
	global $body, $navigation, $ts, $cometservice;
	$cometchecky = "";
	$cometcheckn = "";
	$isTypingy = "";
	$isTypingn = "";
	$cometselfhostedy = "";
	$cometselfhostedn = "";
	$messagereceipty = "";
	$messagereceiptn = "";
	$messagesyncy = "";
	$messagesyncn = "";

	if (defined('USE_COMET') && USE_COMET == 1) {
		$cometchecky = "checked";
	} else {
		$cometcheckn = "checked";
	}

	if (defined('IS_TYPING') && IS_TYPING == 1) {
		$isTypingy = "checked";
	} else {
		$isTypingn = "checked";
	}

	if (defined('MESSAGE_RECEIPT') && MESSAGE_RECEIPT == 1) {
		$messagereceipty = "checked";
	} else {
		$messagereceiptn = "checked";
	}

	if (defined('CS_MESSAGE_SYNC') && CS_MESSAGE_SYNC == 1) {
		$messagesyncy = "checked";
	} else {
		$messagesyncn = "checked";
	}

	if(USE_COMET == 1){
		$cometservice = 'style="display:block"';
	}else{
		$cometservice = 'style="display:none"';
	}

	$keya = KEY_A;
	$keyb = KEY_B;
	$keyc = KEY_C;
	$transport = TRANSPORT;
	$server_url = CS_TEXTCHAT_SERVER;
	$cometserviceselfhosted = 0;
	if($transport == 'cometserviceselfhosted') {
		$cometselfhostedy = "checked";
	} else {
		$cometselfhostedn = "checked";
	}

	$overlay = '';
	if (file_exists(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'transports'.DIRECTORY_SEPARATOR.'cometserviceselfhosted'.DIRECTORY_SEPARATOR.'comet.php')) {
		$cometserviceselfhosted = 1;
	}
	if (!checkCurl()) {
		$overlay = <<<EOD
			<script>
			jQuery('#error_div').before('<div class="col-sm-12 col-lg-12" id="overlaymain" style="position:relative"></div>');
				var overlay = $('<div></div>')
					.attr('id','overlay')
					.css({
						'position':'absolute',
						'height':$('#error_div').innerHeight(),
						'width':$('#error_div').innerWidth(),
						'background-color':'#FFFFFF',
						'opacity':'0.9',
						'z-index':'99',
						'right': '0',
						'margin-left':'1px'
					})
					.appendTo('#overlaymain');
					$('<div class="col-sm-12 col-lg-12">cURL extension is disabled on your server. Please contact your webhost to enable it.<br> cURL is required for CometService.</div>')
						.css({'z-index':' 9999',
						'color':'#000000',
						'font-size':'15px',
						'font-weight':'bold',
						'display':'block',
						'text-align':'center',
						'margin':'auto',
						'position':'absolute',
						'width':'100%',
						'top':'100px'
					}).appendTo('#overlaymain');

			</script>
EOD;
	}


$body .= <<<EOD
<div class="row">
	<div class="col-sm-12 col-lg-12" id="error_div">
    <div class="card">
      	<div class="card-header">
        	CometService
        	<h4><small>If you are using our hosted CometService, please enter the details here</small></h4>
      	</div>
      	<div class="card-block">
      	<form action="?module=settings&action=updatecomet&ts={$ts}" method="post">

      	<div class="form-group row"><div class="col-md-12">
      	<label class="form-control-label">Use Comet Service?</label>
			<div class=""><label class=""><div style="position:relative;"><input style="position: absolute;" id="cs1" class="comet" type="radio" name="dou" value="1" $cometchecky type="radio" ></div><span style="padding-left:25px;">Yes</span></label><label class=""><div style="position:relative;"><input style="position: absolute;left:8px;" id="cs2" class="comet" type="radio" $cometcheckn name="dou" value="0"></div><span style="padding-left:30px;">No</span></label></div>
		</div></div>

		<div class="enabled_cs" $cometservice>

			<div class="form-group row">
				<div class="col-md-12">
		      	<label class="form-control-label">Use SelfHosted Comet Service?</label>
		      		<div class=""><label class=""><div style="position:relative;"><input style="position: absolute;" type="radio" name="dos" value="1" $cometselfhostedy ></div><span style="padding-left:25px;">Yes</span></label><label class=""><div style="position:relative;"><input style="position: absolute;left:8px;" type="radio" name="dos" value="0" $cometselfhostedn></div><span style="padding-left:30px;">No</span></label></div>
				</div>
			</div>

			<div class="form-group row serverurl_text" style="display:none;">
				<div class="col-md-12">
		      	<label class="form-control-label">Server URL:</label>
		      		<input class="form-control" name="server_url" value="$server_url" placeholder="http://www.yoursite.com:portnumber" type="text">
				</div>
			</div>

		    <div class="cckeys">
				<div class="form-group row">
					<div class="col-md-12">
			      	<label class="form-control-label">Key A:</label>
			      		<input class="form-control" name="keya" value="$keya" required="true" type="text">
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-12">
			      	<label class="form-control-label">Key B:</label>
			      		<input class="form-control" name="keyb" value="$keyb" required="true" type="text">
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-12">
			      	<label class="form-control-label">Key C:</label>
			      		<input class="form-control" name="keyc" value="$keyc" required="true" type="text">
					</div>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-12">
		      	<label class="form-control-label">Use isTyping Service?</label>
		      		<div class=""><label class=""><div style="position:relative;"><input style="position: absolute;" type="radio" name="typ" value="1" $isTypingy ></div><span style="padding-left:25px;">Yes</span></label><label class=""><div style="position:relative;"><input style="position: absolute;left:8px;" type="radio" name="typ" value="1" $isTypingn value="0"></div><span style="padding-left:30px;">No</span></label></div>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-12">
		      	<label class="form-control-label">Use message receipt service?</label>
		      		<div class=""><label class=""><div style="position:relative;"><input style="position: absolute;" type="radio" name="rec" value="1" $messagereceipty ></div><span style="padding-left:25px;">Yes</span></label><label class=""><div style="position:relative;"><input style="position: absolute;left:8px;" type="radio" $messagereceiptn name="rec" value="0"></div><span style="padding-left:30px;">No</span></label></div>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-12">
		      	<label class="form-control-label">Synchronize messages across all user devices? (Not recommended; Will increase usage of CometService on your server)</label>
		      		<div class=""><label class=""><div style="position:relative;"><input style="position: absolute;" type="radio" name="cs_sync" value="1" $messagesyncy ></div><span style="padding-left:25px;">Yes</span></label><label class=""><div style="position:relative;"><input style="position: absolute;left:8px;" type="radio" $messagesyncn name="cs_sync" value="0"></div><span style="padding-left:30px;">No</span></label></div>
				</div>
			</div>
	    </div>
		<div class="row col-md-10" style="padding-bottom:5px;"><br>
	      <input type="submit" value="Update"  class="btn btn-primary">
	    </div>
	   </form>
        </div>
	</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		var cometenabled = $("input:radio[name=dou]:checked").val();
		if(cometenabled == 1){
			$('.enabled_cs').show();
		}
		var cometserviceselfhosted = $cometserviceselfhosted;
		if(cometserviceselfhosted != 1){alert()
			$('.cometserviceselfhosted').hide();
		}
		$('input:radio[name=dou]').change(function(){
			cometenabled = $(this).val();
			if(cometenabled == 1){
				$('.enabled_cs').show();
			} else {
				$('.enabled_cs').hide();
			}
		});
		var transport = "$transport";
		if(transport == 'cometserviceselfhosted'){
			$('.serverurl_text').show();
			$('.cometkeys').removeAttr('required');
			$('.cckeys').hide();
		}
		$('input:radio[name=dos]').change(function(){
			selfhostedenabled = $(this).val();
			if(selfhostedenabled == 1){
				$('.serverurl_text').show();
				$('.cometkeys').removeAttr('required');
				$('.cckeys').hide();
				$('input:text[name=server_url]').attr('required','true');
			} else {
				$('.serverurl_text').hide();
				$('.cckeys').show();
				$('.cometkeys').attr('required','true');
				$('input:text[name=server_url]').removeAttr('required');
			}
		});
		$("#leftnav_settings").find('a').removeClass('active_setting');
		$("#cometservice_settings").addClass('active_setting');
	});
</script>
{$overlay}
EOD;
	template();
}

function updatecomet() {
	if (!empty($GLOBALS['client'])) { header("Location:?module=dashboard&ts=".$GLOBALS['ts']); exit; }
    global $ts;
	$_SESSION['cometchat']['error'] = 'Comet service settings successfully updated';
	if($_POST['dos'] == 1){
		$transport = 'cometserviceselfhosted';
	} else {
		$transport = 'cometservice';
	}
	$data = array('USE_COMET' => $_POST['dou'],
				'KEY_A' => $_POST['keya'],
				'KEY_B' => $_POST['keyb'],
				'KEY_C' => $_POST['keyc'],
				'IS_TYPING' => $_POST['typ'],
				'MESSAGE_RECEIPT' => $_POST['rec'],
				'CS_MESSAGE_SYNC' => $_POST['cs_sync'],
				'TRANSPORT' => $transport,
				'CS_TEXTCHAT_SERVER' => $_POST['server_url']);
	configeditor($data);
	header("Location:?module=settings&action=comet&ts={$ts}");
}



function searchlogs() {
    global $ts,$usertable_userid,$usertable_username,$usertable,$body,$bannedUserIDs;
	$username = $_REQUEST['susername'];
	if (empty($username)) {
		$username = 'Q293YXJkaWNlIGFza3MgdGhlIHF1ZXN0aW9uIC0gaXMgaXQgc2FmZT8NCkV4cGVkaWVuY3kgYXNrcyB0aGUgcXVlc3Rpb24gLSBpcyBpdCBwb2xpdGljPw0KVmFuaXR5IGFza3MgdGhlIHF1ZXN0aW9uIC0gaXMgaXQgcG9wdWxhcj8NCkJ1dCBjb25zY2llbmNlIGFza3MgdGhlIHF1ZXN0aW9uIC0gaXMgaXQgcmlnaHQ/DQpBbmQgdGhlcmUgY29tZXMgYSB0aW1lIHdoZW4gb25lIG11c3QgdGFrZSBhIHBvc2l0aW9uDQp0aGF0IGlzIG5laXRoZXIgc2FmZSwgbm9yIHBvbGl0aWMsIG5vciBwb3B1bGFyOw0KYnV0IG9uZSBtdXN0IHRha2UgaXQgYmVjYXVzZSBpdCBpcyByaWdodC4=';
	}

	$sql = ("select ".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_userid)." id, ".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_username)." username from ".mysqli_real_escape_string($GLOBALS['dbh'],$usertable)." where ".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_username)." LIKE '%".mysqli_real_escape_string($GLOBALS['dbh'],sanitize_core($username))."%'");
	$query = mysqli_query($GLOBALS['dbh'],$sql);
	$userslist = '';
	while ($user = mysqli_fetch_assoc($query)) {
		if (function_exists('processName')) {
			$user['username'] = processName($user['username']);
		}
        $banuser = '<a style="color:red;opacity:0.2;" title="Ban the user" data-toggle="tooltip" href="?module=settings&amp;action=banusersprocess&amp;susername='.$username.'&amp;bannedids='.$user['id'].'&amp;ts='.$ts.'"><i class="fa fa-lg fa-ban"></i></a>';

        if(in_array($user['id'],$bannedUserIDs)) {
            $banuser = '<a style="color:red;" title="Unban the user" data-toggle="tooltip" href="?module=settings&amp;action=unbanusersprocess&amp;susername='.$username.'&amp;bannedids='.$user['id'].'&amp;ts='.$ts.'"><i class="fa fa-lg fa-ban"></i></a>';
        }
		$userslist .= '<tr><td>'.$user['username'].'</td><td>'.$user['id'].'</td><td>'.$banuser.'</td></tr>';
	}
	if ($userslist == '') {
		$userslist = '<tr><td colspan="3">No record found.</td></tr>';
	}
	echo <<<EOD
		<div style="height:500px;overflow:auto;overflow-x:hidden;">
		<table class="table">
			<thead>
				<tr><th width="50%">Name</th><th>ID</th>
				<th width="5%">&nbsp;</th></tr>
			</thead>
			<tbody>
			$userslist
		</table>
EOD;
}

function banusersprocess() {
    global $ts;
    global $bannedUserIDs;

    array_push($bannedUserIDs, $_REQUEST['bannedids']);
    $_SESSION['cometchat']['error'] = 'Ban ID list successfully modified.';

    configeditor(array('bannedUserIDs' => $bannedUserIDs));
    header("Location:?module=settings&action=generalsettings&ts={$ts}");
}

function unbanusersprocess() {
    global $ts;
    global $bannedUserIDs;

    if(($key = array_search($_GET['bannedids'], $bannedUserIDs)) !== false) {
        unset($bannedUserIDs[$key]);
    }
    $unbanarray = array_values($bannedUserIDs);

    $_SESSION['cometchat']['error'] = 'Ban ID list successfully modified.';
    configeditor(array('bannedUserIDs' => $unbanarray));
	header("Location:?module=settings&action=generalsettings&ts={$ts}");
}

function cron() {
	if (!empty($GLOBALS['client'])) { header("Location:?module=dashboard&ts=".$GLOBALS['ts']); exit; }
	global $body, $navigation, $trayicon, $plugins, $disableGroupTab, $ts;

	$auth = md5(md5(ADMIN_USER).md5(ADMIN_PASS));
	$baseurl = BASE_URL;
	$datamodules = '';
	$dataplugins = '';
if ($disableGroupTab == 0) {
			$datamodules .= <<<EOD
		        <tr class="sub_modules">
		            <td width="5%">&nbsp;</td>
		            <td width="5%"><input class="input_sub" type="checkbox" name="cron[inactiverooms]" value="1" onclick="javascript:cron_checkbox_check('chatrooms','modules')"></td>
		            <td>Delete all user created inactive chatrooms</td>
		            <td><a data-toggle="tooltip" title="Cron URL Code" href="javascript:void(0)" style="float: right;" onclick="javascript:cron_auth_link('{$baseurl}','inactiverooms','{$auth}')"><i class="fa fa-lg fa-code"></i></a></td>
		        </tr>
		        <tr class="sub_modules">
		            <td width="5%">&nbsp;</td>
		            <td width="5%"><input class="input_sub"  type="checkbox" name="cron[chatroommessages]" value="1" onclick="javascript:cron_checkbox_check('chatrooms','modules')"></td>
		            <td>Delete all user created inactive users from chatrooms</td>
		            <td><a data-toggle="tooltip" title="Cron URL Code" href="javascript:void(0)" style="float: right;" onclick="javascript:cron_auth_link('{$baseurl}','chatroommessages','{$auth}')"><i class="fa fa-lg fa-code"></i></a></td>
		        </tr>
		        <tr class="sub_modules">
		            <td width="5%">&nbsp;</td>
		            <td width="5%"><input class="input_sub"  type="checkbox" name="cron[inactiveusers]" value="1" onclick="javascript:cron_checkbox_check('chatrooms','modules')"></td>
		            <td>Delete all user created inactive chatrooms</td>
		            <td><a data-toggle="tooltip" title="Cron URL Code" href="javascript:void(0)" style="float: right;" onclick="javascript:cron_auth_link('{$baseurl}','inactiveusers','{$auth}')"><i class="fa fa-lg fa-code"></i></a></td>
		        </tr>
EOD;
}
	foreach ($trayicon as $t) {
		if(file_exists(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.$t[0].DIRECTORY_SEPARATOR.'cron.php')) {
			$datamodules .= <<<EOD
		        <tr class="sub_modules">
		            <td width="5%">&nbsp;</td>
		            <td width="5%"><input class="input_sub"  type="checkbox" name="cron[{$t[0]}]" value="1" onclick="javascript:cron_checkbox_check('{$t[0]}','modules')"></td>
		            <td>Run cron for {$t[0]}</td>
		            <td><a data-toggle="tooltip" title="Cron URL Code" href="javascript:void(0)" style="float: right;" onclick="javascript:cron_auth_link('{$baseurl}','{$t[0]}','{$auth}')"><i class="fa fa-lg fa-code"></i></a></td>
		        </tr>
EOD;
		}
	}

	foreach ($plugins as $p) {
		if(file_exists(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.$p.DIRECTORY_SEPARATOR.'cron.php')) {
			$dataplugins .= <<<EOD
		        <tr class="sub_plugins">
		            <td width="5%">&nbsp;</td>
		            <td width="5%"><input  class="input_sub" type="checkbox" name="cron['{$p}']" value="1" onclick="javascript:cron_checkbox_check('{$p}','plugins')"></td>
		            <td> Delete all files from sent with {$p}</td>
		            <td><a data-toggle="tooltip" title="Cron URL Code" href="javascript:void(0)" style="float: right;" onclick="javascript:cron_auth_link('{$baseurl}','{$p}','{$auth}')"><i class="fa fa-lg fa-code"></i></a></td>
		        </tr>
EOD;
		}
	}

$body .= <<<EOD
<div class="row">
      <div class="col-sm-12 col-lg-12">
        <div class="card">
              <div class="card-header">
                Cron
                <h4><small>This feature will remove old messages; old handwrite messages and old files of filetransfer.</small>
                </h4>
              </div>
              <div class="card-block">
              <form action="?module=settings&action=processcron&ts={$ts}" method="post" onsubmit="return cron_submit()">

                <div class="form-group row">
                    <div class="col-md-12">
                      <input id='individual' type="radio" name="cron[type]" value="individual" onclick="javascript:$('#individualcat').show('slow')" checked>&nbsp;&nbsp;<b>Run individual crons</b>
                    </div>
                </div>
                <div id ="individualcat">
                <table class="table">
                    <tr>
                        <td width="5%"><input id="plugins" type="checkbox" name="cron[plugins]" value="1"  class="title_class" onclick="check_all('plugins','sub_plugins','{$auth}')"></td>
                        <td colspan="2" onclick="javascript:$('.sub_plugins').toggle('slow')" style="cursor: pointer;"> Run all plugins cron</td>
                        <td><a data-toggle="tooltip" title="Cron URL Code" href="javascript:void(0)" style="float: right;" onclick="javascript:cron_auth_link('{$baseurl}','plugins','{$auth}')"><i class="fa fa-lg fa-code"></i></a></td>
                    </tr>
                    $dataplugins
                    <tr>
                        <td><input id="modules" type="checkbox" name="cron[modules]" value="1" class="title_class" onclick="check_all('modules','sub_modules','{$auth}')"></td>
                        <td colspan="2"  onclick="javascript:$('.sub_modules').toggle('slow')" style="cursor: pointer;"> Run all modules cron</td>
                        <td><a data-toggle="tooltip" title="Cron URL Code" href="javascript:void(0)" style="float: right;"  onclick="javascript:cron_auth_link('{$baseurl}','core','{$auth}')"><i class="fa fa-lg fa-code"></i></a></td>
                    </tr>
                    $datamodules
                    <tr>
                        <td><input id="core" type="checkbox" name="cron[core]" value="1" class="title_class" onclick="check_all('core','sub_core','{$auth}')"></td>
                        <td colspan="2" onclick="javascript:$('.sub_core').toggle('slow')" style="cursor: pointer;"> Run cron for core</td>
                        <td><a data-toggle="tooltip" title="Cron URL Code" href="javascript:void(0)" style="float: right;"><i class="fa fa-lg fa-code"></i></a></td>
                    </tr>

		        <tr class="sub_core">
		            <td width="5%">&nbsp;</td>
		            <td width="5%"><input class="input_sub" type="checkbox" name="cron[messages]" value="1"onclick="javascript:cron_checkbox_check('messages','core')"></td>
		            <td>Delete one-to-one messages except unread messages</td>
		            <td><a data-toggle="tooltip" title="Cron URL Code" href="javascript:void(0)" style="float: right;" onclick="javascript:cron_auth_link('{$baseurl}','messages','{$auth}')"><i class="fa fa-lg fa-code"></i></a></td>
		        </tr>

		        <tr class="sub_core">
		            <td width="5%">&nbsp;</td>
		            <td width="5%"><input class="input_sub" type="checkbox" name="cron[guest]" value="1" onclick="javascript:cron_checkbox_check('guest','core')"></td>
		            <td>Delete all guest`s entries</td>
		            <td><a data-toggle="tooltip" title="Cron URL Code" href="javascript:void(0)" style="float: right;" onclick="javascript:cron_auth_link('{$baseurl}','guest','{$auth}')"><i class="fa fa-lg fa-code"></i></a></td>
		        </tr>

                </table>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                          <input id='all' type="radio" name="cron[type]" value="all" onclick="javascript:$('#individualcat').hide('slow')" >&nbsp;&nbsp;<b>Run entire crons</b>
                    </div>
                </div>




            <div class="row col-md-10" style="padding-bottom:5px;"><br>
            <input type="hidden" value="{$auth}" name="auth">
              <input type="submit" value="Run" class="btn btn-primary">
            </div>

           </form>
            </div>
        </div>
      </div>
</div>
EOD;

    template();

}

function processcron() {
	if (!empty($GLOBALS['client'])) { header("Location:?module=dashboard&ts=".$GLOBALS['ts']); exit; }
	global $ts;
	$auth = md5(md5(ADMIN_USER).md5(ADMIN_PASS));
	include_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'cron.php');
	$_SESSION['cometchat']['error'] = 'Cron executed successfully';
	header("Location:?module=settings&action=cron&ts={$ts}");
}

function ccauth() {
	global $body, $ccactiveauth, $guestsMode, $guestsList, $guestsUsersList, $guestnamePrefix, $ts, $client;

	$ccauthoptions = array('Facebook','Google','Twitter');
	$ccauthicons   = array('fa-facebook','fa-google','fa-twitter');
	if(USE_CCAUTH == '1'){
		$ccauthshow = '';
		$siteauthshow = 'style="display:none"';
		$siteauthradio_checked = '';
		$ccauthradio_checked = 'checked';
	}else{
		$siteauthshow = '';
		$ccauthshow = 'style="display:none"';
		$ccauthradio_checked = '';
		$siteauthradio_checked = 'checked';
	}
	$authmode = USE_CCAUTH;
	$ccactiveauthlist = '';
	$ccauthlistoptions = '';
	$no = 0;
	$no_auth = '';
	if(!empty($client) && ($key = array_search('Google', $ccauthoptions)) !== false) {
	  unset($ccauthoptions[$key]);
	}

	$no = 0;
	$config = '';
	foreach ($ccauthoptions as $ccauthoption) {
		++$no;
		if(empty($client)) {
			$config = ' <a style="color:black;" data-toggle="tooltip" title="Configure" href="javascript:void(0)" onclick="javascript:auth_configauth(\''.$ccauthoption.'\')" style="margin-right:5px"><i class="fa fa-lg fa-cogs"></i></a>';
		}
		if (in_array($ccauthoption, $ccactiveauth)) {
			$ccauth = "active";
			$action = '<a title="Remove" style="color:red;" data-toggle="tooltip" href="javascript:void(0)" onclick="javascript:ccauth_removeauthmode(\''.$no.'\',this)"><i class="fa fa-lg fa-minus-circle"></i></a>';
		} else {
			$ccauth = "inactive";
			$action = '<a title="Add" data-toggle="tooltip" style="color:green;" href="javascript:void(0)" onclick="javascript:ccauth_addauthmode('.$no.',\''.$ccauthoption.'\',this);"><i class="fa fa-lg fa-plus-circle"></i></a>';
		}
			$ccactiveauthlist .= '<tr ccauth="'.$ccauth.'" id="'.$no.'" d1="'.$ccauthoption.'" rel="'.$ccauthoption.'"><td style="color:#4285f4;font-size:20px;"><i class="fa fa-lg '.$ccauthicons[$no-1].'"></i><td>'.stripslashes($ccauthoption).'</td><td width="5px">'.$config.'</td><td width="5px">'.$action.'</td></tr>';
	}

	if(!$ccactiveauthlist){
		$no_auth .= '<tr id="no_auth"><td colspan="3">You have no Authentication Mode activated at the moment. To activate an Authentication Mode, please add them from the list of available Authentication Modes.</td></tr>';
	}

	$dy = "";
	$dn = "";
	$gL1 = $gL2 = $gL3 = $gUL1 = $gUL2 = $gUL3 = '';

	if ($guestsMode == 1) {
		$dy = "checked";
	} else {
		$dn = "checked";
	}

	if ($guestsList == 1) {	$gL1 = "selected"; }
	if ($guestsList == 2) {	$gL2 = "selected"; }
	if ($guestsList == 3) {	$gL3 = "selected"; }

	if ($guestsUsersList == 1) { $gUL1 = "selected"; }
	if ($guestsUsersList == 2) { $gUL2 = "selected"; }
	if ($guestsUsersList == 3) { $gUL3 = "selected"; }

$body = <<<EOD
	<div class="col-sm-12 col-lg-12">
    <div class="card">
      	<div class="card-header">
        	Authentication Mode
        	<h4><small>You can choose to either integrate with your site's login system (if you have one) or to use our social login feature to enable your users to login using their social accounts.</small></h4>
      	</div>
      	<div class="card-block">
      	<form onsubmit="return ccauth_updateorder({$authmode});" action="?module=settings&action=updateauthmode&ts={$ts}" method="post">
		<input type="hidden" name="ccactiveauth" id="cc_auth_order">

		<div class="form-group row">
			<div class="col-md-12">
	      	<input type="radio" name="USE_CCAUTH" class="auth_select" id="site_auth_radio" value=0 $siteauthradio_checked >&nbsp;&nbsp;<b>Site's Authentication</b>
			</div>
		</div>

	    <div id="site_auth_options" {$siteauthshow}>
			<div class="form-group row">
				<div class="col-md-12">
		      	<label class="form-control-label">Enable Guest Chat:</label>
		      		<div class=""><label class=""><div style="position:relative;"><input style="position: absolute;" type="radio" name="guestsMode" value="1" $dy ></div><span style="padding-left:25px;">Yes</span></label><label class=""><div style="position:relative;"><input style="position: absolute;left:8px;" type="radio" $dn name="guestsMode" value="0"></div><span style="padding-left:30px;">No</span></label></div>
				</div>
			</div>
			<div class="form-group row serverurl_text">
				<div class="col-md-12">
		      	<label class="form-control-label">Prefix for guest names:</label>
		      		<input class="form-control" name="guestnamePrefix" value="$guestnamePrefix" type="text">
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-12">
		      	<label class="form-control-label">In Who`s Online list, for guests:</label>
		      		<select class="form-control" name="guestsList"><option value="1" $gL1>Show only guests</option><option value="2" $gL2>Show only logged in users</option><option value="3" $gL3>Show both</option></select>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-12">
		      	<label class="form-control-label">For logged in users:</label>
		      		<select class="form-control" name="guestsUsersList"><option value="1" $gUL1>Show only guests</option><option value="2" $gUL2>Show only logged in users</option><option value="3" $gUL3>Show both</option></select>
				</div>
			</div>
		</div>

	   <div class="form-group row">
			<div class="col-md-12">
	      	<input type="radio" name="USE_CCAUTH" class="auth_select" id="cc_auth_radio" value=1 {$ccauthradio_checked}>&nbsp;&nbsp;<b>Social Login</b>
			</div>
		</div>


		<div class="row" id="cc_auth_options" {$ccauthshow}>
			<div class="col-md-8">
				<table class="table" id="auth_livemodes" class="ui-sortable" unselectable="on">
		          {$ccactiveauthlist}
		        </table>
	        </div>
        </div>

		<div class="row col-md-10" style="padding-bottom:5px;"><br>
	      <input type="submit" value="Update"  class="btn btn-primary">
	    </div>

	   </form>
        </div>
	</div>
	</div>
<script type="text/javascript">
	/*$(function() {
		$("#auth_livemodes").sortable({
			items: "tr:not(.ui-state-unsort)",
			connectWith: 'table'
		});
		$("#auth_livemodes").disableSelection();
	});*/
	$(function(){
		$('#site_auth_radio').click(function(){
			$('#site_auth_options').show();
			$('#cc_auth_options').hide();
		});
		$('#cc_auth_radio').click(function(){
			$('#cc_auth_options').show();
			$('#site_auth_options').hide();
		});
	});
</script>
EOD;

	return $body;

}

function updateauthmode() {
	global $ts;
	global $ccactiveauth;

	if(USE_CCAUTH!=$_POST['USE_CCAUTH']){
		$sql = ("truncate table `cometchat`;truncate table cometchat_block;truncate table cometchat_chatroommessages;truncate table cometchat_chatrooms;truncate table cometchat_chatrooms_users;truncate table cometchat_status;CREATE TABLE IF NOT EXISTS `cometchat_users` (`id` int(11) NOT NULL AUTO_INCREMENT,`username` varchar(100) NOT NULL,`displayname` varchar(100) NOT NULL,`avatar` varchar(200) NOT NULL,`link` varchar(200) NOT NULL,`grp` varchar(25) NOT NULL,PRIMARY KEY (`id`),UNIQUE KEY `username` (`username`)) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");
		$result = mysqli_multi_query($GLOBALS['dbh'],$sql);

		if ($result) {
			while (mysqli_more_results($GLOBALS['dbh'])) {
				mysqli_use_result($GLOBALS['dbh']);
				mysqli_next_result($GLOBALS['dbh']);
			}
		}
	}
	$_POST['ccactiveauth'] = json_decode($_POST['ccactiveauth'],true);
	configeditor($_POST);
	$_SESSION['cometchat']['error'] = 'Authentication Mode details updated successfully';
	header("Location:?module=settings&action=generalsettings&ts={$ts}");
}

function selectplatform() {
	if (empty($GLOBALS['client'])) { echo "Not Found"; exit; }

	global $body;
	global $navigation;
    global $ts;
    global $cms;
    global $availableIntegrations;
    global $login_url;
    global $logout_url;

    $options = $site_url = '';
    if(defined('CC_SITE_URL')) {
    	$site_url = CC_SITE_URL;
    }

    foreach ($availableIntegrations as $key => $value) {
    	$selected = "";
		if($key==$cms){
			$selected = "selected";
		}
    	$options .=  '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
    }
	$body = <<<EOD
	$navigation
	<form action="?module=settings&action=saveplatform&ts={$ts}" method="post">
	<div id="rightcontent" style="float:left;width:720px;border-left:1px dotted #ccc;padding-left:20px;">
		<h2>Platform & Domain settings</h2>
		<h3>Update your domain and platform you are using CometChat with here. Be careful.</h3>

		<div>
			<div id="centernav">
				<div class="title">Site URL:</div>
				<div class="element">
					<span class="inputbox">http://</span>
					<input type="text" class="inputbox" value="{$site_url}" name="CC_SITE_URL" placeholder="yoursite.com"></div>
				<div style="clear:both;padding:10px;"></div>
				<div class="title">Login URL(Optional): </div>
				<div class="element">
					<input type="text" class="inputbox" value="{$login_url}" name="MOBILE_URL" placeholder="yoursite.com/sign-In"></div>
				<div style="clear:both;padding:10px;"></div>
				<div class="title">Logout URL(Optional): </div>
				<div class="element">
					<input type="text" class="inputbox" value="{$logout_url}" name="MOBILE_LOGOUTURL" placeholder="yoursite.com/sign-Out"></div>
				<div style="clear:both;padding:10px;"></div>
				<div class="title">Select Platform:</div><div class="element">
		    		<select id="cms" name="cms">
						{$options}
					</select>
				</div>
				<div style="clear:both;padding:10px;"></div>
			</div>
			<div id="rightnav">
				<h1>Warning</h1>
				<ul id="modules_availablemodules">
					<li>The site URL must be the domain name of your site.</li>
					<li>If you switch the domain then please make sure that you also update the site url here.</li>
				</ul>
			</div>
		</div>

		<div style="clear:both;padding:7.5px;"></div>
		<input type="submit" value="Save" class="button">&nbsp;&nbsp;or <a href="?module=settings&amp;ts={$ts}">cancel</a>
	</div>

	<div style="clear:both"></div>
	<script type="text/javascript">
		$(function() {
			$("#leftnav_settings").find('a').removeClass('active_setting');
			$("#platform_settings").addClass('active_setting');
		});
	</script>

EOD;

	template();
}

function saveplatform() {
	if (empty($GLOBALS['client'])) { echo "Not Found"; exit; }
	global $client;
	global $ts;
	if (isset($_POST['CC_SITE_URL'])) {
		$url = "http://my.cometchat.com/updatedomain2.php";
		$data = array('client' => $client,'domain' => $_POST['CC_SITE_URL']);
		checkcURL(0,$url,$data);
	}
	configeditor($_POST);
	$_SESSION['cometchat']['error'] = 'Domain & platform updated successfully';
	header("Location:?module=settings&action=selectplatform&ts={$ts}");
}

/*function googleanalytics(){
	global $body;
	global $navigation;
	global $ts;
	global $gatrackerid;

	if(empty($gatrackerid)){
		$gatrackerid='';
	}

$body .= <<<EOD
<div class="row">
  <div class="col-sm-8 col-lg-8">
  	<div class="row">
	  	<div class="col-sm-12 col-lg-12">
		    <div class="card">
		      	<div class="card-header">
		        	Google Analytics ID:
		      	</div>
		      	<div class="card-block">
		      	<form action="?module=settings&action=updategoogleanalytics&ts={$ts}" method="post">
				<div class="row col-md-12" style="padding-bottom:5px;"><br>
					<div class="col-md-4" style="text-align:right;padding-top:7px;"><label >Google Analytics ID:</label></div>
					<div class="col-md-4"><input class="form-control" type="text" name="gatrackerid" value="{$gatrackerid}" ></div>
			    </div>
				<div class="row col-md-12" style="padding-bottom:5px;"><br>
			      <input type="submit" value="UPDATE SETTING"  class="btn btn-primary">
			    </div>

			   </form>
	            </div>
	    	</div>
	  	</div>
	</div>
  </div>
  	<div class="col-sm-4 col-lg-4">
		<div class="card">
		  	<div class="card-header">
		    	Tips
		  	</div>
		  	<ul id="modules_availablemodules">
					<li>Please enter Google Analytics ID. </li>
						<li>You can learn about Google Analytics ID <a href="https://support.google.com/analytics/answer/1032385?hl=en" target="_blank">here</a></li>
 				</ul>
		</div>
		</div>
	</div>
</div>
	<script type="text/javascript">
		$(function() {
			$("#leftnav_settings").find('a').removeClass('active_setting');
			$("#googleanalytics").addClass('active_setting');
			$(".ga").click(function(){
				$(".gatextbox").toggle();
			});
			$(".fb").click(function(){
				$(".fbtextbox").toggle();
			});
		});
	</script>
	<script src="https://apis.google.com/js/client.js"></script>
EOD;
	template();
}*/

function updategoogleanalytics(){
	global $ts;
	configeditor($_POST);
	$_SESSION['cometchat']['error'] = "Settings updated successfully";
	header('location:?module=settings&action=googleanalytics&ts='.$ts);
}

function storage() {
	if (!empty($GLOBALS['client'])) { header("Location:?module=dashboard&ts=".$GLOBALS['ts']); exit; }
	global $body, $ts, $aws_bucket_url;
	$defaultradio_checked = $awsradio_checked = $required = '';
	if(AWS_STORAGE == '0'){
		$defaultradio_checked = 'checked';
	}else{
		$awsradio_checked = 'checked';
		$required = 'required';
	}
	$storagemode = AWS_STORAGE;
	$aws_access_key = AWS_ACCESS_KEY;
	$aws_secret_key = AWS_SECRET_KEY;
	$aws_bucket = AWS_BUCKET;

$body = <<<EOD
  	<div class="col-sm-12 col-lg-12">
	    <div class="card">
	      	<div class="card-header">
	        	Storage
	        	<h4><small>You can choose to use either the default folder storage or Amazon AWS S3 to store files being transferred.</small></h4>
	      	</div>
	      	<div class="card-block">
	      	<form action="?module=settings&action=updatestoragemode&ts={$ts}" method="POST">

			<div class="row col-md-12" style="padding-bottom:5px;">

				<div class="form-group row">
					<div class="col-md-12">
			      	<input name="AWS_STORAGE" id="default_radio" value="0" $defaultradio_checked type="radio" style="margin-top:8px;">&nbsp;&nbsp;<b>Default Folder Storage</b><br>
			      	<input name="AWS_STORAGE" id="aws_radio" value="1" $awsradio_checked type="radio">&nbsp;&nbsp;<b>Amazon Simple Storage Service (AWS)</b>
					</div>
				</div>


		    <div id="aws_keys" style="display:none;">
				<div class="form-group row">
					<div class="col-md-12">
			      	<label class="form-control-label">AWS Access Key:</label>
			      		<input class="form-control" name="AWS_ACCESS_KEY" value="$aws_access_key" $required type="text">
					</div>
				</div>

				<div class="form-group row">
					<div class="col-md-12">
			      	<label class="form-control-label">AWS Secret Key:</label>
			      		<input class="form-control" name="AWS_SECRET_KEY" value="$aws_secret_key" $required type="text">
					</div>
				</div>

				<div class="form-group row">
					<div class="col-md-12">
			      	<label class="form-control-label">AWS Bucket:</label>
			      		<input class="form-control" name="AWS_BUCKET" value="$aws_bucket" $required type="text">
					</div>
				</div>

				<div class="form-group row">
					<div class="col-md-12">
			      	<label class="form-control-label">AWS Bucket URL:</label>
			      		<input class="form-control" name="aws_bucket_url" value="$aws_bucket_url" $required type="text">
					</div>
				</div>
		    </div>
			<div class="row col-md-10" style="padding-bottom:5px;"><br>
		      <input type="submit" value="Update"  class="btn btn-primary">
		    </div>

		   </form>
            </div>
    	</div>
  	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			var storagemode = '{$storagemode}';
			if(storagemode == 1) {
				$('#aws_keys').show();
			}
			$('#default_radio').click(function(){
				$('#aws_keys').hide();
				$('#aws_keys input').attr('required','');
			});
			$('#aws_radio').click(function(){
				$('#aws_keys').show();
				$('#aws_keys input').attr('required','required');
			});
		});
	</script>
EOD;

	return $body;
}
function updatestoragemode() {
	if (!empty($GLOBALS['client'])) { header("Location:?module=dashboard&ts=".$GLOBALS['ts']); exit; }
    global $ts;
    $_POST['aws_bucket_url'] = preg_replace('#^http(s)?://#', '', rtrim($_POST['aws_bucket_url'],'/'));
	configeditor($_POST);
	$_SESSION['cometchat']['error'] = 'Storage mode details updated successfully';
	header("Location:?module=settings&action=generalsettings&ts={$ts}");

}

function mobile() {
	global $body, $options, $ts;
    $form = '';
	$body = <<<EOD
	    <div class="row">
	  <div class="col-sm-12 col-lg-12">
	    <div class="card">
	      <div class="card-header">
	        Mobile
	      </div>
	      <div class="card-block">
	      <iframe height="500px" width="100%"  style="margin-left:-28px;border:none;" src="?module=dashboard&action=loadexternal&type=extension&name=mobileapp"></iframe>
	      </div>
	    </div>
	  </div>
	  <script type="text/javascript">
	  $(function() {
	    $("#mobile").addClass('active');
	  });
	</script>
EOD;
    template();
}

function desktop() {
    global $body, $navigation, $options, $ts, $apikey;
    $form = '';
    $extraquerystring = '';
	if (isset($_REQUEST['branded']) && $_REQUEST['branded']==1) {
		$extraquerystring = '&branded=1';
	}
$body = <<<EOD
    <div class="row">
  	<div class="col-sm-12 col-lg-12">
    <div class="card">
      <div class="card-header">
        Desktop
      </div>
      <div class="card-block">
      <iframe height="500px" width="100%"  style="border:none;" src="?module=dashboard&action=loadexternal&type=extension&name=desktop{$extraquerystring}"></iframe>
      </div>
    </div>
  </div>
EOD;

    template();

}

function licensekey(){
	if (!empty($GLOBALS['client'])) { header("Location:?module=dashboard&ts=".$GLOBALS['ts']); exit; }
	global $body, $navigation, $ts, $settings, $licensekey;
	if(!empty($settings['licensekey'])){
		$licensekey = $settings['licensekey']['value'];
	}

$body = <<<EOD
  	<div class="col-sm-12 col-lg-12">
	    <div class="card">
	      	<div class="card-header">
	        	Change License Key
	      	</div>
	      	<div class="card-block">

	      	<form action="?module=settings&action=updatelicensekey&ts={$ts}" method="post">

      		<div class="form-group row">
				<div class="col-md-12">
				<label class="form-control-label">License Key:</label>
				<input type="text" class="form-control" value="{$licensekey}" name="licensekey">
				</div>
			</div>

			<div class="form-group row col-md-12">
		      <input type="submit" value="Update"  class="btn btn-primary">
		    </div>

		   </form>
            </div>
    	</div>
  	</div>
EOD;
	return $body;
}

function updatelicensekey(){
	if (!empty($GLOBALS['client'])) { header("Location:?module=dashboard&ts=".$GLOBALS['ts']); exit; }
	global $ts;
	configeditor(array('licensekey' => $_POST['licensekey']) );
	$_SESSION['cometchat']['error'] = 'license key updated successfully';
	header("Location:?module=settings&action=generalsettings&ts={$ts}");
}
