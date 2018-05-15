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


$cometchat_messages_old = "cometchat_messages_old_".time();
$force = 1;
if($force == 0){
	$body = "<div id='install_success' style='color:red;font-size:14px;'><strong>Installation could not be proceed.</strong></div><br/>$extra";
}else	{
	$body = "<div id='install_success'><strong>Installation complete. Please <a href='".$baseurl."admin/' style='color:#1E90FF'>click here </a> to login to the CometChat Administration Panel</strong></div>";
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
