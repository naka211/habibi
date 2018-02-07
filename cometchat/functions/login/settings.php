<?php

/*

CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license

*/

if (!defined('CCADMIN')) { echo "NO DICE"; exit; }
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php');
$base_url = BASE_URL;
$option = $_GET['option'];
if (empty($_GET['process'])) {

	if(isset($option) && $option=='Google'){
		$data = <<<EOD
	        <div class="form-group row">
		        <div class="col-md-6">
		          <label for="ccyear">Google API key:</label>
		        </div>
		         <div class="col-md-6">
		              <input class="form-control" style="width:75%;" type="text"  name="googleKey" value="$googleKey">
		        </div>
	      	</div>
	        <div class="form-group row">
		        <div class="col-md-6">
		          <label for="ccyear">Google API Secret Key:</label>
		        </div>
		         <div class="col-md-6">
		              <input class="form-control" style="width:75%;" type="text"  name="googleSecret" value="$googleSecret">
		        </div>
	      	</div>
EOD;

	}else if(isset($option) && $option=='Facebook'){
		$data = <<<EOD
	        <div class="form-group row">
		        <div class="col-md-6">
		          <label for="ccyear">Facebook API key:</label>
		        </div>
		         <div class="col-md-6">
		              <input class="form-control" style="width:75%;" type="text"  name="facebookKey" value="$facebookKey">
		        </div>
	      	</div>
	        <div class="form-group row">
		        <div class="col-md-6">
		          <label for="ccyear">Facebook API Secret Key:</label>
		        </div>
		         <div class="col-md-6">
		              <input class="form-control" style="width:75%;" type="text"  name="facebookSecret" value="$facebookSecret">
		        </div>
	      	</div>
EOD;
	}else if(isset($option) && $option=='Twitter'){
		$data = <<<EOD
	        <div class="form-group row">
		        <div class="col-md-6">
		          <label for="ccyear">Twitter API key:</label>
		        </div>
		         <div class="col-md-6">
		              <input class="form-control" style="width:75%;" type="text"  name="twitterKey" value="$twitterKey">
		        </div>
	      	</div>
	        <div class="form-group row">
		        <div class="col-md-6">
		          <label for="ccyear">Twitter API Secret Key:</label>
		        </div>
		         <div class="col-md-6">
		              <input class="form-control" style="width:75%;" type="text"  name="twitterSecret" value="$twitterSecret">
		        </div>
	      	</div>
EOD;
	}
echo <<<EOD
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" href="images/favicon.ico">
  <title>Setting</title>
  <link href="{$base_url}/css.php?admin=1" rel="stylesheet">
  <script src="{$base_url}/js.php?admin=1"></script>
</head>
 <body class="navbar-fixed sidebar-nav fixed-nav" style="background-color: white;overflow-y:hidden;">
             <div class="col-sm-6 col-lg-6">
                <div class="card">
                <div class="card-block">
                 <form action="?module=dashboard&action=loadexternal&type=function&name=login&option={$option}&process=true" method="post">

                 	<div class="note note-success">Please enter your {$option} application details below.</div>
						$data
                    <div class="row col-md-4" style="">
                       <input type="submit" value="Update Settings" class="btn btn-primary">
                    </div>
                    </form>
                </div>
                </div>
              </div>
EOD;
} else {
	$auth_mode = $option;
	configeditor($_POST);
	header("Location:?module=dashboard&action=loadexternal&type=function&name=login&option=".$auth_mode);
}
