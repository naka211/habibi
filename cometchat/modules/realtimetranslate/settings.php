<?php

/*

CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license

*/

if (!defined('CCADMIN')) { echo "NO DICE"; exit; }

if (empty($_GET['process'])) {
	$base_url  = BASE_URL;
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php');
	$dy = $dn = $errorMsg = '';
	$googleapi = $bingapi = '';
	if ($useGoogle == 1) {
		$dy = "checked";
	} else {
		$dn = "checked";
	}
	if(!checkcURL()) {
		$errorMsg = "<h2 id='errormsg' style='font-size: 14px; color: rgb(255, 0, 0);'>cURL extension is disabled on your server. Please contact your webhost to enable it. cURL is required for Translate Conversations.</h2>";
		$innercontent = ';display:none;"';
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
 <body class="navbar-fixed sidebar-nav fixed-nav" style="background-color: white;overflow-y:hidden;">
             <div class="col-sm-6 col-lg-6">
                <div class="card">
                <div class="card-block">
                 <form style="height:100%" action="?module=dashboard&action=loadexternal&type=module&name=realtimetranslate&process=true" method="post">
                 {$errorMsg}
                   <div class="form-group row">
		            <div class="col-md-6">
		            <div class="note note-success">
			           Please refer to our online <a href="https://support.cometchat.com/documentation/php/admin/modules/real-time-translate-2/" target="_blank">documentation</a> for information on how to setup this service.</div>
		            </div>
		          </div>

		          <div class="form-group row">
		            <div class="col-md-6">
		              <label for="ccyear">Use Google Translate API:</label>
		               <label class="">
			              <div style="position:relative;"><input style="position: absolute;" type="radio" type="radio" $dy name="useGoogle" value="1"></div><span style="padding-left:25px;">Yes</span>
			            </label>
		            </div>
		          </div>

		          <div class="form-group row">
		            <div class="col-md-6">
		              <label for="ccyear">Google Key:</label>
		            </div>
		             <div class="col-md-6">
		             <input type="text" class="form-control" name="googleKey" value="{$googleKey}" style="width:75%;">
		            </div>
		          </div>

		          <div class="form-group row">
		            <div class="col-md-6">
		              <label for="ccyear">Use Bing Translate API:</label>
		              <label class="">
			              <div style="position:relative;"><input style="position: absolute;" type="radio" type="radio" $dn name="useGoogle" value="0"></div><span style="padding-left:25px;">Yes</span>
			            </label>
		            </div>
		          </div>

		          <div class="form-group row">
		            <div class="col-md-6">
		              <label for="ccyear">Bing Client ID:</label>
		            </div>
		             <div class="col-md-6">
		             <input type="text" class="form-control" name="bingClientID" value="{$bingClientID}" style="width:75%;">
		            </div>
		          </div>
		          <div class="form-group row">
		            <div class="col-md-6">
		              <label for="ccyear">Bing Client Secret:</label>
		            </div>
		             <div class="col-md-6">
		             <input type="text" class="form-control" name="bingClientSecret" value="{$bingClientSecret}" style="width:75%;">
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
	configeditor($_POST);
	header("Location:?module=dashboard&action=loadexternal&type=module&name=realtimetranslate");
}
