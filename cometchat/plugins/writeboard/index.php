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

if ($p_<3) exit;

if ($_GET['action'] == 'request') {
	$optionalmessage = 0;
	
	if(function_exists('hooks_sendOptionalMessage')) {
		$optionalmessage = hooks_sendOptionalMessage(array('to' => $to, 'plugin' => 'writeboard'));
	}

	if($optionalmessage == 0){
		$response = sendMessage($_REQUEST['to'],$writeboard_language[2]." <a href='javascript:void(0);' class='accept_Write' to='".$userid."' random='".$_REQUEST['id']."' chatroommode='0' mobileAction=\"javascript:jqcc.ccwriteboard.accept('".$userid."','".$_REQUEST['id']."');\">".$writeboard_language[3]."</a> ".$writeboard_language[4],1);

		$processedMessage = $_SESSION['cometchat']['user']['n'].": ".$writeboard_language[2];
	   	pushMobileNotification($_REQUEST['to'],$response['id'],$processedMessage);

		sendMessage($_REQUEST['to'],$writeboard_language[5],2);
	}
	
	if (!empty($_GET['callback'])) {
		header('content-type: application/json; charset=utf-8');
		echo $_GET['callback'].'()';
	}
}

if ($_GET['action'] == 'accept') {
	sendMessage($_REQUEST['to'],$writeboard_language[6],1);

	if (!empty($_GET['callback'])) {
		header('content-type: application/json; charset=utf-8');
		echo $_GET['callback'].'()';
	}
}

if ($_GET['action'] == 'writeboard') {

	$id = $_REQUEST['id'];
	$type = $_REQUEST['type'];

	if ($type == 1) {
		$type = 'publisher';
	} else {
		$type = 'subscriber';
	}

	if (!empty($_REQUEST['chatroommode'])) {
		sendChatroomMessage($_REQUEST['roomid'],$writeboard_language[2]." <a href='javascript:void(0);' class='accept_Write' to='".$userid."' random='".$_REQUEST['id']."' chatroommode='".$_REQUEST['chatroommode']."' mobileAction=\"javascript:jqcc.ccwriteboard.accept('".$userid."','".$_REQUEST['id']."','".$_REQUEST['chatroommode']."');\">".$writeboard_language[3]."</a>",0);
	}

    $room = "writeboard".$id;
	$room = md5($room);

	$name = "Unknown".rand(0,999);

    $sql = getUserDetails($userid);

	if ($guestsMode && $userid >= 10000000) {
		$sql = getGuestDetails($userid);
	}

	$result = mysqli_query($GLOBALS['dbh'],$sql);

	if($row = mysqli_fetch_assoc($result)) {

		if (function_exists('processName')) {
			$row['username'] = processName($row['username']);
		}

		$name = $row['username'];
	}


echo <<<EOD
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="user-scalable=0,width=device-width, minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>{$writeboard_language[0]}</title>
<style>
html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, font, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td {
	margin: 0;
	padding: 0;
	border: 0;
	outline: 0;
	font-weight: inherit;
	font-style: inherit;
	font-size: 100%;
	font-family: inherit;
	vertical-align: baseline;
    text-align: center;
}

html {
  height: 100%;
  overflow: hidden; /* Hides scrollbar in IE */
}

body {
  height: 100%;
  margin: 0;
  padding: 0;
}

</style>
</head>
<body>
	<iframe src="{$etherURL}/p/chat-{$room}?userName={$name}" width="100%" height="100%" frameborder="0">
</body>
</html>
EOD;
}
