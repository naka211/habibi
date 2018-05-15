<?php
/**
 * Product   CometChat
 * Copyright (c) 2016 Inscripts
 * License: https://www.cometchat.com/legal/license

 * This is a installation file of Web-SDK. At the time of Web-SDK
 * installation you have to modify this file. This installation work for Different framework
 * Reference ULR : https://docs.cometchat.com/web-sdk/quick-start/
 *
 *
 * @category   Installation
 * @package    CometChat
 * @class      Integration
 * @author     Cometchat
 * @since      NA
 * @deprecated NA
 */
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* ADVANCED */

/**
* CMS Name
* @var string
*/
$cms = "codeigniter";

/**
* Database type
* @var string
*/
$dbms = "mysql";

/**
* If client want to integrate role base access control in his system. He have change value to "1"
* $role_base_access = 0; (Role base access control is deactive)
* $role_base_access = 1; (Role base access control is active)
* @var string
*/
$role_base_access = 0;

/**
* If client want to integrate Credit System for CometChat features. He have change value to "1"
* $enabled_credit = 0; (Credit system for CometChat feature deactive)
* $enabled_credit = 1; (Credit system for CometChat feature active)
* @var string
*/
$enabled_credit = 0;

define('SET_SESSION_NAME','');
define('SWITCH_ENABLED','1');
define('INCLUDE_JQUERY','1');
define('FORCE_MAGIC_QUOTES','0');
define('UNIQUE_CACHE_KEY','0'); // SET to 1 when getFriendList function is Configured manually


define('BASEPATH',true);
if(!file_exists(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'database.php')) {
	echo "Please check if CometChat is installed in the correct directory.<br /> The 'cometchat' folder should be placed at <CODEEGNITER_HOME_DIRECTORY>/cometchat";
	exit;
}
include_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'database.php');

/**
* DATABASE SETTINGS
* DB_SERVER : database server name. @var string
* DB_PORT : database port id. @var integer
* DB_USERNAME : database user name. @var string
* DB_PASSWORD : database Password. @var string
* DB_NAME : database name.  @var string
*/

define('DB_SERVER',			$db['default']['hostname']	 );
define('DB_PORT',			$db['port']					 );
define('DB_USERNAME',		$db['default']['username']	 );
define('DB_PASSWORD',		$db['default']['password']	 );
define('DB_NAME',			$db['default']['database'] 	 );

/**
* $table_prefix : table prefix
* If table prefix is not present keep it blank.
* @var string
*/
$table_prefix = '';

/**
* $db_usertable : User table name
* Users or members information table name.
* @var string
*/
$db_usertable = 'users';

/**
* $db_usertable_userid : UserId field in user / Member table. Its a primary key of user table.
* @var string
*/
$db_usertable_userid = 'userid';

/**
* $db_usertable_name : User Name containing field in the users or members table.
* @var string
*/
$db_usertable_name = 'username';

/**
* $db_avatartable : avatar field name.
* @var string
* If avatar is in same table enter 'avatar' table name
* If avatar is in another table use left join for it.
* Example : LEFT JOIN avatar_table ON user.id = avator_table.userid
*/
$db_avatartable = ' ';

/**
* $db_avatarfield : avatar field name.
* @var string
*/
$db_avatarfield = ' '.$table_prefix.$db_usertable.'.'.$db_usertable_userid.' ';

/**
* $db_linkfield : profile link field.
* @var string
*/
$db_linkfield = ' '.$table_prefix.$db_usertable.'.'.$db_usertable_userid.' ';


class Integration{

  /**
  * Constructor defining and default variable defining
  */
	function __construct(){
		if(!defined('TABLE_PREFIX')){
			$this->defineFromGlobal('table_prefix');
			$this->defineFromGlobal('db_usertable');
			$this->defineFromGlobal('db_usertable_userid');
			$this->defineFromGlobal('db_usertable_name');
			$this->defineFromGlobal('db_avatartable');
			$this->defineFromGlobal('db_avatarfield');
			$this->defineFromGlobal('db_linkfield');
			$this->defineFromGlobal('role_base_access');
			$this->defineFromGlobal('enabled_credit');
		}
	}

  /**
  * Define Global variables & unset it.
  */
	function defineFromGlobal($key){
		if(isset($GLOBALS[$key])){
			define(strtoupper($key), $GLOBALS[$key]);
			unset($GLOBALS[$key]);
		}
	}

  /**
  * get user id
  * @param -
  * @return (integer) ($userid)
  */
	function getUserID() {
		$userid = 0;
		if (!empty($_SESSION['basedata']) && $_SESSION['basedata'] != 'null') {
			$_REQUEST['basedata'] = $_SESSION['basedata'];
		}
		if (!empty($_REQUEST['basedata'])) {

			if (function_exists('mcrypt_encrypt') && defined('ENCRYPT_USERID') && ENCRYPT_USERID == '1') {
				$key = "";
				if( defined('KEY_A') && defined('KEY_B') && defined('KEY_C') ){
					$key = KEY_A.KEY_B.KEY_C;
				}
				$uid = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode(rawurldecode($_REQUEST['basedata'])), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
				if (intval($uid) > 0) {
					$userid = $uid;
				}
			} else {
				$userid = $_REQUEST['basedata'];
			}
		}
		if (!empty($_COOKIE['ci_session']) && (empty($userid) || $userid == "null")) {
			$uid = unserialize($_COOKIE['ci_session']);
			if(!empty($uid['userid'])){
				$userid = $uid['userid'];
			}
		}

		if (!empty($_COOKIE['username']) &&  empty($userid)) {
			$userEmail = urldecode($_COOKIE['username']);
			$sql = ("SELECT user_id FROM ".TABLE_PREFIX.DB_USERTABLE." WHERE ".TABLE_PREFIX.DB_USERTABLE.".user_email = '".sql_real_escape_string($userEmail)."' ");
			$result = sql_query($sql, array(), 1);
			$row = sql_fetch_assoc($result);
			$userid = $row['user_id'];
		}

		$userid = intval($userid);
		return $userid;
	}

  /**
  * Chat login
  * @param - (integer) ($userName), (string) ($userPass)
  * @return (integer) ($userid)
  */
  	function chatLogin($userName,$userPass) {
		$userid = 0;
		global $guestsMode;

	    /** TODO: Modifiable SQL query START **/
			/* The SQL query should return user details */
			if (filter_var($userName, FILTER_VALIDATE_EMAIL)) {
				$sql = ("SELECT * FROM `".TABLE_PREFIX.DB_USERTABLE."` WHERE email = '".sql_real_escape_string($userName)."'");
			} else {
				$sql = ("SELECT * FROM `".TABLE_PREFIX.DB_USERTABLE."` WHERE ".DB_USERTABLE_NAME." = '".sql_real_escape_string($userName)."'");
			}
	    /** Modifiable SQL query END **/

		$result = sql_query($sql, array(), 1);
		$row = sql_fetch_assoc($result);
		if($row['password'] == $userPass) {
			$userid = $row['id'];
		}
		if(!empty($userName) && !empty($_REQUEST['social_details'])) {
			$social_details = json_decode($_REQUEST['social_details']);
			$userid = socialLogin($social_details);
		}
		if(!empty($_REQUEST['guest_login']) && $userPass == "CC^CONTROL_GUEST" && $guestsMode == 1){
			$userid = getGuestID($userName);
		}
		if(!empty($userid) && isset($_REQUEST['callbackfn']) && $_REQUEST['callbackfn'] == 'mobileapp'){
			 $sql = ("insert into cometchat_status (userid,isdevice) values ('".sql_real_escape_string($userid)."','1') on duplicate key update isdevice = '1'");
                sql_query($sql, array(), 1);
		}
		if($userid && function_exists('mcrypt_encrypt') && defined('ENCRYPT_USERID') && ENCRYPT_USERID == '1'){
			$key = "";
				if( defined('KEY_A') && defined('KEY_B') && defined('KEY_C') ){
					$key = KEY_A.KEY_B.KEY_C;
				}
			$userid = rawurlencode(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $userid, MCRYPT_MODE_CBC, md5(md5($key)))));
		}
	    return $userid;
	}

  /**
  * Get Online Friends List
  * @param - (integer) ($userid), (timestamp) ($time)
  * @return (string) ($sql)
  */
	function getFriendsList($userid,$time) {
		global $hideOffline;
		$offlinecondition = '';
		if ($hideOffline) {
			$offlinecondition = "where ((cometchat_status.lastactivity > (".sql_real_escape_string($time)."-".((ONLINE_TIMEOUT)*2).")) OR cometchat_status.isdevice = 1) and (cometchat_status.status IS NULL OR cometchat_status.status <> 'invisible' OR cometchat_status.status <> 'offline')";
		}
		$sql = ("select DISTINCT ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username, ".DB_LINKFIELD." link, ".DB_AVATARFIELD." avatar, cometchat_status.lastactivity lastactivity, cometchat_status.lastseen lastseen, cometchat_status.lastseensetting lastseensetting, cometchat_status.status, cometchat_status.message, cometchat_status.isdevice, cometchat_status.readreceiptsetting readreceiptsetting from ".TABLE_PREFIX.DB_USERTABLE." left join cometchat_status on ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid ".DB_AVATARTABLE." ".$offlinecondition." order by username asc");

		return $sql;
	}

   /**
  * Get Friends Ids
  * @param - (integer) $userid
  * @return (string) ($sql)
  */
	function getFriendsIds($userid) {
		$sql = ("select ".TABLE_PREFIX."friends.friend_user_id friendid from ".TABLE_PREFIX."friends where ".TABLE_PREFIX."friends.initiator_user_id = '".sql_real_escape_string($userid)."' and is_confirmed = 1 union select ".TABLE_PREFIX."friends.initiator_user_id friendid from ".TABLE_PREFIX."friends where ".TABLE_PREFIX."friends.friend_user_id = '".sql_real_escape_string($userid)."' and is_confirmed = 1");

		return $sql;
	}

  /**
  * Get User Details
  * @param - (integer) $userid
  * @return (string) ($sql)
  */
	function getUserDetails($userid) {
		$sql = ("select ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username, ".DB_LINKFIELD." link, ".DB_AVATARFIELD." avatar, cometchat_status.lastactivity lastactivity, cometchat_status.lastseen lastseen, cometchat_status.lastseensetting lastseensetting, cometchat_status.status, cometchat_status.message, cometchat_status.isdevice, cometchat_status.readreceiptsetting readreceiptsetting from ".TABLE_PREFIX.DB_USERTABLE." left join cometchat_status on ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid ".DB_AVATARTABLE." where ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = '".sql_real_escape_string($userid)."'");

		return $sql;
	}

   /**
  * Get Active Chatbox Details
  * @param - (integer) $userid
  * @return (string) ($sql)
  */
	function getActivechatboxdetails($userids) {
		$sql = ("select DISTINCT ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username, ".DB_LINKFIELD." link, ".DB_AVATARFIELD." avatar, cometchat_status.lastactivity lastactivity, cometchat_status.lastseen lastseen, cometchat_status.lastseensetting lastseensetting, cometchat_status.status, cometchat_status.message, cometchat_status.isdevice, cometchat_status.readreceiptsetting readreceiptsetting from ".TABLE_PREFIX.DB_USERTABLE." left join cometchat_status on ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." = cometchat_status.userid ".DB_AVATARTABLE." where ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." IN (".$userids.")");

		return $sql;
	}

  /**
  * Get User Status
  * @param - (integer) $userid
  * @return (string) ($sql)
  */
	function getUserStatus($userid) {
		$sql = ("select cometchat_status.message, cometchat_status.lastseen lastseen, cometchat_status.lastseensetting lastseensetting, cometchat_status.status from cometchat_status where userid = '".sql_real_escape_string($userid)."'");

		return $sql;
	}

  /**
  * Fetch Link
  * user profile URL
  * @param - (string) $link
  * @return ''
  */
	function fetchLink($link) {
		return '';
	}

  /**
  * Get User Avatar URL
  * user Avatar URL
  * @param - (string) $image
  * @return default avatar
  */
	function getAvatar($image) {
		return BASE_URL.'images/noavatar.png';
	}

	function getTimeStamp() {
		return time();
	}

	function processTime($time) {
		return $time;
	}

  /**
  * Get Users Role
  * get users current role
  * @param - (string) $image
  * @return role
  */
	function getRole($userid){
		$role = 'default';
		global $userid;

		$sql = ("SELECT `role` FROM `users` WHERE `id` = '".$userid."'");
		$result = sql_query($sql, array(), 1);
		if($user = sql_fetch_assoc($result)){
			if(!empty($user['role']) && $user['role']<>'NULL'){
				$role = $user['role'];
			}
		}
		return $role;
	}

  /**
  * Get All Roles Details
  *
  * @param - (string) $role
  * @return (array)  $roles
  */
	function getRolesDetails($role = ''){
		global $guestsMode, $firstguestID;
		$roles = array();
		$sql = ("SELECT DISTINCT `role` FROM `users` order by `role`");
		if(!empty($role)){
			$sql = ("SELECT DISTINCT `role` FROM `users` WHERE `role`='".sql_real_escape_string($role)."'");
		}
		$result = sql_query($sql, array(), 1);
		while ($role = sql_fetch_assoc($result)) {
			if($role['role']=='NULL'||$role['role']==''){
				$role['role'] = 'default';
			}
			$roles[$role['role']] = array('name' => ucwords($role['role']));
		}
		if(empty($roles['default'])){
			$roles['default'] = array('name' => 'Default');
		}
		if ($guestsMode) {
			$roles["guest"] = array("name" => "Guest");
		}
		return $roles;
	}

/**
* Get Credits Details
*
* This function should return the number of credits present for a user
* @param -
* @return (integer)  $credits
*/
function getCredits(){
		/**
			The function returns the current value of the credits for a loggedin user.
			The developers can modify the SQL query to retrieve the credits available with the user.
		**/
		global $userid;
		$credits = 0;

		/** TODO: Modifiable SQL query START **/
		/* The SQL query should return the credits for $userid */
		$sql = ("SELECT `credits` FROM `users` WHERE `id` = '".sql_real_escape_string($userid)."'");
		/** Modifiable SQL query END **/

		$result = sql_query($sql, array(), 1);
		if($user = sql_fetch_assoc($result)){
			$credits = $user['credits'];
		}
		return $credits;
	}

  /**
  * Get Credits to Deduct
  *
  * returns the credit to deduct and the deduction interval
  * @param - (array) $params
  * @return (array)  $creditsinfo
  */
	function getCreditsToDeduct($params=array()){
		/**
		    The function returns the returns the credit to deduct and the deduction interval.
			It is not recommended for the developers to modify the function.
		**/
		global $userid;
		$creditsinfo = array(
			'creditsToDeduct'=>0,
			'deductionInterval'=>0
		);

		$defaultParams = array(
			'type'=>'',
			'name'=>''
		);
		$params =  array_merge($defaultParams,$params);
		$role = !empty($params['role'])?$params['role']:$this->getRole($userid);
		$type = $params['type'];
		$name = $params['name'];
		if(!empty($role) && !empty($type) && !empty($name)){
			$rolefeature = $GLOBALS[$role.'_'.$type.($type!='core'?'s':'')];
			if(!empty($rolefeature) && !empty($rolefeature[$name]) && !empty($rolefeature[$name]['credit'])){
				$creditsinfo['creditsToDeduct'] =  $rolefeature[$name]['credit']['creditsToDeduct'];
				$creditsinfo['deductionInterval'] = $rolefeature[$name]['credit']['deductionInterval'];
			}
		}
		return $creditsinfo;
	}

  /**
  * Deduct Credits
  *
  * The function deducts the credits from database.
  * @param - (array) $params
  * @return (array)  $response
  */
	function deductCredits($params){

		/**
			The function deducts the credits in database.
			The developers can modify the query to update the deducted credits to database.
		**/

		if(!defined('ENABLED_CREDIT') && ENABLED_CREDIT==0){
			return array('errorcode'=>1,'message'=>'Credit Deduction is disabled by the Administrator.');
		}
		global $userid;
		$defaultParams = array(
			'to'=>0,
			'isGroup'=>0
		);
		$params =  array_merge($defaultParams,$params);
		$response = array('success'=> false);
		$to = $params['to'];
		$isGroup = $params['isGroup'];
		$type = $params['type'];
		$name = $params['name'];

		if(!empty($params['creditsToDeduct']) && !empty($params['deductionInterval'])){
			$creditsToDeduct = abs($params['creditsToDeduct']);
			$deductionInterval = $params['deductionInterval'];
		}else{
			$creditsinfo =  $this->getCreditsToDeduct($params);
			$creditsToDeduct = abs($creditsinfo['creditsToDeduct']);
			$deductionInterval = $creditsinfo['deductionInterval'];
		}

		/*** Set credit deduction timer ***/
		if(empty($_SESSION['cometchat'])){
			$_SESSION['cometchat'] = array();
		}
		if(empty($_SESSION['cometchat']['creditsdeductiontimer'])){
			$_SESSION['cometchat']['creditsdeductiontimer'] = array();
		}
		if(empty($_SESSION['cometchat']['creditsdeductiontimer'][$type.$name.$to.$isGroup])){
			$_SESSION['cometchat']['creditsdeductiontimer'][$type.$name.$to.$isGroup] = 0;
		}


		$availableCredits = $this->getCredits();

		if($creditsToDeduct==0){
			$response['errorcode'] = '2';
			$response['message'] = 'The Credit Deduction is not enabled for the '.$name.' '.$type.' for the '.$role.' role';
			$response['balance'] = $availableCredits;
		}elseif($creditsToDeduct > $availableCredits){
			$response['errorcode'] = '3';
			$response['message'] = $GLOBALS['language']['insufficient_credits'];
			$response['balance'] = $availableCredits;
		}elseif($_SESSION['cometchat']['creditsdeductiontimer'][$type.$name.$to.$isGroup]>time()-$deductionInterval*60){
			$response['errorcode'] = '4';
			$response['message'] = 'Already deducted '.$creditsToDeduct.' credits for the '.$type.' '.$name.' for the interval of '.$deductionInterval.' minutes';
			$response['balance'] = $availableCredits;
		}else{
			/** TODO: Modifiable SQL query START **/
			/* The SQL query should update the deducted credits for $userid */
			$sql = ("UPDATE `users` SET `credits` = `credits` - ".sql_real_escape_string($creditsToDeduct)." WHERE `id`='".sql_real_escape_string($userid)."'");
			/** Modifiable SQL query END **/
			$result = sql_query($sql, array(), 1);
			if(sql_affected_rows()>0){
				$_SESSION['cometchat']['creditsdeductiontimer'][$type.$name.$to.$isGroup] = time();
				$response['success'] = true;
				$response['message'] = 'Deducted '.$creditsToDeduct.' credits for using the '.$name.' '.$type.' for the interval of '.$deductionInterval.' minutes';
				$response['balance'] = $this->getCredits();
			}else{
				$response['errorcode'] = '5';
				$response['message'] = 'An error occurred while deducting credits from the database';
			}
		}
		return $response;
	}

 /* HOOKS */

  /**
  * hooks message
  *
  * This function inserts messages into Sites Messaging Table.
  * @param - (integer) $userid, (integer) $to, (string) $unsanitizedmessage, (integer) $dir, (string) $origmessage
  * @return -
  */
	function hooks_message($userid,$to,$unsanitizedmessage,$dir,$origmessage='') {
		global $language;
	}

  /**
  * hooks message
  *
  * This function forcefuly Add user into Contact List.
  * @param -
  * @return - (array)
  */
	function hooks_forcefriends() {

	}

  /**
  * hooks update Last Activity
  *
  * This function forcefuly Add user into Contact List.
  * @param - (integer) $userid
  * @return - (array)
  */
	function hooks_updateLastActivity($userid) {

	}

  /**
  * hooks update Last Activity
  *
  * This function forcefuly Add user into Contact List.
  * @param - (integer) $userid
  * @return - (array)
  */
	function hooks_statusupdate($userid,$statusmessage) {

	}

	function hooks_activityupdate($userid,$status) {

	}

}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* LICENSE */

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'license.php');
$x = "\x62a\x73\x656\x34\x5fd\x65c\157\144\x65";
eval($x('JHI9ZXhwbG9kZSgnLScsJGxpY2Vuc2VrZXkpOyRwXz0wO2lmKCFlbXB0eSgkclsyXSkpJHBfPWludHZhbChwcmVnX3JlcGxhY2UoIi9bXjAtOV0vIiwnJywkclsyXSkpOw'));

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
