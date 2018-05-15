<?php
/*

CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license

*/



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
global $cc_auth_table_prefix, $cc_auth_db_usertable, $cc_auth_db_usertable_userid, $cc_auth_db_usertable_username, $cc_auth_db_usertable_name, $cc_auth_db_avatartable, $cc_auth_db_avatarfield, $cc_auth_db_linkfield, $cc_auth_db_groupfield;

$cc_auth_table_prefix = ''								;
$cc_auth_db_usertable =	'cometchat_users'				;
$cc_auth_db_usertable_userid = 'userid'					;
$cc_auth_db_usertable_username = 'username'				;
$cc_auth_db_usertable_name = 'displayname'				;
$cc_auth_db_avatartable = ' '							;
$cc_auth_db_avatarfield = ' '.$db_usertable.'.avatar '	;
$cc_auth_db_linkfield = ' link '						;
$cc_auth_db_groupfield = ' grp '						;

/* COMETCHAT'S SOCIAL AUTHENTICATION CLASS */

class CCAuth{

	function __construct(){
		$this->defineFromGlobal('table_prefix');
		$this->defineFromGlobal('db_usertable');
		$this->defineFromGlobal('db_usertable_userid');
		$this->defineFromGlobal('db_usertable_username');
		$this->defineFromGlobal('db_usertable_name');
		$this->defineFromGlobal('db_avatartable');
		$this->defineFromGlobal('db_avatarfield');
		$this->defineFromGlobal('db_linkfield');
		$this->defineFromGlobal('db_groupfield');
	}

	function defineFromGlobal($key){
		if(isset($GLOBALS['cc_auth_'.$key])&&!defined(strtoupper($key))){
			define(strtoupper($key), $GLOBALS['cc_auth_'.$key]);
			unset($GLOBALS[$key]);
		}
	}

	function getUserID() {
		$userid = 0;


		if (!empty($_SESSION['basedata']) && $_SESSION['basedata'] != 'null') {
			   $_REQUEST['basedata'] = $_SESSION['basedata'];
		   }

		if (!empty($_REQUEST['basedata'])) {
		   $userid = $_REQUEST['basedata'];
		}

		if (!empty($_SESSION['cometchat']['userid']) && !empty($_SESSION['cometchat']['ccauth'])){
			$userid = $_SESSION['cometchat']['userid'];
		}

		return $userid;
	}

	function chatLogin($userName,$userPass) {
		$userid = 0;
		if(!empty($userName) && !empty($_REQUEST['social_details'])) {
			$social_details = json_decode($_REQUEST['social_details']);
			$userid = socialLogin($social_details);
		}
		return $userid;
	}

	function getFriendsList($userid,$time) {

		$sql = ("select DISTINCT ".DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".DB_USERTABLE.".".DB_USERTABLE_NAME." username, ".DB_USERTABLE.".".DB_LINKFIELD." link, ".DB_AVATARFIELD." avatar, ".DB_USERTABLE.".".DB_GROUPFIELD." grp, cometchat_status.lastactivity lastactivity, cometchat_status.lastseen lastseen, cometchat_status.lastseensetting lastseensetting, cometchat_status.status, cometchat_status.message, cometchat_status.isdevice from ".DB_USERTABLE." left join cometchat_status on ".DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid ".DB_AVATARTABLE." where (cometchat_status.status IS NULL OR cometchat_status.status <> 'invisible' OR cometchat_status.status <> 'offline') order by username asc");

		return $sql;
	}

	function getUserDetails($userid) {
		$sql = ("select ".DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".DB_USERTABLE.".".DB_USERTABLE_NAME." username,  ".DB_USERTABLE.".".DB_LINKFIELD." link, ".DB_AVATARFIELD." avatar, cometchat_status.lastactivity lastactivity, cometchat_status.lastseen lastseen, cometchat_status.lastseensetting lastseensetting, cometchat_status.status, cometchat_status.message, cometchat_status.isdevice from ".DB_USERTABLE." left join cometchat_status on ".DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid ".DB_AVATARTABLE." where ".DB_USERTABLE.".".DB_USERTABLE_USERID." = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."'");
		return $sql;
	}

function getActivechatboxdetails($userids) {
	$sql = ("select DISTINCT ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username,  ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." link, ".DB_AVATARFIELD." avatar,".DB_USERTABLE.".".DB_GROUPFIELD." grp, cometchat_status.lastactivity lastactivity, cometchat_status.lastseen lastseen, cometchat_status.lastseensetting lastseensetting, cometchat_status.status, cometchat_status.message, cometchat_status.isdevice from ".TABLE_PREFIX.DB_USERTABLE." left join cometchat_status on ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid ".DB_AVATARTABLE." where ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." IN (".$userids.")");

	return $sql;
}

	function fetchLink($link) {
	   return $link;
	}

	function getAvatar($data) {
		return $data;
	}

	function getTimeStamp() {
		return time();
	}

	function processTime($time) {
		return $time;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/* HOOKS */

	function hooks_statusupdate($userid,$statusmessage) {

	}

	function hooks_forcefriends() {

	}

	function hooks_activityupdate($userid,$status) {

	}

	function hooks_message($userid,$to,$unsanitizedmessage) {

	}
}
