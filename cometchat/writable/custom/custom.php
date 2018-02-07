<?php

/*
CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license
*/

/* HOOKS */

function hooks_processUserID($params){
	/* action performed on the basis of userid and usertype. returns processed userid */
	return $params['userid'];
}

function hooks_processMessageBefore($params){
	/* process message or perform action before sending message */
	return $params['message'];
}

function hooks_processMessageAfter($params){
	/* action performed after sending the message */
	return $params['message'];
}

function hooks_processGroupMessageBefore($params){
	/* process message  or perform action before sending group message */
	return $params['message'];
}

function hooks_processGroupMessageAfter($params){
	/* action performed after sending the group message */
	return $params['message'];
}

function hooks_guestLogin($params){
	/* customize guest login. Returns userid of guest */
	return 0;
}

function hooks_forceFriendsAfter($params){
	/* forcefully add friends after buddylist is sorted */
	$buddyList = array();
	return $buddyList;
}

function hooks_getBotIDs($params){
	/* returns ids of custom bots */
	$botids = array();
	return $botids;
}

function hooks_sendOptionalMessage($params){
	/* send optional messages instead of the default one in case of plugins. return 0 to also send the default message or return 1. */
	return 0;
}
