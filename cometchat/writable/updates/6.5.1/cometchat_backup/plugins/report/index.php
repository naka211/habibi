<?php

/*

CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license

*/

include_once(dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."plugins.php");
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."config.php");

if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR."lang.php")) {
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."lang.php");
}

if ($p_<1) exit;
$callback = '';
$cc_theme='';

if(!empty($_REQUEST['cc_theme'])){ $cc_theme = "&cc_theme=".$_REQUEST['cc_theme'];}
if(!empty($_REQUEST['callback'])) { $callback = $_REQUEST['callback'];}
if (!empty($_GET['action']) && !empty($_SESSION['cometchat']['report_rand']) && $_SESSION['cometchat']['report_rand'] == $_POST['rand']) {

unset($_SESSION['cometchat']['report_rand']);

$id = $_POST['id'];
$issue = $_POST['issue'];

$sql = getUserDetails($userid);

if ($guestsMode && $userid >= 10000000) {
	$sql = getGuestDetails($userid);
}

$query = mysqli_query($GLOBALS['dbh'],$sql);
if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysqli_error($GLOBALS['dbh']); }
$user = mysqli_fetch_assoc($query);
if (function_exists('processName')) {
	$user['username'] = processName($user['username']);
}

$reporter = $user['username'];

$sql = getUserDetails($id);

if ($guestsMode && $id >= 10000000) {
	$sql = getGuestDetails($id);
}

$query = mysqli_query($GLOBALS['dbh'],$sql);
if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysqli_error($GLOBALS['dbh']); }
$user = mysqli_fetch_assoc($query);
if (function_exists('processName')) {
	$user['username'] = processName($user['username']);
}

$log = '';
$filename = 'Conversation with '.$user['username'].' on '.date('M jS Y');

$messages = array();

getChatboxData($id);

$log .= 'Conversation with '.$user['username'].' ('.$id.') on '.date('M jS Y');
$log .= "\r\n-------------------------------------------------------\r\n\r\n";

foreach ($messages as $chat) {
	$chat['message'] = strip_tags($chat['message']);
	if ($chat['self'] == 1) {
		$log .= '('.date('g:iA e', $chat['sent']).") ".$language[10].': '.$chat['message']."\r\n";
	} else {
		$log .= '('.date('g:iA e', $chat['sent']).") ".$user['username'].': '.$chat['message']."\r\n";
	}
}

$to      = $reportEmail;
$subject = 'CometChat Incident Report';
$message = <<<EOD
Hello,

The following incident was reported by $reporter:

-------------------------------------------------------
$issue
-------------------------------------------------------

$log

EOD;

$headers = 'From: bounce@chat.com' . "\r\n" .
    'Reply-To: bounce@chat.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);

$embed = '';
$embedcss = '';
$webapp = '';
$close = "setTimeout('window.close()',2000);";

if (!empty($_GET['embed']) && $_GET['embed'] == 'web') {
	$embed = 'web';
	$embedcss = 'embed';
	$close = "closePopup();";
}

if (!empty($_GET['embed']) && $_GET['embed'] == 'desktop') {
	$embed = 'desktop';
	$embedcss = 'embed';
	$close = "parentSandboxBridge.closeCCPopup('report');";
}

if (!empty($_REQUEST['callback']) && $_REQUEST['callback'] == 'mobilewebapp') {
	$webapp = 'webapp';
}

echo <<<EOD
<!DOCTYPE html>
<html>
<head>
<title>{$report_language[0]} (closing)</title>
<meta name="viewport" content="user-scalable=1,width=device-width, minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link type="text/css" rel="stylesheet" media="all" href="../../css.php?type=plugin&name=report{$cc_theme}" />
<script type="text/javascript">
	function closePopup(){
		var controlparameters = {'type':'plugins', 'name':'report', 'method':'closeCCPopup', 'params':{'name':'report'}};
		controlparameters = JSON.stringify(controlparameters);
		if(typeof(parent) != 'undefined' && parent != null && parent != self){
			parent.postMessage('CC^CONTROL_'+controlparameters,'*');
		} else {
			window.close();
		}
	}
</script>
</head>
<body onload="{$close}">

<div  class="cometchat_wrapper">
<div  class="container_title {$embedcss} {$webapp}">{$report_language[3]}</div>

<div  class="container_body {$embedcss}">

<div class="report {$webapp}">{$report_language[4]}</div>

<div style="clear:both"></div>
</div>
</div>
</div>

</body>
</html>
EOD;

} else {

	$toId = $_GET['id'];
	$baseData = $_GET['basedata'];
	$_SESSION['cometchat']['report_rand'] = rand(0,9999);


	$embed = '';
	$embedcss = '';
	$webapp = '';

	if (!empty($_GET['embed']) && $_GET['embed'] == 'web') {
		$embed = 'web';
		$embedcss = 'embed';
	}

	if (!empty($_GET['embed']) && $_GET['embed'] == 'desktop') {
		$embed = 'desktop';
		$embedcss = 'embed';
	}

	if (!empty($_REQUEST['callback']) && $_REQUEST['callback'] == 'mobilewebapp') {
		$webapp = 'webapp';
	}

	if (!empty($_REQUEST['callbackfn']) && $_REQUEST['callbackfn'] == 'mobileapp') {
		echo $_SESSION['cometchat']['report_rand'];
	} else {

		echo <<<EOD
		<!DOCTYPE html>
		<html>
			<head>
				<title>{$report_language[0]}</title>
				<meta name="viewport" content="user-scalable=0,width=device-width, minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0" />
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
				<link type="text/css" rel="stylesheet" media="all" href="../../css.php?type=plugin&name=report{$cc_theme}" />
				<script>
					function checkmessage() {
					    var x = document.forms["reportform"]["reportbox"].value.trim();
					    if (x == null || x == "") {
					        alert("{$report_language[6]}");
					        return false;
					    }
					}
				</script>
			</head>
			<body>
				<form name="reportform" method="post" action="index.php?action=report&id={$toId}&basedata={$baseData}&embed={$embed}&callback={$callback}{$cc_theme}" onsubmit="return checkmessage()">
					<div class="cometchat_wrapper {$webapp}">
						<div class="container_title {$embedcss} {$webapp}">{$report_language[1]}</div>

						<div class="container_body {$embedcss} {$webapp}">
							<textarea id="reportbox" class="reportbox {$webapp}" name="issue"></textarea><div style="clear:both"></div>
							<div class="sendwrapper {$webapp}">
								<div id="send" class="send {$webapp}">
									<input type="submit" value="{$report_language[2]}" class="reportbutton {$webapp}">
									<input type="hidden" value="{$toId}" name="id">
									<input type="hidden" value="{$_SESSION['cometchat']['report_rand']}" name="rand">
								</div>
							<div style="clear:both"></div>
							</div>
						</div>
					</div>
					</div>
				</form>
			</body>
		</html>
EOD;
	}
}
