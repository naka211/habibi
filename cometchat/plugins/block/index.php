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

if ($p_<1) exit;
$theme = '';
if(!empty($_REQUEST['cc_theme'])){
	$theme = $_REQUEST['cc_theme'];
}
if (!empty($_REQUEST['action']) && $_REQUEST['action'] == 'block') {
	$blockedIds=getBlockedUserIDs();
	$id = mysqli_real_escape_string($GLOBALS['dbh'],$_REQUEST['to']);
	if(!in_array($id, $blockedIds)){

		$sql = "insert into cometchat_block (fromid, toid) values ('".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."','".mysqli_real_escape_string($GLOBALS['dbh'],$id)."')";
		$query = mysqli_query($GLOBALS['dbh'],$sql);

		removeCache('blocked_id_of_'.$userid);
		removeCache('blocked_id_of_'.$id);
		removeCache('blocked_id_of_receive_'.$userid);
		removeCache('blocked_id_of_receive_'.$id);

		$response = array();
		$response['id'] = $id;
		$error = mysqli_error($GLOBALS['dbh']);
		if (!empty($error)) {
			$response['result'] = "0";
			header('content-type: application/json; charset=utf-8');
			$response['error'] = mysqli_error($GLOBALS['dbh']);
			echo $_REQUEST['callback'].'('.json_encode($response).')';
			exit;
		}

		$response['result'] = "1";

		if (!empty($_REQUEST['callback']) || !empty($_REQUEST['callbackfn'])) {
			header('content-type: application/json; charset=utf-8');
			if(empty($_REQUEST['callbackfn']) || $_REQUEST['callbackfn']<>'mobileapp'){
				echo $_REQUEST['callback'].'('.json_encode($response).')';
			} else {
				echo json_encode($response);
			}
		}
	}else{
		$response['result'] = "2";
		if (!empty($_REQUEST['callback']) || !empty($_REQUEST['callbackfn'])) {
			header('content-type: application/json; charset=utf-8');
			if(empty($_REQUEST['callbackfn']) || $_REQUEST['callbackfn']<>'mobileapp'){
				echo $_REQUEST['callback'].'('.json_encode($response).')';
			} else {
				echo json_encode($response);
			}
		}
	}

} else if (!empty($_REQUEST['action']) && $_REQUEST['action'] == 'unblock') {
	if(empty($_REQUEST['id'])){
		$id = intval($_REQUEST['to']);
	} else {
		$id = intval($_REQUEST['id']);
	}
	$embed = '';
	$embedcss = '';

	if (!empty($_REQUEST['embed']) && $_REQUEST['embed'] == 'web') {
		$embed = 'web';
		$embedcss = 'embed';
	}

	if (!empty($_REQUEST['embed']) && $_REQUEST['embed'] == 'desktop') {
		$embed = 'desktop';
		$embedcss = 'embed';
	}

	$sql = "delete from cometchat_block where toid = '".mysqli_real_escape_string($GLOBALS['dbh'],$id)."' and fromid = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."'";
	$query = mysqli_query($GLOBALS['dbh'],$sql);
	$affectedRows = mysqli_affected_rows($GLOBALS['dbh']);
	removeCache('blocked_id_of_'.$userid);
	removeCache('blocked_id_of_'.$id);
	removeCache('blocked_id_of_receive_'.$userid);
	removeCache('blocked_id_of_receive_'.$id);
	$response = array();
	$response['id'] = $id;
	$error = mysqli_error($GLOBALS['dbh']);

	if(empty($_REQUEST['callbackfn']) || $_REQUEST['callbackfn']<>'mobileapp'){
		if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysqli_error($GLOBALS['dbh']); }
		$ts = time();
		header("Location: index.php?basedata={$_REQUEST['basedata']}&cc_theme={$theme}&embed={$embed}&ts={$ts}\r\n");
		exit;
	} else {
		header('content-type: application/json; charset=utf-8');
		if (!empty($error)) {
			$response['result'] = "0";
			$response['error'] = mysqli_error($GLOBALS['dbh']);
		}else if($affectedRows == 0){
			$response['result'] = "0";
			$response['error'] = 'NOT_A_BLOCKED_USER';
		} else {
			$response['result'] = "1";
		}
		echo json_encode($response);
		exit;
	}
} else {

	$embed = '';
	$embedcss = '';

	if (!empty($_REQUEST['embed']) && $_REQUEST['embed'] == 'web') {
		$embed = 'web';
		$embedcss = 'embed';
	}

	if (!empty($_REQUEST['embed']) && $_REQUEST['embed'] == 'desktop') {
		$embed = 'desktop';
		$embedcss = 'embed';
	}

	$usertable = TABLE_PREFIX.DB_USERTABLE;
	$usertable_username = DB_USERTABLE_NAME;
	$usertable_userid = DB_USERTABLE_USERID;
	$avatartable = DB_AVATARTABLE;
	$avatarfield = DB_AVATARFIELD;
	$body = '';
	$number = 0;
	$guestpart = '';
	if($guestsMode == 1){
		$guestpart = " UNION (select distinct(m.id) `id`, concat('".$guestnamePrefix."',m.name) `name`, '' avatar from cometchat_block, cometchat_guests m where m.id = toid and fromid = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."')";
	}

	$sql = ("(select distinct(".$usertable.".".$usertable_userid.") `id`, ".$usertable.".".$usertable_username." `name`, ".$avatarfield." avatar from cometchat_block, ".$usertable." ".$avatartable." where ".$usertable.".".$usertable_userid." = toid and fromid = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."') ".$guestpart."");

	$query = mysqli_query($GLOBALS['dbh'],$sql);


	if(empty($_REQUEST['callbackfn']) || $_REQUEST['callbackfn']<>'mobileapp'){
			while ($chat = mysqli_fetch_assoc($query)) {
				$imageurl = $integration->getAvatar($chat['id']);
				if (function_exists('processName')) {
					$chat['name'] = processName($chat['name']);
				}

				++$number;

				$body = <<<EOD
				$body
				<div class="chat"  id="cometchat_blocked_{$chat['id']}">
					<div class="chatrequest"><span class="cometchat_userscontentavatar"><img class="cometchat_userscontentavatarimage" src="{$imageurl}"></span></div>
					<div class="chatmessage"><div class="cometchat_userdisplayname">{$chat['name']}</div></div>
					<div id="cometchat_unblocked_{$chat['id']}" class="cometchat_unblock_user"><a href="javascript:void(0);">Unblock</a></div>
					<div style="clear:both"></div>
				</div>

EOD;
			}

	if ($number == 0) {
		$body = <<<EOD
 $body
<div class="chat noborderclass">
			<div class="chatrequest"></div>
			<div class="chatmessage"><div class="cc_nouser">{$block_language[6]}</div></div>
			<div class="chattime"></div>
			<div style="clear:both"></div>
</div>

EOD;
	}



echo <<<EOD
	<!DOCTYPE html>
	<html>
	<head>
	<meta name="viewport" content="user-scalable=0,width=device-width, minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>{$block_language[3]}</title>
	<link type="text/css" rel="stylesheet" media="all" href="../../css.php?type=plugin&name=block&cc_theme={$theme}" />
	<script src="../../js.php?type=core&name=jquery" type="text/javascript"></script>
	<script src="../../js.php?type=core&name=scroll" type="text/javascript"></script>
	<script>
		jqcc(document).ready(function() {
			jqcc('.chat').click(function(){
				id = this.id;
				id = id.split("_");
				var hidden = jqcc('#cometchat_unblocked_'+id[2]);
				if (hidden.hasClass('visible')){
					hidden.animate({"left":"100%"}, "fast").removeClass('visible');
				} else {
					var width = jqcc(document).width()-100;
					hidden.animate({"left":width}, "fast").addClass('visible');
				}
			});
			jqcc('.cometchat_unblock_user').click(function(){
                id = this.id;
                id = id.split("_");
            	var unblockurl = "?action=unblock&id="+id[2]+"&cc_theme={$theme}&basedata={$_REQUEST['basedata']}&embed={$embed}";
                jqcc('#cometchat_blocked_'+id[2]).animate(
                    {
                        'margin-left':'-1000px'
                    },
                    function(){
                        jqcc('#cometchat_blocked_'+id[2]).slideUp('fast');
                        jqcc('#cometchat_blocked_'+id[2]).hide('fast');
                        jqcc('#cometchat_blocked_'+id[2]).remove();
                        jqcc.ajax({
                        	url:unblockurl,
                        	success:function(){
                        		if(jqcc('.cometchat_unblock_user').length==0){
                        			jqcc('.blocked_users_container').html('<div class="chat noborderclass"><div class="chatrequest"></div><div class="chatmessage"><div class="cc_nouser">{$block_language[6]}</div></div><div class="chattime"></div><div style="clear:both"></div></div>');
                        		}
                        	}
                        });
                    }
                );
            });
			if('{$theme}' == 'embedded'){
				var calculatedheight = parent.document.body.clientHeight - 40;
				jqcc('.container_body').slimScroll({height: calculatedheight});
			}else{
				var mobileDevice = navigator.userAgent.match(/ipad|ipod|iphone|android|windows ce|Windows Phone|blackberry|palm|symbian/i);
				if(mobileDevice){
					jqcc('.container_body').css({'overflow-y': 'scroll'});
				}else{
		   			jqcc('.container_body').slimScroll({scroll: '1'});
		   			jqcc('.container_body').slimScroll({height: jqcc(".container_body").css('height')});
		   		}
			}
		});
		function buddyListRefresh(){
			var controlparameters = {"type":"core", "name":"cometchat", "method":"chatHeartbeat", "params":{}};
			controlparameters = JSON.stringify(controlparameters);
			if(window.top != window.self){
				parent.postMessage('CC^CONTROL_'+controlparameters,'*');
			} else {
				window.opener.postMessage('CC^CONTROL_'+controlparameters,'*');
			}
		}
	</script>
	</head>
	<body onload="buddyListRefresh()">
	<div class="cometchat_wrapper">

	<div class="container_body {$embedcss} blocked_users_container">

	$body

	</div>
	</div>
	</div>
	</body>
	</html>
EOD;
	} else {
	$response = array();
	while ($chat = mysqli_fetch_assoc($query)) {
		if (function_exists('processName')) {
			$blockedName = processName($chat['name']);
		} else {
			$blockedName = $chat['name'];
		}
		$blockedID = $chat['id'];
		$response[$blockedID] = array('id'=>$blockedID,'name'=>$blockedName);
	}
	if(empty($response)){
		$response = json_decode('{}');
	}
	echo json_encode($response);
	}
}
