<?php

if(!empty($_POST['userid'])){
	$_POST['basedata'] = $_POST['userid'];
}
$route = '';
if(!empty($_GET['route'])){
	$route = trim($_GET['route']);
	$route =  stripslashes($route);
	$route = str_replace('/','',$route);
}

if (!empty($route)) {
	$_POST['action'] = $route;
}

include_once(dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."config.php");
include_once(dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."cometchat_init.php");

if(!empty($client) && file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR."api.php")) {
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."api.php");
}

function checkAPIKEY($keyvalue) {
	global $apikey;
	if(!empty($keyvalue) && !empty($apikey)) {
		if($apikey == $keyvalue) {
			return 1;
		}
		$msg = 'Incorrect API KEY.';
		$response = array('failed' => array('status' => '1011', 'message' => $msg));
		echo json_encode($response); exit;
	}
	$msg = 'Invalid API KEY.';
	$response = array('failed' => array('status' => '1010', 'message' => $msg));
	echo json_encode($response); exit;
}

/*
* Handel Logic of Create User
* Created On : April-2018
* return boolean
*/
function createUser($dataArray) {
	$api_response 	= array();
	$UID		 	= $dataArray['UID'];
	$name 			= $dataArray['name'];
	$avatarURL 		= $dataArray['avatarURL'];
	$profileURL 	= $dataArray['profileURL'];
	$role			= $dataArray['role'];

	if($UID == false) {
		$api_response['failed'] = array('status' => '2001','message' => 'Invalid UID.');
	} else {
		$queryUniqueUser = fn_ccIsUserExist($UID);
		if($queryUniqueUser){
			$api_response['failed'] = array('status' => '2001','message' => 'User already exists');
		} else {
			$columns = array('username' => $name, 'link' => $profileURL, 'displayname' => $name,
							'avatar' => $avatarURL, 'uid' => $UID, DB_USERTABLE_ROLE   => $role);

			// Create New User Function. Return true if user added in database successfuly.
			$isUserCreated = fn_ccCreateNewUser($columns);
			if($isUserCreated) {
				$api_response['success'] = array('status' => '2000', 'message' => 'User created successfully!');
			} else {
				$api_response['failed'] = array('status' => '2001', 'message' => 'Someething Went Wrong. Please try after some time');
			}
		}
	}
	return $api_response;
}

function deleteUser($dataArray) {
	$api_response 	= array();
	$UID		 	= $dataArray['UID'];

	if($UID == false) {
		$api_response['failed'] = array('status' => '2001','message' => 'Invalid UID.');
	} else {
		$queryUniqueUser = fn_ccIsUserExist($UID);
		if($queryUniqueUser){
			//  Remove User From Cloud Database
			$isUserDelete = sql_query('cloudapi_removeUserUsingUID',array('uid'=>$UID));

			if($isUserDelete) {
				// Remove User from Other Friend's List
				$result = sql_query('removeIdsFromOtherFriendListUsingUID',array('uid' => $UID));
				while($row = sql_fetch_assoc($result)) {
					$friendsArray = explode(',', $row['friends']);
					$key = array_search($UID, $friendsArray);
					unset($friendsArray[$key]);
					$friendsString = implode(',', $friendsArray);

					// Update User Friend List
					sql_query('cloudapi_updatefriends',array('friends'=>$friendsString, 'uid'=>$UID,'fieldname'=>'uid'));
				}
				$api_response['success'] = array('status' => '2000','message' => 'User deleted successfully!');
			}
		} else {
			$api_response['failed'] = array('status' => '2001','message' => 'Invalid UID');
		}
	}
	return $api_response;
}

function updateUser($dataArray) {
	$api_response 	= array();
	$UID 		= $dataArray['UID'];
	if($UID == false) {
		$api_response['failed'] = array('status' => '2001','message' => 'Invalid UID.');
	} else {
		$queryUniqueUser = fn_ccIsUserExist($UID);
		if($queryUniqueUser){

			$name 			= $dataArray['name'];
			$avatarURL 		= $dataArray['avatarURL'];
			$profileURL 	= $dataArray['profileURL'];
			$role 			= $dataArray['role'];

			// Set All Variables in Update
			$set .= "";
			$set .=  "`username`= '".sql_real_escape_string($name)."', ";
			$set .=  "`link`= '".sql_real_escape_string($profileURL)."', ";
			$set .=  "`avatar`= '".sql_real_escape_string($avatarURL)."', ";
			$set .=  "`displayname`= '".sql_real_escape_string($name)."', ";
			$set .=  "`role`= '".sql_real_escape_string($role)."' ";
			sql_query('cloudapi_updateuserUsingUID',array('set'=>$set, 'uid'=>$UID));
			$api_response['success'] = array('status' => '2000','message' => 'User updated successfully');
		} else {
			$api_response['failed'] = array('status' => '2001','message' => 'Invalid UID');
		}
	}
	return $api_response;
}

function blockUser($dataArray) {
	$api_response 	= array();
	$senderUID 		= $dataArray['senderUID'];
	$receiverUID 	= $dataArray['receiverUID'];

	if($senderUID == false || $receiverUID == false){
		$api_response['failed'] = array('status' => '2001','message' => 'Invalid Sender or Receiver UID');
	} else {
		// Check if sender User Id & Receiver User Id Is Present in Database
		$queryUniqueUserSender 		= fn_ccIsUserExist($senderUID);
		$queryUniqueUserReceiver 	= fn_ccIsUserExist($receiverUID);

		if($queryUniqueUserSender == false || $queryUniqueUserReceiver == false) {
			$api_response['failed'] = array('status' => '2001','message' => 'Invalid Sender or Receiver UID');
		} else {
			/* Get Sender CometChat Id Details */
			$resultSender = sql_query('cloudapi_getData',array('fetchfield'=>'userid','fieldname'=>'uid','value'=>$senderUID));
			$userSender = sql_fetch_array($resultSender);
			$ccSenderId = $userSender['userid'];

			/* Get Receiver CometChat Id Details */
			$resultReceiver = sql_query('cloudapi_getData',array('fetchfield'=>'userid','fieldname'=>'uid','value'=>$receiverUID));
			$userReceiver = sql_fetch_array($resultReceiver);
			$ccReceiverId = $userReceiver['userid'];

			$query = sql_query('isUserBlocked',array('fromuserid'=>$ccSenderId, 'touserid'=>$ccReceiverId));

			if($result = sql_fetch_assoc($query)){
				$api_response['failed'] = array('status' => '2001', 'message' => "User already Blocked.");
			} else {
				$query = sql_query('blockUser',array('fromid'=>$ccSenderId, 'toid'=>$ccReceiverId));
				$error = sql_error($GLOBALS['dbh']);
				$api_response['success'] = array('status' => '2000', 'message' => "User blocked successfully");
			}
		}
	}
	return $api_response;
}

function unblockUser($dataArray) {
	$api_response 	= array();
	$senderUID 		= $dataArray['senderUID'];
	$receiverUID 	= $dataArray['receiverUID'];

	if($senderUID == false || $receiverUID == false){
		$api_response['failed'] = array('status' => '2001','message' => 'Invalid Sender or Receiver UID');
	} else {
		// Check if sender User Id & Receiver User Id Is Present in Database
		$queryUniqueUserSender 		= fn_ccIsUserExist($senderUID);
		$queryUniqueUserReceiver 	= fn_ccIsUserExist($receiverUID);

		if($queryUniqueUserSender == false || $queryUniqueUserReceiver == false) {
			$api_response['failed'] = array('status' => '2001','message' => 'Invalid Sender or Receiver UID');
		} else {
			/* Get Sender CometChat Id Details */
			$resultSender = sql_query('cloudapi_getData',array('fetchfield'=>'userid','fieldname'=>'uid','value'=>$senderUID));
			$userSender = sql_fetch_array($resultSender);
			$ccSenderId = $userSender['userid'];

			/* Get Receiver CometChat Id Details */
			$resultReceiver = sql_query('cloudapi_getData',array('fetchfield'=>'userid','fieldname'=>'uid','value'=>$receiverUID));
			$userReceiver = sql_fetch_array($resultReceiver);
			$ccReceiverId = $userReceiver['userid'];

			$queryIsUserBlocked = sql_query('isUserBlocked',array('fromuserid'=>$ccSenderId, 'touserid'=>$ccReceiverId));
			if($result = sql_fetch_assoc($queryIsUserBlocked)){
				$query = sql_query('unblockUser',array('fromid'=>$ccSenderId, 'toid'=>$ccReceiverId));
				$error = sql_error($GLOBALS['dbh']);
				if (!empty($error)) {
					$api_response['error'] = sql_error($GLOBALS['dbh']);
					$api_response['failed'] = array('status' => '2001', 'message' => "Failed to unblocked user.");
				}else{
					$api_response['success'] = array('status' => '2000', 'message' => "User unblocked successfully.");
				}
			}else{
				$api_response['failed'] = array('status' => '1014', 'message' => "User already unblocked.");
			}
		}
	}
	return $api_response;
}

function addFriends($dataArray) {
	$api_response 		= array();
	$newFriendsArray 	= array();
	$dbFriendList 		= array();
	$UID 				= $dataArray['UID'];
	$friendsUID 		= $dataArray['friendsUID'];

	if($UID == false) {
		$api_response['failed'] = array('status' => '2001','message' => 'Invalid UID.');
	} else {
		$queryUniqueUser = fn_ccIsUserExist($UID);
		if($queryUniqueUser){
			if($friendsUID == false) {
				$api_response['failed'] = array('status' => '2001','message' => 'Invalid Friends UID');
			} else {
				$newFriendsArray = explode(',',$friendsUID);

				/* Get Logedin Users Details */
				$result = sql_query('cloudapi_getData',array('fetchfield'=>'friends','fieldname'=>'uid','value'=>$UID));
				$user = sql_fetch_array($result);

				if(!empty($user['friends']) && $clearExisting == 0) {
					$dbFriendList = explode(",",$user['friends']);
				}

				$finalFriendsList = array_merge($dbFriendList,$newFriendsArray);
				$newFriendsList = trim(implode(',',$finalFriendsList),',');

				sql_query('cloudapi_updateFriendsUsingUID',array('friends'=>$newFriendsList, 'uid'=>$UID));
				$api_response['success'] = array('status' => '2000','message' => 'Friends updated successfully!');
			}
		} else {
			$api_response['failed'] = array('status' => '2001','message' => 'Invalid UID');
		}
	}
	return $api_response;
}

function deleteFriends($dataArray){
	$UID 					= $dataArray['UID'];
	$friendsUID 			= $dataArray['friendsUID'];
	$api_response 			= array();
	$newFriendsList    		= array();
	$dbFriendList 	   		= array();
	$finalFriendsList  		= array();
	$finalFriendsListStr 	= "";

	if($UID == false) {
		$api_response['failed'] = array('status' => '2001','message' => 'Invalid UID');
	} else {
		$queryUniqueUser = fn_ccIsUserExist($UID);
		if($queryUniqueUser){
			if($friendsUID == false) {
				$api_response['failed'] = array('status' => '2001','message' => 'Invalid Friends UID');
			} else {
				$removeFriendsArray = explode(',',$friendsUID);

				/* Get Logedin Users Details */
				$result = sql_query('cloudapi_getData',array('fetchfield'=>'friends','fieldname'=>'uid','value'=>$UID));
				$user = sql_fetch_array($result);

				if(!empty($user['friends'])) {
					$dbFriendList = explode(",",$user['friends']);
				}
				$finalFriendsList = array_diff($dbFriendList, $removeFriendsArray);
				$finalFriendsListStr = trim(implode(',',$finalFriendsList),',');

				sql_query('cloudapi_updateFriendsUsingUID',array('friends'=>$finalFriendsListStr, 'uid'=>$UID));
				$api_response['success'] = array('status' => '2000','message' => 'Friends updated successfully!');
			}
		} else {
			$api_response['failed'] = array('status' => '2001','message' => 'Invalid UID');
		}
	}
	return $api_response;
}

function listUsers($dataArray) {
	$api_response 			= array();
	$offset 				= $dataArray['offset'];
	$limit 					= $dataArray['limit'];

	$start = ($offset - 1) * $limit;
	$userlist = array();
	$result = sql_query('cloudapi_getUsersDetails', array('limit'=>$limit,'offset'=>$offset));

	while($row = sql_fetch_assoc($result)){
		$userlist[] = $row;
	}
	$api_response['success'] = array('status' => '2000', 'message' => "List fetched successfully", 'data' => $userlist);

	return $api_response;
}

function updateCredits($dataArray) {
	$UID 	= $dataArray['UID'];
	$credits = 0;
	if($UID == false) {
		$api_response['failed'] = array('status' => '2001','message' => 'Invalid UID.');
	} else {
		$credits = getCredit($dataArray);
		if($credits != $dataArray['credits']) {
		$sql = ("UPDATE `".TABLE_PREFIX.DB_USERTABLE."` SET credits = ".sql_real_escape_string($dataArray['credits'])." WHERE `uid`='".sql_real_escape_string($UID)."'");
		$result = sql_query($sql, array(), 1);
		$credits = getCredit($dataArray);
		}
	}
	return $credits;
}
function getCredits($dataArray) {
	$UID 	= $dataArray['UID'];
	$credits = 0;
	if($UID == false) {
		$api_response['failed'] = array('status' => '2001','message' => 'Invalid UID.');
	} else {
	$sql = ("SELECT `credits` FROM `".TABLE_PREFIX.DB_USERTABLE."` WHERE `uid` = '".sql_real_escape_string($UID)."'");
		$result = sql_query($sql, array(), 1);
		$user = sql_fetch_assoc($result);
		$credits = $user['credits'];
	}
	return $credits;
}
/*
* Create New User Into Database
* Created On : April-2018
* return boolean
*/
function fn_ccCreateNewUser($userDataColumnsArr) {
	sql_query('cloudapi_createuser', $userDataColumnsArr);
	$userid = sql_insert_id(TABLE_PREFIX.DB_USERTABLE, DB_USERTABLE_USERID);
	return ($userid > 0 ? true : false);
}

/*
* Get User Details Query Using UID
* Created On : 23-April-2018
* return boolean
*/
function fn_ccIsUserExist($UID) {
	$sql = sql_getQuery('selectUser');
	$sql .= (" where `uid` = '".$UID."'");
	$query = sql_query($sql, array(), 1);

	if($query->num_rows > 0){
		return true;
	}
	return false;
}
