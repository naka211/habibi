<?php

/*

CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license

*/
define('CC_INSTALL','1');
include_once((dirname(__FILE__)).DIRECTORY_SEPARATOR.'config.php');
cometchatDBConnect();
$files = array('writable/');
$extra = '';

$unwritable = '';
foreach ($files as $file) {
	if (iswritable(dirname(__FILE__).'/'.$file)) {
	} else {
		$unwritable .= '<br/>'.$file;
	}
}

if (!empty($unwritable)) {
	$extra = "<br/><br/><strong>Please CHMOD the following files<br/>and folders to 777:</strong><br/>$unwritable*";
}

function iswritable($path) {

	if ($path{strlen($path)-1}=='/')
		return iswritable($path.uniqid(mt_rand()).'.tmp');

	if (file_exists($path)) {
		if (!($f = @fopen($path, 'r+')))
			return false;
		fclose($f);
		return true;
	}

	if (!($f = @fopen($path, 'w')))
		return false;
	fclose($f);
	unlink($path);
	return true;
}

$body = '';
$path = '';

$rollback = 0;
$errors = '';
$cometchat_chatrooms_users = '';
$extension = '';

$sql = mysqli_query($GLOBALS['dbh'],'select 1 from `cometchat_chatrooms_users`');

if($sql == TRUE) {
    $sql = ("show FULL columns from cometchat_chatrooms_users");
    $res = mysqli_query($GLOBALS['dbh'],$sql);
    $row = mysqli_fetch_assoc($res);

    if(!isset($row['isbanned'])) {
        $cometchat_chatrooms_users = "ALTER TABLE cometchat_chatrooms_users ADD COLUMN isbanned int(1) default 0;";
    }
} else {
    $cometchat_chatrooms_users = "CREATE TABLE IF NOT EXISTS `cometchat_chatrooms_users` (
  `userid` int(10) unsigned NOT NULL,
  `chatroomid` int(10) unsigned NOT NULL,
  PRIMARY KEY  USING BTREE (`userid`,`chatroomid`),
  `isbanned` int(1) default 0,
  KEY `chatroomid` (`chatroomid`),
  KEY `userid` (`userid`),
  KEY `userid_chatroomid` (`chatroomid`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
}
$cometchat_messages_old = "cometchat_messages_old_".time();
$content = <<<EOD
RENAME TABLE `cometchat` to `{$cometchat_messages_old}`;

CREATE TABLE  `cometchat` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL default '0',
  `read` tinyint(1) unsigned NOT NULL default '0',
  `direction` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `to` (`to`),
  KEY `from` (`from`),
  KEY `direction` (`direction`),
  KEY `read` (`read`),
  KEY `sent` (`sent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `cometchat_announcements` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `announcement` text NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `to` int(10) NOT NULL,
  `recd` int(1) NOT NULL DEFAULT 0,

  PRIMARY KEY  (`id`),
  KEY `to` (`to`),
  KEY `time` (`time`),
  KEY `to_id` (`to`,`id`)
) ENGINE=InnoDB AUTO_INCREMENT = 5000 DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `cometchat_chatroommessages` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `userid` int(10) unsigned NOT NULL,
  `chatroomid` int(10) unsigned NOT NULL,
  `message` text NOT NULL,
  `sent` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `userid` (`userid`),
  KEY `chatroomid` (`chatroomid`),
  KEY `sent` (`sent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `cometchat_chatrooms` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `lastactivity` int(10) unsigned NOT NULL,
  `createdby` int(10) unsigned NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `vidsession` varchar(512) default NULL,
  `invitedusers` varchar(512) default NULL,
  PRIMARY KEY  (`id`),
  KEY `lastactivity` (`lastactivity`),
  KEY `createdby` (`createdby`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `cometchat_chatrooms`
add column(
`invitedusers` varchar(512) default NULL
);

CREATE TABLE IF NOT EXISTS `cometchat_status` (
  `userid` int(10) unsigned NOT NULL,
  `message` text,
  `status` enum('available','away','busy','invisible','offline') default NULL,
  `typingto` int(10) unsigned default NULL,
  `typingtime` int(10) unsigned default NULL,
  `isdevice` int(1) unsigned NOT NULL default '0',
  `lastactivity` int(10) unsigned NOT NULL default '0',
  `lastseen` int(10) unsigned NOT NULL default '0',
  `lastseensetting` int(1) unsigned NOT NULL default '0',
  `readreceiptsetting` int(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`userid`),
  KEY `typingto` (`typingto`),
  KEY `typingtime` (`typingtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `cometchat_status`
add column(
`lastseen` int(10) unsigned NOT NULL default '0',
`lastseensetting` int(1) unsigned NOT NULL default '0'
);

ALTER TABLE `cometchat_status`
add column(
`readreceiptsetting` int(1) unsigned NOT NULL default '1'
);

CREATE TABLE IF NOT EXISTS `cometchat_videochatsessions` (
  `username` varchar(255) NOT NULL,
  `identity` varchar(255) NOT NULL,
  `timestamp` int(10) unsigned default 0,
  PRIMARY KEY  (`username`),
  KEY `username` (`username`),
  KEY `identity` (`identity`),
  KEY `timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `cometchat_block` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `fromid` int(10) unsigned NOT NULL,
  `toid` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `fromid` (`fromid`),
  KEY `toid` (`toid`),
  KEY `fromid_toid` (`fromid`,`toid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `cometchat_guests` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10000001 DEFAULT CHARSET=utf8;

INSERT INTO `cometchat_guests` (`id`, `name`) VALUES ('10000000', 'guest-10000000');

CREATE TABLE IF NOT EXISTS `cometchat_session` (
  `session_id` char(32) NOT NULL,
  `session_data` text NOT NULL,
  `session_lastaccesstime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `cometchat_settings` (
  `setting_key` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Configuration setting name. It can be PHP constant, variable or array',
  `value` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Value of the key.',
  `key_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'States whether the key is: 0 = PHP constant, 1 = atomic variable or 2 = serialized associative array.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Stores all the configuration settings for CometChat';

ALTER TABLE `cometchat_settings`
  ADD PRIMARY KEY (`setting_key`),
  ADD KEY `key` (`setting_key`);

INSERT INTO `cometchat_settings` set `setting_key` = 'extensions_core', `value` = 'a:4:{s:3:"ads";s:14:"Advertisements";s:9:"mobileapp";s:9:"Mobileapp";s:7:"desktop";s:7:"Desktop";s:4:"bots";s:4:"Bots";}', `key_type` = 2 on duplicate key update `value` = 'a:5:{s:3:"ads";s:14:"Advertisements";s:6:"jabber";s:10:"Gtalk Chat";s:9:"mobileapp";s:9:"Mobileapp";s:7:"desktop";s:7:"Desktop";s:4:"bots";s:4:"Bots";}';


INSERT INTO `cometchat_settings` set `setting_key` = 'plugins_core', `value` = 'a:17:{s:9:"audiochat";a:2:{i:0;s:10:"Audio Chat";i:1;i:0;}s:6:"avchat";a:2:{i:0;s:16:"Audio/Video Chat";i:1;i:0;}s:5:"block";a:2:{i:0;s:10:"Block User";i:1;i:1;}s:9:"broadcast";a:2:{i:0;s:21:"Audio/Video Broadcast";i:1;i:0;}s:11:"chathistory";a:2:{i:0;s:12:"Chat History";i:1;i:0;}s:17:"clearconversation";a:2:{i:0;s:18:"Clear Conversation";i:1;i:0;}s:12:"filetransfer";a:2:{i:0;s:11:"Send a file";i:1;i:0;}s:9:"handwrite";a:2:{i:0;s:19:"Handwrite a message";i:1;i:0;}s:6:"report";a:2:{i:0;s:19:"Report Conversation";i:1;i:1;}s:4:"save";a:2:{i:0;s:17:"Save Conversation";i:1;i:0;}s:11:"screenshare";a:2:{i:0;s:13:"Screensharing";i:1;i:0;}s:7:"smilies";a:2:{i:0;s:7:"Smilies";i:1;i:0;}s:8:"stickers";a:2:{i:0;s:8:"Stickers";i:1;i:0;}s:5:"style";a:2:{i:0;s:15:"Color your text";i:1;i:2;}s:13:"transliterate";a:2:{i:0;s:13:"Transliterate";i:1;i:0;}s:10:"whiteboard";a:2:{i:0;s:10:"Whiteboard";i:1;i:0;}s:10:"writeboard";a:2:{i:0;s:10:"Writeboard";i:1;i:0;}}', `key_type` = 2 on duplicate key update `value` = 'a:17:{s:9:"audiochat";a:2:{i:0;s:10:"Audio Chat";i:1;i:0;}s:6:"avchat";a:2:{i:0;s:16:"Audio/Video Chat";i:1;i:0;}s:5:"block";a:2:{i:0;s:10:"Block User";i:1;i:1;}s:9:"broadcast";a:2:{i:0;s:21:"Audio/Video Broadcast";i:1;i:0;}s:11:"chathistory";a:2:{i:0;s:12:"Chat History";i:1;i:0;}s:17:"clearconversation";a:2:{i:0;s:18:"Clear Conversation";i:1;i:0;}s:12:"filetransfer";a:2:{i:0;s:11:"Send a file";i:1;i:0;}s:9:"handwrite";a:2:{i:0;s:19:"Handwrite a message";i:1;i:0;}s:6:"report";a:2:{i:0;s:19:"Report Conversation";i:1;i:1;}s:4:"save";a:2:{i:0;s:17:"Save Conversation";i:1;i:0;}s:11:"screenshare";a:2:{i:0;s:13:"Screensharing";i:1;i:0;}s:7:"smilies";a:2:{i:0;s:7:"Smilies";i:1;i:0;}s:8:"stickers";a:2:{i:0;s:8:"Stickers";i:1;i:0;}s:5:"style";a:2:{i:0;s:15:"Color your text";i:1;i:2;}s:13:"transliterate";a:2:{i:0;s:13:"Transliterate";i:1;i:0;}s:10:"whiteboard";a:2:{i:0;s:10:"Whiteboard";i:1;i:0;}s:10:"writeboard";a:2:{i:0;s:10:"Writeboard";i:1;i:0;}}';



INSERT INTO `cometchat_settings` (`setting_key`, `value`, `key_type`) VALUES ('modules_core', 'a:11:{s:13:"announcements";a:9:{i:0;s:13:"announcements";i:1;s:13:"Announcements";i:2;s:31:"modules/announcements/index.php";i:3;s:6:"_popup";i:4;s:3:"280";i:5;s:3:"310";i:6;s:0:"";i:7;s:1:"1";i:8;s:0:"";}s:16:"broadcastmessage";a:9:{i:0;s:16:"broadcastmessage";i:1;s:17:"Broadcast Message";i:2;s:34:"modules/broadcastmessage/index.php";i:3;s:6:"_popup";i:4;s:3:"385";i:5;s:3:"300";i:6;s:0:"";i:7;s:1:"1";i:8;s:0:"";}s:9:"chatrooms";a:9:{i:0;s:9:"chatrooms";i:1;s:9:"Chatrooms";i:2;s:27:"modules/chatrooms/index.php";i:3;s:6:"_popup";i:4;s:3:"600";i:5;s:3:"300";i:6;s:0:"";i:7;s:1:"1";i:8;s:1:"1";}s:8:"facebook";a:9:{i:0;s:8:"facebook";i:1;s:17:"Facebook Fan Page";i:2;s:26:"modules/facebook/index.php";i:3;s:6:"_popup";i:4;s:3:"500";i:5;s:3:"460";i:6;s:0:"";i:7;s:1:"1";i:8;s:0:"";}s:5:"games";a:9:{i:0;s:5:"games";i:1;s:19:"Single Player Games";i:2;s:23:"modules/games/index.php";i:3;s:6:"_popup";i:4;s:3:"465";i:5;s:3:"300";i:6;s:0:"";i:7;s:1:"1";i:8;s:0:"";}s:4:"home";a:8:{i:0;s:4:"home";i:1;s:4:"Home";i:2;s:1:"/";i:3;s:0:"";i:4;s:0:"";i:5;s:0:"";i:6;s:0:"";i:7;s:0:"";}s:17:"realtimetranslate";a:9:{i:0;s:17:"realtimetranslate";i:1;s:23:"Translate Conversations";i:2;s:35:"modules/realtimetranslate/index.php";i:3;s:6:"_popup";i:4;s:3:"280";i:5;s:3:"310";i:6;s:0:"";i:7;s:1:"1";i:8;s:0:"";}s:11:"scrolltotop";a:8:{i:0;s:11:"scrolltotop";i:1;s:13:"Scroll To Top";i:2;s:40:"javascript:jqcc.cometchat.scrollToTop();";i:3;s:0:"";i:4;s:0:"";i:5;s:0:"";i:6;s:0:"";i:7;s:0:"";}s:5:"share";a:8:{i:0;s:5:"share";i:1;s:15:"Share This Page";i:2;s:23:"modules/share/index.php";i:3;s:6:"_popup";i:4;s:3:"350";i:5;s:2:"50";i:6;s:0:"";i:7;s:1:"1";}s:9:"translate";a:9:{i:0;s:9:"translate";i:1;s:19:"Translate This Page";i:2;s:27:"modules/translate/index.php";i:3;s:6:"_popup";i:4;s:3:"280";i:5;s:3:"310";i:6;s:0:"";i:7;s:1:"1";i:8;s:0:"";}s:7:"twitter";a:8:{i:0;s:7:"twitter";i:1;s:7:"Twitter";i:2;s:25:"modules/twitter/index.php";i:3;s:6:"_popup";i:4;s:3:"500";i:5;s:3:"300";i:6;s:0:"";i:7;s:1:"1";}}', 2);

CREATE TABLE IF NOT EXISTS `cometchat_languages` (
  `lang_key` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Key of a language variable',
  `lang_text` text CHARACTER SET utf8 NOT NULL COMMENT 'Text/value of a language variable',
  `code` varchar(20) CHARACTER SET utf8 NOT NULL COMMENT 'Language code for e.g. en for English',
  `type` varchar(20) CHARACTER SET utf8 NOT NULL COMMENT 'Type of CometChat add on for e.g. module/plugin/extension/function',
  `name` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT 'Name of add on for e.g. announcement,smilies, etc.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Stores all CometChat languages';

ALTER TABLE `cometchat_languages`
  ADD UNIQUE KEY `lang_index` (`lang_key`,`code`,`type`,`name`) USING BTREE;

INSERT INTO `cometchat_languages` (`lang_key`, `lang_text`, `code`, `type`, `name`) VALUES ('rtl', '0', 'en', 'core', 'default');

CREATE TABLE IF NOT EXISTS `cometchat_colors` (
  `color_key` varchar(100) NOT NULL,
  `color_value` text NOT NULL,
  `color` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `cometchat_colors`
  ADD UNIQUE KEY `color_index` (`color_key`,`color`);

INSERT INTO `cometchat_colors` (`color_key`, `color_value`, `color`) VALUES
('color1', 'a:3:{s:7:"primary";s:6:"56a8e3";s:9:"secondary";s:6:"3777A7";s:5:"hover";s:6:"ECF5FB";}', 'color1'),
('color2', 'a:3:{s:7:"primary";s:6:"4DC5CE";s:9:"secondary";s:6:"068690";s:5:"hover";s:6:"D3EDEF";}', 'color2'),
('color3', 'a:3:{s:7:"primary";s:6:"FFC107";s:9:"secondary";s:6:"FFA000";s:5:"hover";s:6:"FFF8E2";}', 'color3'),
('color4', 'a:3:{s:7:"primary";s:6:"FB4556";s:9:"secondary";s:6:"BB091A";s:5:"hover";s:6:"F5C3C8";}', 'color4'),
('color5', 'a:3:{s:7:"primary";s:6:"DBA0C3";s:9:"secondary";s:6:"D87CB3";s:5:"hover";s:6:"ECD9E5";}', 'color5'),
('color6', 'a:3:{s:7:"primary";s:6:"3B5998";s:9:"secondary";s:6:"213A6D";s:5:"hover";s:6:"DFEAFF";}', 'color6'),
('color7', 'a:3:{s:7:"primary";s:6:"065E52";s:9:"secondary";s:6:"244C4E";s:5:"hover";s:6:"AFCCAF";}', 'color7'),
('color8', 'a:3:{s:7:"primary";s:6:"FF8A2E";s:9:"secondary";s:6:"CE610C";s:5:"hover";s:6:"FDD9BD";}', 'color8'),
('color9', 'a:3:{s:7:"primary";s:6:"E99090";s:9:"secondary";s:6:"B55353";s:5:"hover";s:6:"FDE8E8";}', 'color9'),
('color10', 'a:3:{s:7:"primary";s:6:"23025E";s:9:"secondary";s:6:"3D1F84";s:5:"hover";s:6:"E5D7FF";}', 'color10'),
('color11', 'a:3:{s:7:"primary";s:6:"24D4F6";s:9:"secondary";s:6:"059EBB";s:5:"hover";s:6:"DBF9FF";}', 'color11'),
('color12', 'a:3:{s:7:"primary";s:6:"289D57";s:9:"secondary";s:6:"09632D";s:5:"hover";s:6:"DDF9E8";}', 'color12'),
('color13', 'a:3:{s:7:"primary";s:6:"D9B197";s:9:"secondary";s:6:"C38B66";s:5:"hover";s:6:"FFF1E8";}', 'color13'),
('color14', 'a:3:{s:7:"primary";s:6:"FF67AB";s:9:"secondary";s:6:"D6387E";s:5:"hover";s:6:"F3DDE7";}', 'color14'),
('color15', 'a:3:{s:7:"primary";s:6:"8E24AA";s:9:"secondary";s:6:"7B1FA2";s:5:"hover";s:6:"EFE8FD";}', 'color15');

DELETE FROM `cometchat_colors` WHERE `color_key` NOT LIKE 'color%';

INSERT INTO `cometchat_settings` set `setting_key` = 'theme', `value` = 'docked', `key_type` = 1 on duplicate key update `value` = 'docked';

INSERT INTO `cometchat_settings` set `setting_key` = 'color', `value` = 'color1', `key_type` = 1 on duplicate key update `value` = 'color1';

CREATE TABLE IF NOT EXISTS `cometchat_users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `displayname` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `avatar` varchar(200) NOT NULL,
  `link` varchar(200) NOT NULL,
  `grp` varchar(25) NOT NULL,
  `friends` text NOT NULL,
  PRIMARY KEY (`userid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `cometchat_bots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `keywords` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `avatar` varchar(200) NOT NULL,
  `apikey` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `cometchat_recentconversation` (
  `convo_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `id` int(10) unsigned NOT NULL,
  `from` int(10) unsigned NOT NULL,
  `to` int(10) unsigned NOT NULL,
  `message` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sent` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  UNIQUE KEY `convo_id` (`convo_id`),  
  KEY `fromid` (`from`),
  KEY `toid` (`to`),
  KEY `fromid_toid` (`from`,`to`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

{$cometchat_chatrooms_users}

EOD;

	$q = preg_split('/;[\r\n]+/',$content);
  $sql = ("select 1 AS needInstall from cometchat_settings limit 1");
  $rows = mysqli_query($GLOBALS['dbh'],$sql);
  if($rows === false || !empty($_REQUEST['forceInstall'])){
  	foreach ($q as $query) {
  		if (strlen($query) > 4) {
  		$result = mysqli_query($GLOBALS['dbh'],$query);
  			if (!$result) {
  				$rollback = 1;
  				$errors .= mysqli_error($GLOBALS['dbh'])."<br/>\n";
  			}
  		}
  	}
    $force = 1;
  }elseif(empty($_REQUEST['forceInstall'])){
    $extra .= "<br/><strong style='font-size:14px;'>Please do not install manually, update CometChat from administration panel.</strong><form action='' method='post'><p style='font-size:14px;'>If you still install the CometChat, all the messages of CometChat will be deleted. Do you want to continue?</p><input type='hidden' value='forceInstall' name='forceInstall'/><input class='button' type='submit' value='Yes'/><input onClick='window.location.href=\"admin/index.php\"' class='button' style='margin-left:20px;' type='button' value='No'/></form>";
    $force = 0;
  }

$updated_settings = array ('extensions'=>'mobilewebapp','plugins'=>'chattime','crplugins'=>'chattime');

foreach ($updated_settings as $key => $value) {
  $sql = mysqli_query($GLOBALS['dbh'],"select `value` from `cometchat_settings` where `setting_key` like '".$key."'");
  while($row = mysqli_fetch_assoc($sql)){
    if(isset($row['value'])) {
      $extension = unserialize($row['value']);
      if(in_array($value, $extension)) {
        array_splice($extension, array_search($value,$extension),1);
      }

      $extension = mysqli_query($GLOBALS['dbh'],"UPDATE `cometchat_settings` SET `value`='".mysqli_real_escape_string($GLOBALS['dbh'],serialize($extension))."' WHERE `setting_key` like '".$key."';");
    }
  }
}
	$sql = ("show table status where name = '".$table_prefix.$db_usertable."'");
	$query = mysqli_query($GLOBALS['dbh'],$sql);
	$result = mysqli_fetch_assoc($query);

	$table_co = $result['Collation'];

	$sql = ("show FULL columns from ".$table_prefix.$db_usertable." where field = '".$db_usertable_name."'");
	$query = mysqli_query($GLOBALS['dbh'],$sql);
	echo mysqli_error($GLOBALS['dbh']);
	$result = mysqli_fetch_assoc($query);

	$field_co = $result['Collation'];

	$field_cs = explode('_',$field_co);
	$field_cs = $field_cs[0];

	if (!empty($table_co)) {
		$result = mysqli_query($GLOBALS['dbh'],"alter table cometchat_guests default collate ".$table_co);
	}

	if (!$result) { $errors .= mysqli_error($GLOBALS['dbh'])."<br/>\n"; }

	if (!empty($field_cs) && !empty($field_co)) {
		$result = mysqli_query($GLOBALS['dbh'],"alter table cometchat_guests convert to character set ".$field_cs." collate ".$field_co);
	}

	if (!$result) { $errors .= mysqli_error($GLOBALS['dbh'])."<br/>\n"; }

        $sql = ("SHOW FULL COLUMNS FROM `cometchat_status` WHERE field = 'isdevice' or field = 'lastactivity'");
        $query = mysqli_query($GLOBALS['dbh'],$sql);
	echo mysqli_error($GLOBALS['dbh']);
	$result = mysqli_fetch_assoc($query);
        if (!($result)) {
            $sql = ("RENAME TABLE `cometchat_status` to `cometchat_status_old`");
            $query = mysqli_query($GLOBALS['dbh'],$sql);

            $sql = ("CREATE TABLE  IF NOT EXISTS `cometchat_status` (
                `userid` int(10) unsigned NOT NULL,
                `message` text,
                `status` enum('available','away','busy','invisible','offline') default NULL,
                `typingto` int(10) unsigned default NULL,
                `typingtime` int(10) unsigned default NULL,
                `isdevice` int(1) unsigned NOT NULL default '0',
                `lastactivity` int(10) unsigned NOT NULL default '0',
                `lastseen` int(10) unsigned NOT NULL default '0',
                `lastseensetting` int(1) unsigned NOT NULL default '0',
                PRIMARY KEY  (`userid`),
                KEY `typingto` (`typingto`),
                KEY `typingtime` (`typingtime`)
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
            $query = mysqli_query($GLOBALS['dbh'],$sql);

            $sql = ("INSERT INTO `cometchat_status` (`userid`, `message`, `status`, `typingto`, `typingtime`, `isdevice`, `lastactivity`, `lastseen`, `lastseensetting`) SELECT *, NULL, NULL from `cometchat_status_old`");
            $query = mysqli_query($GLOBALS['dbh'],$sql);
        }

	$baseurl = '/cometchat/';

	if (!empty($_SERVER['DOCUMENT_ROOT']) && !empty($_SERVER['SCRIPT_FILENAME'])) {
		$baseurl = preg_replace('/install.php/i','',str_replace($_SERVER['DOCUMENT_ROOT'],'',$_SERVER['SCRIPT_FILENAME']));
	}

	$baseurl = str_replace('\\','/',$baseurl);

	if (!empty($baseurl) && $baseurl[0] != '/') {
		$baseurl = '/'.$baseurl;
	}

	if (!empty($baseurl) && $baseurl[strlen($baseurl)-1] != '/') {
		$baseurl = $baseurl.'/';
	}

	if($baseurl != '/cometchat/'){
    $sql = ("insert into cometchat_settings(`setting_key`,`value`,`key_type`) values('BASE_URL','".$baseurl."','0')");
    $query = mysqli_query($GLOBALS['dbh'],$sql);
  }

  $apikey = md5(time().$_SERVER['SERVER_NAME']);
  $sql = ("insert into cometchat_settings(`setting_key`,`value`,`key_type`) values('apikey','".$apikey."','1')");
  $query = mysqli_query($GLOBALS['dbh'],$sql);

	$codeA = '<link type="text/css" href="'.$baseurl.'cometchatcss.php" rel="stylesheet" charset="utf-8">'."\r\n".'<script type="text/javascript" src="'.$baseurl.'cometchatjs.php" charset="utf-8"></script>';

	$codeB = '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>'."\r\n".'<script>jqcc=jQuery.noConflict(true);</script>';

	$embedcode = '&lt;div id="cometchat_embed_synergy_container" style="max-width:100%;" >&lt;/div&gt;&lt;script src="'.$baseurl.'js.php?type=core&name=embedcode" type="text/javascript"&gt;&lt;/script&gt;&lt;script&gt;var iframeObj = {};iframeObj.module="synergy";iframeObj.style="min-height:420px;min-width:300px;";iframeObj.src="'.$baseurl.'cometchat_embedded.php"; if(typeof(addEmbedIframe)=="function"){addEmbedIframe(iframeObj);}&lt;/script&gt;';
  if($force == 0){
    $body = "<div id='install_success' style='color:red;font-size:14px;'><strong>Installation could not be proceed.</strong></div><br/>$extra";
  }else	if (defined('INCLUDE_JQUERY') && INCLUDE_JQUERY == 1) {
		$body = "<div id='install_success'><strong>Installation complete.</strong> Did you expect something more complicated?</div><br/><div id='docked_code'><strong>1. For Docked layout: </strong><br/><br/> Add the following immediately after <strong>&lt;head&gt;</strong> tag in your site template:<br/><br/><textarea readonly id=\"code\" onclick=\"copycode('code')\"  class=\"textarea\" name=\"code\">$codeA</textarea><br/><br/></div><div id='embeded_code'><strong>2. For Embedded layout: </strong><br/><br/> Add the following code in your site's HTML code to embed the chat: <br/><br/><textarea readonly id=\"embedcode\" rows=\"7\" style=\"height:auto;\" onclick=\"copycode('embedcode')\"  class=\"textarea\" name=\"embedcode\">$embedcode</textarea></div>$extra";
	} else {
		$body = "<div id='install_success'><strong>Installation complete.</strong> Did you expect something more complicated?</div><br/><div id='docked_code'><strong>1. For Docked layout: </strong><br/><br/>Add the following immediately after <strong>&lt;head&gt;</strong> tag in your site template:<br/><br/><textarea readonly id=\"codeJ\" onclick=\"copycodeJ()\"  class=\"textarea\" name=\"codeJ\">$codeB</textarea><br/><br/>Add the following immediately before <strong>&lt;/body&gt;</strong> tag in your site template:<br/><br/><textarea readonly id=\"code\" onclick=\"copycode('code')\"  class=\"textarea\" name=\"code\">$codeA</textarea><br/><br/></div><div id='embeded_code'><strong>2. For Embedded layout: </strong><br/><br/> Add the following code in your site's HTML code where you want to embed the chat: <br/><br/><textarea readonly id=\"embedcode\" rows=\"7\" style=\"height:auto;\" onclick=\"copycode('embedcode')\"  class=\"textarea\" name=\"embedcode\">$embedcode</textarea></div>$extra";
	}


?>
<!DOCTYPE HTML>
<html>

	<head>

		<title>CometChat Installation</title>

		<style type="text/css">
			html,body {
				background: #f9f9f9;
				overflow: hidden;
			}
			#cometchat_wrapper { margin-top: 15px; }
			#box { padding:0px; width:475px; margin:0 auto; }
			#boxtop {
				background: url(images/install_top.png);
				width: auto;
				height: 53px;
				border-top-left-radius: 4px;
				border-top-right-radius: 4px;
			}
      .button {
        border:1px solid #76b6d2;
        padding:6px 30px;
        background:#76b6d2;
        color:#fff;
        font-weight:bold;
        font-size:10px;
        font-family:arial;
        text-transform:uppercase;
        cursor: pointer;
      }
      .button:hover {
        opacity: 0.5;
      }
			#boxrepeat {
				font-family: "Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
				font-size: 11px;
				color: #333333;
				background: url(images/install_repeat.png);
				width: auto;
				padding: 15px;
				border: 1px solid #d3d3d3;
				border-top: 0px;
				border-bottom-left-radius: 4px;
				border-bottom-right-radius: 4px;
			}
			#boxbottom { background: url(images/install_bottom.png); width: auto; height: 25px;}

			.textarea {
				font-family: "Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
				font-size: 10px;
				color: #333333;
				width: 435px;
				border: 1px solid #ccc;
				padding: 2px;
				height: 80px;
				overflow:hidden;
				line-height: 14px;
			}

			#install_success {
				margin: 0 auto;
  				width: 450px;
			}

			#docked_code {
				margin: 0 auto;
  				width: 450px;
			}

			#embeded_code {
				margin: 0 auto;
  				width: 450px;
			}

		</style>

		<script>
			function copycode(code) {
				var tempval= document.getElementById(code);
				tempval.focus()
				tempval.select()
			}

			function copycodeJ() {
				var tempval= document.getElementById('codeJ');
				tempval.focus()
				tempval.select()
			}
		</script>

		<!--[if IE]>

		<style type="text/css">

			#cometchat_wrapper { position: relative; }
			#position { position: absolute; top: 50%; }
			#content { position: relative; width:100%; top: -50%; }
			#box { position:relative; left:50%; margin-left:-181px; }

		</style>

		<![endif]-->

	</head>

	<body>

		<div id="cometchat_wrapper">
			<div id="position">
				<div id="content">
					<div id="box">
						<div id="boxtop"></div>
						<div id="boxrepeat"><?php echo $body;?></div>
						<div id="boxbottom"></div>
					</div>
				</div>
			</div>
		</div>
		<!-- License void if removed -->
		<?php
			echo '<img src="//my.cometchat.com/track?k='.$licensekey.'&v='.$currentversion.'" width="1" height="1" />';
		?>

	</body>

</html>
