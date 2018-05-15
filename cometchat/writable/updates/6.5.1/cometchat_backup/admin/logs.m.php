<?php

/*
CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license
*/
if (!defined('CCADMIN')) { echo "NO DICE"; exit; }
if(!empty($guestnamePrefix)){ $guestnamePrefix .= '-'; }
function index() {
	global $body, $ts;
$chatroomLog = chatroomLog();
$body .= <<<EOD
  	<div class="row">
	  	<div class="col-sm-6 col-lg-6">
		    <div class="card">
		      	<div class="card-header">
		        	One on one chat
		        	<h4><small>You can search by username or user ID. Please fill in atleast one field below.</small></h4>
		      	</div>
		      	<div class="card-block">
		      	<form action="?module=logs&action=searchlogs&ts={$ts}" onsubmit="return loadLogs();" method="post" enctype="multipart/form-data">

				<div class="form-group row">
					<div class="col-md-12">
					<label class="form-control-label">User ID:</label>
					<input class="form-control" name="userid" id="userid" placeholder="Enter the User ID" autocomplete="off" type="text">
					</div>
				</div>

				<div class="form-group row">
					<div class="col-md-12">
					<label class="form-control-label">Username:</label>
					<input class="form-control" name="susername" id="susername" placeholder="Enter the Username"" autocomplete="off" type="text">
					</div>
				</div>

				<div class="row col-md-12" style="padding-bottom:5px;"><br>
			      <input type="submit" value="Search"  class="btn btn-primary">
			    </div>

			   </form>
	            </div>
	    	</div>
	  	</div>
		$chatroomLog
	</div>
<script type="text/javascript">
function loadLogs() {
	$("#adminModellink").trigger('click');
	$("#admin-modal-title").text('Search Result');
	$("#admin-modal-body").css('height','550px');
	$("#admin-modal-body").html("<center><img src='images/simpleloading.gif'></center>");
	var userid = $("#userid").val();
	var name = $("#susername").val();
	var link = '?module=logs&action=searchlogs&userid='+userid+'&susername='+name+'&ts={$ts}';
	$("#admin-modal-body").html("<iframe frameborder='0' height='510px' width='100%' src='"+link+"'></iframe>");
	$("#susername").val('');
	$("#userid").val('');
	return false;
}

</script>
EOD;
	template();

}

function searchlogs() {
    global $ts, $usertable_userid, $usertable_username, $usertable, $navigation, $body, $guestsMode, $guestnamePrefix;
	$userid   = $_REQUEST['userid'];
	$username = $_REQUEST['susername'];
	if (empty($username)) {
		$username = 'Q293YXJkaWNlIGFza3MgdGhlIHF1ZXN0aW9uIC0gaXMgaXQgc2FmZT8NCkV4cGVkaWVuY3kgYXNrcyB0aGUgcXVlc3Rpb24gLSBpcyBpdCBwb2xpdGljPw0KVmFuaXR5IGFza3MgdGhlIHF1ZXN0aW9uIC0gaXMgaXQgcG9wdWxhcj8NCkJ1dCBjb25zY2llbmNlIGFza3MgdGhlIHF1ZXN0aW9uIC0gaXMgaXQgcmlnaHQ/DQpBbmQgdGhlcmUgY29tZXMgYSB0aW1lIHdoZW4gb25';
	}
	$guestpart = "";
	if($guestsMode) {
		$guestpart = "union (select cometchat_guests.id, concat('".mysqli_real_escape_string($GLOBALS['dbh'],$guestnamePrefix)."',cometchat_guests.name) username from cometchat_guests where cometchat_guests.name LIKE '%".mysqli_real_escape_string($GLOBALS['dbh'],sanitize_core($username))."%' or cometchat_guests.id = '".mysqli_real_escape_string($GLOBALS['dbh'],sanitize_core($userid))."')";
	}

	$sql = ("(select ".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_userid)." id, ".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_username)." username from ".mysqli_real_escape_string($GLOBALS['dbh'],$usertable)." where ".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_username)." LIKE '%".mysqli_real_escape_string($GLOBALS['dbh'],sanitize_core($username))."%' or ".$usertable_userid." = '".mysqli_real_escape_string($GLOBALS['dbh'],sanitize_core($userid))."') ".$guestpart." ");
	$query = mysqli_query($GLOBALS['dbh'],$sql);
	$userslist = '';
	while ($user = mysqli_fetch_assoc($query)) {
		if (function_exists('processName')) {
			$user['username'] = processName($user['username']);
		}
		$userslist .= '<tr style="cursor:pointer;" onclick="javascript:logs_gotouser(\''.$user['id'].'\',\''.$user['username'].'\');"><td>'.$user['username'].'</td><td>'.$user['id'].'</td></tr>';
	}

	if(!$userslist){
		$userslist .= '<tr><td colspan="2">No results found</td></tr>';
	}
$base_url = BASE_URL;
echo <<<EOD
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" href="images/favicon.ico">
  <title>Setting</title>
  <link href="{$base_url}/css.php?admin=1" rel="stylesheet">
  <script src="{$base_url}/js.php?admin=1"></script>
</head>
 <body class="navbar-fixed sidebar-nav fixed-nav" style="background-color: white;overflow-y:hidden;">
 <div class="col-sm-12 col-lg-12">
    <div class="card">
    <div class="card-block">
	    <table class="table">
	      <thead>
	        <tr>
	          <th>Name</th>
	          <th width="20%">ID</th>
	        </tr>
	      </thead>
	      <tbody>
	      {$userslist}
	      </tbody>
	    </table>
    </div>
    </div>
  </div>
EOD;
}

function viewuser() {
	global $ts, $body, $usertable_userid, $usertable_username, $usertable, $guestsMode, $guestnamePrefix;
	$userid = mysqli_real_escape_string($GLOBALS['dbh'],$_GET['data']);
	$guestpart = "";
	if($userid < '10000000') {
		$sql = ("select ".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_username)." username from ".mysqli_real_escape_string($GLOBALS['dbh'],$usertable)." where ".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_userid)." = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."'");
	} else {
		$sql = ("select concat('".mysqli_real_escape_string($GLOBALS['dbh'],$guestnamePrefix)."',name) username from cometchat_guests where cometchat_guests.id = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."'");
	}
	$query = mysqli_query($GLOBALS['dbh'],$sql);
	$usern = mysqli_fetch_assoc($query);

	if($guestsMode) {
		$guestpart = " union (select distinct(f.id) id, concat('".mysqli_real_escape_string($GLOBALS['dbh'],$guestnamePrefix)."',f.name) username  from cometchat m1, cometchat_guests f where (f.id = m1.from and m1.to = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."') or (f.id = m1.to and m1.from = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."'))";
	}

	$sql = ("(select distinct(f.".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_userid).") id, f.".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_username)." username  from cometchat m1, ".mysqli_real_escape_string($GLOBALS['dbh'],$usertable)." f where (f.".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_userid)." = m1.from and m1.to = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."') or (f.".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_userid)." = m1.to and m1.from = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."')) ".$guestpart." order by username asc");
	$query = mysqli_query($GLOBALS['dbh'],$sql);
	$userslist = '';
	$no_users = '';

	if (function_exists('processName')) {
		$usern['username'] = processName($usern['username']);
	}
	while ($user = mysqli_fetch_assoc($query)) {
		if (function_exists('processName')) {
			$user['username'] = processName($user['username']);
		}
			$userslist .= '<tr style="cursor:pointer;" onclick="javascript:logs_gotouserb(\''.$userid.'\',\''.$user['id'].'\',\''.$user['username'].'\');"><td>'.$user['username'].'</td><td>'.$user['id'].'</td></tr>';
	}

	if(!$userslist){
		$userslist .= '<tr><td colspan="2">No results found</td></tr>';
	}

$base_url = BASE_URL;
echo <<<EOD
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" href="images/favicon.ico">
  <title>Setting</title>
  <link href="{$base_url}/css.php?admin=1" rel="stylesheet">
  <script src="{$base_url}/js.php?admin=1"></script>
</head>
 <body class="navbar-fixed sidebar-nav fixed-nav" style="background-color: white;overflow-y:hidden;">
 <div class="col-sm-12 col-lg-12">
    <div class="card">
    <div class="card-block">
    <h4><small>Select a user between whom you want to view the conversation.</small></h4>
    <table class="table">
      <thead>
        <tr>
          <th>Name</th>
          <th width="20%">ID</th>
        </tr>
      </thead>
      <tbody>
      {$userslist}
      </tbody>
    </table>
    </div>
    </div>
  </div>
EOD;
}

function viewuserconversation() {
	global $ts, $body, $navigation, $usertable_userid, $usertable_username, $usertable, $guestnamePrefix;

	$userid = mysqli_real_escape_string($GLOBALS['dbh'],$_GET['data']);
	$userid2 = mysqli_real_escape_string($GLOBALS['dbh'],$_GET['data2']);

	if($userid < '10000000') {
		$sql = ("select ".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_username)." username from ".mysqli_real_escape_string($GLOBALS['dbh'],$usertable)." where ".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_userid)." = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."'");
	} else {
		$sql = ("select concat('".mysqli_real_escape_string($GLOBALS['dbh'],$guestnamePrefix)."',name) username from cometchat_guests where cometchat_guests.id = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."'");
	}
	$query = mysqli_query($GLOBALS['dbh'],$sql);
	$usern = mysqli_fetch_assoc($query);

	if($userid2 < '10000000') {
		$sql = ("select ".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_username)." username from ".mysqli_real_escape_string($GLOBALS['dbh'],$usertable)." where ".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_userid)." = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid2)."'");
	} else {
		$sql = ("select concat('".mysqli_real_escape_string($GLOBALS['dbh'],$guestnamePrefix)."',name) username from cometchat_guests where cometchat_guests.id = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid2)."'");
	}
	$query = mysqli_query($GLOBALS['dbh'],$sql);
	$usern2 = mysqli_fetch_assoc($query);

	$sql = ("(select m.*  from cometchat m where  (m.from = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."' and m.to = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid2)."') or (m.to = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."' and m.from = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid2)."'))
	order by id desc");

	$query = mysqli_query($GLOBALS['dbh'],$sql);

	if (function_exists('processName')) {
			$usern['username'] = processName($usern['username']);
			$usern2['username'] = processName($usern2['username']);
	}

	$userslist = '';

	while ($chat = mysqli_fetch_assoc($query)) {
		$time = $chat['sent'];

		if ($userid == $chat['from']) {
			$uname = $usern['username'];
		} else {
			$uname = $usern2['username'];
		}

		if(strpos($chat['message'], 'CC^CONTROL_') === false)
		$userslist .= '<tr><td width="20%">'.$uname.'</td><td>'.$chat['message'].'</td><td><span class="chat_time" timestamp="'.$time.'"></span></td></tr>';
	}


$base_url = BASE_URL;
echo <<<EOD
	<!DOCTYPE html>
	<html lang="en">
	<head>
	  <meta charset="utf-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	  <link rel="shortcut icon" href="images/favicon.ico">
	  <title>Setting</title>
	  <link href="{$base_url}/css.php?admin=1" rel="stylesheet">
	  <script src="{$base_url}/js.php?admin=1"></script>
	</head>
	 <body class="navbar-fixed sidebar-nav fixed-nav" style="background-color: white;overflow-y:hidden;">
	 <div class="col-sm-12 col-lg-12">
	    <div class="card">
	    <div class="card-block">
	    <table class="table">
	      <thead>
	        <tr>
	          <th width="30%">User</th>
	          <th width="50%">Message</th>
	          <th width="10%">Time</th>
	        </tr>
	      </thead>
	      <tbody>
	      {$userslist}
	      </tbody>
	    </table>
	    </div>
	    </div>
	  </div>
<script>
	\$(function() {
		\$('.chat_time').each(function(key,value){
			var ts = new Date(\$(this).attr('timestamp') * 1000);
			var timest = getTimeDisplay(ts);
			\$(this).html(timest);
		});
		$("#admin-modal-title").text('Log between {$usern['username']} and {$usern2['username']}');
		$('#admin-modal-title', window.parent.document).text('Log between {$usern['username']} and {$usern2['username']}');
	});
</script>
EOD;
}

function chatroomLog() {
	global $grouplogs,$ts;

	$sql = ("select * from cometchat_chatrooms order by lastactivity desc");
	$query = mysqli_query($GLOBALS['dbh'],$sql);
	$chatroomlog = '';

	while ($chatroom = mysqli_fetch_assoc($query)) {
		$chatroomlog .= '<tr style="cursor:pointer;" onclick="javascript:logs_gotochatroom(\''.$chatroom['id'].'\');"><td>'.$chatroom['name'].'</td><td>'.$chatroom['id'].'</td></tr>';
	}

    if(empty($chatroomlog)){
        $chatroomlog = '<tr id="no_module"><td>No Groups available.</td></tr>';
    }

$grouplogs = <<<EOD
<div class="col-sm-6 col-lg-6">
	<div class="card">
	  	<div class="card-header">
	    	Groups<h4><small>View chatrooms logs for active rooms</small></h4>
	  	</div>
	  	<div class="card-block">
		    <table class="table">
		      <thead>
		        <tr>
		          <th>Name</th>
		          <th width="20%">ID</th>
		        </tr>
		      </thead>
		      <tbody>
		      {$chatroomlog}
		      </tbody>
		    </table>
	    </div>
	</div>
</div>
<script>
	function logs_gotochatroom(id) {
		var link = '?module=logs&action=viewuserchatroomconversation&data='+id+'&ts='+ts;
		$("#adminModellink").trigger('click');
		$("#admin-modal-body").css('height','550px');
		$("#admin-modal-title").text('Group log');
		$('.tooltip').remove();
		$("#admin-modal-body").html("<center><img src='images/simpleloading.gif'></center>");
		$.post(link, function(data) {
				$("#admin-modal-body").html(data);
		});
	}
</script>
EOD;
return $grouplogs;
}


function viewuserchatroomconversation() {
	global $ts, $body, $navigation, $usertable_userid, $usertable_username, $usertable, $guestsMode, $guestnamePrefix;

	if(!empty($guestnamePrefix)){ $guestnamePrefix .= '-'; }

	if($guestsMode) {
		$usertable = "(select ".$usertable_userid.", ".$usertable_username."  from ".$usertable." union select id ".$usertable_userid.",concat('".mysqli_real_escape_string($GLOBALS['dbh'],$guestnamePrefix)."',name) ".$usertable_username." from cometchat_guests)";
	}
	$chatroomid = mysqli_real_escape_string($GLOBALS['dbh'],$_GET['data']);

	$sql = ("select name chatroomname from cometchat_chatrooms where id = '".mysqli_real_escape_string($GLOBALS['dbh'],$chatroomid)."'");
	$query = mysqli_query($GLOBALS['dbh'],$sql);
	$chatroomn = mysqli_fetch_assoc($query);

	$sql = ("select cometchat_chatroommessages.*, f.".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_username)." username  from cometchat_chatroommessages join ".$usertable." f on cometchat_chatroommessages.userid = f.".mysqli_real_escape_string($GLOBALS['dbh'],$usertable_userid)." where chatroomid = '".mysqli_real_escape_string($GLOBALS['dbh'],$chatroomid)."' order by id desc LIMIT 200");
	$query = mysqli_query($GLOBALS['dbh'],$sql);
	$chatroomlog = '';

	while ($chat = mysqli_fetch_assoc($query)) {
		if (function_exists('processName')) {
			$chatroomn['chatroomname'] = processName($chatroomn['chatroomname']);
		}
		$time = $chat['sent'];
		if(strpos($chat['message'], 'CC^CONTROL_') === false)
		$chatroomlog .= '<tr><td width="20%">'.$chat["username"].'</td><td>'.$chat['message'].'</td><td width="20%"><span class="chat_time" timestamp="'.$time.'"></span></td></tr>';
	}


echo <<<EOD
	<div style="height:500px;overflow:auto;overflow-x:hidden;">
    <table class="table">
      <thead>
        <tr>
          <th width="30%">User</th>
          <th width="50%">Message</th>
          <th width="10%">Time</th>
        </tr>
      </thead>
      <tbody>
      {$chatroomlog}
      </tbody>
    </table>
  	</div>
<script>
	\$(function() {
		\$('.chat_time').each(function(key,value){
			var ts = new Date(\$(this).attr('timestamp') * 1000);
			var timest = getTimeDisplay(ts);
			\$(this).html(timest);
		});
	});
</script>
EOD;

}
