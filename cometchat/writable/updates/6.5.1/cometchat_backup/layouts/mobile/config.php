<?php

include_once(dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR.'config.php');

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$mobile_settings = setConfigValue('mobile_settings',array('enableMobileTab' => '1', 'confirmOnAllMessages' => '2'));

/* SETTINGS START */

foreach ($mobile_settings as $key => $value) {
	$$key = $value;
}

/* SETTINGS END */

?>
