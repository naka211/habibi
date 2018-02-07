<?php

/*

CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license

*/
include_once(dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."plugins.php");

if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR."lang.php")) {
    include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."lang.php");
}

$history = intval($_REQUEST['history']);
function logs() {
    $usertable = TABLE_PREFIX.DB_USERTABLE;
    $usertable_username = DB_USERTABLE_NAME;
    $usertable_userid = DB_USERTABLE_USERID;
    global $history;
    global $userid;
    global $chathistory_language;
    global $guestsMode;
    global $guestnamePrefix;
    global $response;

    if (!empty($_REQUEST['history'])) {
        $currentroom = $_REQUEST['history'];
    }
    $guestpart = "";
    if (!empty($_REQUEST['chatroommode'])) {
        if ($guestsMode == '1') {
            $guestpart = " union (select m1.*, concat('".mysqli_real_escape_string($GLOBALS['dbh'],$guestnamePrefix)."',f.name) fromu, from_unixtime(m1.sent,'%y,%m,%d') from cometchat_chatroommessages m1, cometchat_guests f where f.id = m1.userid and m1.chatroomid = '".mysqli_real_escape_string($GLOBALS['dbh'],$history)."' and m1.message NOT LIKE 'CC^CONTROL_deletemessage_%' group by date_format(from_unixtime(sent),'%y,%m,%d') desc) order by id";
            }
            $sql = ("select * from ((select m1.*, f.".$usertable_username." fromu, from_unixtime(m1.sent,'%y,%m,%d') from cometchat_chatroommessages m1, ".$usertable." f where f.".$usertable_userid." = m1.userid and m1.chatroomid = '".mysqli_real_escape_string($GLOBALS['dbh'],$history)."' and m1.message not like '%banned%' and m1.message not like '%kicked%' and m1.message not like '%deletemessage%' group by date_format(from_unixtime(sent),'%y,%m,%d') desc) ".$guestpart.") as t group by date_format(from_unixtime(sent),'%y,%m,%d') desc");
            } else {
                if ($guestsMode == '1') {
                    $guestpart = "union (select * from (
    (select m1.*, concat('".$guestnamePrefix."',f.name) fromu, concat('".$guestnamePrefix."',t.name) tou, from_unixtime(m1.sent,'%y,%m,%d')from cometchat m1, cometchat_guests f, cometchat_guests t where  f.id = m1.from and t.id = m1.to and ((m1.from = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."' and m1.to = '".mysqli_real_escape_string($GLOBALS['dbh'],$history)."' and m1.direction <> 1) or (m1.to = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."' and m1.from = '".mysqli_real_escape_string($GLOBALS['dbh'],$history)."' and m1.direction <> 2)) and m1.direction <> 3)
union (select m1.*, concat('".$guestnamePrefix."',f.name) fromu, t.".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_username)." tou, from_unixtime(m1.sent,'%y,%m,%d') from cometchat m1, cometchat_guests f, ".mysqli_real_escape_string($GLOBALS['dbh'],$usertable)." t where  f.id = m1.from and t.".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_userid)." = m1.to and ((m1.from = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."' and m1.to = '".mysqli_real_escape_string($GLOBALS['dbh'],$history)."' and m1.direction <> 1) or (m1.to = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."' and m1.from = '".mysqli_real_escape_string($GLOBALS['dbh'],$history)."' and m1.direction <> 2)) and m1.direction <> 3)
union (select m1.*, f.".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_username)." fromu, concat('".$guestnamePrefix."',t.name) tou, from_unixtime(m1.sent,'%y,%m,%d') from cometchat m1, ".mysqli_real_escape_string($GLOBALS['dbh'],$usertable)." f, cometchat_guests t where  f.".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_userid)." = m1.from and t.id = m1.to and ((m1.from = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."' and m1.to = '".mysqli_real_escape_string($GLOBALS['dbh'],$history)."') or (m1.to = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."' and m1.from = '".mysqli_real_escape_string($GLOBALS['dbh'],$history)."')) and m1.direction <> 3)
    order by id) as t group by date_format(from_unixtime(sent),'%y,%m,%d') desc)";
		}
                $sql = ("(select m1.*,  f.".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_username)." fromu, t.".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_username)." tou, from_unixtime(m1.sent,'%y,%m,%d') from `cometchat` m1, ".mysqli_real_escape_string($GLOBALS['dbh'],$usertable)." f, ".mysqli_real_escape_string($GLOBALS['dbh'],$usertable)." t where f.".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_userid)." = m1.from and t.".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_userid)." = m1.to and ((m1.from = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."' and m1.to = '".mysqli_real_escape_string($GLOBALS['dbh'],$history)."' and m1.direction <> 1) or (m1.to = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."' and m1.from = '".mysqli_real_escape_string($GLOBALS['dbh'],$history)."' and m1.direction <> 2)) and m1.direction <> 3 group by date_format(from_unixtime(sent),'%y,%m,%d') desc) ".$guestpart." ");
            }
            $query = mysqli_query($GLOBALS['dbh'],$sql);
            $previd = 1000000;
            if (mysqli_num_rows($query)>0) {
		 while ($chat = mysqli_fetch_assoc($query)) {
                     if (function_exists('processName')) {
                         $chat['fromu'] = processName($chat['fromu']);
                         if (empty($_REQUEST['chatroommode'])) {
                             $chat['tou'] = processName($chat['tou']);
                             }
                    }
                    if (empty($_REQUEST['chatroommode'])) {

                        if ($chat['from'] == $userid) {
                            $chat['fromu'] = $chathistory_language[1];
                        }
                        } else {
                            if ($chat['userid'] == $userid) {
                                $chat['fromu'] = $chathistory_language[1];
                            }
                        }
                        if((strpos($chat['message'],'CC^CONTROL_')) !== false){
                            $controlparameters = str_replace('CC^CONTROL_', '', $chat['message']);
                            if((strpos($controlparameters,'deletemessage_')) <= -1){
                                $chatmsg = $chat['message'];
    			             }
                        }else{
                            $chatmsg = $chat['message'];
                        }
			if ($chat['id'] == $previd) {
                            $previd = 1000000;
			}
            $read = 0;
            if(empty($chat['read'])){
                $read = 1;
            } else {
                $read = $chat['read'];
            }
			$response[] = array('id' => $chat['id'], 'previd' => $previd, 'from' => $chat['fromu'], 'message' => $chatmsg, 'sent' =>  $chat['sent']*1000, 'old' => $read);
                        $previd = $chat['id'];
                }
                echo json_encode($response); exit;
        } else {
            echo '0'; exit;
        }
}

function logview() {
    $usertable = TABLE_PREFIX.DB_USERTABLE;
    $usertable_username = DB_USERTABLE_NAME;
    $usertable_userid = DB_USERTABLE_USERID;
    global $history;
    global $userid;
    global $chathistory_language;
    global $guestsMode;
    global $guestnamePrefix;
    global $limit;
    global $response;
    $requester = '';
    $limit = 13;
    $preuserid = 0;

	if (!empty($_REQUEST['range'])) {
        $range = $_REQUEST['range'];
    }

    if (!empty($_REQUEST['history'])) {
        $history = $_REQUEST['history'];
    }

    $range = intval($range);

    if (!empty($_REQUEST['lastidfrom'])) {
        $lastidfrom = $_REQUEST['lastidfrom'];
    }
    $guestpart= "";
    if (!empty($_REQUEST['chatroommode'])) {
        if ($guestsMode == '1') {
            $guestpart = "union (select m1.*, m2.name chatroom, concat('".$guestnamePrefix."',f.name) fromu from cometchat_chatroommessages m1, cometchat_chatrooms m2, cometchat_guests f where  f.id = m1.userid and m1.chatroomid=m2.id and m1.chatroomid=".mysqli_real_escape_string($GLOBALS['dbh'],$history)." and m1.id >= ".mysqli_real_escape_string($GLOBALS['dbh'],$range)." and m1.message not like 'CC^CONTROL_deletemessage_%')";
        }
        $sql = ("(select m1.*, m2.name chatroom, f.".$usertable_username." fromu from cometchat_chatroommessages m1, cometchat_chatrooms m2, ".$usertable." f where  f.".$usertable_userid." = m1.userid and m1.chatroomid=m2.id and m1.chatroomid='".$history."' and m1.id >= ".mysqli_real_escape_string($GLOBALS['dbh'],$range)." and m1.message not like '%banned%' and m1.message not like '%kicked%' and m1.message not like '%deletemessage%') ".$guestpart." order by id limit ".$limit."");

    } else {
        if ($guestsMode == '1') {
            $guestpart = "union (select m1.*, concat('".mysqli_real_escape_string($GLOBALS['dbh'],$guestnamePrefix)."',f.name) fromu, concat('".mysqli_real_escape_string($GLOBALS['dbh'],$guestnamePrefix)."',t.name) tou from cometchat m1, cometchat_guests f, cometchat_guests t where f.id = m1.from and t.id = m1.to and ((m1.from = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."' and m1.to = '".mysqli_real_escape_string($GLOBALS['dbh'],$history)."' and m1.direction <> 1) or (m1.to = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."' and m1.from = '".mysqli_real_escape_string($GLOBALS['dbh'],$history)."' and m1.direction <> 2)) and m1.id >= ".mysqli_real_escape_string($GLOBALS['dbh'],$range)." and m1.direction <> 3)
union (select m1.*, concat('".mysqli_real_escape_string($GLOBALS['dbh'],$guestnamePrefix)."',f.name) fromu, t.".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_username)." tou from cometchat m1, cometchat_guests f, ".mysqli_real_escape_string($GLOBALS['dbh'],$usertable)." t where f.id = m1.from and t.".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_userid)." = m1.to and ((m1.from = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."' and m1.to = '".mysqli_real_escape_string($GLOBALS['dbh'],$history)."' and m1.direction <> 1) or (m1.to = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."' and m1.from = '".mysqli_real_escape_string($GLOBALS['dbh'],$history)."' and m1.direction <> 2)) and m1.id >= ".mysqli_real_escape_string($GLOBALS['dbh'],$range)." and m1.direction <> 3)
union (select m1.*, f.".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_username)." fromu, concat('".mysqli_real_escape_string($GLOBALS['dbh'],$guestnamePrefix)."',t.name) tou from cometchat m1, ".mysqli_real_escape_string($GLOBALS['dbh'],$usertable)." f, cometchat_guests t where f.".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_userid)." = m1.from and t.id = m1.to and ((m1.from = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."' and m1.to = '".mysqli_real_escape_string($GLOBALS['dbh'],$history)."'and m1.direction <> 1) or (m1.to = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."' and m1.from = '".mysqli_real_escape_string($GLOBALS['dbh'],$history)."' and m1.direction <> 2)) and m1.id >= ".mysqli_real_escape_string($GLOBALS['dbh'],$range)." and m1.direction <> 3)";
        }
        $sql = ("(select m1.*, f.".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_username)." fromu, t.".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_username)." tou from cometchat m1, ".mysqli_real_escape_string($GLOBALS['dbh'],$usertable)." f, ".mysqli_real_escape_string($GLOBALS['dbh'],$usertable)." t  where  f.".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_userid)." = m1.from and t.".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_userid)." = m1.to and ((m1.from = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."' and m1.to = '".mysqli_real_escape_string($GLOBALS['dbh'],$history)."' and m1.direction <> 1) or (m1.to = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."' and m1.from = '".mysqli_real_escape_string($GLOBALS['dbh'],$history)."' and m1.direction <> 2)) and m1.id >= ".mysqli_real_escape_string($GLOBALS['dbh'],$range)." and m1.direction <> 3) ".$guestpart." order by id limit ".mysqli_real_escape_string($GLOBALS['dbh'],$limit)."");
    }
    $query = mysqli_query($GLOBALS['dbh'],$sql);
    $previd = '';
    $lines = 0;
    $s = 0;
	if (mysqli_num_rows($query)>0) {
		while ($chat = mysqli_fetch_assoc($query)) {
			if (function_exists('processName')) {
				$chat['fromu'] = processName($chat['fromu']);
				if (empty($_REQUEST['chatroommode'])) {
					$chat['tou'] = processName($chat['tou']);
				}
			}
			if ($s == 0) {
                            $s = $chat['sent'];
			}
            if($chat['from'] == $history) {
                $requester = $chat['fromu'];
            } else {
                $requester = $chat['tou'];
            }
                        if (!empty($_REQUEST['chatroommode'])) {
                            $chathistory_language[2]=$chathistory_language[7];
                            $requester=$chat['chatroom'];
                            if ($chat['userid']==$userid) {
                                $chat['fromu'] = $chathistory_language[1];
                            }
                            if($chat['userid'] == $preuserid) {
                                $chat['fromu']= '';
                            }
                            $preuserid = $chat['userid'];
			} else {
                            if ($chat['from'] == $userid) {
                                    $chat['fromu'] = $chathistory_language[1];
                            }
			}
            if((strpos($chat['message'],'CC^CONTROL_')) !== false){
                $controlparameters = str_replace('CC^CONTROL_', '', $chat['message']);
                if((strpos($controlparameters,'deletemessage_')) <= -1){
                    $chatmes = $chat['message'];
                 }
            }elseif((strpos($chat['message'],'avchat_webaction=initiate')) !== false || (strpos($chat['message'],'avchat_webaction=acceptcall')) !== false){
                    $chatmes = $chathistory_language['video_call'];
            }else{
                $chatmes = $chat['message'];
            }
                        if (!empty($_REQUEST['chatroommode'])) {
                            if (!empty($_REQUEST['lastidfrom']) && $lastidfrom == $chat['userid']) {
                                $chat['fromu'] = '';
                            }
			} else	{
                            if (!empty($_REQUEST['lastidfrom']) && $lastidfrom == $chat['from']) {
                                $chat['fromu'] = '';
                            }
			}
			$lines++;
                        $previd = 1000000;
			if (!empty($chat['userid'])) {
                            $lastidfrom = $chat['userid'];
			} else if(!empty($chat['from'])) {
                            $lastidfrom = $chat['from'];
			}
            $read = 0;
            if(empty($chat['read'])){
                $read = 1;
            } else {
                $read = $chat['read'];
            }
		$response['_'.$chat['id']] = array('id' => $chat['id'], 'previd' => $previd, 'from' => $chat['fromu'], 'requester' => $requester, 'message' => $chatmes, 'sent' =>  $chat['sent']*1000, 'userid' => $lastidfrom, 'old' => $read);
	}
        echo json_encode($response);
        exit;
        } else {
            echo '0'; exit;

        }
}
$allowedActions = array('logs','logview');

if (!empty($_GET['action']) && in_array($_GET['action'],$allowedActions)) {
    call_user_func($_GET['action']);
}
?>
