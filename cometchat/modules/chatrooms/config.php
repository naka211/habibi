<?php

include_once(dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR.'config.php');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* SETTINGS START */

$chatroomTimeout = setConfigValue('chatroomTimeout','604800');
$lastMessages = setConfigValue('lastMessages','10');
$allowUsers = setConfigValue('allowUsers','1');
$allowGuests = setConfigValue('allowGuests','1');
$allowDelete = setConfigValue('allowDelete','1');
$allowAvatar = setConfigValue('allowAvatar','1');
$crguestsMode = setConfigValue('crguestsMode','1');
$showChatroomUsers = setConfigValue('showChatroomUsers','1');
$minHeartbeat = setConfigValue('minHeartbeat','3000');
$maxHeartbeat = setConfigValue('maxHeartbeat','12000');
$autoLogin = setConfigValue('autoLogin','0');
$messageBeep = setConfigValue('messageBeep','1');
$newMessageIndicator = setConfigValue('newMessageIndicator','1');
$showchatbutton = setConfigValue('showchatbutton','1'); //Show private chat for friends only
$showUsername = setConfigValue('showUsername','0'); 

/* SETTINGS END */

/* MODERATOR START */

$moderatorUserIDs = setConfigValue('moderatorUserIDs',array());

/* MODERATOR END */



if (USE_COMET == 1 && COMET_CHATROOMS == 1) {
	$minHeartbeat = $maxHeartbeat = REFRESH_BUDDYLIST.'000';
}

/* ADDITIONAL SETTINGS */

$chatroomLongNameLength = 60;	// The chatroom length after which characters will be truncated
$chatroomShortNameLength = 30;	// The chatroom length after which characters will be truncated

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
