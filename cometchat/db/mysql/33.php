<?php

$content = <<<EOD

ALTER TABLE `cometchat_users` CHANGE `displayname` `displayname` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
UPDATE `cometchat_users` set `displayname` = NULL WHERE `displayname` = '';

REPLACE INTO `cometchat_settings` (setting_key,value,key_type) values ('dbversion','33','1');

EOD;
$q = preg_split('/;[\r\n]+/',$content);
if(!isset($errors)){
   $errors='';
}
foreach ($q as $query) {
  if (strlen($query) > 4) {
    if (!sql_query($query, array(), 1)) {
      $errors .= sql_error($dbh)."<br/>\n";
    }
  }
}
removeCachedSettings($client.'settings');
