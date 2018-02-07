<?php
/*
CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license
*/

if (!defined('CCADMIN')) { echo "NO DICE"; exit; }

function index() {
	global $body, $navigation, $ts, $currentversion, $writable, $client, $customjs, $customcss;
	$restoreurl = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$restoreurl = substr($restoreurl,0, strpos($restoreurl, '?')).'update/restore.php';
	$restoreurl = str_replace('index.php', '', $restoreurl);
	$integrationbtn = '';
	$warning = '';
	$text = '';
	$op1 = $op2 = $op3 = '';
	$isenabled = 0;
	$file = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'integration.php';
	if (isset($_POST['text'])){
		$type = $_POST['hiddenfield'];
		if($type != 'integration'){
			configeditor(array($type => $_POST['text']));
			$text = $_POST['text'];
			$_SESSION['cometchat']['error'] = 'File saved successfully.';
		}elseif(is_writable($file) && empty($client)){
			file_put_contents($file, $_POST['text']);
			$text = file_get_contents($file);
			$_SESSION['cometchat']['error'] = 'File saved successfully.';
		}else{
			$_SESSION['cometchat']['type'] = 'alert';
			$_SESSION['cometchat']['error'] = 'File not saved, permission denied.';
		}
		clearcache(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'writable'.DIRECTORY_SEPARATOR.$writable);
	}
	if(!empty($_REQUEST['customjs'])){
		if(!empty($customjs) && empty($_POST['text'])){
			$text = $customjs;
		}
		$url = '?module=editor&customjs=1&ts='.$ts;
		$filename = 'Custom JavaScript';
		$op2 = 'selected';
		$active_id = 'editor_extrajs';
		$hiddenfield = '<input type="hidden" name="hiddenfield" value="customjs"/>';
	}	elseif(!empty($_REQUEST['customcss'])){
		if(!empty($customcss) && empty($_POST['text'])){
			$text = $customcss;
		}
		$url = '?module=editor&customcss=1&ts='.$ts;
		$filename = 'Custom CSS';
		$active_id = 'editor_extracss';
		$op3 = 'selected';
		$hiddenfield = '<input type="hidden" name="hiddenfield" value="customcss"/>';
	}else{
		if(!empty($client)) {
			header("Location: ?module=editor&customjs=1&ts=".$ts);
			exit;
		}

		$url = '?module=editor&ts='.$ts;
		$filename = 'Integration File';
		$active_id = 'editor_integration';
		$op1 = 'selected';
		$hiddenfield = '<input type="hidden" name="hiddenfield" value="integration"/> ';
		$integrationbtn = '<button style="float:right;" class="btn btn-primary" id="restorebtn">Restore to default</button>
					      <button style="float:right;margin-right:5px;" class="btn btn-primary" id="backupbtn">Backup this copy</button>';
		$warning = <<<EOD
      	<div class="note note-success">
            Kindly copy the following URL <span style="color:blue;word-wrap: break-word;">{$restoreurl}</span> before you make changes to this "integration.php" file, which will help you go to previous version of this file. This is important, because if the site does not load post making changes then you can easily restore it from this URL.
        </div>
EOD;
		$text = file_get_contents($file);
		if(!file_exists(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'writable'.DIRECTORY_SEPARATOR.'backup'.DIRECTORY_SEPARATOR.'integration.bak')){
			$dir = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'writable'.DIRECTORY_SEPARATOR.'backup';
			if(!is_dir($dir)){
				mkdir($dir);
			}
			file_put_contents(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'writable'.DIRECTORY_SEPARATOR.'backup'.DIRECTORY_SEPARATOR.'integration.bak', $text);
		}
}
if(empty($client)) {
	$addintegration = "<option ".$op1." value=''>Integration</option>";
}

$body = <<<EOD
	<script>
		jQuery(function() {
			$(".midmenu").removeClass('active_setting');
			$("#{$active_id}").addClass('active_setting');
			$(".codeEditor").linedtextarea({selectedLine: 1});
			$(".codeEditor").blur(function(){
				$(".linedwrap").css('box-shadow','inset 0 0 ');
			});
			var winHt = $(window).height();
			$('.codeEditor').height(winHt - 305);
			$('.linedwrap').height(winHt - 300);
			$('.lines').height(winHt - 300);

			$(window).resize(function(){
				var winHt = $(window).height();
				$('.codeEditor').height(winHt - 305);
				$('.linedwrap').height(winHt - 300);
				$('.lines').height(winHt - 300);
			});
			$("#restorebtn").click(function(){
				var confirmation = confirm('Are you sure you wish to restore this with backup copy?');
				if(confirmation == true){
					$.ajax({
						url: 'update/restore.php',
						type: 'get',
						success: function(data){
							window.location.href = '?module=editor';
						}
					});
				}
			});
			$("#backupbtn").click(function(){
				var confirmation = confirm('Are you sure you wish to backup this copy?');
				if (confirmation == true) {
					$.ajax({
						url: 'update/restore.php',
						data: {'backup':true},
						type: 'get',
						success: function(data){
							window.location.href = '?module=editor';
						}
					});
				}
			});
			$(".lineno").removeClass('lineselect');
		});
		function submit_form(){
			var confirmation = confirm('Are you sure you wish to save this file?');
			if (confirmation == true) {
				$('#editsubmit').submit();
			}
		}
	</script>
	<div class="row">
	  <div class="col-sm-12 col-lg-12">
	  	<div class="row">
		  	<div class="col-sm-12 col-lg-12">
			    <div class="card">
			      	<div class="card-header">
			        	{$filename}
			        	<select onchange="window.location='?module=editor'+this.value+'&ts={$ts}'" class="form-control" style="width:200px;float:right;">
				        	{$addintegration}
				        	<option {$op2} value="&customjs=1">Custom JavaScript</option>
				        	<option {$op3} value="&customcss=1">Custom CSS</option>
			        	</select>
			      	</div>
			      	<div class="card-block">
			      		{$warning}
			      	<form action="" method="post" id="editsubmit" >
				      	<div id="windowcontainer"  style="min-height:200px;">
							<textarea row="45" id="editortext" class="codeEditor" name="text">$text</textarea>
						</div>
						{$hiddenfield}
						<div class="row col-md-12"><br>
					      <input type="button" value="Save" id="savebtn" class="btn btn-primary" onclick="submit_form()"/>
					    	$integrationbtn
					    </div>
					</form>
		            </div>
		    	</div>
		  	</div>
		</div>
	  </div>
	</div>
EOD;

template();
}
