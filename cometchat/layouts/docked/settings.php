<?php

if (!defined('CCADMIN')) { echo "NO DICE"; exit; }
global $theme, $client, $jslink, $csslink;
$base_url = BASE_URL;
if(!empty($_GET['process']) && $_GET['process'] == true) {
    include_once(dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR.'config.php');
    $embed_code = '<link type="text/css" href="'.BASE_URL.'cometchatcss.php" rel="stylesheet" charset="utf-8">'."\r\n".'<script type="text/javascript" src="'.BASE_URL.'cometchatjs.php" charset="utf-8"></script>';
    if(!empty($client)) {
        $embed_code = '<link type="text/css" href="'.$csslink.'" rel="stylesheet" charset="utf-8">'."\r\n".'<script type="text/javascript" src="'.$jslink.'" charset="utf-8"></script>';
    }
    echo <<<EOD
        <!DOCTYPE html>
        <html>
            <head>
                <link href="{$base_url}/css.php?admin=1" rel="stylesheet">
                <script type="text/javascript" src="{$base_url}/js.php?admin=1"></script>
                <script type="text/javascript" language="javascript">
                    $(function() {
                        setTimeout(function(){
                            resizeWindow();
                        },200);
                    });

                    function resizeWindow() {
                        window.resizeTo((520), (190+window.outerHeight-window.innerHeight));
                    }
                </script>
            </head>
        <body style="background-color: white;overflow-y:hidden;">
            <textarea readonly="" style="width:100%;height:170px">{$embed_code}</textarea>
        </body>
        </html>
EOD;

}
?>
