<?php

/*

CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license

*/

if (!defined('CCADMIN')) { echo "NO DICE"; exit; }

if (empty($_GET['process'])) {
	global $getstylesheet;
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php');
	$base_url = BASE_URL;
	$alchkd = '';
	$zchkd = '';
	$ochkd = '';
if ($confirmOnAllMessages == 2) {
    $confirmOnAllMessagesYes = '';
    $confirmOnAllMessagesNo = '';
	$ochkd = "selected";
    $confirmNever = 'checked="checked"';
}else if ($confirmOnAllMessages == 1) {
    $confirmOnAllMessagesYes = 'checked="checked"';
    $confirmOnAllMessagesNo = '';
	$zchkd = "selected";
    $confirmNever = '';
} else {
    $confirmOnAllMessagesNo = 'checked="checked"';
	$alchkd = "selected";
    $confirmOnAllMessagesYes = '';
    $confirmNever = '';
}
if($enableMobileTab == 1){
    $enableMobileTabYes = 'checked="checked"';
    $enableMobileTabNo = '';
}else{
    $enableMobileTabNo = 'checked="checked"';
    $enableMobileTabYes = '';
}
echo <<<EOD
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" href="images/favicon.ico">
  <title>Generate Embed Code</title>
  <link href="{$base_url}/css.php?admin=1" rel="stylesheet">
  <script src="{$base_url}/js.php?admin=1"></script>
</head>
 <body class="navbar-fixed sidebar-nav fixed-nav" style="background-color:white;white;overflow-y:hidden;"">
             <div class="col-sm-6 col-lg-6">
                <div class="card">
                <div class="card-block">
                  <form style="height:100%" action="?module=dashboard&action=loadthemetype&type=layout&name=mobile&process=true" method="post">

		          <div class="form-group row">
		            <div class="col-md-6">
		              <label for="ccyear">Enable Mobile theme:</label>
		            </div>
		             <div class="col-md-6">
		              <label class="">
			              <div style="position:relative;"><input style="position: absolute;" type="radio" $enableMobileTabYes value="1" name="enableMobileTab"></div><span style="padding-left:25px;">Yes</span>
			            </label>
			            <label class="">
			              <div style="position:relative;"><input style="position: absolute;" type="radio" $enableMobileTabNo value="0" name="enableMobileTab"></div><span style="padding-left:25px;">No</span>
			            </label>
		            </div>
		          </div>

		          <div class="form-group row">
		            <div class="col-md-6">
		              <label for="ccyear">New messages notification:</label>
		              <select class="form-control" name="confirmOnAllMessages" id="pluginTypeSelector" style="width:75%;">
							<option  value="1" $zchkd>Always </option>
							<option  value="0" $alchkd>Once</option>
							<option  value="2" $ochkd>Never</option>
						</select>
		            </div>
		          </div>
                    <div class="row col-md-4" style="">
                       <input type="submit" value="Update Settings" class="btn btn-primary">
                    </div>
                    </form>
                </div>
                </div>
              </div>

EOD;

} else {
	configeditor(array('mobile_settings' => $_POST));
	header("Location:?module=dashboard&action=loadthemetype&type=layout&name=mobile");
}
