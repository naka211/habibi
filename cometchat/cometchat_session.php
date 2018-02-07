<?php

/*

CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license

*/

session_set_save_handler("cometchatSessionOpen", "cometchatSessionClose", "cometchatSessionRead", "cometchatSessionWrite", "cometchatSessionDestroy", "cometchatSessionGarbageCollector");

function cometchatSessionOpen($path, $name) {
    global $dbh;
    cometchatDBConnect();
    $sql = ("INSERT INTO cometchat_session(`session_id`,`session_data`) values('" . session_id() . "','') ON DUPLICATE KEY UPDATE session_lastaccesstime = NOW()");
    $query = mysqli_query($GLOBALS['dbh'],$sql);
}

function cometchatSessionClose() {
    $sessionId = session_id();
    //perform some action here
}

function cometchatSessionRead($sessionId) {
    global $dbh;
    cometchatDBConnect();
    $data = "";
    $sql = ("SELECT session_data FROM cometchat_session where session_id = '" . session_id() . "'");
    $query = mysqli_query($GLOBALS['dbh'],$sql);
    if($session = mysqli_fetch_assoc($query)){
        $data = $session['session_data'];
    }
    return $data;
}

function cometchatSessionWrite($sessionId, $data) {
    global $dbh;
    cometchatDBConnect();
    $sql = ("INSERT INTO cometchat_session SET session_id = '" . session_id() . "', session_data = '" . mysqli_real_escape_string($GLOBALS['dbh'],$data) . "' ON DUPLICATE KEY UPDATE session_data = '" . mysqli_real_escape_string($GLOBALS['dbh'],$data) . "'");
    $query = mysqli_query($GLOBALS['dbh'],$sql);
}

function cometchatSessionDestroy($sessionId) {
    global $dbh;
    cometchatDBConnect();
    $sql = ("DELETE FROM cometchat_session WHERE session_id = '" . session_id() . "'");
    $query = mysqli_query($GLOBALS['dbh'],$sql);
    setcookie(session_name(), "", time() - 3600);
}

function cometchatSessionGarbageCollector($lifetime) {
    global $dbh;
    cometchatDBConnect();
    $sql = ("DELETE FROM cometchat_session WHERE session_lastaccesstime < DATE_SUB(NOW(), INTERVAL " . mysqli_real_escape_string($GLOBALS['dbh'],$lifetime) . " SECOND)");
    $query = mysqli_query($GLOBALS['dbh'],$sql);
}

?>
