<?php

if (!defined('CCADMIN')) { echo "NO DICE"; exit; }

if (empty($_GET['process'])) {
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php');
$base_url = BASE_URL;
if ($allowUsers == 1) {
	$allowUsersYes = 'checked="checked"';
	$allowUsersNo = '';
} else {
	$allowUsersNo = 'checked="checked"';
	$allowUsersYes = '';
}

if ($allowGuests == 1) {
	$allowGuestsYes = 'checked="checked"';
	$allowGuestsNo = '';
} else {
	$allowGuestsNo = 'checked="checked"';
	$allowGuestsYes = '';
}

if ($allowDelete == 1) {
	$allowDeleteYes = 'checked="checked"';
	$allowDeleteNo = '';
} else {
	$allowDeleteNo = 'checked="checked"';
	$allowDeleteYes = '';
}

if ($showChatroomUsers == 1) {
	$showChatroomUsersYes = 'checked="checked"';
	$showChatroomUsersNo = '';
} else {
	$showChatroomUsersNo = 'checked="checked"';
	$showChatroomUsersYes = '';
}

if ($messageBeep == 1) {
	$messageBeepYes = 'checked="checked"';
	$messageBeepNo = '';
} else {
	$messageBeepNo = 'checked="checked"';
	$messageBeepYes = '';
}

if ($allowAvatar == 1) {
	$allowAvatarYes = 'checked="checked"';
	$allowAvatarNo = '';
} else {
	$allowAvatarNo = 'checked="checked"';
	$allowAvatarYes = '';
}

if ($crguestsMode == 1) {
	$crguestsModeYes = 'checked="checked"';
	$crguestsModeNo = '';
} else {
	$crguestsModeNo = 'checked="checked"';
	$crguestsModeYes = '';
}

if ($newMessageIndicator == 1) {
	$newMessageYes = 'checked="checked"';
	$newMessageNo = '';
} else {
	$newMessageNo = 'checked="checked"';
	$newMessageYes = '';
}

if ($showUsername == 1) {
	$showUsernameYes = 'checked="checked"';
	$showUsernameNo = '';
} else {
	$showUsernameNo = 'checked="checked"';
	$showUsernameYes = '';
}

$pcb = '';
if(defined('DISPLAY_ALL_USERS') && DISPLAY_ALL_USERS == '0') {
	if($showchatbutton == 1) {
		$showchatbuttonYes = 'checked="checked"';
		$showchatbuttonNo = '';
	}else {
		$showchatbuttonNo = 'checked="checked"';
		$showchatbuttonYes = '';
	}
	$pcb = <<<EOD
 	<div class="form-group row">
	    <div class="col-md-6">
	      <label for="ccyear">Show private chat for friends only</label>
	    </div>
	    <div class="col-md-6">
	      <label class="">
	          <div style="position:relative;"><input style="position: absolute;" type="radio" name="showchatbutton" value="1" $showchatbuttonYes ></div><span style="padding-left:25px;">Yes</span>
	        </label>
	        <label class="">
	          <div style="position:relative;"><input style="position: absolute;" type="radio" name="showchatbutton" value="0" $showchatbuttonYes ></div><span style="padding-left:25px;">No</span>
	        </label>
	    </div>
  	</div>
EOD;
}

echo <<<EOD
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" href="images/favicon.ico">
  <title>Generate Embed Code</title>
  <link href="{$base_url}/css.php?admin=1" rel="stylesheet">
  <script src="{$base_url}/js.php?admin=1"></script>
</head>
 <body class="navbar-fixed sidebar-nav fixed-nav" style="background-color: white;overflow-y:hidden;">
             <div class="col-sm-6 col-lg-6">
                <div class="card">
                <div class="card-block">
                 <form style="height:100%" action="?module=dashboard&action=loadexternal&type=module&name=chatrooms&process=true" method="post">

                   <div class="form-group row">
		            <div class="col-md-6">
		              <div class="note note-success">
			            If you are unsure about any value, please skip them.
			        </div>
		            </div>
		          </div>

		          <div class="form-group row">
		            <div class="col-md-6">
		              <label for="">The number of seconds after which a user created group will be removed if no activity:</label>
	             		<input class="form-control" type="text" name="chatroomTimeout" value="$chatroomTimeout">
		            </div>
		          </div>

		          <div class="form-group row">
		            <div class="col-md-6">
		             <label for="ccyear">Number of messages that are fetched when load earlier messages is clicked:</label>
	             		<input class="form-control" type="text" name="lastMessages" value="$lastMessages">
		            </div>
		          </div>

		          <div class="form-group row">
		            <div class="col-md-6">
		              <label for="ccyear">If yes, users can create groups:</label>
		            </div>
		             <div class="col-md-6">
		              <label class="">
			              <div style="position:relative;"><input style="position: absolute;" type="radio" name="allowUsers" value="1" $allowUsersYes ></div><span style="padding-left:25px;">Yes</span>
			            </label>
			            <label class="">
			              <div style="position:relative;"><input style="position: absolute;" type="radio" name="allowUsers" $allowUsersNo value="0"></div><span style="padding-left:25px;">No</span>
			            </label>
		            </div>
		          </div>

		         <div class="form-group row">
		            <div class="col-md-6">
		              <label for="ccyear">If yes, guests can create groups:</label>
		            </div>
		             <div class="col-md-6">
		              <label class="">
			              <div style="position:relative;"><input style="position: absolute;" type="radio" name="allowGuests" value="1" $allowGuestsYes ></div><span style="padding-left:25px;">Yes</span>
			            </label>
			            <label class="">
			              <div style="position:relative;"><input style="position: absolute;" type="radio" name="allowGuests" $allowGuestsNo value="0"></div><span style="padding-left:25px;">No</span>
			            </label>
		            </div>
		          </div>

				<div class="form-group row">
		            <div class="col-md-6">
		              <label for="ccyear">If yes, users can delete his own message in groups:</label>
		            </div>
		            <div class="col-md-6">
		              	<label class="">
			              <div style="position:relative;"><input style="position: absolute;" type="radio" name="allowDelete" value="1" $allowDeleteYes ></div><span style="padding-left:25px;">Yes</span>
			            </label>
			            <label class="">
			              <div style="position:relative;"><input style="position: absolute;" type="radio" name="allowDelete" $allowDeleteNo value="0"></div><span style="padding-left:25px;">No</span>
			            </label>
		            </div>
		         </div>

				<div class="form-group row">
		            <div class="col-md-6">
		              <label for="ccyear">If yes, user avatars will be displayed in groups:</label>
		            </div>
		            <div class="col-md-6">
		              	<label class="">
			              <div style="position:relative;"><input style="position: absolute;" type="radio" name="allowAvatar" $allowAvatarYes value="1" ></div><span style="padding-left:25px;">Yes</span>
			            </label>
			            <label class="">
			              <div style="position:relative;"><input style="position: absolute;" type="radio" name="allowAvatar" $allowAvatarNo value="0"></div><span style="padding-left:25px;">No</span>
			            </label>
		            </div>
		         </div>
				<div class="form-group row">
		            <div class="col-md-6">
		              <label for="ccyear">If yes, guests can access groups (Guest chat needs to be enabled)</label>
		            </div>
		            <div class="col-md-6">
		              	<label class="">
			              <div style="position:relative;"><input style="position: absolute;" type="radio" name="crguestsMode" $crguestsModeYes value="1" ></div><span style="padding-left:25px;">Yes</span>
			            </label>
			            <label class="">
			              <div style="position:relative;"><input style="position: absolute;" type="radio" name="crguestsMode" $crguestsModeNo value="0"></div><span style="padding-left:25px;">No</span>
			            </label>
		            </div>
		         </div>



				<div class="form-group row">
		            <div class="col-md-6">
		              <label for="ccyear">If yes, show total number of participants in groups</label>
		            </div>
		            <div class="col-md-6">
		              	<label class="">
			              <div style="position:relative;"><input style="position: absolute;" type="radio" name="showChatroomUsers" $showChatroomUsersYes value="1" ></div><span style="padding-left:25px;">Yes</span>
			            </label>
			            <label class="">
			              <div style="position:relative;"><input style="position: absolute;" type="radio" name="showChatroomUsers" $showChatroomUsersNo value="0"></div><span style="padding-left:25px;">No</span>
			            </label>
		            </div>
		         </div>

		        <div class="form-group row">
		            <div class="col-md-6">
		              <label for="">Minimum poll-time in milliseconds (1 second = 1000 milliseconds)</label>
	             		<input class="form-control" type="text" name="minHeartbeat" value="$minHeartbeat">
		            </div>
		        </div>

		        <div class="form-group row">
		            <div class="col-md-6">
		              <label for="">Maximum poll-time in milliseconds</label>
	             		<input class="form-control" type="text"  name="maxHeartbeat" value="$maxHeartbeat">
		            </div>
		        </div>

				<div class="form-group row">
		            <div class="col-md-6">
		              <label for="ccyear">Beep on new messages:</label>
		            </div>
		            <div class="col-md-6">
		              	<label class="">
			              <div style="position:relative;"><input style="position: absolute;" type="radio" name="messageBeep" $messageBeepYes value="1" ></div><span style="padding-left:25px;">Yes</span>
			            </label>
			            <label class="">
			              <div style="position:relative;"><input style="position: absolute;" type="radio" name="messageBeep" $messageBeepNo value="0"></div><span style="padding-left:25px;">No</span>
			            </label>
		            </div>
		        </div>

				<div class="form-group row">
		            <div class="col-md-6">
		              <label for="ccyear">Show indicator on new messages:</label>
		            </div>
		            <div class="col-md-6">
		              	<label class="">
			              <div style="position:relative;"><input style="position: absolute;" type="radio" name="newMessageIndicator" $newMessageYes value="1" ></div><span style="padding-left:25px;">Yes</span>
			            </label>
			            <label class="">
			              <div style="position:relative;"><input style="position: absolute;" type="radio" name="newMessageIndicator" $newMessageNo value="0"></div><span style="padding-left:25px;">No</span>
			            </label>
		            </div>
		        </div>

				<div class="form-group row">
		            <div class="col-md-6">
		              <label for="ccyear">Show username in groups:</label>
		            </div>
		            <div class="col-md-6">
		              	<label class="">
			              <div style="position:relative;"><input style="position: absolute;" type="radio" name="showUsername" $showUsernameYes value="1" ></div><span style="padding-left:25px;">Yes</span>
			            </label>
			            <label class="">
			              <div style="position:relative;"><input style="position: absolute;" type="radio" name="showUsername" $showUsernameNo value="0"></div><span style="padding-left:25px;">No</span>
			            </label>
		            </div>
		        </div>

				{$pcb}

                <div class="row col-md-4" style="">
                   <input type="submit" value="Update Settings" class="btn btn-primary">
                </div>
                </form>
                </div>
                </div>
              </div>
EOD;

} else {
	configeditor($_POST);
	header("Location:?module=dashboard&action=loadexternal&type=module&name=chatrooms");
}
