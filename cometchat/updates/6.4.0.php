<?php

/*

CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license

*/

include_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'config.php');
cometchatDBConnect();
$errors = '';
$content = <<<EOD
			ALTER TABLE `cometchat_status`
			add column(
				`readreceiptsetting` int(1) unsigned NOT NULL default '1'
			);

			CREATE TABLE IF NOT EXISTS `cometchat_recentconversation` (
			  `convo_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
			  `id` int(10) unsigned NOT NULL,
			  `from` int(10) unsigned NOT NULL,
			  `to` int(10) unsigned NOT NULL,
			  `message` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
			  `sent` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
			  UNIQUE KEY `userid` (`convo_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;

EOD;

$q = preg_split('/;[\r\n]+/',$content);

foreach ($q as $query) {
	if (strlen($query) > 4) {
		$result = mysqli_query($GLOBALS['dbh'],$query);
		if (!$result) {
			$rollback = 1;
			$errors .= mysqli_error($GLOBALS['dbh'])."<br/>\n";
		}
	}
}

?>
