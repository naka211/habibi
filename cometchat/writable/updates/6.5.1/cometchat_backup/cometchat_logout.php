<?php

/*

CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license

*/

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."cometchat_init.php");

if(!empty($_REQUEST['callbackfn']) && $_REQUEST['callbackfn'] == 'mobileapp') {
	$sql = ("update `cometchat_status` set isdevice = '0' where userid = ".mysqli_real_escape_string($GLOBALS['dbh'], $userid)."");
	mysqli_query($GLOBALS['dbh'], $sql);
} else if(!empty($_REQUEST['callbackfn']) && $_REQUEST['callbackfn'] == 'desktop'){
	unset($_SESSION['cometchat']);
    unset($_SESSION['CCAUTH_SESSION']);
	setcookie($cookiePrefix.'guest',"",time() - 3600,'/');
	setcookie($cookiePrefix."state", "", time() - 3600,'/');
	echo json_encode(1);
}else{
    echo "Nothing to look here";
}

exit;
