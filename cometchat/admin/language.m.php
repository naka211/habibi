<?php

/*

CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license

*/

if (!defined('CCADMIN')) { echo "NO DICE"; exit; }

function index() {
	global $body;
	global $languages;
	global $lang;
    global $ts;
    global $dbh;

    $sql = ("select distinct `code` from `cometchat_languages`");
    $query = mysqli_query($dbh,$sql);

    $languages = '';
	$no = 0;
	$activelanguages = '';
    while ($language = mysqli_fetch_assoc($query)) {
    	$code = $language['code'];
    	$default = '';
		$opacity = '0.5;cursor:default;';
		$titlemakedefault = 'title="Make language default"';
		$setdefault = 'onclick="javascript:language_makedefault(\''.$code.'\')"';
		$removelanguage = '<a style="color:red;" data-toggle="tooltip" title="Remove Language" href="javascript:void(0)" onclick="javascript:language_removelanguage(\''.$code.'\')"><i class="fa fa-lg fa-minus-circle"></i></a>';
		if (strtolower($lang) == strtolower($code)) {
			$default = ' (Active)';
			$opacity = $titlemakedefault = '';
			$setdefault = '';
			$removelanguage = '';
		}
		++$no;
		$activelanguages .= '<tr id="'.$no.'" d1="'.$code.'"><td id="'.$code.'_title">'.$code.$default.'</td><td><a data-toggle="tooltip" style="color:#000000;opacity:'.$opacity.';" '.$titlemakedefault.' href="javascript:void(0)" '.$setdefault.'><i class="fa fa-lg fa-star"></i></a></td><td><a style="text-decoration:none;color:#000000;" data-toggle="tooltip" title="Edit Language" href="?module=language&amp;action=editlanguage&amp;data='.$code.'&amp;ts='.$ts.'"<i class="fa fa-lg fa-cogs"></i></a></td><td>'.$removelanguage.'</td></tr>';
    }

$body .= <<<EOD
<div class="row">
	<div class="col-sm-6 col-lg-6">
	  	<div class="row">
		  	<div class="col-sm-12 col-lg-12">
			    <div class="card">
					<div class="card-header">
						Languages
					</div>
					<div class="card-block">
			        <table class="table">
			          <thead>
			            <tr>
			              <th width="70%">Languages</th>
			              <th width="5%">&nbsp;</th>
			              <th width="5%">&nbsp;</th>
			              <th width="5%">&nbsp;</th>
			            </tr>
			          </thead>
			          <tbody>
			          {$activelanguages}
			          </tbody>
			        </table>
			    	</div>
			    </div>
			</div>
	  	 	<div class="col-sm-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						Add New Language
					</div>

					<div class="card-block">
						<form action="?module=language&action=createlanguageprocess&ts={$ts}" method="post" enctype="multipart/form-data">

				      		<div class="form-group row">
								<div class="col-md-12">
									<label class="form-control-label">Enter the first two letters of your new language:</label>
									<input type="text" class="form-control" name="lang" maxlength=2 required="true"/>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-12">
						     		<input type="submit" value="Save"  class="btn btn-primary">
						    	</div>
						    </div>

						</form>
					</div>
				</div>
		  </div>
		</div>
	</div>
  	<div class="col-sm-6 col-lg-6">
  		<div class="row">
		  	<div class="col-sm-12 col-lg-12">
			    <div class="card">
				    <div class="card-header">
				    	Language
				    </div>
				    <div class="card-block">
			       	<table class="table">
			          <thead>
			            <tr>
			              <th width="80%">Languages</th>
			              <th width="5%">&nbsp;</th>
			              <th width="5%">&nbsp;</th>
			            </tr>
			          </thead>
			          <tbody id="modules_livelanguage">
			          <tr><td colspan="3" align="center" style="font-size:20px;"><img src="images/simpleloading.gif" height="100" width ="100" /></td></tr>
			          </tbody>
			        </table>
			    	</div>
			    </div>
		  	</div>
		</div>
	</div>
</div>
<script>
	$(function() { language_getlanguages(); });
	$("body").prepend('<div id = "over" ><div id ="loadingimage" ><img src="images/loading.gif" height="100" width ="100" /></div></div>');
</script>
	<style type="text/css">
		#loadingimage{
		    top: 45%;
    		left: 45%;
    		position: fixed;
		}
		#over{
			z-index: 1000001;
			background-color:black;
			opacity:0.7;
			position: fixed;
    		left: 0px;
    		height:100%;
    		width:100%;
    		display:none;
		}
	</style>
EOD;

	template();

}

function makedefault() {

	if (!empty($_POST['lang'])) {
		configeditor($_POST);
	}
	$_SESSION['cometchat']['error'] = 'Language details updated successfully';

	echo "1";

}

function removelanguageprocess() {
    global $ts;
    global $dbh;
    global $client;

	$lang = $_GET['data'];

	if ($lang != 'en') {
		$sql = ("delete from `cometchat_languages` where `code` = '".mysqli_real_escape_string($dbh,$lang)."'");
		mysqli_query($dbh,$sql);
		removeCachedSettings($client.'cometchat_language');
		$_SESSION['cometchat']['error'] = 'Language deleted successfully';
	} else {
		$_SESSION['cometchat']['error'] = 'Sorry, this language cannot be deleted.';
	}

	header("Location:?module=language&ts={$ts}");


}

function editlanguage() {
	global $body, $rtl, $languages;
	$plugins_core    = setConfigValue('plugins_core',array());
	$extensions_core = setConfigValue('extensions_core',array());
	$modules_core 	 = setConfigValue('modules_core',array());
	$data ='';

	$lang = $_GET['data'];

	if(empty($data)){
		$rtly = "";
		$rtln = "";

		if ($rtl == 1) {
			$rtly = "checked";
		} else {
			$rtln = "checked";
		}
		$data .='<div class="form-group row"><label class="col-md-2 form-control-label">Right to left text:</label><div class="col-md-4"><label class="radio-inline" for="inline-radio1"><input type="radio" id="rtl" lang_key = "rtl" name="rtl" value="1" '.$rtly.' onchange="javascript:language_updatelanguage($(this));" code="'.$lang.'" addontype="core" addonname="default">&nbsp;Yes&nbsp;&nbsp;</label><label class="radio-inline" for="inline-radio2"><input id="rtl" type="radio" '.$rtln.' name="rtl" lang_key = "rtl" value="0" onchange="javascript:language_updatelanguage($(this));" code="'.$lang.'" addontype="core" addonname="default">&nbsp;No</label></div></div>';
	}

	if(file_exists(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'lang.php')) {
		$array = 'language';
		global $$array;
		include_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'lang.php');
		$$array = setNewLanguageValue($$array,$lang,'core','default');
		$x = 0;
		$data .= '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a style="display:block;" data-toggle="collapse" data-parent="#accordion" href="#collapse'.md5('').'">Core</a></h4></div>';
		$data .= '<div id="collapse'.md5('').'" class="panel-collapse collapse"><div class="panel-body">';
		foreach ($$array as $key => $value) {
			$x++;
		$value = stripslashes($value);
		$data .= <<<EOD
          <div class="form-group row">
            <div class="col-md-12">
               <label class="form-control-label">
                {$x}.
              </label>
              <textarea id="textarea_{$lang}_core_default_{$key}" lang_key = "{$key}" code="{$lang}" addontype="core" addonname="default"  rows="2" class="form-control">{$value}</textarea>
			</div>
            <div class="col-md-12"><br>
				<input type="button" onclick="javascript:language_updatelanguage($(this));" value="Update" class="btn btn-primary">
            </div>
          </div>
EOD;
		}
		$data.='</div></div></div>';
	}

	$addontypes = array('modules','plugins','extensions');
	foreach($addontypes as $addon_type){
		foreach (${$addon_type."_core"} as $addon => $addondata) {
			if(file_exists(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.$addon_type.DIRECTORY_SEPARATOR.$addon.DIRECTORY_SEPARATOR.'lang.php')){
				include_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.$addon_type.DIRECTORY_SEPARATOR.$addon.DIRECTORY_SEPARATOR.'lang.php');
				$array = $addon.'_language';
				$title = ucfirst($addon);
				$title = ($title == 'Writeboard') ? 'Share collaborative document' :  $title;
        		$title = ($title == 'Whiteboard') ? 'Share Whiteboard document' :  $title;
        		$title = ($title == 'Chatrooms') ? 'Groups' :  $title;
				$$array = setNewLanguageValue($$array,$lang,rtrim($addon_type,'s'),$addon);
				$data .= '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a style="display:block;text-transform:capitalize;" data-toggle="collapse" data-parent="#accordion" href="#collapse'.md5($addon).'">'.$title.'</a></h4></div>';
				$data .= '<div id="collapse'.md5($addon).'" class="panel-collapse collapse"><div class="panel-body">';
				$x = 0;
				foreach (${$array} as $key => $value) {
					$x++;
					$addon_type_r = rtrim($addon_type,'s');
					$value = stripslashes($value);
				$data .= <<<EOD
		          <div class="form-group row">
		            <div class="col-md-12">
		               <label class="form-control-label">
		                {$x}.
		              </label>
		              <textarea id="textarea_{$lang}_{$addon_type}_{$addon}_{$key}" lang_key = "{$key}" code="{$lang}" addontype="{$addon_type_r}" addonname="{$addon}"  rows="2" class="form-control">{$value}</textarea>
					</div>
		            <div class="col-md-12"><br>
						<input type="button" onclick="javascript:language_updatelanguage($(this));" value="Update" class="btn btn-primary">
		            </div>
		          </div>
EOD;
				}
				$data.='</div></div></div>';
			}else{
				unset(${$addon_type."_core"}[$addon]);
			}
		}
	}

$body = <<<EOD
<div class="row">
	<div class="col-sm-12 col-lg-12">
    <div class="card">
      <div class="card-header">
        Edit Language- {$lang}
      </div>
	<div class="card-block">
	<div class="panel-group" id="accordion">
	{$data}
    <!--div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Core</a>
        </h4>
      </div>
      <div id="collapse1" class="panel-collapse collapse in">
        <div class="panel-body">
	        <div class="form-group row">
	        	<span style="float:left;padding-left:5px;">1.</span>
		        <div class="col-md-4">
		          <textarea id="textarea-input" name="core" rows="3" class="form-control" placeholder="Type your announcement here..."></textarea>
		        </div>
		        <div class="col-md-4">
		        	<input type="submit" value="UPDATE" class="btn btn-primary">
		        </div>
	      	</div>
	      	<div class="form-group row">
	      		<span style="float:left;padding-left:5px;">2.</span>
		        <div class="col-md-4">
		          <textarea id="textarea-input" name="core" rows="3" class="form-control" placeholder="Type your announcement here..."></textarea>
		        </div>
		        <div class="col-md-4">
		        	<input type="submit" value="UPDATE" class="btn btn-primary">
		        </div>
	      	</div>
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Module</a>
        </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
        <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
        sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Chatrooms</a>
        </h4>
      </div>
      <div id="collapse3" class="panel-collapse collapse">
        <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
        sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
      </div>
    </div>
  </div>
</div-->
    </div>
  	</div>
</div>

EOD;


	template();

}

function editlanguageprocess() {
	if(isset($_POST)){
		languageeditor($_POST);
	}
	echo "1";
	exit;
}

function restorelanguageprocess() {

	$lang = $_POST['lang'];

	if (!empty($_POST['id'])) {
		$_POST['id'] .= '/';
	}

	$file = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.$_POST['id'].'lang'.DIRECTORY_SEPARATOR.'en.bak';
	$fh = fopen($file, 'r');
	$restoredata = fread($fh, filesize($file));
	fclose($fh);

	$file = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.$_POST['id'].'lang'.DIRECTORY_SEPARATOR.strtolower($lang).".php";
	$fh = fopen($file, 'w');
	if (fwrite($fh, $restoredata) === FALSE) {
			echo "Cannot write to file ($file)";
			exit;
	}
	fclose($fh);
	chmod($file, 0777);

	$_SESSION['cometchat']['error'] = 'Language has been restored successfully.';

	echo "1";
	exit;
}

function createlanguage() {
	global $body;
	global $navigation;
    global $ts;

	$body = <<<EOD
	$navigation
	<form action="?module=language&action=createlanguageprocess&ts={$ts}" method="post" enctype="multipart/form-data">
	<div id="rightcontent" style="float:left;width:720px;border-left:1px dotted #ccc;padding-left:20px;">
		<h2>Create new language</h2>
		<h3>Enter the first two letters of your new language.</h3>
		<div>
			<div id="centernav">
				<div class="title">Language:</div><div class="element"><input type="text" class="inputbox" name="lang" maxlength=2 required="true"/></div>
				<div style="clear:both;padding:10px;"></div>
			</div>
		</div>

		<div style="clear:both;padding:7.5px;"></div>
		<input type="submit" value="Add language" class="button">&nbsp;&nbsp;or <a href="?module=language&amp;ts={$ts}">cancel</a>
	</div>

	<div style="clear:both"></div>

	<script type="text/javascript">
		$(function() {
			$("#leftnav").find('a').removeClass('active_setting');
			$("#new_langs").addClass('active_setting');
		});
	</script>

EOD;

	template();

}

function createlanguageprocess() {
    global $ts;
    global $languages;

    if(empty($languages[$_POST['lang']]['core']['default']['rtl'])){
    	$new_lang = array('lang_key' 	=> 'rtl',
    					  'lang_text' 	=> '0',
    					  'code' 		=> $_POST['lang'],
    					  'type' 		=> 'core',
    					  'name' 		=> 'default');
    	languageeditor($new_lang);
    	$_SESSION['cometchat']['error'] = 'New language added successfully';
    }else{
		$_SESSION['cometchat']['error'] = 'Language already exists. Please remove it and then try again.';
	}
	header("Location:?module=language&ts={$ts}");
}

function getlanguage($lang) {
	global $dbh;
	$sql = 'select * from `cometchat_languages` where `code` = "'.mysqli_real_escape_string($dbh,$lang).'" order by `type` asc, `name` asc';
	$query = mysqli_query($GLOBALS['dbh'],$sql);

	while ($lang = mysqli_fetch_assoc($query)) {
		if(empty($languages[$lang['code']])){
			$languages[$lang['code']] = array();
		}
		if(empty($languages[$lang['code']][$lang['type']])){
			$languages[$lang['code']][$lang['type']] = array();
		}
		if(empty($languages[$lang['code']][$lang['type']][$lang['name']])){
			$languages[$lang['code']][$lang['type']][$lang['name']] = array();
		}
		$languages[$lang['code']][$lang['type']][$lang['name']][$lang['lang_key']] = $lang['lang_text'];
	}

	return serialize($languages);
}

function additionallanguages() {
	global $body;
	global $navigation;
    global $ts;

	$body = <<<EOD
	$navigation
	<form action="?module=language&action=updatelanguage&ts={$ts}" method="post">
	<div id="rightcontent" style="float:left;width:720px;border-left:1px dotted #ccc;padding-left:20px;">
		<h2>Additional Languages</h2>
		<h3>Official languages available from CometChat. If your language is not in the list below, you can create your own.</h3>

		<div>
			<div id="centernav">
				<div style="clear:both;">
					<ul id="modules_livelanguage">

					</ul>
				</div>
			</div>



			</div>
		</div>

		<div id = "over" ><div id ="loadingimage" ><img src="images/loading.gif" height="100" width ="100" /></div></div>
	<div style="clear:both"></div>
	</form>
	<script>
		$(function() { language_getlanguages(); });
	</script>
	<script type="text/javascript">
		$(function() {
			$("#leftnav").find('a').removeClass('active_setting');
			$("#additional_langs").addClass('active_setting');
		});
	</script>
	<style type="text/css">
		#loadingimage{
		    top: 45%;
    		left: 45%;
    		position: fixed;
		}
		#over{
			z-index: 1000001;
			background-color:black;
			opacity:0.7;
			position: fixed;
    		left: 0px;
    		height:100%;
    		width:100%;
    		display:none;
		}
	</style>

EOD;

	template();

}

function mb_unserialize_part($m){
    $len = strlen($m[2]);
    $result = "s:$len:\"{$m[2]}\";";
    return $result;
}

function mb_unserialize($string) {
    $string2 = preg_replace_callback('!s:(\d+):"(.*?)";!s','mb_unserialize_part',$string);
    return unserialize($string2);
}

function previewlanguage() {
	if (!empty($_POST['data'])) {
		$langdata = mb_unserialize($_POST['data']['data']);
		foreach ($langdata as $code => $addon) {
			foreach ($addon as $addon_type => $addondata) {
				foreach ($addondata as $addon_name => $addonvalue) {
					if($addon_name == 'default'){
						$addon_name = 'core';
					}
					$x = 0;
					echo "\n-- ";
					echo $addon_name;
					echo " ----------------------\r\n\n";
					foreach ($addonvalue as $key => $value) {
						if($key!='rtl'){
							$x++;
							$d = $x.".".$value."\n";
							echo $d;
						}
					}
				}
			}
		}
	}
}

function importlanguage(){
	global $client;
	if(!empty($_POST['data'])){
		$newlanguage = mb_unserialize($_POST['data']['data']);
		$sql="";
		$cumulative_rows = 0;
		foreach($newlanguage as $code => $langdata){
			foreach($langdata as $type => $addondata){
				foreach($addondata as $name => $lang_keys){
					foreach($lang_keys as $lang_key => $lang_text){
						$sql .= ("insert into `cometchat_languages` set `lang_key` = '".mysqli_real_escape_string($GLOBALS['dbh'],$lang_key)."', `lang_text` = '".mysqli_real_escape_string($GLOBALS['dbh'],$lang_text)."', `code` = '".mysqli_real_escape_string($GLOBALS['dbh'],$code)."', `type` = '".mysqli_real_escape_string($GLOBALS['dbh'],$type)."', `name` = '".mysqli_real_escape_string($GLOBALS['dbh'],$name)."' on duplicate key update `lang_key` = '".mysqli_real_escape_string($GLOBALS['dbh'],$lang_key)."', `lang_text` = '".mysqli_real_escape_string($GLOBALS['dbh'],$lang_text)."', `code` = '".mysqli_real_escape_string($GLOBALS['dbh'],$code)."', `type` = '".mysqli_real_escape_string($GLOBALS['dbh'],$type)."', `name` = '".mysqli_real_escape_string($GLOBALS['dbh'],$name)."';");
					}
				}
			}
		}
		if(mysqli_multi_query($GLOBALS['dbh'],$sql)){
		    do{
		    	$cumulative_rows+=mysqli_affected_rows($GLOBALS['dbh']);
		    }while(mysqli_more_results($GLOBALS['dbh']) && mysqli_next_result($GLOBALS['dbh']));
		}
		removeCachedSettings($client.'cometchat_language');
	}
	echo "1";
}

function uploadlanguage() {
	global $body;
	global $navigation;
    global $ts;

	$body = <<<EOD
	$navigation
	<form action="?module=language&action=uploadlanguageprocess&ts={$ts}" method="post" enctype="multipart/form-data">
	<div id="rightcontent" style="float:left;width:720px;border-left:1px dotted #ccc;padding-left:20px;">
		<h2>Upload new language</h2>
		<h3>Have you downloaded a new CometChat language? Upload only the .lng file e.g. "en.lng".</h3>

		<div>
			<div id="centernav">
				<div class="title">Language:</div><div class="element"><input type="file" class="inputbox" name="file"></div>
				<div style="clear:both;padding:10px;"></div>
			</div>

		</div>

		<div style="clear:both;padding:7.5px;"></div>
		<input type="submit" id="uploadlang" value="Add language" class="button">&nbsp;&nbsp;or <a href="?module=language&amp;ts={$ts}">cancel</a>
	</div>
	<div id = "over" ><div id ="loadingimage" ><img src="images/loading.gif" height="100" width ="100" /></div></div>
	<div style="clear:both"></div>

	<script type="text/javascript">
		$(function() {
			$("#leftnav").find('a').removeClass('active_setting');
			$("#upload_langs").addClass('active_setting');
		});
		$(function() {
			$("#uploadlang").click(function(){
				$("#over").show();
			});
		});
	</script>

	<style type="text/css">
		#loadingimage{
		    top: 45%;
    		left: 45%;
    		position: fixed;
		}
		#over{
			z-index: 1000001;
			background-color:black;
			opacity:0.7;
			position: fixed;
    		left: 0px;
    		height:100%;
    		width:100%;
    		display:none;
		}
	</style>


EOD;

	template();

}

function uploadlanguageprocess() {
    global $ts;
    global $dbh;
    global $client;
    $sql="";
    $cumulative_rows = 0;

	$error = '';
	if (!empty($_FILES["file"]["size"])) {
		if ($_FILES["file"]["error"] > 0) {
			$error = "Language corrupted. Please try again.";
		} else {
			if($newlanguage = mb_unserialize(file_get_contents($_FILES['file']['tmp_name']))){
				$sql="";
				$cumulative_rows = 0;
			    foreach($newlanguage as $code => $langdata){
					foreach($langdata as $type => $addondata){
						foreach($addondata as $name => $lang_keys){
							foreach($lang_keys as $lang_key => $lang_text){
								$sql .= ("insert into `cometchat_languages` set `lang_key` = '".mysqli_real_escape_string($dbh,$lang_key)."', `lang_text` = '".mysqli_real_escape_string($dbh,$lang_text)."', `code` = '".mysqli_real_escape_string($dbh,$code)."', `type` = '".mysqli_real_escape_string($dbh,$type)."', `name` = '".mysqli_real_escape_string($dbh,$name)."' on duplicate key update `lang_key` = '".mysqli_real_escape_string($dbh,$lang_key)."', `lang_text` = '".mysqli_real_escape_string($dbh,$lang_text)."', `code` = '".mysqli_real_escape_string($dbh,$code)."', `type` = '".mysqli_real_escape_string($dbh,$type)."', `name` = '".mysqli_real_escape_string($dbh,$name)."';");
							}
						}
					}
				}
				if(mysqli_multi_query($GLOBALS['dbh'],$sql)){
				    do{
				    	$cumulative_rows+=mysqli_affected_rows($GLOBALS['dbh']);
				    }while(mysqli_more_results($GLOBALS['dbh']) && mysqli_next_result($GLOBALS['dbh']));
				}
			}else{
				$error = "Invalid language file.";
			}
		}
	} else {
		$error = "Language not found. Please try again.";
	}

	if (!empty($error)) {
		$_SESSION['cometchat']['error'] = $error;
		header("Location: ?module=language&action=uploadlanguage&ts={$ts}");
		exit;
	}

	$_SESSION['cometchat']['error'] = 'Language added successfully';
	removeCachedSettings($client.'cometchat_language');
	header("Location: ?module=language&ts={$ts}");
	exit;
}

function exportlanguage() {

	$lang = $_GET['data'];

	$data = getlanguage($lang);

	header('Content-Description: File Transfer');
	header('Content-Type: application/force-download');
	header('Content-Disposition: attachment; filename='.$lang.'.lng');
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	if (ob_get_contents()) ob_end_clean();
	flush();
	echo ($data);

}
