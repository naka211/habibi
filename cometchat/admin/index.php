<?php

/*

CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license

*/
define('CCADMIN',true);

include_once (dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."config.php");
include_once (dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."cometchat_shared.php");
include_once (dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."php4functions.php");

if(!empty($client)) {
  if(file_exists(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'cloud'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'pubnub.php')) {
    include_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'cloud'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'pubnub.php');
  }
  if(file_exists(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'cloud'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'cloudfront.php')) {
    include_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'cloud'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'cloudfront.php');
  }
  if(file_exists(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'cloud'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'shared.php')) {
    include_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'cloud'.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'shared.php');
  }
}

$livesoftware = 'software';
if(!empty($_COOKIE['software-dev'])){
  $livesoftware = 'software-dev';
}
global $licensekey;
$marketplace = 0;
if(substr($licensekey, -2) == '-M'){
  $marketplace = 1;
}

$ts = time();
define('ADMIN_URL',BASE_URL.'admin/');
if(!session_id()){
  session_name('CCADMIN');
  @session_start();
}

if(get_magic_quotes_runtime()){
  set_magic_quotes_runtime(false);
}

include_once (dirname(__FILE__).DIRECTORY_SEPARATOR."shared.php");
function stripSlashesDeep($value){
  $value = is_array($value) ? array_map('stripSlashesDeep',$value) : stripslashes($value);
  return $value;
}

if(get_magic_quotes_gpc()||(defined('FORCE_MAGIC_QUOTES')&&FORCE_MAGIC_QUOTES==1)){
  $_GET = stripSlashesDeep($_GET);
  $_POST = stripSlashesDeep($_POST);
  $_COOKIE = stripSlashesDeep($_COOKIE);
}

cometchatDBConnect();
cometchatMemcacheConnect();

$usertable = TABLE_PREFIX.DB_USERTABLE;
$usertable_username = DB_USERTABLE_NAME;
$usertable_userid = DB_USERTABLE_USERID;

$body = '';
if (empty($client) && !empty($_POST['username']) && !empty($_POST['password'])) {
  if ($_POST['username'] == ADMIN_USER && (sha1($_POST['password']) == ADMIN_PASS || $_POST['password'] == ADMIN_PASS)){
    $_SESSION['cometchat']['cometchat_admin_user'] = $_POST['username'];
    if(sha1($_POST['password']) == ADMIN_PASS){
      $_SESSION['cometchat']['cometchat_admin_pass'] = sha1($_POST['password']);
    }else{
      $_SESSION['cometchat']['cometchat_admin_pass'] = $_POST['password'];
    }
  } else {
    $_SESSION['cometchat']['error'] = "Incorrect username/password. Please try again.";
    $_SESSION['cometchat']['type'] = 'alert';
  }
}

if(!function_exists("authenticate")) {
  function authenticate(){
    if(empty($_SESSION['cometchat']['cometchat_admin_user'])||empty($_SESSION['cometchat']['cometchat_admin_pass'])||!($_SESSION['cometchat']['cometchat_admin_user']==ADMIN_USER&&$_SESSION['cometchat']['cometchat_admin_pass']==ADMIN_PASS)){  
      if (filter_var(ADMIN_USER, FILTER_VALIDATE_EMAIL) !== false){
            $usernameplaceholder='Email';
            $texttype='email';
      } else {
            $usernameplaceholder='Username';
            $texttype='text';
      }
      global $body;
      $body = <<<EOD
        <script>
          $(function(){
            var todaysDate = new Date();
            var currentTime = Math.floor(todaysDate.getTime()/1000);
            $(".currentTime").val(currentTime);
          });
        </script>
        <div class="outerframe">
          <div class="middleform">
            <div class="cometchat_logo_div"><img class="cometchat_logo_image" src="images/logo.png"></div>
            <div class="module form-module">
              <div class="form" > 
                <h2 >CometChat Administration Panel</h2>
                <form method="post" action="?module=dashboard"+currentTime>
                  <input type="{texttype}" name="username" placeholder="{$usernameplaceholder}" required="true"/>
                  <input type="password" name="password" placeholder="Password" required="true"/>
                  <button type="submit" value="Login">Login</button>
                  <input type="hidden" name="currentTime" class="login_inputbox currentTime">
                  <div class="cometchat_forgotpwd"><a href="index.php?module=forgotpassword&action=forgotpassword" target="_blank">Forgot Password?</a></div>
                </form>
              </div>
            </div>
          </div>
        </div>
EOD;
      template(1);
    }
  }
}

$_GET['module']= (!isset($_GET['module'])) ? '' : $_GET['module'];

if($_GET['module']!='forgotpassword'){
  authenticate();
}

$module = "dashboard";
$action = "index";
error_reporting(E_ALL);
ini_set('display_errors','On');

if(!empty($_GET['module'])){
  if(file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR.$_GET['module'].'.m.php')){
    $module = $_GET['module'];
  }
}

if(!file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR.$module.'.m.php')){
  $_SESSION['cometchat']['error'] = 'Oops. This module does not exist.';
  $module = 'dashboard';
}

include_once (dirname(__FILE__).DIRECTORY_SEPARATOR.$module.'.m.php');

$allowedActions = array('deleteannouncement','updateorder','ccauth','addauthmode','updateauthmode','index','updatesettings','moderator','newchatroomprocess','newannouncement','newannouncementprocess','newchatroom','updatechatroomorder','loadexternal','makedefault','removecolorprocess','viewuser','viewuserchatroomconversation','viewuserconversation','updatevariablesprocess','editlanguage','editlanguageprocess','restorelanguageprocess','importlanguage','previewlanguage','removelanguageprocess','sharelanguage','data','moderatorprocess','createmodule','createmoduleprocess','chatroomplugins','additionallanguages','createlanguage','createlanguageprocess','uploadlanguage','uploadlanguageprocess','comet','guests','banuser','baseurl','changeuserpass','disablecometchat','updatecomet','updateguests','banuserprocess','updatebaseurl','changeuserpassprocess','updatedisablecometchat','chatroomlog','searchlogs','addmodule','addplugin','addextension','deletechatroom','finduser','updatelanguage','newlogprocess','addchatroomplugin','whosonline','updatewhosonline','cron','processcron','getlanguage','exportlanguage','caching','updatecaching','removecustommodules','clearcachefiles','clearcachefilesprocess','makemoderatorprocess','removemoderatorprocess','banusersprocess','unbanusersprocess','ccautocomplete','themeembedcodesettings','googleanalytics','updategoogleanalytics','storage','updatestoragemode','selectplatform','saveplatform','updatecolorval','addnewcolor','devsettings','updatedevsetting','loadthemetype','processUpdate','compareHashes','backupFiles','applyChanges','extractZip','generateHash','updateNewVersion','updateNow','desktop','mobile','updatemoduleorder','updateextensionorder','forceUpdate','generalsettings','updatelicensekey','removeBot','addBot','rebuildBots','updatBotsetting','addReadytoUseBot','callUpdateMethod','updatecustomsetting','forgotpassword','resetpassword','sendemail','resetpasswordprocess');

if(!empty($_GET['action'])&&in_array($_GET['action'],$allowedActions)&&function_exists($_GET['action'])){
  $action = mysqli_real_escape_string($GLOBALS['dbh'],$_GET['action']);
}

call_user_func($action);

function onlineusers(){
  global $db;
  $sql = ("select count(*) as users from (select DISTINCT cometchat.from userid from cometchat where ('".mysqli_real_escape_string($GLOBALS['dbh'],getTimeStamp())."'-cometchat.sent)<300 UNION SELECT DISTINCT cometchat_chatroommessages.userid userid FROM cometchat_chatroommessages WHERE ('".mysqli_real_escape_string($GLOBALS['dbh'],getTimeStamp())."'-cometchat_chatroommessages.sent)<300) x");

  $query = mysqli_query($GLOBALS['dbh'],$sql);
  $chat = mysqli_fetch_assoc($query);

  $count = !empty($chat['users'])?$chat['users']:0;

  return $count;
}

function getMesseageCnt(){
  global $db;
  $sql = ("select (select count(id) from cometchat) + (select count(id) from cometchat_chatroommessages) as totalmessages");
  $query = mysqli_query($GLOBALS['dbh'],$sql);
  $r = mysqli_fetch_assoc($query);
  $count = !empty($r['totalmessages'])?$r['totalmessages']:0;
  $_SESSION['cometchat']['MsgCnt'] = $count;
  return $count;
}

function template($auth = 0){
  global $ts, $body, $menuoptions, $module, $navigation, $action, $currentversion;
  include_once (dirname(__FILE__).DIRECTORY_SEPARATOR.'sidebar.php');
  $errorjs = '';

  if(!empty($_SESSION['cometchat']['error'])){
    $type = !empty($_SESSION['cometchat']['type']) ? $_SESSION['cometchat']['type'] : 'success';
    $errorjs = <<<EOD
<script>
\$(function() {
  \$.fancyalert('{$_SESSION['cometchat']['error']}','{$type}');
});
</script>
EOD;
    unset($_SESSION['cometchat']['error']);
    unset($_SESSION['cometchat']['type']);
  }

$testnavigation = <<<EOD
  <div id="leftnav">
  </div>
EOD;

  if ($navigation == $testnavigation || empty($navigation)) {
    $nosubnav = 'nosubnav';
  } else {
    $nosubnav = '';
  }

echo <<<EOD
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" href="images/favicon.ico">
  <title>CometChat Admin Panel</title>
  <link href="../css.php?admin=1&v={$currentversion}" rel="stylesheet" >
  <script src="../js.php?admin=1&v={$currentversion}"></script>
</head>
EOD;

if ($auth == 1) {
echo <<<EOD
 <body><br><br><br>
      {$body}
EOD;
} else {
echo <<<EOD
 <body class="navbar-fixed sidebar-nav fixed-nav">
   <header class="navbar">
    <div class="container-fluid">
      <button class="navbar-toggler mobile-toggler hidden-lg-up" type="button">☰</button>
      <a class="navbar-brand" href="#"></a>
    </div>
  </header>
  <div class="sidebar">
   {$navigationbar}
  </div>
  <main class="main">
    <div class="container-fluid">
      {$body}
    </div>
  </main>
  <a style="display:none;" id="adminModellink" href="javascript:void();" data-toggle="modal" data-target="#adminModal">click</a>
  <!-- Modal -->
  <div class="modal fade" id="adminModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 id="admin-modal-title" class="modal-title"></h4>
        </div>
        <div id="admin-modal-body" class="modal-body">
        </div>
        <div class="admin-modal-footer" class="modal-footer">
        </div>
      </div>

    </div>
  </div>
<!-- Modal -->
EOD;
}
echo <<<EOD

  <script src="../js.php?admin=1&app=1&v={$currentversion}"></script>
  {$errorjs}
  <script>
  $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();
  });
  </script>
</body>
</html>
EOD;
    exit();
}
