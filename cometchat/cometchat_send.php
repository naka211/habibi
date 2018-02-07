<?php

/*

CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license

*/

include_once dirname(__FILE__).DIRECTORY_SEPARATOR."cometchat_init.php";

if(isset($_REQUEST['status'])) {

	if ($userid > 0) {
		$message = mysqli_real_escape_string($GLOBALS['dbh'],$_REQUEST['status']);
		$sql = ("insert into cometchat_status (userid,status) values ('".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."','".sanitize_core($message)."') on duplicate key update status = '".sanitize_core($message)."'");
		$query = mysqli_query($GLOBALS['dbh'],$sql);

		if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysqli_error($GLOBALS['dbh']); }

		$_SESSION['cometchat']['user']['s'] = $message;

		if ($message == 'offline') {
			$_SESSION['cometchat']['cometchat_sessionvars']['buddylist'] = 0;
		}

		if (function_exists('hooks_activityupdate')) {
			hooks_activityupdate($userid,$message);
		}
	}

	if (!empty($_GET['callback'])) {
		header('content-type: application/json; charset=utf-8');
		echo $_GET['callback'].'(1)';
	} else {
		echo "1";
	}
	exit(0);
}

if(isset($_REQUEST['lastseenSettingsFlag']) && !empty($_REQUEST['lastseenSettingsFlag'])) {
    $message = $_REQUEST['lastseenSettingsFlag'];
   	setLastseensettings($message);
   	if (!empty($_GET['callback'])) {
		header('content-type: application/json; charset=utf-8');
		echo $_GET['callback'].'(1)';
	} else {
		echo "1";
	}
	exit(0);
}

if(isset($_REQUEST['readreceiptsetting']) && !empty($_REQUEST['readreceiptsetting'])) {
    $message = $_REQUEST['readreceiptsetting'];
   	setReadReceiptsettings($message);
   	if (!empty($_GET['callback'])) {
		header('content-type: application/json; charset=utf-8');
		echo $_GET['callback'].'(1)';
	} else {
		echo "1";
	}
	exit(0);
}

if (isset($_REQUEST['guestname']) && $userid > 0) {
	$guestname = mysqli_real_escape_string($GLOBALS['dbh'],sanitize_core($_REQUEST['guestname']));

	if($guestname != ''){
		$sql = ("UPDATE `cometchat_guests` SET name='".$guestname."' where id='".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."'");
		$query = mysqli_query($GLOBALS['dbh'],$sql);
		if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysqli_error($GLOBALS['dbh']); }

		$_SESSION['cometchat']['username'] =  $guestnamePrefix.$guestname;

		if (!empty($_GET['callback'])) {
			header('content-type: application/json; charset=utf-8');
			echo $_GET['callback'].'(1)';
		} else {
			echo "1";
		}
	}
	exit(0);
}

if (isset($_REQUEST['statusmessage'])) {
	$message = mysqli_real_escape_string($GLOBALS['dbh'],$_REQUEST['statusmessage']);
	if (empty($_SESSION['cometchat']['statusmessage']) || ($_SESSION['cometchat']['statusmessage'] != $message)) {

		$sql = ("insert into cometchat_status (userid,message) values ('".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."','".sanitize_core($message)."') on duplicate key update message = '".sanitize_core($message)."'");
		$query = mysqli_query($GLOBALS['dbh'],$sql);
		if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysqli_error($GLOBALS['dbh']); }

		$_SESSION['cometchat']['statusmessage'] = $message;

		if (function_exists('hooks_statusupdate')) {
			hooks_statusupdate($userid,$message);
		}
	}

	if (!empty($_GET['callback'])) {
		header('content-type: application/json; charset=utf-8');
		echo $_GET['callback'].'(1)';
	} else {
		echo "1";
	}

	exit(0);
}


if ( (!empty($_REQUEST['to']) && isset($_REQUEST['message']) && $_REQUEST['message']!='')||(!empty($_REQUEST['broadcast']))) {

	if(!empty($_REQUEST['broadcast'])){
		$broadcasttemp = $_REQUEST['broadcast'];
		$broadcast = array();
		$broadcast_toids = array();
		$bsize =sizeof($broadcasttemp);
		foreach ($broadcasttemp as $key => $value) {
			$value["dir"] = 0;
			$value["localmessageid"] = $key;
			array_push($broadcast, $value);
		}
	}else{
		$to = mysqli_real_escape_string($GLOBALS['dbh'],$_REQUEST['to']);
		$message = str_ireplace('CC^CONTROL_','',$_REQUEST['message']);
	}
	if ($userid > 0) {

		if (!in_array($userid,$bannedUserIDs) && !in_array($_SERVER['REMOTE_ADDR'],$bannedUserIPs)) {

			if(empty($_REQUEST['broadcast'])){
				$response = sendMessage($to,$message,0);
			}else{
				broadcastMessage($broadcast);
			}
			if(!defined('DEV_MODE') || DEV_MODE == '0'){
				header('content-type: application/json; charset=utf-8');
				sendCCResponse(json_encode($response));
			}

			if(empty($_REQUEST['broadcast'])){
				if (function_exists('hooks_message') && !isset($_REQUEST['deny_hooks_message'])) {
					hooks_message($userid,$to,$response['m'],0);
				}

				if(strpos($response['m'],'@') === 0 && $usebots) {
					checkBotMessage($to, $message, 0);
				}
				
				$response['push']=pushMobileNotification($to,$response['id'],$_SESSION['cometchat']['user']['n'].": ".$response['m']);
			}
			if(defined('DEV_MODE') && DEV_MODE == '1'){
				header('content-type: application/json; charset=utf-8');
				sendCCResponse(json_encode($response));
			}

		} else if(empty($_REQUEST['broadcast'])){
			$sql = ("insert into cometchat (cometchat.from,cometchat.to,cometchat.message,cometchat.sent,cometchat.read,cometchat.direction) values ('".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."', '".mysqli_real_escape_string($GLOBALS['dbh'],$to)."','".mysqli_real_escape_string($GLOBALS['dbh'],sanitize($bannedMessage))."','".mysqli_real_escape_string($GLOBALS['dbh'],getTimeStamp())."',0,2)");
			$query = mysqli_query($GLOBALS['dbh'],$sql);
			if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysqli_error($GLOBALS['dbh']); }


			if (!empty($_GET['callback'])) {
				header('content-type: application/json; charset=utf-8');
				echo $_GET['callback'].'()';
			}
		}
	}

	exit(0);
}
