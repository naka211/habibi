<?php

include_once(dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR.'config.php');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

global $bingClientID;
global $bingClientSecret;
global $googleKey;

/* SETTINGS START */

$bingClientID = setConfigValue('bingClientID','');
$bingClientSecret = setConfigValue('bingClientSecret','');
$useGoogle = setConfigValue('useGoogle','1');
$googleKey = setConfigValue('googleKey','');

/* SETTINGS END */

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
