<?php

/*

CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license

*/

include_once(dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."plugins.php");

if ($_REQUEST['action'] == 'clear' && !empty($_REQUEST['clearid'])) {
	$id = $_REQUEST['clearid'];

	if(!empty($_REQUEST['chatroommode'])) {
		$_SESSION['cometchat']['chatrooms_'.$id.'_clearId'] = $_REQUEST['lastid'];
		unset($_SESSION['cometchat']['cometchat_chatroom_'.$id]);
	} else {
		$lastentry = 0;

		if (!empty($_SESSION['cometchat']['cometchat_user_'.$id]) && is_array($_SESSION['cometchat']['cometchat_user_'.$id])) {
			$lastentry = end($_SESSION['cometchat']['cometchat_user_'.$id]);
			$lastentry = $lastentry['id'];
			unset($_SESSION['cometchat']['cometchat_user_'.$id]);
		}

		$_SESSION['cometchat']['cometchat_user_'.$id.'_clear'] = array('timestamp' => getTimeStamp().'999', 'lastentry' => array('id' => $lastentry));
	}
	if (!empty($_GET['callback'])) {
		header('content-type: application/json; charset=utf-8');
		echo $_GET['callback'].'()';
	}
}else{
	if(!empty($_REQUEST['deleteid'])){
		$to = $_REQUEST['deleteid'];
	}
	$_SESSION['cometchat']['cometchat_user_'.$to]=array();
	$sql="UPDATE
        cometchat
    SET
        cometchat.direction =
        (
            CASE
                WHEN
                    (cometchat.from =".mysqli_real_escape_string($GLOBALS['dbh'],$userid)." AND cometchat.direction = 0 AND cometchat.to = ".mysqli_real_escape_string($GLOBALS['dbh'],$to).")
                THEN
                    1
                WHEN
                    (cometchat.from = ".mysqli_real_escape_string($GLOBALS['dbh'],$to)." AND cometchat.direction = 0 AND cometchat.to = ".mysqli_real_escape_string($GLOBALS['dbh'],$userid).")
                THEN
                    2
                WHEN
                    (cometchat.direction = 1 AND cometchat.from=".mysqli_real_escape_string($GLOBALS['dbh'],$to)." AND cometchat.to = ".mysqli_real_escape_string($GLOBALS['dbh'],$userid).")
                THEN
                    3
                WHEN
                    (cometchat.direction = 2 AND cometchat.from=".mysqli_real_escape_string($GLOBALS['dbh'],$userid)." AND cometchat.to = ".mysqli_real_escape_string($GLOBALS['dbh'],$to).")
                THEN
                    3
                ELSE
                	cometchat.direction
            END
        )";

	$query = mysqli_query($GLOBALS['dbh'],$sql);
	$response = array();
	$response['id'] = $to;
	if (!empty($error) ) {
		$response['result'] = "0";
		header('content-type: application/json; charset=utf-8');
		$response['error'] = mysqli_error($GLOBALS['dbh']);
		echo $_REQUEST['callback'].'('.json_encode($response).')';
		exit;
	}
	header('content-type: application/json; charset=utf-8');
	$response['result'] = "1";
	echo $_REQUEST['callback'].'('.json_encode($response).')';
}
?>
