<?php

/*

CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license

*/

if (!defined('CCADMIN')) { echo "NO DICE"; exit; }

$navigation = <<<EOD
	<div id="leftnav">
	</div>
EOD;

function index() {
	if(isset($_SESSION['d'])) {
		unset($_SESSION['d']);
	}
	unset($_SESSION['cometchat']['cometchat_admin_user']);
	unset($_SESSION['cometchat']['cometchat_admin_pass']);
	unset($_SESSION['cometchat']['VERSION_CHECK']);
	header("Location: ".ADMIN_URL."\r\n");
	exit;
}
