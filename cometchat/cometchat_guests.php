<?php

/*

CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license

*/

if(!empty($guestnamePrefix)){ $guestnamePrefix .= '-'; }

function getGuestID($guestName) {

	$_SESSION['cometchat']['guestMode'] = 1;

	global $cookiePrefix;

	$userid = 0;

	if(function_exists('hooks_guestLogin')){
		$userid = hooks_guestLogin(array('guestname' => $guestName));
	} else {
		if (!empty($_COOKIE[$cookiePrefix.'guest'])) {
			$checkId = base64_decode($_COOKIE[$cookiePrefix.'guest']);

			$sql = ("select id from cometchat_guests where id = '".mysqli_real_escape_string($GLOBALS['dbh'],$checkId)."'");
			$query = mysqli_query($GLOBALS['dbh'],$sql);
			$result = mysqli_fetch_assoc($query);

			if (!empty($result['id'])) {
				$userid = $result['id'];
			}
		}

		if (empty($userid) && ((empty($_REQUEST['callbackfn']) || (!empty($_REQUEST['callbackfn']) && $_REQUEST['callbackfn'] != 'desktop') || !empty($_REQUEST['guest_login'])))) {
			if(empty($guestName)){
				$guestName = rand(10000,99999);
			}
			$sql = ("insert into cometchat_guests (name) values ('".mysqli_real_escape_string($GLOBALS['dbh'],$guestName)."')");
			$query = mysqli_query($GLOBALS['dbh'],$sql);
			$userid = mysqli_insert_id($GLOBALS['dbh']);
			setcookie($cookiePrefix.'guest', base64_encode($userid), time()+3600*24*365, "/");
		}
		if (isset($_REQUEST['callbackfn']) && $_REQUEST['callbackfn'] == 'mobileapp') {
	        $sql = ("insert into cometchat_status (userid,isdevice) values ('".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."','1') on duplicate key update isdevice = '1'");
	        mysqli_query($GLOBALS['dbh'], $sql);
	    }
	}
	return $userid;
}

function getGuestsList($userid,$time,$originalsql) {

	global $guestsList;
	global $guestsUsersList;
	global $guestnamePrefix;

	$sql = ("select DISTINCT cometchat_guests.id userid, concat('".$guestnamePrefix."',cometchat_guests.name) username, '' link, '' avatar, cometchat_status.lastactivity lastactivity, cometchat_status.lastseen lastseen, cometchat_status.lastseensetting lastseensetting, cometchat_status.status, cometchat_status.message, cometchat_status.isdevice, cometchat_status.readreceiptsetting readreceiptsetting from cometchat_guests left join cometchat_status on cometchat_guests.id = cometchat_status.userid where ('".mysqli_real_escape_string($GLOBALS['dbh'],$time)."'- cometchat_status.lastactivity < '".((ONLINE_TIMEOUT)*2)."') and (cometchat_status.status IS NULL OR cometchat_status.status <> 'invisible' OR cometchat_status.status <> 'offline')");

	if (empty($_SESSION['cometchat']['guestMode'])) {
		if ($guestsUsersList == 2) {
			$sql = $originalsql;
		} else if ($guestsUsersList == 3) {
			$sql .= " UNION ".$originalsql;
		}
	} else {
		if ($guestsList == 2) {
			$sql = $originalsql;
		} else if ($guestsList == 3) {
			$sql .= " UNION ".$originalsql;
		}
	}
	return $sql;
}

function getChatroomGuests($chatroomid,$time,$originalsql) {

	global $guestnamePrefix;

	$sql = ("select DISTINCT cometchat_guests.id userid, concat('".mysqli_real_escape_string($GLOBALS['dbh'],$guestnamePrefix)."',cometchat_guests.name) username, '' avatar, cometchat_status.lastactivity lastactivity, cometchat_status.isdevice isdevice, cometchat_chatrooms_users.isbanned from cometchat_guests left join cometchat_status on cometchat_guests.id = cometchat_status.userid inner join cometchat_chatrooms_users on cometchat_guests.id = cometchat_chatrooms_users.userid where chatroomid = '".mysqli_real_escape_string($GLOBALS['dbh'],$chatroomid)."' and ('".mysqli_real_escape_string($GLOBALS['dbh'],$time)."' - cometchat_status.lastactivity < ".ONLINE_TIMEOUT.") Union ".$originalsql);

	return $sql;
}

function getChatroomBannedGuests($chatroomid,$time,$originalsql) {

	global $guestnamePrefix;

   $sql = ("select DISTINCT cometchat_guests.id userid, concat('".mysqli_real_escape_string($GLOBALS['dbh'],$guestnamePrefix)."',cometchat_guests.name) username, '' link, '' avatar, cometchat_status.lastactivity lastactivity, cometchat_status.isdevice isdevice, cometchat_status.status, cometchat_status.message from cometchat_guests left join cometchat_status on cometchat_guests.id = cometchat_status.userid inner join cometchat_chatrooms_users on  cometchat_guests.id =  cometchat_chatrooms_users.userid where chatroomid = '".mysqli_real_escape_string($GLOBALS['dbh'],$chatroomid)."' and cometchat_chatrooms_users.isbanned = 1 Union ".$originalsql);

   return $sql;
}

function getGuestDetails($userid) {

	global $guestnamePrefix;

	$sql = ("select cometchat_guests.id userid, concat('".mysqli_real_escape_string($GLOBALS['dbh'],$guestnamePrefix)."',cometchat_guests.name) username,  '' link,  '' avatar, cometchat_status.lastactivity lastactivity, cometchat_status.lastseen lastseen, cometchat_status.lastseensetting lastseensetting, cometchat_status.status, cometchat_status.message, cometchat_status.isdevice isdevice, cometchat_status.readreceiptsetting readreceiptsetting from cometchat_guests left join cometchat_status on cometchat_guests.id = cometchat_status.userid where cometchat_guests.id = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."'");

	return $sql;
}
