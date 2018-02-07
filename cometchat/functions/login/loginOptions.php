<?php

/*

CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license

*/

include_once(dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."cometchat_init.php");

global $lang;

if (file_exists(dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."lang.php")){
	include_once(dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."lang.php");
}

global $ccactiveauth;
$authpopup = '';

foreach ($ccactiveauth as $key) {
	 $authpopup .= '<img onclick="window.open(\''.BASE_URL.'functions/login/signin.php?network='.strtolower($key).'\',\'socialwindow\',\'location=0,status=0,scrollbars=0,width=1000,height=600\')" src="'.BASE_URL.'themes/'.$theme.'/images/login'.strtolower($key).'.png" class="auth_options"></img>';
}

echo <<<EOD
	<!DOCTYPE html>
	<html style="height:100%;">
		<head>
			<meta http-equiv="cache-control" content="no-cache">
			<meta http-equiv="pragma" content="no-cache">
			<meta http-equiv="expires" content="-1">
			<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
			<link type="text/css" rel="stylesheet" media="all" href="../../css.php?type=core&name=default" />
			<script src="../../js.php?type=core&name=jquery"></script>
			<script type="text/javascript">
				$ = jQuery = jqcc;
			</script>
		</head>
		<body style="height:100%;margin:0;padding:0;">
			<div class="social_options">
				<div id="social_login" class="social_login">{$authpopup}</div>
			</div>
		</body>
	</html>
EOD;


?>
