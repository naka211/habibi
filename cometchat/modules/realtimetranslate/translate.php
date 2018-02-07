<?php

/*

CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license

*/

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php');

if ($useGoogle == 1) {
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'google.php');
} else {
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'bing.php');
}
