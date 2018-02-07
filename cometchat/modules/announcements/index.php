<?php

/*

CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license

*/

include_once(dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."modules.php");
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."config.php");

if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR."lang.php")) {
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."lang.php");
}

function datify($ts) {
	if(!ctype_digit($ts)) {
		$ts = strtotime($ts);
	}
	$diff = time() - $ts;
	$date = date('l, F j, Y',$ts).' at '.date('g:ia',$ts);
	if($diff == 0) {
		return array ('now',$date);
	} elseif($diff > 0) {
		$day_diff = floor($diff / 86400);
		if($day_diff == 0) {
			if($diff < 60) return array('just now',$date);
			if($diff < 120) return array ('1 minute ago',$date);
			if($diff < 3600) return array (floor($diff / 60) . ' minutes ago',$date);
			if($diff < 7200) return array ('1 hour ago',$date);
			if($diff < 86400) return array (floor($diff / 3600) . ' hours ago',$date);
		}
		if($day_diff == 1) { return array ('Yesterday at '.date('g:ia',$ts),$date); }

		if (date('Y') == date('Y',$ts)) {
			return array (date('F jS',$ts).' at '.date('g:ia',$ts),$date);
		} else {
			return array (date('F jS, Y',$ts).' at '.date('g:ia',$ts),$date);
		}
	} else {
	return array (date('F jS, Y',$ts).' at '.date('g:ia',$ts),$date);
	}
}

$extra = "";

if (!empty($userid)) {
	$extra = "or `to` = '0' or `to` = '".mysqli_real_escape_string($GLOBALS['dbh'],$userid)."'";
}

$limit = " limit ".$noOfAnnouncements;
if(!empty($_REQUEST['callbackfn']) && $_REQUEST['callbackfn']=='mobileapp')
{
	$limit = '';
}
$sql = ("select id,announcement,time,`to` from cometchat_announcements where `to` = '-1' ".$extra." order by id desc ".$limit);
$query = mysqli_query($GLOBALS['dbh'],$sql);

if (defined('DEV_MODE') && DEV_MODE == '1') { echo mysqli_error($GLOBALS['dbh']); }

$announcementdata = '';
$announcementJson = array();
while ($announcement = mysqli_fetch_assoc($query)) {
	$time = $announcement['time'];
	$timehover=datify($time);
	$class = 'highlight';

	if ($announcement['to'] == 0 || $announcement['to'] == -1) {
		$class = '';
	}
	$ann = array();

	$ann['id'] =  $announcement['id'];
	$ann['m'] =  $announcement['announcement'];
	$ann['t'] =  $announcement['time'];

	$announcementJson["_".$announcement['id']] = $ann;
	$announcement['announcement'] = utf8_decode($announcement['announcement']);
	$announcementdata .= <<<EOD
	<li class="announcement"><span class="{$class}">{$announcement['announcement']}</span><br/><small class="chattime" timestamp="{$timehover['0']}" timehover="{$timehover['1']}"></small><br/></li>
EOD;

}

if (empty($announcementdata)) {
	$announcementdata = '<li class="announcement no-announcement">'.$announcements_language[0].'</li>';
}

$extrajs = "";
if ($sleekScroller == 1) {
	$extrajs = '<script src="../../js.php?type=core&name=scroll"></script>';
}

if(empty($_REQUEST['callbackfn']) || $_REQUEST['callbackfn']<>'mobileapp')
{
	if($theme == 'embedded'){
echo <<<EOD
	<!DOCTYPE html>
	<html>
		<head>
			<title>{$announcements_language[100]}</title>
			<meta name="viewport" content="user-scalable=1,width=device-width, initial-scale=1.0" />
			<meta http-equiv="cache-control" content="no-cache">
			<meta http-equiv="pragma" content="no-cache">
			<meta http-equiv="expires" content="-1">
			<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
			<link type="text/css" rel="stylesheet" media="all" href="../../css.php?type=module&name=announcements" />
			<script src="../../js.php?type=core&name=jquery"></script>
			<script>
			  $ = jQuery = jqcc;
			</script>
			<script src="../../js.php?type=module&name=announcements"></script>
			{$extrajs}
		</head>
		<body>
			<div style="width:100%;margin:0 auto;margin-top: 0px;height: 100%;overflow-y: auto;">
				<div class="cometchat_wrapper">
					<div class="announcements" style="width: 100%; height: 300px;overflow:auto">
						<ul>
							<ul>{$announcementdata}</ul>
						</ul>
					</div>
					<div style="clear:both">&nbsp;</div>
				</div>
			</div>
		</body>
	</html>
EOD;

	}else{
echo <<<EOD
	<!DOCTYPE html>
	<html>
		<head>
			<title>{$announcements_language[100]}</title>
			<meta name="viewport" content="user-scalable=1,width=device-width, initial-scale=1.0" />
			<meta http-equiv="cache-control" content="no-cache">
			<meta http-equiv="pragma" content="no-cache">
			<meta http-equiv="expires" content="-1">
			<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
			<link type="text/css" rel="stylesheet" media="all" href="../../css.php?type=module&name=announcements" />
			<script src="../../js.php?type=core&name=jquery"></script>
			<script>
			  $ = jQuery = jqcc;
			</script>
			<script src="../../js.php?type=module&name=announcements"></script>
			{$extrajs}
		</head>
		<body>
			<div style="width:100%;margin:0 auto;margin-top: 0px;height: 100%;overflow-y: auto;">
				<div class="cometchat_wrapper">
					<div class="announcements" style="width: 100%; height: 300px;overflow:auto">
						<ul>
							<ul>{$announcementdata}</ul>
						</ul>
					</div>
					<div style="clear:both">&nbsp;</div>
				</div>
			</div>
		</body>
	</html>
EOD;
}
} else{
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($announcementJson);
}
?>
