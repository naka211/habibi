<?php

/*
CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license

*/

if (!defined('CCADMIN')) { echo "NO DICE"; exit; }

function index() {
global $body, $navigation, $options, $ts, $apikey;
    $form = '';

$body = <<<EOD
    <div class="row">
  <div class="col-sm-12 col-lg-12">
    <div class="card">
      <div class="card-header">
        Mobile App
      </div>
      <div class="card-block">
      <iframe height="500px" width="100%"  style="border:none;" src="?module=dashboard&action=loadexternal&type=extension&name=mobileapp"></iframe>
      </div>
    </div>
  </div>
  <script type="text/javascript">
  $(function() {
    $("#mobile").addClass('active');
  });
</script>
EOD;

    template();

}

function desktop() {
    global $body, $navigation, $options, $ts, $apikey;
    $form = '';

$body = <<<EOD
    <div class="row">
  <div class="col-sm-12 col-lg-12">
    <div class="card">
      <div class="card-header">
        Desktop
      </div>
      <div class="card-block">
      <iframe height="500px" width="100%"  style="border:none;" src="?module=dashboard&action=loadexternal&type=extension&name=desktop"></iframe>
      </div>
    </div>
  </div>
EOD;

    template();

}
