<?php 
$root = $_SERVER['CONTEXT_DOCUMENT_ROOT'];
$url = $root.str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
echo $url;
echo file_get_contents($url."/site/config/config.php");
?>