<?php
/*
CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license
*/
if (!defined('CCADMIN')) {echo 'NO DICE';exit;}

function index()
{
    global $body, $usebots, $ts;
    $activebots = array();
    $disableBoty = $disableBotn = '';
    if ($usebots == 1) {
        $disableBoty = "checked";
    } else {
        $disableBotn = "checked";
    }
    $botslist = '<tr><td colspan="3">No Active Bots!</td></tr>';
    $bots = getBotList();
    if(!empty($bots)) {
    $botslist = '';
    foreach ($bots as $botinfo) {
        if(!empty($botinfo)) {
            $activebots[] = strtolower($botinfo["n"]);
            $botslist .='<input type="hidden" id="active_bot_name_'.$botinfo['id'].'" name="active_bot_name" value="'.$botinfo['n'].'"/><textarea style="display:none;" id="active_bot_description_'.$botinfo['id'].'" name="active_bot_description" >'.$botinfo['d'].'</textarea><input type="hidden" id="active_bot_avatar_'.$botinfo['id'].'" name="active_bot_avatar" value="'.$botinfo['a'].'"/>';
            $botslist .= '<tr class="botlist" id="bot_'.$botinfo['id'].'"><td class="cometchat_bot_'.$botinfo['id'].'"><img style="border-radius:25px;" src="'.$botinfo['a'].'" width="30" height="30"></td>';
            $botslist .= '<td id="'.$botinfo['id'].'_title">'.stripslashes($botinfo["n"]).'</td>';
            if(strpos($botinfo["api"], 'd-cometchat') === false){
                $botslist .= '<td> <a style="color:black;" data-toggle="tooltip" title="Rebuild" href="?module=bots&action=rebuildBots&botid='.$botinfo['id'].'&ts='.$ts.'"><i class="fa fa-lg fa-refresh"></i></a></td>';
            } else {
                $botslist .= '<td></td>';
            }
            $botslist .= '<td><a style="color:black;" data-toggle="tooltip" title="View Bots Details" href="javascript:void(0)" onclick="javascript:botsinfo(\''.$botinfo['id'].'\',\'active\');"><i class="fa fa-lg fa-info-circle"></i></a></td>';
            $botslist .= '<td><a data-toggle="tooltip" title="Delete" style="color:red;" href="?module=bots&action=removeBot&botid='.$botinfo['id'].'&ts='.$ts.'"><i class="fa fa-lg fa-minus-circle"></i></a></td></tr>';
        }
    }
}
$activebots = json_encode($activebots);
$body = <<<EOD
<div class="row">
    <div class="col-sm-6 col-lg-6">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
            <div class="card-header">
              Settings
            </div>
            <div class="card-block">
              <form action="?module=bots&action=updatBotsetting&ts={$ts}" method="post" onSubmit="">
                  <div class="form-group row">
                      <div class="col-md-12">
                      <label class="form-control-label">Enable Bots?</label>
                          <div class=""><label class=""><div style="position:relative;"><input style="position: absolute;" type="radio" name="usebots" value="1" $disableBoty ></div><span style="padding-left:25px;">Yes</span></label><label class=""><div style="position:relative;"><input style="position: absolute;left:8px;" type="radio" name="usebots" value="0" $disableBotn></div><span style="padding-left:30px;">No</span></label></div>
                      </div>
                  </div>
                  <div class="form-actions">
                      <input type="submit" value="Update" class="btn btn-primary">
                  </div>
              </form>
            </div>
            </div>
        </div>    
        <div class="col-sm-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              Active Bots
            </div>
            <div class="card-block">
              <table class="table">
                <thead>
                  <tr>
                    <th width="10%">Bot</th>
                    <th width="80%">&nbsp;</th>
                    <th width="5%">&nbsp;</th>
                    <th width="5%">&nbsp;</th>
                    <th width="5%">&nbsp;</th>
                  </tr>
                </thead>
                  {$botslist}
              </table>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-lg-12">
            <div class="card">
              <div class="card-header">
                Add New Custom Bot
              </div>
              <div class="card-block">
              <div class="note note-success">
                  Please visit <a href = "https://app.bots.co/" style="text-decoration:none">Bots.co</a> and create a new custom bot.<br>
                  After creating the bot, you can use the Bot API Key to add the same below.
              </div>
                <form action="?module=bots&action=addBot&ts={$ts}" method="post" onSubmit="">
                    <div class="form-group row">
                    <div class="col-md-12">
                       <label class="form-control-label">
                        Bot API Key:
                      </label>
                      <input type="text" required="true" id="apikey" name="apikey" class="form-control">
                    </div>
                    </div>
                  <div class="form-actions">
                    <input type="submit" value="Add Bot" class="btn btn-primary">
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
        Available Bots
      </div>
      <div class="card-block">
        <table class="table">
          <thead>
            <tr>
              <th width="10%">Bot</th>
              <th width="80%">&nbsp;</th>
              <th width="5%">&nbsp;</th>
              <th width="5%">&nbsp;</th>
            </tr>
          </thead>
          <tbody id="automated_bots">
            <tr><td colspan="4" align="center" style="font-size:20px;">
            <img src="images/simpleloading.gif" height="100" width ="100" /></td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
    </div>
</div>
</div>
<script>
  $(function() { get_automatedbots($activebots); });
</script>
EOD;

    template();
}

function saveimage($url,$target) {
  if(!empty($url) && !empty($target)) {
    $file = file_get_contents($url);
    if(file_put_contents($target, $file)) {
      return true;
    }else {
      return false;
    }
  }
}

function updatBotsetting () {
    global $ts;
    configeditor($_POST);
    $_SESSION['cometchat']['error'] = 'Settings updated successfully';
    header("Location:?module=bots&ts=".$ts);
}

function addBot()
{
  global $ts,$client;
  if(empty($_REQUEST['apikey'])) {
    $_SESSION['cometchat']['error'] = 'Please enter API Key';
    $_SESSION['cometchat']['type'] = 'alert';
    header("Location:?module=bots&ts=".$ts);
    exit;
  }
  $url = 'http://app.bots.co/api-cometchat/bot-info?apiKey='.$_REQUEST['apikey'];
  $postdata = array();
  $bot = cc_curl_call($url,$postdata);
  $bot = json_decode($bot,true);

  if(!empty($bot)) {
    $sql = "select id from `cometchat_bots` where `apikey` = '".mysqli_real_escape_string($GLOBALS["dbh"],$_REQUEST['apikey'])."'";
    $query = mysqli_query($GLOBALS["dbh"],$sql);
    if($query && mysqli_num_rows($query) == 0) {
      $filename = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."writable".DIRECTORY_SEPARATOR."bots".DIRECTORY_SEPARATOR.$bot['name'].".jpg";

      if(empty($client) && saveimage($bot['avatar'],$filename)) {
        $avatar = BASE_URL."writable".DIRECTORY_SEPARATOR."bots".DIRECTORY_SEPARATOR.$bot['name'].".jpg";
      }else {
        $avatar = $bot['avatar'];
      }

      $sql = "insert into `cometchat_bots`(`name`, `description`, `avatar`, `apikey`) values('".mysqli_real_escape_string($GLOBALS["dbh"],$bot['name'])."','".mysqli_real_escape_string($GLOBALS["dbh"],$bot['description'])."','".mysqli_real_escape_string($GLOBALS["dbh"],$avatar)."','".mysqli_real_escape_string($GLOBALS["dbh"],$_REQUEST['apikey'])."')";
      mysqli_query($GLOBALS["dbh"],$sql);
      removeCachedSettings($client.'cometchat_bots');
    }
  }
  $_SESSION['cometchat']['error'] = 'Bot added successfully!';
  header("Location:?module=bots&ts=".$ts);
  exit;
}

function addReadytoUseBot()
{
  global $client, $ts;

 if(empty($_REQUEST['apikey']) || empty($_REQUEST['bot_name']) || empty($_REQUEST['bot_avatar'])) {
    $_SESSION['cometchat']['error'] = 'Invalid bot';
    $_SESSION['cometchat']['type'] = 'alert';
    header("Location:?module=bots&ts=".$ts);
    exit;
  }

  $sql = "select id from `cometchat_bots` where `apikey` = '".mysqli_real_escape_string($GLOBALS["dbh"],$_REQUEST['apikey'])."'";
  $query = mysqli_query($GLOBALS["dbh"],$sql);
  if($query && mysqli_num_rows($query) == 0) {
    $filename = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."writable".DIRECTORY_SEPARATOR."bots".DIRECTORY_SEPARATOR.$_REQUEST['bot_name'].".jpg";

    if(empty($client) && saveimage($_REQUEST['bot_avatar'],$filename)) {
      $avatar = BASE_URL."writable".DIRECTORY_SEPARATOR."bots".DIRECTORY_SEPARATOR.$_REQUEST['bot_name'].".jpg";
    }else {
      $avatar = $_REQUEST['bot_avatar'];
    }

    $sql = "insert into `cometchat_bots`(`name`, `description`, `avatar`, `apikey`) values('".mysqli_real_escape_string($GLOBALS["dbh"],$_REQUEST['bot_name'])."','".mysqli_real_escape_string($GLOBALS["dbh"],$_REQUEST['bot_description'])."','".mysqli_real_escape_string($GLOBALS["dbh"],$avatar)."','".mysqli_real_escape_string($GLOBALS["dbh"],$_REQUEST['apikey'])."')";
    mysqli_query($GLOBALS["dbh"],$sql);
    removeCachedSettings($client.'cometchat_bots');
  }

  $_SESSION['cometchat']['error'] = 'Bot added successfully!';
  header("Location:?module=bots&ts=".$ts);
  exit;
}

function removeBot()
{
  global $ts, $client;
  if(!empty($_REQUEST['botid'])) {
      $sql = "delete from `cometchat_bots` where `id` = '".mysqli_real_escape_string($GLOBALS["dbh"],$_REQUEST['botid'])."'";
      mysqli_query($GLOBALS["dbh"],$sql);
      removeCachedSettings($client.'cometchat_bots');
      $_SESSION['cometchat']['error'] = 'Bot removed successfully!';
      header("Location:?module=bots&ts=".$ts);
      exit();
  } else {
      $_SESSION['cometchat']['error'] = 'Failed to remove bot';
      $_SESSION['cometchat']['type'] = 'alert';
      header("Location:?module=bots&ts=".$ts);
      exit();
  }
}

function rebuildBots()
{
    global $ts,$client;
    if(!empty($_REQUEST['botid'])) {
      $sql = "select * from `cometchat_bots` where `id` = '".mysqli_real_escape_string($GLOBALS["dbh"],$_REQUEST['botid'])."'";
      if($query = mysqli_query($GLOBALS["dbh"],$sql)) {
        $bot = mysqli_fetch_assoc($query);
        if(!empty($bot)) {
          $url = 'http://app.bots.co/api-cometchat/bot-info?apiKey='.$bot['apikey'];
          $postdata = array();
          $bots = cc_curl_call($url,$postdata);
          $bots = json_decode($bots,true);
          if(!empty($bots)) {
            $filename = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."writable".DIRECTORY_SEPARATOR."bots".DIRECTORY_SEPARATOR.$bot['name'].".jpg";

            if(empty($client) && saveimage($bot['avatar'],$filename)) {
              $avatar = BASE_URL."writable".DIRECTORY_SEPARATOR."bots".DIRECTORY_SEPARATOR.$bot['name'].".jpg";
            }else {
              $avatar = $bots['avatar'];
            }
            $sql = "update `cometchat_bots` set `name`='".mysqli_real_escape_string($GLOBALS["dbh"],$bots['name'])."', `description`='".mysqli_real_escape_string($GLOBALS["dbh"],$bots['description'])."',`avatar`='".mysqli_real_escape_string($GLOBALS["dbh"],$avatar)."' where id='".mysqli_real_escape_string($GLOBALS["dbh"],$_REQUEST['botid'])."'";
            mysqli_query($GLOBALS["dbh"],$sql);
            removeCachedSettings($client.'cometchat_bots');
          }
        }
      }
      $_SESSION['cometchat']['error'] = 'Successfully Rebuild!';
      header("Location:?module=bots&ts=".$ts);
      exit();
    } else{
      $_SESSION['cometchat']['error'] = 'Invalid bot ID';
      $_SESSION['cometchat']['type'] = 'alert';
      header("Location:?module=bots&ts=".$ts);
      exit();
    }
}
