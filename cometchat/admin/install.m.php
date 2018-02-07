<?php

/*

CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license

*/

if (!defined('CCADMIN')) { echo "NO DICE"; exit; }

function index() {
	global $body,$color_original,$theme_original,$ts,$client,$availableIntegrations,$cms,$login_url,$logout_url,$protocol,$pluginkey;
	$addcometchat = '';
    $athemes = array();

	if ($handle = opendir(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'layouts')) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != ".." && $file != "base" && $file !="mobile" && is_dir(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'layouts'.DIRECTORY_SEPARATOR.$file) && file_exists(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'layouts'.DIRECTORY_SEPARATOR.$file.DIRECTORY_SEPARATOR.'config.php')) {
				if($file == 'embedded' || $file == 'docked') {
					$athemes[] = $file;
				}
			}
		}
		closedir($handle);
	}
	asort($athemes);
	array_push($athemes, "mobile");

	$activethemes = '';
	$no = 0;

	foreach ($athemes as $ti) {
		$title = ucwords($ti);
		++$no;
		$default = '';
		$opacity = '0.5';
		$setdefault = '';

		if (strtolower($theme_original) == strtolower($ti)) {
			$opacity = '1;cursor:default';
			$setdefault = '';
        }

        if (strtolower($ti) == 'mobile' || strtolower($ti) == 'synergy' || strtolower($ti) == 'embedded') {
			$Default = ' (Default)';
			$opacity = '1;cursor:default';
			$setdefault = '';
		}

		if(strtolower($ti) == 'embedded'){
			$default = '';
		}

		if (strtolower($ti) == 'embedded'){
			$activethemes .= '<tr><td id="'.$no.'" d1="'.$ti.'">'.stripslashes($title).$default.'</td><td><a style="color:black;" data-toggle="tooltip" title="Generate Embed Code"  href="javascript:void(0)" onclick="javascript:themetype_embedcode(\''.$ti.'\')" ><i class="fa fa-lg fa-code"></i></a></td><td><a href="../cometchat_embedded.php" target="_blank" data-toggle="tooltip" title="Direct link to Embedded" style="color:black;"><i class="fa fa-lg fa-external-link-square"></i></a></td></tr>';
		}else if(strtolower($ti) == 'docked'){
			$activethemes .= '<tr><td id="'.$no.'" d1="'.$ti.'">'.stripslashes($title).$default.'</td><td><a style="color:black;" data-toggle="tooltip" title="Generate Footer Code" href="javascript:void(0)" onclick="javascript:themetype_embedcode(\''.$ti.'\')"><i class="fa fa-lg fa-code"></i></a></td><td></td></tr>';
		} else {
			$activethemes .= '<tr><td id="'.$no.'" d1="'.$ti.'">'.stripslashes($title).$default.'</td><td></td><td><a data-toggle="tooltip" title="Edit '.$title.'" href="javascript:void(0)" onclick="javascript:themetype_configmodule(\''.$ti.'\')" style="color:black;"><i class="fa fa-lg fa-edit"></i></a></td></tr>';
		}
	}

	if(!empty($client)) {
		$code =	$options = $site_url = $httpsy = $httpsn = '';

	    if(defined('CC_SITE_URL')) {
	    	$site_url = CC_SITE_URL;
	    }
	    foreach ($availableIntegrations as $key => $value) {
	    	$selected = "";
			if($key==$cms){
				$selected = "selected";
			}
	    	$options .=  '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
	    }

		if (!empty($protocol) && $protocol == 'https:') {
			$httpsy = "checked";
		} else {
			$httpsn = "checked";
		}
		if(file_exists(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'cloud'.DIRECTORY_SEPARATOR.'addcometchat'.DIRECTORY_SEPARATOR.$cms.'.php')) {
			$code = include_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'cloud'.DIRECTORY_SEPARATOR.'addcometchat'.DIRECTORY_SEPARATOR.$cms.'.php');
		}
		$configure_vars = '';
		if(!empty($code)) {
			$configure_vars = '<div class="col-sm-6 col-lg-6">
				<div class="card">
					<div class="card-header">
						Configure CometChat
						<h4><small>Add the following code to your site template and update the variables below programmatically.</small></h4>
					</div>
					<div class="card-block">
						'.$code.'
					</div>
				</div>
			</div>';
		}

		$addcometchat = <<<EOD
		<div class="row">
		  	<div class="col-sm-12 col-lg-12">
		  		<div class="row">
		  			<div class="col-sm-6 col-lg-6">
					   	<div class="card">
					   		<div class="card-header">
					   			Add CometChat
					   			<h4><small>Update your domain and platform.</small></h4>
					   		</div>
					   		<div class="card-block">
					   			<form action="?module=install&action=saveplatform&ts={$ts}" method="post">
					   				<div class="form-group row">
					   					<div class="col-md-12">
					   						<label class="form-control-label">Site URL:</label>
					   						<div class="input-group">
					   							<span class="input-group-addon">http://</span>
					   							<input type="text" class="form-control" id = "site_url" value="{$site_url}" name="CC_SITE_URL" placeholder="yoursite.com">
					   						</div>
					   					</div>
					   				</div>

					   				<div class="form-group row">
					   					<div class="col-md-12">
					   						<label class="form-control-label">Login URL(Optional):</label>
					   						<input type="text" id= "logi_url" class="form-control" value="{$login_url}" name="MOBILE_URL" placeholder="yoursite.com/sign-In">
					   					</div>
					   				</div>

					   				<div class="form-group row">
					   					<div class="col-md-12">
					   						<label class="form-control-label">Logout URL(Optional):</label>
					   						<input type="text" id= "logout_url" class="form-control" value="{$logout_url}" name="MOBILE_LOGOUTURL" placeholder="yoursite.com/sign-Out">
					   					</div>
					   				</div>

					   				<div class="form-group row">
					   					<div class="col-md-12">
					   						<label class="form-control-label">Select Platform:</label>
					   						<select id="cms" name="cms" class="form-control">
					   							{$options}
					   						</select>
					   					</div>
					   				</div>

					   				<div class="form-group row">
					   					<div class="col-md-12">
					   						<label class="form-control-label">Does your site use https?</label>
					   						<div><label><div style="position:relative;"><input style="position: absolute;" type="radio" name="protocol" value="https:" $httpsy></div><span style="padding-left:25px;">Yes</span></label><label><div style="position:relative;"><input type="radio" style="position: absolute;left:8px;" name="protocol" value="http:" $httpsn></div><span style="padding-left:30px;">No</span></label></div>
					   					</div>
					   				</div>
					   				<div class="row col-md-10" style="padding-bottom:5px;"><br>
					   					<input type="submit" value="Update"  class="btn btn-primary">
					   				</div>
					   			</form>
					   		</div>
					   	</div>
					</div>
					{$configure_vars}
				</div>
			</div>
		</div>
EOD;
}

	$body .= <<<EOD
	{$addcometchat}
	<div class="row">
	  	<div class="col-sm-12 col-lg-12">
		    <div class="card">
		    	<div class="card-header">
		    		Install
		    	</div>
			    <div class="card-block">
			        <table class="table">
			          <thead>
			            <tr>
			              <th width="80%">Layouts</th>
			              <th width="5%">&nbsp;</th>
			              <th width="5%">&nbsp;</th>
			            </tr>
			          </thead>
			          <tbody>
			          {$activethemes}
			          </tbody>
			        </table>
			    </div>
		    </div>
		</div>
	</div>
EOD;

	template();
}

function saveplatform() {
	if (empty($GLOBALS['client'])) { header("Location:?module=dashboard&ts=".$GLOBALS['ts']); exit; }
	global $client;
	global $ts;

	if (!empty($_POST['CC_SITE_URL'])) {
		$domain = preg_replace('#^https?://#', '', rtrim($_POST['CC_SITE_URL'],'/'));
		$valid_domain = is_valid_domain_name($domain);
		if($valid_domain){
			$url = "http://my.cometchat.com/updatedomain2.php";
			$data = array('client' => $client,'domain' => $domain);
			fetchURL($url,$data);
			configeditor($_POST);
			$_SESSION['cometchat']['error'] = 'Domain & platform updated successfully';
			header("Location:?module=install&ts={$ts}");
		}else{
			$_SESSION['cometchat']['error'] = 'Invalid domain name. Note: IP address is not allowed';
			header("Location:?module=install&ts={$ts}");
		}
	}else{
		$_SESSION['cometchat']['error'] = 'Please enter a domain name';
		header("Location:?module=install&ts={$ts}");
	}
}

function is_valid_domain_name($domain_name){
	if (empty($GLOBALS['client'])) { header("Location:?module=dashboard&ts=".$GLOBALS['ts']); exit; }

	$domain_name = preg_replace('#((?:https?://)?[^/]*)(?:/.*)?$#', '$1', $domain_name);
	return preg_match("/^([a-z](-*[a-z0-9])*)(\.([a-z0-9](-*[a-z0-9])*))*$/i", $domain_name);
}
